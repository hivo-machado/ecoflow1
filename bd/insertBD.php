<?php
//Conexão com banco de dados
//include_once("/home/ecofl253/public_html/conexao.php");//hostgator diretorio
include_once("../conexao.php");

$result = mysqli_query($con, "SELECT * FROM xml");

// loop para os links
while ( $links =  mysqli_fetch_object($result) ) {
		// Tempo de execução maxima do programa 120 seg.
		ini_set('max_execution_time',120);//valor original de 120, alterado para teste 

		$xml = simplexml_load_file($links->link);
	// loop para grupos
	foreach ($xml->grupo as $grupo){
		// verifica se grupo ja existe, senão existir adiciona o novo grupo
		$resGrupo = mysqli_query($con, "SELECT * FROM grupo WHERE id = '$grupo->id'");
		$objGrupo = mysqli_fetch_object($resGrupo);
		echo $grupo->nome.'<br>';
		if(!isset($objGrupo)){
		    $sql = "INSERT INTO grupo (id, nome) VALUES ('$grupo->id', '$grupo->nome')";
			mysqli_query($con, $sql);
		}

		// loop para planta
	    foreach ($grupo->plantas->planta as $planta) {
	    	// verifica se planta já existe, senão existir adicionar a nova planta
	    	$resPlanta = mysqli_query($con, "SELECT * FROM planta WHERE nome = '$planta->nome'");
	    	$objPlanta = mysqli_fetch_object($resPlanta);
			echo $planta->nome.'<br>';
		   	if(!isset($objPlanta)){
				$idecoflowPlanta = $planta->{'id-ecoflow'};
			    $sql = "INSERT INTO planta (idecoflow, id_grupo_fk, nome) VALUES ('$idecoflowPlanta', '$grupo->id', '$planta->nome')";
				mysqli_query($con, $sql);
			}
			// loop para unidade
		    foreach ($planta->unidades->unidade as $unidade) {

				$idecoflowUnidade = $unidade->{'id-ecoflow'};

				// verifica se usuario ja existe, senão existir adicionar o novo usuario
				$resUsuario = mysqli_query($con, "SELECT * FROM usuario WHERE id_unidade = '$idecoflowUnidade'");
				$objUsuario = mysqli_fetch_object($resUsuario);
				echo $unidade->{'id-ecoflow'}.'<br>';
				   if(!isset($objUsuario)){
					$idecoflowUnidade = $unidade->{'id-ecoflow'};
					$idecoflowPlanta = $planta->{'id-ecoflow'};
					$tipo = 'usuario';
					$status = 'ativo';
					$sql = "INSERT INTO usuario (id_unidade, id_planta, id_grupo, login, senha, nome, tipo, status) VALUES ('$idecoflowUnidade', '$idecoflowPlanta', '$grupo->id', '$idecoflowUnidade', '$idecoflowUnidade', '$unidade->nome', '$tipo', '$status')";
					mysqli_query($con, $sql);
				}

				// Converte a data para modelo do banco de dados
		    	$data = date("Y-m-d",strtotime(str_replace('/','-',$unidade->timestamp)));
		    	$date = date_create($data);
				$tempo =  date_format($date, 'Y-m-d');

				//Converte para hora
				$hora = substr($unidade->timestamp,-5);

				//Altera o "," do XML para "."
				$leitura = (string)$unidade->leitura;
				$leitura = str_replace("," , "." , $leitura);
				$leitura = (float)$leitura;
				
				//Verifica o medidor se valido para inserção no banco de dados
				if($unidade->nome != 'null'){
			    	$idecoflowUnidade = $unidade->{'id-ecoflow'};
			    	$idecoflowPlanta = $planta->{'id-ecoflow'};
				    $sql = "INSERT INTO unidade (idecoflow, tempo, hora, id_planta_fk, nome, medidor, servico, leitura) 
				    VALUES ('$idecoflowUnidade', '$tempo', '$hora', '$idecoflowPlanta', '$unidade->nome', '$unidade->medidor', '$unidade->servico', '$leitura')";
					mysqli_query($con, $sql);
				}
		    }
	    }
	}
}

?>