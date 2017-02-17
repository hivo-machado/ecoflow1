<?php 
	//Atividade CRON para verificar se todas as torres ou unidades estão online

	//Conexão com banco de dados
	include_once("../conexao.php");

	//E-mail
	$email = 'v1n1c1u5_1@hotmail.com';
	//$email = 'v1n1c1u5_1@hotmail.com, v1n3k0@outlook.com';

	//Data atual
  	date_default_timezone_set('America/Sao_Paulo');
  	$tempoAtual = strtotime( date('Y-m-d') );
	
	//Data do dia anterior
	$tempoAnt = strtotime('-1 day', $tempoAtual);
	$dataAnt =  date_format( date_create( date('Y-m-d', $tempoAnt) ),'Y-m-d' );

	$grupos = mysqli_query($con, "SELECT * FROM grupo");

	//Percorre todos os grupos
	while ( $grupo = mysqli_fetch_object($grupos) ) {
		//flag para enviar ou não enviar e-mail
		$flag = false;
		$flagUnidade = false;
		$str = null;
		$strUni = null;

		$str .= '<strong>Grupo: '.$grupo->nome.'</strong><br>';
		
		//Percorre todas as plantas
		$plantas = mysqli_query($con, "SELECT * FROM planta WHERE id_grupo_fk = '$grupo->id'");

		while ( $planta = mysqli_fetch_object($plantas) ) {

			$unidades = mysqli_query($con, "SELECT * FROM unidade WHERE id_planta_fk = '$planta->idecoflow' AND tempo = '$dataAnt' GROUP BY idecoflow");
			
			//Verifica se houve alguma leitura no dia
			if( mysqli_num_rows($unidades) ) {

				//Iniciar variavel vetor e contador
				$vetorUnidades = array();
				$cont = 0;

				//add todas as unidades vetor
				while ($unidade = mysqli_fetch_object($unidades) ) {
					$vetorUnidades[$cont] = $unidade->idecoflow;
					$cont++;
				}
				
				$usuarios = mysqli_query($con, "SELECT * FROM usuario WHERE id_planta = '$planta->idecoflow' AND tipo = 'usuario' AND status = 'ativo' ");

				//Percorre todos os usuario
				while ($usuario = mysqli_fetch_object($usuarios)) {
					$flagUsuario = true;
					for ($i = 0; $i < $cont; $i++) {
						if ($usuario->id_unidade == $vetorUnidades[$i]) {
							$flagUsuario = false;
						}
					}

					if($flagUsuario){
						$strUni .= $grupo->nome.' - '.$planta->nome.' - '.$usuario->id_unidade.', '.$usuario->nome.'<br>';
						$flagUnidade = true;
					}
				}

				$str .= 'Torre: [ON] - '.$planta->nome.'<br>';
			}else{
				$str = $str.'<strong>Torre: [OFF] - '.$planta->nome.'</strong><br>';
				$flag = true;
			}

		}//Fecha while planta
		
		//Envia e-mail se pelo menos uma torre esteja offline
		if($flag){
			//envia e-email
			$assunto = "Torres Offline";
			$menssagem = "
			O sistema verificou torres offline.<br>
			Data: $dataAnt<br>
			<br> 
			$str
			<br>
			Entre em nosso site <a href='ecoflow-gratis.umbler.net'>Ecoflow</a>
			<br>
			";
			$menssagem = wordwrap($menssagem, 70);
			$headers = "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: <noreplay@ecoflow.com>\r\n";
			mail($email, $assunto, $menssagem, $headers);
			
			echo $menssagem;
		}

		//Enviar e-mail se pelo menos uma unidade esteja offline 
		if($flagUnidade){
			//envia e-email
			$assunto = "Unidades Offline";
			$menssagem = "
			O sistema verificou unidades offline.<br>
			Data: $dataAnt<br>
			<br> 
			$strUni
			<br>
			Entre em nosso site <a href='ecoflow-gratis.umbler.net'>Ecoflow</a>
			<br>
			";
			$menssagem = wordwrap($menssagem, 70);
			$headers = "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: <noreplay@ecoflow.com>\r\n";
			mail($email, $assunto, $menssagem, $headers);

			echo $menssagem;
		}

		
	}// fecha while do grupo

 ?>