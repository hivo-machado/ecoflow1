<?php
	
	//include_once('../conexao.php');
	//echo consumoDia($con, 2150, 2016, 12);
	
	//Retorna string com consumo diario de um mês
	function consumoDia($con, $id, $ano, $mes){

		//Numero de dias do mes
		$numDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
		//String com dias e consumo
		$str = null;
		// Loop para calculo consumo do dias do mes
		for ($dia = 1; $dia <= $numDiasMes; $dia++){
			$ant = $dia - 1;

			// Converte a data para modelo do banco de dados
			$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$mes.'-'.$ant)));
		    $date = date_create($data);
			$tempo =  date_format($date, 'Y-m-d');

			$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and tempo like '$tempo%' ORDER by tempo LIMIT 1");
			$unidadeAnt = mysqli_fetch_object($result);
			//Caso não exista leitura anterior
			if(isset($unidadeAnt)){
				$leituraAnt = $unidadeAnt->leitura;
			}else{
				$leituraAnt = 0;					
			}
			
			// Converte a data para modelo do banco de dados 
			$data = date("Y-m-d",strtotime(str_replace('/','-',$ano.'-'.$mes.'-'.$dia)));
			$date = date_create($data);
			$tempo =  date_format($date, 'Y-m-d');

			$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and tempo like '$tempo%' ORDER by tempo LIMIT 1");
			$unidade = mysqli_fetch_object($result);
			
			//Caso não exista leitura o consumo 0
			if(isset($unidade)){
				if($leituraAnt != 0){
					$unidade->leitura;
					$consumo = $unidade->leitura - $leituraAnt;	
				}else{
					$consumo = 0;
				} 
			}else{
				$consumo = 0;
			}
			$str = $str.'['.$dia.','.$consumo.']';
            if($dia != 31) $str = $str.',';
		}
		return $str;		
	}

	function consumoMes($con, $id, $ano, $mes, $dia = 18){
		//Primerira leitura do mes
		$tempo = $ano.'-'.$mes.'-'.$dia;
		$resUnid = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = 0 and tempo like '$tempo%' ORDER by tempo LIMIT 1");
		$unidade = mysqli_fetch_object($resUnid);

		//Primerira leitura do mes posterior
		$cont = 0;
		$mes += 1;
		do{
			if($dia < 1){
				$dia = 31;
				echo $mes--;
				$cont = 0;
			}
			$auxDia = $dia - $cont;
			$tempo = $ano.'-'.$mes.'-'.$auxDia;
			$resUnidPos = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and servico = 0 and tempo like '$tempo%' ORDER by tempo LIMIT 1");
			$cont++;
		}while($resUnidPos);
		$unidadePos = mysqli_fetch_object($resUnidPos);

		if(isset($unidade)){
			echo 'pos'.$pos = $unidadePos->leitura;
			echo 'atual'.$atual = $unidade->leitura;
			$consumoDoMes = $pos - $atual;
			return  'Consumo do mes: '.$consumoDoMes;
		}
		
		return 0;
	}

 ?>