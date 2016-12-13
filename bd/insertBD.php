<?php
//Conexão com banco de dados
include_once("../conexao.php");

// Tempo de execução maxima do programa 300 seg.
ini_set('max_execution_time',300);

// lista com links para arquvios xml
$arquivos = array( 'http://ecoflow.ind.br/rest?groupId=2&login=suportti&password=suportti','http://ecoflow.ind.br/rest?groupId=3&login=vector&password=vector1234');

// loop para os links
foreach ($arquivos as $arquivo) {
		$xml = simplexml_load_file($arquivo);
	
	// loop para grupos
	foreach ($xml->grupo as $grupo){
		// verifica se grupo ja existe, senão existir adiciona o novo grupo
		if(mysqli_query($con, "SELECT * FROM grupo WHERE nome = '$grupo->nome'")){
		    $sql = "INSERT INTO grupo (id, nome) VALUES ('$grupo->id', '$grupo->nome')";
			mysqli_query($con, $sql);
		}

		// loop para planta
	    foreach ($grupo->plantas->planta as $planta) {
	    	// verifica se planta já existe, senão existir adicionar a nova planta
		   	if(mysqli_query($con, "SELECT * FROM planta WHERE nome = '$planta->nome'")){
				$idecoflowPlanta = $planta->{'id-ecoflow'};
			    $sql = "INSERT INTO planta (idecoflow, id_grupo_fk, nome) VALUES ('$idecoflowPlanta', '$grupo->id', '$planta->nome')";
				mysqli_query($con, $sql);
			}
			// loop para unidade
		    foreach ($planta->unidades->unidade as $unidade) {
		    	// Converte a data para modelo do banco de dados
		    	$data = date("Y-m-d H:i:s",strtotime(str_replace('/','-',$unidade->timestamp)));
		    	$date = date_create($data);
				$tempo =  date_format($date, 'Y-m-d H:i:s');

				//Verifica o medidor se valido para inserção no banco de dados
		   		if($unidade->medidor != 'null'){
			    	$idecoflowUnidade = $unidade->{'id-ecoflow'};
			    	$idecoflowPlanta = $planta->{'id-ecoflow'};
				    $sql = "INSERT INTO unidade (idecoflow, tempo, id_planta_fk, nome, medidor, servico, leitura) 
				    VALUES ('$idecoflowUnidade', '$tempo', '$idecoflowPlanta', '$unidade->nome', '$unidade->medidor', '$unidade->servico', '$unidade->leitura')";
					mysqli_query($con, $sql);
		   		}
		    }
	    }
	}
}

?>