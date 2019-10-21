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
  	$tempoAtual = strtotime( date('Y-m-d') );
	
	//Data do dia anterior
	$tempoAnt = strtotime('-1 day', $tempoAtual);
    $dataAnt =  date_format( date_create( date('Y-m-d', $tempoAnt) ),'Y-m-d' );
    
    //Data de uma semana anterior
    $tempo1Sem = strotime('-1 week', $tempoAtual);
    $data1Sem =  date_format( date_create( date('Y-m-d', $tempo1Sem) ),'Y-m-d' );
    echo($data1Sem);

    //Data de duas semanas anteriores
    $tempo2Sem = strotime('-2 week', $tempoAtual);
    $data2Sem =  date_format( date_create( date('Y-m-d', $tempo2Sem) ),'Y-m-d' );
    echo($data2Sem);

	$grupos = mysqli_query($con, "SELECT * FROM grupo");

	//Percorre todos os grupos
	while ( $grupo = mysqli_fetch_object($grupos) ) {
		//flag para enviar ou não enviar e-mail
        // $flag = false;

		//String com idetinficação das unidades
		$strUni = null;
		
		$plantas = mysqli_query($con, "SELECT * FROM planta WHERE id_grupo_fk = '$grupo->id'");

		//Percorre todas as plantas
		while ( $planta = mysqli_fetch_object($plantas) ) {

            $unidades = mysqli_query($con, "SELECT * FROM unidade WHERE id_planta_fk = '$planta->idecoflow' AND tempo = '$dataAnt' AND hora LIKE '06:%' GROUP BY idecoflow");
            
			//Iniciar variavel vetor e contador
            // $vetorUnidades = array();
            // $vetorServico = array();
            // $vetorLeituras = array();
			// $cont = 0;

			//add todas as unidades vetor
			while ($unidade = mysqli_fetch_object($unidades) ) {
                $idecoflow = $unidades->idecoflow;
                $servico = $unidades->servico;
                $leitura = $leitura->servico; 

                $unidades1Sem = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = $idecoflow AND servico = $servico AND tempo = '$data1Sem' AND hora LIKE '06:%' GROUP BY idecoflow");
                $leitura1Sem = $unidades1Sem->leitura;
                $unidades2Sem = mysqli_query($con, "SELECT * FROM unidade WHERE idecoflow = $idecoflow AND servico = $servico AND tempo = '$data2Sem' AND hora LIKE '06:%' GROUP BY idecoflow");
                $leitura2Sem = $unidades2Sem->leitura;

                if($leitura1Sem-$leitura2Sem =! 0){
                    if($leitura-$leitura1Sem == 0){
                        $strUni .= '<strong>Planta: '.$planta->nome.'<br> Unidade: '.$unidade->nome.'('.$servico.')'.'</strong><br><br>';
                        echo($strUni);
                        // $vetorUnidades[$cont] = $unidade->nome;
                        // $vetorServico[$cont] = $unidade->servico;
                        // $vetorLeituras[$cont] = $unidade->leitura;
                        // $cont++;
                    }
                }				
			}

		}//Fecha while planta
		
		//Enviar e-mail se pelo menos uma unidade estiver offline 
		if($flagUnidade){
			//envia e-email
			$assunto = "Unidades com consumo zero";
			$menssagem = $headerEmail."
				<h4>Unidades</h4>
				O sistema verificou unidades com consumo zero.<br>
				Data: $dataAnt<br>
				<br> 
				$strUni
			".$footerEmail;
			$menssagem = wordwrap($menssagem, 70);
			$headers = "Content-type: text/html; charset=utf-8\r\n";
			$headers .= "From: <noreplay@ecoflow.net.br>\r\n";
			mail($email, $assunto, $menssagem, $headers);
		}

		
	}// fecha while do grupo
 ?>