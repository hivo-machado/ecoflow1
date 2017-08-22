<?php 
	//Atividade CRON para verificar se não existe consumo excessivo

	//Conexão com banco de dados
	include_once("/home/ecofl253/public_html/conexao.php");
	include_once("/home/ecofl253/public_html/corpoEmail.php");
	//include('../conexao.php');
	//include('../corpoEmail.php');

	// Tempo de execução maxima do programa 10 min.
	ini_set('max_execution_time', 600);

	//Quantidade minima de vezes que o menor consumo deve repetir
	define("QTDMINCONSUMO", 3);

	//E-mail
	//define("EMAIL", "vectoramerico@gmail.com, lucineia@vector.eng.br, v1n1c1u5_1@hotmail.com");
	define("EMAIL", "v1n1c1u5_1@hotmail.com");

	//Fuso horario
  	date_default_timezone_set('America/Sao_Paulo');


  	//***********************************************************************************************************************
	
	//Data mes atual
  	$tempoAtual = strtotime( date('Y-m-d') );
  	//$tempoAtual = strtotime( '30-06-2017' );
  	$dataAtual =  date_format( date_create( date('Y-m-d', $tempoAtual) ),'Y-m-d' );

  	//Data do dia anterior
	$tempoAnterior = strtotime('-1 day', $tempoAtual);
	$dataDiaAnterior =  date_format( date_create( date('Y-m-d', $tempoAnterior) ),'Y-m-d' );

	echo "Tempo Atual: ", $dataAtual, " Tempo dia anterior: ", $dataDiaAnterior, " Tempo mes anterior: ", "<br>";

	//***********************************************************************************************************************

  	//Pesquisa todos usuario do tipo usuario e ativos
  	$usuarios = mysqli_query($con, "SELECT * FROM usuario WHERE tipo = 'usuario' AND status = 'ativo' AND id_unidade IS NOT null");

  	//String com idEcoflow dos alertas
  	$idecoflow = "";
  	$cont = 0;

  	
  	while ($usuario = mysqli_fetch_object($usuarios) ){

  		//Primeira Leitura do dia atual
		$unidadeMesAtualSelect = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$usuario->id_unidade' AND tempo = '$dataAtual' AND servico = '0' ORDER BY tempo DESC, hora ASC LIMIT 1");
  		$unidadeAtual = mysqli_fetch_object($unidadeMesAtualSelect);

  		if($unidadeAtual != null){

			//Seleciona todas as leituras do dia anterior
	  		$unidades = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$usuario->id_unidade' AND tempo = '$dataDiaAnterior' AND servico = '0' ORDER BY hora DESC");

	  		if($unidades->num_rows > 0){

		  		$leituraAnterior = $unidadeAtual->leitura;
		  		$alerta = true;
		  		$contConsumo = 0;
		  		$consumo = null;

				//Calcula consumo por intervalo de hora (2h/2h ou 6h/6h) no dia
		  		while ($unidade = mysqli_fetch_object($unidades) ){
		  			$leitura = $unidade->leitura;
		  			$consumo[$contConsumo] = number_format($leituraAnterior - $leitura, 3, '.', '');
		  			$leituraAnterior = $leitura;

		  			if ($consumo[$contConsumo] == 0) $alerta = false;
		  			$contConsumo++;
		  		}

		  		if($alerta){
					//ordena o vetor
		  			sort($consumo);
					//Conta quantidade de consumo no vetor
		  			$qtdConsumo = count($consumo);
					//inicia a variavel contador de menor consumo
		  			$qtdMenorConsumo = 0;

					//Conta quantidade de vezes que menor leitura-se repete
		  			for($i = 0; $i < $qtdConsumo; $i++){
		  				if($consumo[0] == $consumo[$i]) $qtdMenorConsumo++;
						echo $consumo[$i], ' ';
		  			}
		  			echo '<br>';
		  				
		  			echo ' - ID: ', $usuario->id_unidade;

		  			if($qtdMenorConsumo >= QTDMINCONSUMO){
						//echo 'Consumo dia: ', $consumoDia;
						//echo ' - Media: ', $consumoMedio;
		  				echo ' - ALERTA';
		  			//String com idEcoflow dos alertas
		  				$idecoflow .= $usuario->id_unidade."<br>";
		  				$cont++;
		  			}
		  			echo ' Quantidade vezes: ', $qtdMenorConsumo;
		  			echo '<br>';
		  		}

	  		}

  		}

  	}


  	echo "quantidade alerta: ", $cont;
  	
  	//Envia e-mail com os alertas
  	if($idecoflow != ""){
  		//envia e-email
			$assunto = "Vazamento pequeno ";
			$menssagem = $headerEmail."
				<h4>Possível vazamento</h4>
				Data: $dataDiaAnterior<br>
				O sistema verificou um possível pequeno vazamento nos seguintes idecoflow:<br>
				<br> 
				$idecoflow
				<br>
			".$footerEmail;
			$menssagem = wordwrap($menssagem, 70);
			$headers = "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: <noreplay@ecoflow.net.br>\r\n";
			mail(EMAIL, $assunto, $menssagem, $headers);
  	}

 ?>