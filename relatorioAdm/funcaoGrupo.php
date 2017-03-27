<?php
	
	function leitura($con, $id, $servico, $data, $hora){
		//Iniciar time zone
		date_default_timezone_set('America/Sao_Paulo');

		//Variavel
		$listUniNome = null;
		$listData = null;
		$listHora = null;
		$listUniLeitura = null;
		$listLeitura = null;
		$cont = 0;

		//Data do Inicio do intervalo
		$data = date("Y-m-d",strtotime(str_replace('/','-', $data)));
		$date = date_create($data);
		$tempo =  date_format($date, 'Y-m-d');// Formato de data para BD

		//Seleciona todos os usuario de um grupo de perfil usuario
		$usuarios = mysqli_query($con, "SELECT un.idecoflow idecoflow, un.nome nome FROM unidade un INNER JOIN planta pl ON pl.id_grupo_fk = '$id' AND pl.idecoflow = un.id_planta_fk WHERE un.servico = '$servico' GROUP BY un.idecoflow ORDER BY un.nome");

		//Percorre todas as unidade do grupo
		while ( $usuario = mysqli_fetch_object($usuarios) ) {
			//Seleciona a leitura inicial da unidade
			$res = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = '$usuario->idecoflow' AND servico = '$servico' AND tempo <= '$tempo' AND hora <= '$hora' ORDER BY tempo DESC, hora DESC LIMIT 1");
			$unidade = mysqli_fetch_object($res);

			$listUniNome[$cont] = $usuario->nome;
			if(isset($unidade)){
				$listData[$cont] = $unidade->tempo;
				$listHora[$cont] = $unidade->hora;
				$listUniLeitura[$cont] = number_format( $unidade->leitura, 3, '.', '');
			}else{
				$listData[$cont] = 0;
				$listHora[$cont] = 0;
				$listUniLeitura[$cont] = 0;
			}

			$cont++;
		}//fim while

		return $listLeitura = array($listUniNome, $listData, $listHora, $listUniLeitura);
	}//Fim da função

	
?>