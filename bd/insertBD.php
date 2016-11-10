<?php 
include_once("../conexao.php");

$xml = simplexml_load_file('http://ecoflow.ind.br/rest?groupId=2&login=suportti&password=suportti'); /* Lê o arquivo XML e recebe um objeto com as informações */
 
/* Percorre o objeto e imprime na tela as informações de cada contato */
foreach ($xml->grupo as $grupo){

    $result = mysqli_query($con, "SELECT * FROM grupo WHERE nome = '$grupo->nome'");
    $resgrupo = mysqli_fetch_object($result);
	if(!isset($resgrupo)){
	    $sql = "INSERT INTO grupo (id, nome) VALUES ('$grupo->id', '$grupo->nome')";
		mysqli_query($con, $sql);
	}

    foreach ($grupo->plantas->planta as $planta) {
    	$result = mysqli_query($con, "SELECT * FROM grupo WHERE nome = '$grupo->nome'");
    	$resgrupo = mysqli_fetch_object($result);
	   	$result = mysqli_query($con, "SELECT * FROM planta WHERE nome = '$planta->nome'");
	   	$resplanta = mysqli_fetch_object($result);
	   	if(!isset($resplanta)){
			$idecoflow = $planta->{'id-ecoflow'};
		    $sql = "INSERT INTO planta (idecoflow, id_grupo_fk, nome) VALUES ('$idecoflow', '$resgrupo->id', '$planta->nome')";
			mysqli_query($con, $sql);
		}
	    foreach ($planta->unidades->unidade as $unidade) {

	    	$data = date("Y-m-d H:i:s",strtotime(str_replace('/','-',$unidade->timestamp)));
	    	$date = date_create($data);
			$tempo =  date_format($date, 'Y-m-d H:i:s');

			$result = mysqli_query($con, "SELECT * FROM planta WHERE nome = '$planta->nome'");
	   		$resplanta = mysqli_fetch_object($result);

	    	$idecoflow = $unidade->{'id-ecoflow'};
		    $sql = "INSERT INTO unidade (idecoflow, tempo, id_planta_fk, nome, medidor, servico, leitura) 
		    VALUES ('$idecoflow', '$tempo', '$resplanta->idecoflow', '$unidade->nome', '$unidade->medidor', '$unidade->servico', '$unidade->leitura')";
			mysqli_query($con, $sql);
	    }
    }
}
?>