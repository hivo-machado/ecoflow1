<?php
//Conexão com banco de dados
//include_once("/home/ecofl253/public_html/conexao.php");//hostgator diretorio
include_once("../conexao.php");

$result = mysqli_query($con, "SELECT * FROM xml");

// loop para os links
while ( $links =  mysqli_fetch_object($result) ) {
		// Tempo de execução maxima do programa 120 seg.
		ini_set('max_execution_time',200);//valor original de 120, alterado para teste 

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
				//verifica se o usuario e valido antes de tudo
				if($unidade->nome != 'null' && $unidade->nome != 'NU' && $unidade->nome != 'N U' && $unidade->nome != 'N-U' && $unidade->nome != 'T1-RES1' && $unidade->nome != 'T1-RES2' && $unidade->nome != 'T1-RES3' && $unidade->nome != 'T1-RES4' && $unidade->nome != 'T1-RES5' && $unidade->nome != 'T1-RES6' && $unidade->nome != 'T1-RES7' && $unidade->nome != 'T1-RES8'){
					$idecoflowUnidade = $unidade->{'id-ecoflow'};
					$idecoflowPlanta = $planta->{'id-ecoflow'};					

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
					
					//OFFSET PARA UNIDADES DA REMOTA 13 FLORIDA
					if($idecoflowPlanta == 38){						
						if($unidade->nome == 'T4-A131'){
							$leitura = $leitura+7.429;
						}else if($unidade->nome == 'T4-G131'){
							$leitura = $leitura+12.92;
						}else if($unidade->nome == 'T4-A132'){
							$leitura = $leitura+4.75;							
						}else if($unidade->nome == 'T4-G132'){
							$leitura = $leitura+6.55;							
						}else if($unidade->nome == 'T4-A133'){
							$leitura = $leitura+0.11;							
						}else if($unidade->nome == 'T4-A134'){
							$leitura = $leitura+10.865;							
						}else if($unidade->nome == 'T4-G134'){
							$leitura = $leitura+7.38;							
						}else if($unidade->nome == 'T4-A141'){
							$leitura = $leitura+1.953;							
						}else if($unidade->nome == 'T4-G141'){
							$leitura = $leitura+3.47;							
						}else if($unidade->nome == 'T4-A142'){
							$leitura = $leitura+3.693;							
						}else if($unidade->nome == 'T4-G142'){
							$leitura = $leitura+6.57;							
						}else if($unidade->nome == 'T4-A143'){
							$leitura = $leitura+1.002;							
						}else if($unidade->nome == 'T4-G143'){
							$leitura = $leitura+0.39;							
						}else if($unidade->nome == 'T4-A144'){
							$leitura = $leitura+2.909;							
						}else if($unidade->nome == 'T4-G144'){
							$leitura = $leitura+29.13;						
						}
					}

					// Converte A e G na mesma unidade. Criada somente para resolver o problema da instalação do grupo ISF
					if($grupo->id == 18){
						$nome = (string)$unidade->nome;
						$servico = $unidade->servico;
						$servicoLetra = $nome[3];

						if($servicoLetra == 'A'){
							$nome = str_replace("A" , "" , $nome);
							$idecoflowGas = $idecoflowUnidade;

							$sql = "INSERT INTO unidade (idecoflow, tempo, hora, id_planta_fk, nome, medidor, servico, leitura) 
							VALUES ('$idecoflowUnidade', '$tempo', '$hora', '$idecoflowPlanta', '$nome', '$unidade->medidor', '$servico', '$leitura')";
							mysqli_query($con, $sql);

						}elseif($servicoLetra == 'G'){
							$nome = str_replace("G" , "" , $nome);
							$idecoflowUnidade = $idecoflowGas;
							$servico = 2;

							// Como o banco usa o $idecoflowUnidade, $tempo e $hora como PRIMARY KEY foi necessário a criacao de um offset na hora.
							$hora .= ":01";

							$sql = "INSERT INTO unidade (idecoflow, tempo, hora, id_planta_fk, nome, medidor, servico, leitura) 
							VALUES ('$idecoflowUnidade', '$tempo', '$hora', '$idecoflowPlanta', '$nome', '$unidade->medidor', '$servico', '$leitura')";
							mysqli_query($con, $sql);

						}
					}else{
						$sql = "INSERT INTO unidade (idecoflow, tempo, hora, id_planta_fk, nome, medidor, servico, leitura) 
						VALUES ('$idecoflowUnidade', '$tempo', '$hora', '$idecoflowPlanta', '$unidade->nome', '$unidade->medidor', '$unidade->servico', '$leitura')";
						mysqli_query($con, $sql);
					}				
				}				
			}				    
		}
	}
}
?>