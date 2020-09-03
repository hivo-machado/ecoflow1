<?php

	//Retorna string com status diario de um mês
	function statusBateria($con, $device, $ano, $mes, $dia = 1){
		//Iniciar time zone
		date_default_timezone_set('America/Sao_Paulo');
		//iniciar variavel
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); //Numero de dias do mes
		$i = 0;		

		//Data do Inicio do intervalo
		$dataInicio = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$mes.'-'.$dia)));
		$dateInicio = date_create($dataInicio);
		$tempoInicio =  date_format($dateInicio, 'Y-m-d');

		// //Data de Fim do intervalo
		$dateFim = $dateInicio;
		$dateFim->add(new DateInterval("P1M")); // Soma um mes
		$tempoFim =  date_format($dateFim, 'Y-m-d'); // Formato de data para BD
		
		//Seleciona as primeiras leituras de cada dia
		$result = mysqli_query($con, "SELECT * FROM lorawan_status WHERE device_addr = '$device' AND tempo BETWEEN '$tempoInicio' AND '$tempoFim' GROUP BY tempo ORDER BY tempo ASC");
		
		//Percorre todos os resultado do SELECT
		while( $bateria = mysqli_fetch_object($result) ){
			$listaBateria[$i] = $bateria->nivel_bateria;
			$listaData[$i] = $bateria->tempo;
		}
		return $return = array($listaBateria, $listaData);
	}//Fim da função

	//Retorna string com status diario de um mês
	function statusRssi($con, $device, $ano, $mes, $dia = 1){
		//Iniciar time zone
		date_default_timezone_set('America/Sao_Paulo');
		//iniciar variavel
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); //Numero de dias do mes
		$i = 0;		

		//Data do Inicio do intervalo
		$dataInicio = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$mes.'-'.$dia)));
		$dateInicio = date_create($dataInicio);
		$tempoInicio =  date_format($dateInicio, 'Y-m-d');

		// //Data de Fim do intervalo
		$dateFim = $dateInicio;
		$dateFim->add(new DateInterval("P1M")); // Soma um mes
		$tempoFim =  date_format($dateFim, 'Y-m-d'); // Formato de data para BD
		
		//Seleciona as primeiras leituras de cada dia
		$result = mysqli_query($con, "SELECT * FROM lorawan_status WHERE device_addr = '$device' AND tempo BETWEEN '$tempoInicio' AND '$tempoFim' GROUP BY tempo ORDER BY tempo ASC");
		
		//Percorre todos os resultado do SELECT
		while( $bateria = mysqli_fetch_object($result) ){
			$listaBateria[$i] = $bateria->nivel_bateria;
			$listaData[$i] = $bateria->tempo;
		}
		return $return = array($listaBateria, $listaData);
	}//Fim da função

	//Retorna string com status diario de um mês
	function statusSnr($con, $device, $ano, $mes, $dia = 1){
		//Iniciar time zone
		date_default_timezone_set('America/Sao_Paulo');
		//iniciar variavel
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); //Numero de dias do mes
		$i = 0;		

		//Data do Inicio do intervalo
		$dataInicio = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$mes.'-'.$dia)));
		$dateInicio = date_create($dataInicio);
		$tempoInicio =  date_format($dateInicio, 'Y-m-d');

		// //Data de Fim do intervalo
		$dateFim = $dateInicio;
		$dateFim->add(new DateInterval("P1M")); // Soma um mes
		$tempoFim =  date_format($dateFim, 'Y-m-d'); // Formato de data para BD
		
		//Seleciona as primeiras leituras de cada dia
		$result = mysqli_query($con, "SELECT * FROM lorawan_status WHERE device_addr = '$device' AND tempo BETWEEN '$tempoInicio' AND '$tempoFim' GROUP BY tempo ORDER BY tempo ASC");
		
		//Percorre todos os resultado do SELECT
		while( $bateria = mysqli_fetch_object($result) ){
			$listaBateria[$i] = $bateria->nivel_bateria;
			$listaData[$i] = $bateria->tempo;
		}
		return $return = array($listaBateria, $listaData);
	}//Fim da função
	//Retorna string com consumo diario de um mês para grafico
	function statusGrafico($valor, $ano, $mes){
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); //Numero de dias do mes
		$str = '['; //String para retonar dias e consumo

		//loop para preenchimento da string de retorno da função
		for ($i = 1; $i <= $numDiasMes; $i++){
			$str .= number_format($valor[0][$i], 3, '.', '');
		    if($i != $numDiasMes ) $str .= ',';
		}
		$str .= ']';
		return $str;
	}

	//Retorna string com os dias do mes
	function qtdDias($valor, $ano, $mes){
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); //Numero de dias do mes
		$str = '['; //String para retonar dias e consumo
		
		for($i = 1; $i <= $numDiasMes; $i++){
			$str .= date('d',strtotime($valor[1][$i]) );
			if($i != $numDiasMes) $str .= ',';
		}
		$str .= ']';
		return $str;
	}
	
 ?>