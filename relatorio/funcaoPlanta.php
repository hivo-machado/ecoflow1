<?php 
	function consumo($con, $id, $anoInicio, $mesInicio, $diaInicio, $anoFim, $mesFim, $diaFim){
		//Iniciar time zone
		date_default_timezone_set('America/Sao_Paulo');

		//Variavel
		$listUniNome = null;
		$listUniConsumo = null;
		$listConsumo = null;
		$cont = 0;

		//Data do Inicio do intervalo
		$dataInicio = date("Y-m-d",strtotime(str_replace('/','-',$anoInicio.'-'.$mesInicio.'-'.$diaInicio)));
		$dateInicio = date_create($dataInicio);
		$tempoInicio =  date_format($dateInicio, 'Y-m-d');// Formato de data para BD

		//Data de Fim do intervalo
		$dataFim = date("Y-m-d",strtotime(str_replace('/','-',$anoFim.'-'.$mesFim.'-'.$diaFim)));
		$dateFim = date_create($dataFim);
		$tempoFim =  date_format($dateFim, 'Y-m-d'); // Formato de data para BD

		$usuarios = mysqli_query($con, "SELECT * FROM usuario WHERE id_planta = $id");

		//Percorre todas as unidade da planta
		while ( $usuario = mysqli_fetch_object($usuarios) ) {
			//Seleciona a leitura inicial da unidade
			$resInicio = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$usuario->id_unidade' AND servico = '0' AND tempo BETWEEN '$tempoInicio' AND '$tempoFim' ORDER BY tempo ASC, hora ASC LIMIT 1");
			$unidadeInicio = mysqli_fetch_object($resInicio);

			//Seleciona a leitura final da unidade
			$resFim = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$usuario->id_unidade' AND servico = '0' AND tempo BETWEEN '$tempoInicio' AND '$tempoFim' ORDER BY tempo DESC, hora ASC LIMIT 1");
			$unidadeFim = mysqli_fetch_object($resFim);


			$listUniNome[$cont] = $usuario->nome;
			if (isset($unidadeFim)||(isset($unidadeInicio))) {
				$listUniConsumo[$cont] = number_format($unidadeFim->leitura - $unidadeInicio->leitura, 3, '.', '');
			}else{
				$listUniConsumo[$cont] = number_format(0, 3, '.', '');;
			}

			$cont++;
		}

		return $listConsumo = array($listUniNome, $listUniConsumo);
	}

	// Função para consumo total do mês
	function consumoTotal($consumos){
		$total = 0; //String para retonar dias e consumos

		//loop para soma total
		for($i = 0; $i < count($consumos[0]); $i++){
			$total += $consumos[1][$i];
		}

		return $total;
	}

	function leitura($con, $id, $data, $hora){
		//Iniciar time zone
		date_default_timezone_set('America/Sao_Paulo');

		//Variavel
		$listUniNome = null;
		$listHora = null;
		$listUniLeitura = null;
		$listLeitura = null;
		$cont = 0;

		//Data do Inicio do intervalo
		$data = date("Y-m-d",strtotime(str_replace('/','-', $data)));
		$date = date_create($data);
		$tempo =  date_format($date, 'Y-m-d');// Formato de data para BD

		//Seleciona todos os usuario de um grupo de perfil usuario
		$usuarios = mysqli_query($con, "SELECT * FROM usuario WHERE id_planta = $id");

		//Percorre todas as unidade do grupo
		while ( $usuario = mysqli_fetch_object($usuarios) ) {
			//Seleciona a leitura inicial da unidade
			$res = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$usuario->id_unidade' AND servico = '0' AND tempo = '$tempo' AND hora <= '$hora' ORDER BY hora DESC LIMIT 1");
			$unidade = mysqli_fetch_object($res);

			$listUniNome[$cont] = $usuario->nome;
			if(isset($unidade)){
				$listHora[$cont] = $unidade->hora;
				$listUniLeitura[$cont] = number_format( $unidade->leitura, 3, '.', '');
			}else{
				$listUniLeitura[$cont] = 0;
			}

			$cont++;
		}//fim while

		return $listLeitura = array($listUniNome, $listHora, $listUniLeitura);
	}//Fim da função

?>