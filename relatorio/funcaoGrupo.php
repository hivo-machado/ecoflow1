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

		$usuarios = mysqli_query($con, "SELECT * FROM usuario WHERE id_grupo = $id AND tipo = 'usuario'");

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
		}//fim while

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
?>