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

		// loop para planta
	    foreach ($grupo->plantas->planta as $planta) {
	    	
			// loop para unidade
		    foreach ($planta->unidades->unidade as $unidade) {
				//verifica se o usuario e valido antes de tudo
				if($unidade->nome != 'null' && $unidade->nome != 'NU' && $unidade->nome != 'N U' && $unidade->nome != 'N-U' && $unidade->nome != 'T1-RES1' && $unidade->nome != 'T1-RES2' && $unidade->nome != 'T1-RES3' && $unidade->nome != 'T1-RES4' && $unidade->nome != 'T1-RES5' && $unidade->nome != 'T1-RES6' && $unidade->nome != 'T1-RES7' && $unidade->nome != 'T1-RES8'){
					$idecoflowUnidade = $unidade->{'id-ecoflow'};
					$idecoflowPlanta = $planta->{'id-ecoflow'};	
					$nome = (string)$unidade->nome;				

					// Converte A e G no mesmo usuario. Criada somente para resolver o problema da instalação do grupo ISF
					if($grupo->id == 18){						
						$servicoLetra = $nome[3];

						if($servicoLetra == 'A'){							
							$nome = str_replace("A" , "" , $nome);
							$idecoflowGas = $idecoflowUnidade;

						}elseif($servicoLetra == 'G'){							
							$nome = str_replace("G" , "" , $nome);
							$idecoflowUnidade = $idecoflowGas;
						}
					}

					// verifica se usuario ja existe, senão existir adicionar o novo usuario
					$resUsuario = mysqli_query($con, "SELECT * FROM usuario WHERE id_unidade = '$idecoflowUnidade'");
					$objUsuario = mysqli_fetch_object($resUsuario);
					echo $idecoflowUnidade.'<br>';
					
					if(!isset($objUsuario)){
						$tipo = 'usuario';
						$status = 'ativo';
						$sql = "INSERT INTO usuario (id_unidade, id_planta, id_grupo, login, senha, nome, tipo, status) 
						VALUES ('$idecoflowUnidade', '$idecoflowPlanta', '$grupo->id', '$idecoflowUnidade', '$idecoflowUnidade', '$nome', '$tipo', '$status')";
						mysqli_query($con, $sql);
					}			
				}				
			}				    
		}
	}
}
?>