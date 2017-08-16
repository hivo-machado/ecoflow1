<?php 
	//Atividade CRON para verificar se não existe consumo excessivo

	//Conexão com banco de dados
	//include_once("/home/ecofl253/public_html/conexao.php");
	//include_once("/home/ecofl253/public_html/corpoEmail.php");
	include('../conexao.php');
	include('../corpoEmail.php');

	// Tempo de execução maxima do programa 10 min.
	ini_set('max_execution_time',600);

	//Razão pelo consumo medio
	define("RAZAO", 2);

	//Numero de Serviço 0 - agua fria, 1 - agua quente, 2 - gas
	define("SERVICO", 0);

	//E-mail
	//define("EMAIL", "vectoramerico@gmail.com, lucineia@vector.eng.br, v1n1c1u5_1@hotmail.com");
	define("EMAIL", "v1n1c1u5_1@hotmail.com");

	//Fuso horario
  	date_default_timezone_set('America/Sao_Paulo');
	
	//Data mes atual
  	//$tempoAtual = strtotime( date('Y-m-d') );
  	$tempoAtual = strtotime( '30-06-2017' );
  	$dataAtual =  date_format( date_create( date('Y-m-d', $tempoAtual) ),'Y-m-d' );

  	//Data do dia anterior
	$tempoAnterior = strtotime('-1 day', $tempoAtual);
	$dataDiaAnterior =  date_format( date_create( date('Y-m-d', $tempoAnterior) ),'Y-m-d' );

  	//Data de 1 meses anterior
	$tempoAnterior = strtotime('-3 month', $tempoAtual);
	$dataMesAnterior =  date_format( date_create( date('Y-m-d', $tempoAnterior) ),'Y-m-d' );

	//echo "Tempo Atual: ", $dataAtual, " Tempo dia anterior: ", $dataDiaAnterior, " Tempo mes anterior: ", $dataMesAnterior, "<br>";

  	//Pesquisa todos usuario do tipo usuario e ativos
  	$usuarios = mysqli_query($con, "SELECT * FROM usuario WHERE tipo = 'usuario' AND status = 'ativo' AND id_unidade IS NOT null");

  	//String com idEcoflow dos alertas
  	$idecoflow = "";
  	$cont = 0;
  	
  	while ($usuario = mysqli_fetch_object($usuarios) ){

		//Primeira leitura do dia atual
		$unidadeMesAtualSelect = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$usuario->id_unidade' AND tempo = '$dataAtual' AND servico = 'SERVICO' ORDER BY tempo DESC, hora ASC LIMIT 1");
  		$unidadeAtual = mysqli_fetch_object($unidadeMesAtualSelect);

  		if($unidadeAtual != null){
  			
			//Primeira leitura do dia anterior
			$unidadeDiaAnteriorSelect = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$usuario->id_unidade' AND tempo = '$dataDiaAnterior' AND servico = 'SERVICO' ORDER BY hora ASC LIMIT 1");
	  		$unidadeDiaAnterior = mysqli_fetch_object($unidadeDiaAnteriorSelect);	  		
	  		
	  		if($unidadeDiaAnterior != null){

	  			//Chamada da função de leituras diarias
	  			$consumos = consumo($con, $usuario->id_unidade, SERVICO, $dataMesAnterior, $dataDiaAnterior);
	  			//Ordena em decrescente
			  	rsort( $consumos );

			  	$soma = 0;
			  	$contZero = 0;
			  	//Soma consumos
			  	foreach( $consumos as $consumo ){
			  		//Verifica se consumo é positivo 
			  		if($consumo > 0){
			  			$soma += $consumo;
			  		}else{ //Caso exista consumo incorreto ou consumo = 0
			  			$contZero ++;
			  		}
			  	}

			  	$divisor = count( $consumos ) - $contZero;
			  	//Calcula o divisor caso não exista nehuma leitura maior que 0
			  	if( $divisor != 0 ){
			  		$media = $soma / ( $divisor );
			  	}else{
			  		$media = $soma / 1;
			  	}


			  	$somaMedia = 0;
			  	$conta = 0;
			  	//Soma os consumo maiores que a media
			  	foreach ($consumos as $consumo) {
			  		if($media <= $consumo){
			  			$somaMedia += $consumo;
			  			$conta++;
			  		}
			  	}

			  	//Calcula media dos maiores consumos
			  	if($conta != 0){
			  		$mediaAcima = $somaMedia / $conta;
			  	}else{
			  		$mediaAcima = $somaMedia / 1;
			  	}

			  	//Calculo o consumo do dia atual
			  	$consumoAtual = $unidadeAtual->leitura - $unidadeDiaAnterior->leitura;

			  	//Verifica se consumo do dia e excessivo
			  	if($consumoAtual > $mediaAcima * RAZAO){
			  		$idecoflow .= $usuario->id_unidade."<br>";

		  			echo "<br>Idecolfow: ", $usuario->id_unidade, "<br>";
			  		print_r( $consumos );
			  		echo "<br>Consumo: ", $consumoAtual;
				  	echo "<br>Media: ", $media;
				  	echo "<br>Media acima:" , $mediaAcima;
				  	echo "<br>Media acima 2x: ", $mediaAcima * 2;
				  	echo "<br> <br>";
			  	}

	  		}

  		}

  	}

  	
  	if($idecoflow != ""){
  		//envia e-email
			$assunto = "Possivel vazamento";
			$menssagem = $headerEmail."
				<h4>Possível vazamento</h4>
				Data: $dataDiaAnterior<br>
				O sistema verificou um possivel vazamento ou um consumo execessivo dos seguintes idecoflow:<br>
				<br> 
				$idecoflow
				<br>
			".$footerEmail;
			$menssagem = wordwrap($menssagem, 70);
			$headers = "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: <noreplay@ecoflow.net.br>\r\n";
			mail(EMAIL, $assunto, $menssagem, $headers);
  	}
	 	

  	//***********************************************************************************************************************

  	//Retorna string com consumo diario de um mês
	function consumo($con, $idecoflow, $servico, $tempoInicio, $tempoFim ){

		//iniciar variavel
		$unidadeAnt  = null; //Unidade anterior
		$cont = 0; //contador de dias
		$listaConsumo = null; //inicializando variavel

		//Seleciona as primeiras leituras de cada dia
		$result = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$idecoflow' AND servico = '$servico' AND tempo BETWEEN '$tempoInicio' AND '$tempoFim' GROUP BY tempo ORDER BY tempo ASC");
		
		//Percorre todos os resultado do SELECT
		while( $unidade = mysqli_fetch_object($result) ){

			//Verifica se existe leitura anterior para calculo
			if($unidadeAnt != null){

				$listaConsumo[$cont] = $unidade->leitura - $unidadeAnt->leitura; //adiciona na lista de consumo
				
				//Calcula proxima data baseado na leitura anterior
				$dataAnt = strtotime($unidadeAnt->tempo);
				$dateAnt = strtotime('+1 day', $dataAnt);
				$proxDataPre = date('Y-m-d',$dateAnt); //Proxima data prevista

				//Data da leitura atual
				$data = strtotime($unidade->tempo);
				$proxData = date('Y-m-d',$data);// Data da leitura

				//Calcula media em intervalo sem leitura
				if($proxDataPre != $proxData){

					$date1 = date_create($proxDataPre);
					$date2 = date_create($proxData);
					$diff = date_diff($date1,$date2);
					$dias = $diff->format("%a"); //quantidade de dias sem leitura
					$consumoAux = number_format($listaConsumo[$cont] / ($dias + 1), 3, '.', '');

					for($i = 0; $i <= $dias; $i++){
						$listaConsumo[($cont + $i)] = $consumoAux; //Adiciona consumo medio no intervalo na lista de consumo
					}

					$cont = $cont + $dias;
				}// fim do if Calcula media no intervalo sem leitura

				$cont++; // soma +1 contador de dias
			} // Fim do if($unidadeAnt != null)

			$unidadeAnt = $unidade;
		}// Fim do while

		//return $cosumo = array($listaConsumo, $listaData);
		return $listaConsumo;
	}//Fim da função

 ?>