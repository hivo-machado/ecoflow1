<?php 
	function consumo($con, $id, $ano, $mes, $dia = 1){
		//Iniciar time zone
		date_default_timezone_set('America/Sao_Paulo');

		//Variavel
		$listUniNome = null;
		$listUniConsumo = null;
		$listConsumo = null;
		$cont = 0;

		//Data do Inicio do intervalo
		$dataInicio = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$mes.'-'.$dia)));
		$dateInicio = date_create($dataInicio);
		$tempoInicio =  date_format($dateInicio, 'Y-m-d');// Formato de data para BD

		//Data de Fim do intervalo
		$dateFim = $dateInicio;
		$dateFim->add(new DateInterval("P1M")); // Soma um mes
		$tempoFim =  date_format($dateFim, 'Y-m-d'); // Formato de data para BD

		$unidades = mysqli_query($con, "SELECT * FROM unidade WHERE id_planta_fk = '$id' AND servico = '0' AND tempo = '$tempoInicio' GROUP BY idecoflow ORDER BY hora");

		//Percorre todas as unidade da planta
		while ( $unidade = mysqli_fetch_object($unidades) ) {
			//Seleciona a leitura final da unidade
			$resFim = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$unidade->idecoflow' AND servico = '0' AND tempo <= '$tempoFim' ORDER BY tempo DESC, hora ASC LIMIT 1");
			$unidadeFim = mysqli_fetch_object($resFim);

			$listUniNome[$cont] = $unidade->nome;
			$listUniConsumo[$cont] = number_format($unidadeFim->leitura - $unidade->leitura, 3, '.', '');

			$cont++;

			//echo $unidade->idecoflow.'<br>';
		}

		return $listConsumo = array($listUniNome, $listUniConsumo);
	}

	// Função para consumo total do mês
	function consumoTotal($consumo){
		$total = 0; //String para retonar dias e consumo

		//loop para preenchimento da string de retorno da função
		for($i = 0; $i < count($consumo[0]); $i++){
			$total = $total + $consumo[1][$i];
		}
		return $total;
	}


	//include('../conexao.php');
	//var_dump( consumo($con, 9, 2017, 01, 2) );
?>