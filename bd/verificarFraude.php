<?php 
	//Atividade CRON para verificar possiveis fraudes de consumo zerado

	//Conexão com banco de dados
	include_once("/home/ecofl253/public_html/conexao.php");
	include_once("/home/ecofl253/public_html/corpoEmail.php");

	//E-mail
	$email = 'none';
	
	//Fuso horario
  	date_default_timezone_set('America/Sao_Paulo');
	
	//Data atual
  	$tempoAtual = strtotime( date('Y-m-d'));
	
	//Data do dia anterior
	$tempoAnt = strtotime('-1 day', $tempoAtual);
    $dataAnt =  date_format( date_create( date('Y-m-d', $tempoAnt) ),'Y-m-d' );
    
    //Data de uma semana anterior
    $tempo1Sem = strtotime('-1 week', $tempoAtual);
    $data1Sem =  date_format( date_create( date('Y-m-d', $tempo1Sem) ),'Y-m-d' );
    //echo($data1Sem);

    //Data de duas semanas anteriores
    $tempo2Sem = strtotime('-2 week', $tempoAtual);
    $data2Sem =  date_format( date_create( date('Y-m-d', $tempo2Sem) ),'Y-m-d' );
    //echo($data2Sem);

	$grupos = mysqli_query($con, "SELECT * FROM grupo");
	
	$arrayFraude = array();

	//Percorre todos os grupos
	while ( $grupo = mysqli_fetch_object($grupos) ) {
		
		$plantas = mysqli_query($con, "SELECT * FROM planta WHERE id_grupo_fk = '$grupo->id'");

		//Percorre todas as plantas
		while ( $planta = mysqli_fetch_object($plantas) ) {

            $unidades = mysqli_query($con, "SELECT * FROM unidade WHERE id_planta_fk = '$planta->idecoflow' AND tempo = '$dataAnt' AND hora LIKE '06:%' GROUP BY idecoflow");
		   
			echo($unidades);

			while ($unidade = mysqli_fetch_object($unidades) ) {
                
                //$unidades1Sem = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = $idecoflow AND servico = $servico AND tempo = '$data1Sem' AND hora LIKE '06:%' GROUP BY idecoflow");
				//echo($unidades1Sem);
				// $leitura1Sem = $unidades1Sem->leitura;
                // $unidades2Sem = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = $idecoflow AND servico = $servico AND tempo = '$data2Sem' AND hora LIKE '06:%' GROUP BY idecoflow");
				// $leitura2Sem = $unidades2Sem->leitura;
				//echo($unidades2Sem);
				
				// $testeFraude = $leitura1Sem-$leitura2Sem;
				//echo($testeFraude);

                // if($leitura1Sem-$leitura2Sem =! 0){
                //     if($leitura-$leitura1Sem == 0){
                //         $strUni .= '<strong>Planta: '.$planta->nome.'<br> Unidade: '.$unidade->nome.'('.$servico.')'.'</strong><br><br>';
                //         echo($strUni);
                //     }
                // }				
			}

		}//Fecha while planta
		
		
	}// fecha while do grupo
 ?>