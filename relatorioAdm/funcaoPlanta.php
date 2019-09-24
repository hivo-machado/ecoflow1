<?php 
	function consumo($con, $id, $servico, $anoInicio, $mesInicio, $diaInicio, $anoFim, $mesFim, $diaFim){
		//Iniciar time zone
		date_default_timezone_set('America/Sao_Paulo');

		//Variavel
		$listConsumo = array();

		//Data do Inicio do intervalo
		$dataInicio = date("Y-m-d",strtotime(str_replace('/','-',$anoInicio.'-'.$mesInicio.'-'.$diaInicio)));
		$dateInicio = date_create($dataInicio);
		$tempoInicio =  date_format($dateInicio, 'Y-m-d');// Formato de data para BD

		//Data de Fim do intervalo
		$dataFim = date("Y-m-d",strtotime(str_replace('/','-',$anoFim.'-'.$mesFim.'-'.$diaFim)));
		$dateFim = date_create($dataFim);
		$tempoFim =  date_format($dateFim, 'Y-m-d'); // Formato de data para BD

		$usuarios = mysqli_query($con, "SELECT * FROM unidade WHERE id_planta_fk = $id AND servico = '$servico' GROUP BY idecoflow ORDER BY nome");

		//Percorre todas as unidade da planta
		while ( $usuario = mysqli_fetch_object($usuarios) ) {
			//Seleciona a leitura inicial da unidade
			$resInicio = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$usuario->idecoflow' AND servico = '$servico' AND tempo BETWEEN '$tempoInicio' AND '$tempoFim' ORDER BY tempo ASC, hora ASC LIMIT 1");
			$unidadeInicio = mysqli_fetch_object($resInicio);

			//Seleciona a leitura final da unidade
			$resFim = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$usuario->idecoflow' AND servico = '$servico' AND tempo BETWEEN '$tempoInicio' AND '$tempoFim' ORDER BY tempo DESC, hora ASC LIMIT 1");
			$unidadeFim = mysqli_fetch_object($resFim);

			if (isset($unidadeFim)||(isset($unidadeInicio))) {
				$listConsumo[] = array( $usuario->nome, number_format($unidadeInicio->leitura, 3, '.', ''), $unidadeInicio->tempo, number_format($unidadeFim->leitura, 3, '.', ''), $unidadeFim->tempo, number_format($unidadeFim->leitura - $unidadeInicio->leitura, 3, '.', '') );
			}else{
				$listConsumo[] = array( $usuario->nome, 0 );
			}
		}

		return $listConsumo;
	}

	// Função para consumo total do mês
	function consumoTotal($consumos){
		$total = 0; //String para retonar dias e consumos

		//loop para soma total
		for($i = 0; $i < count($consumos); $i++){
			$total += $consumos[$i][1];
		}

		return $total;
	}

	function leitura($con, $id, $servico, $data, $hora){
		//Iniciar time zone
		date_default_timezone_set('America/Sao_Paulo');

		//Variavel
		$listLeitura = array();

		//Data do Inicio do intervalo
		$data = date("Y-m-d",strtotime(str_replace('/','-', $data)));
		$date = date_create($data);
		$tempo =  date_format($date, 'Y-m-d');// Formato de data para BD

		//Seleciona todos os usuario de um grupo de perfil usuario
		$usuarios = mysqli_query($con, "SELECT * FROM unidade WHERE id_planta_fk = $id AND servico = '$servico' GROUP BY idecoflow ORDER BY nome");

		//Percorre todas as unidade do grupo
		while ( $usuario = mysqli_fetch_object($usuarios) ) {
			//Seleciona a leitura inicial da unidade
			$res = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$usuario->idecoflow' AND servico = '$servico' AND tempo <= '$tempo' AND hora <= '$hora' ORDER BY tempo DESC, hora DESC LIMIT 1");
			$unidade = mysqli_fetch_object($res);

			if(isset($unidade)){
				$listLeitura[] = array($usuario->nome, $unidade->tempo, $unidade->hora, number_format( $unidade->leitura, 3, '.', '') );
			}else{
				$listLeitura[] = array($usuario->nome, 0, 0, 0 );
			}
		}//fim while

		return $listLeitura;
	}//Fim da função

?>