<?php 
	 include_once("../conexao.php");
	 include_once("funcaoMesPlanta.php");

	 //Variavel POST
	$id = $_POST['id_planta'];
	$anoInicio = $_POST['anoInicio'];
	$mesInicio = $_POST['mesInicio'];
	$diaInicio = $_POST['diaInicio'];
	$anoFim = $_POST['anoFim'];
	$mesFim = $_POST['mesFim'];
	$diaFim = $_POST['diaFim'];


	//Consulta o Banco de dados e retorna vetor com nome da unidade e consumo
	$consumos = consumo($con, $id, $anoInicio, $mesInicio, $diaInicio, $anoFim, $mesFim, $diaFim);

	//Total de consumo da consulta
	$total = consumoTotal($consumos);

	// Nome do Arquivo do Excel que será gerado
	$arquivo = 'Planta_'.$id.'_'.$diaInicio.'-'.$mesInicio.'-'.$anoInicio.'_'.$diaFim.'-'.$mesFim.'-'.$anoFim.'.xls';

	// Criamos uma tabela HTML com o formato da planilha para excel
	$tabela = '<table border="1">';
	$tabela .= '<tr>';
	$tabela .= '<td colspan="2"><strong>Tabela de Consumo '.$diaInicio.'/'.$mesInicio.'/'.$anoInicio.' - '.$diaFim.'/'.$mesFim.'/'.$anoFim.'</strong></td>';
	$tabela .= '</tr>';
	$tabela .= '<tr>';
	$tabela .= '<td><strong>Unidade</strong></td>';
	$tabela .= '<td><strong>Consumo</strong></td>';
	$tabela .= '</tr>';

	//loop para soma total
	for($i = 0; $i < count($consumos[0]); $i++){
		$tabela .= '<tr>';
		$tabela .= '<td>'.$consumos[0][$i].'</td>';
		$tabela .= '<td>'.number_format($consumos[1][$i], 3, '', '').'</td>';
		$tabela .= '</tr>';
	}

	$tabela .= '<tr>';
	$tabela .= '<td><strong>Total</strong></td>';
	$tabela .= '<td><strong>'.number_format($total, 3, '', '').'</strong></td>';
	$tabela .= '</tr>';
	$tabela .= '</table>';

	// Força o Download do Arquivo Gerado
	header ('Cache-Control: no-cache, must-revalidate');
	header ('Pragma: no-cache');
	header('Content-Type: application/x-msexcel');
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"");


	echo $tabela;

?>