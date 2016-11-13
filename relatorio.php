<?php

	echo consumoDia(13);
	
	function consumoDia($dia, $mes = 11, $ano = 2016, $id = 1770)
	{
		include("conexao.php");
		
		$ant = $dia - 1;
		$tempo = $ano.'-'.$mes.'-'.$ant;
		
		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and tempo like '$tempo%' ORDER by tempo LIMIT 1");
		$unidadeAnt = mysqli_fetch_object($result);
		//Caso não exista leitura anterior
		if(isset($unidadeAnt)){
			$leituraAnt = $unidadeAnt->leitura;
		}else{
			$leituraAnt = 0;		
		}
		
		$tempo = $ano.'-'.$mes.'-'.$dia;

		$result = mysqli_query($con, "SELECT * from unidade WHERE idecoflow = '$id' and tempo like '$tempo%' ORDER by tempo LIMIT 1");
		$unidade = mysqli_fetch_object($result);
		//Caso não exista leitura o consumo 0
		if(isset($unidade)){
			$consumo = $unidade->leitura - $leituraAnt;	
		}else{
			$consumo = 0;
		}		
		return $consumo;		
		
	}

 ?>