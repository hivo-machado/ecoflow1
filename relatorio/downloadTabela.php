<?php 
	 include_once("../conexao.php");
	 include_once("funcaoMesPlanta.php");

	 //Variavel POST
	$id = $_POST['id_planta'];
	$ano = $_POST['ano'];
	$mes = $_POST['mes'];
	$dia = $_POST['dia'];


	//Consulta o Banco de dados e retorna vetor com nome da unidade e consumo
	$consumos = consumo($con, $id, $ano, $mes, $dia);

	//Total de consumo da consulta
	$total = consumoTotal($consumos);

	// Nome do Arquivo do Excel que será gerado
	$arquivo = 'Planta_'.$id.'_'.$dia.'-'.$mes.'-'.$ano.'.xls';

	// Criamos uma tabela HTML com o formato da planilha para excel
	$tabela = '<table border="1">';
	$tabela .= '<tr>';
	$tabela .= '<td colspan="2">Tabela de Consumo '.$dia.'/'.$mes.'/'.$ano.'</tr>';
	$tabela .= '</tr>';
	$tabela .= '<tr>';
	$tabela .= '<td><b>Unidade</b></td>';
	$tabela .= '<td><b>Consumo</b></td>';
	$tabela .= '</tr>';

	//loop para soma total
	for($i = 0; $i < count($consumos[0]); $i++){
		$tabela .= '<tr>';
		$tabela .= '<td>'.$consumos[0][$i].'</td>';
		$tabela .= '<td>'.number_format($consumos[1][$i], 3, '', '').'</td>';
		$tabela .= '</tr>';
	}

	$tabela .= '<tr>';
	$tabela .= '<td>Total</td>';
	$tabela .= '<td>'.$total.'</td>';
	$tabela .= '</tr>';
	$tabela .= '</table>';

	// Força o Download do Arquivo Gerado
	header ('Cache-Control: no-cache, must-revalidate');
	header ('Pragma: no-cache');
	header('Content-Type: application/x-msexcel');
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"");


	echo $tabela;

?>