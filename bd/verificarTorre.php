<?php 
	//Atividade CRON para verificar se todas as torres ou unidades estão online

	//Conexão com banco de dados
	include_once("/home/ecofl253/public_html/conexao.php");
	include_once("/home/ecofl253/public_html/corpoEmail.php");

	//E-mail
	$email = 'vectoramerico@gmail.com, lucineia@vector.eng.br';
	//$email = 'v1n1c1u5_1@hotmail.com';

	//Fuso horario
  	date_default_timezone_set('America/Sao_Paulo');
	
	//Data atual
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

		//String com idetinficação das torres e unidades
		$str = null;
		$strUni = null;

		$str .= '<strong>Grupo: '.$grupo->nome.'</strong><br>';
		
		$plantas = mysqli_query($con, "SELECT * FROM planta WHERE id_grupo_fk = '$grupo->id'");

		//Percorre todas as plantas
		while ( $planta = mysqli_fetch_object($plantas) ) {

			$unidades = mysqli_query($con, "SELECT * FROM unidade WHERE servico = '0' AND  id_planta_fk = '$planta->idecoflow' AND tempo = '$dataAnt' GROUP BY idecoflow");
			
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
						$strUni .= '<strong>Grupo:'.$grupo->nome.'<br> Planta: '.$planta->nome.'<br> Unidade: '.$usuario->id_unidade.' - '.$usuario->nome.'</strong><br><br>';
						$flagUnidade = true;
					}
				}

				$str .= 'Torre: [ON] - '.$planta->nome.'<br>';
			}else{
				$str = $str.'<strong>Torre: [OFF] - '.$planta->nome.'</strong><br>';
				$flag = true;
			}

		}//Fecha while planta
		
		//Envia e-mail se pelo menos uma torre estiver offline
		if($flag){
			//envia e-email
			$assunto = "Torres Offline";
			$menssagem = $headerEmail."
				<h4>Torres Offline</h4>
				O sistema verificou torres offline.<br>
				Data: $dataAnt<br>
				<br> 
				$str
				<br>
			".$footerEmail;
			$menssagem = wordwrap($menssagem, 70);
			$headers = "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: <noreplay@ecoflow.net.br>\r\n";
			mail($email, $assunto, $menssagem, $headers);
		}

		//Enviar e-mail se pelo menos uma unidade estiver offline 
		if($flagUnidade){
			//envia e-email
			$assunto = "Unidades Offline";
			$menssagem = $headerEmail."
				<h4>Unidades Offline</h4>
				O sistema verificou unidades offline.<br>
				Data: $dataAnt<br>
				<br> 
				$strUni
			".$footerEmail;
			$menssagem = wordwrap($menssagem, 70);
			$headers = "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: <noreplay@ecoflow.net.br>\r\n";
			mail($email, $assunto, $menssagem, $headers);
		}

		
	}// fecha while do grupo

 ?>