<?php 
	include_once("../conexao.php");
	include_once("funcaoPlanta.php");
	include_once("../php/Classes/PHPExcel.php");

	//variavel
	$cont = 2;

	//Variavel POST
	$id = $_POST['id_planta'];
	$anoInicio = $_POST['anoInicio'];
	$mesInicio = $_POST['mesInicio'];
	$diaInicio = $_POST['diaInicio'];
	$anoFim = $_POST['anoFim'];
	$mesFim = $_POST['mesFim'];
	$diaFim = $_POST['diaFim'];

	//Consultar planta
	$result = mysqli_query($con, "SELECT * from planta WHERE idecoflow = '$id'");
	$planta = mysqli_fetch_object($result);

	$nome = $planta->nome;

	// Nome do Arquivo do Excel que será gerado
	$arquivo = $nome.' '.$diaInicio.'-'.$mesInicio.'-'.$anoInicio.' '.$diaFim.'-'.$mesFim.'-'.$anoFim.'.xls';

	// Instanciamos a classe
	$objPHPExcel = new PHPExcel();

	//Consulta o Banco de dados e retorna vetor com nome da unidade e consumo
	$consumosAguaFria = consumo($con, $id, 0, $anoInicio, $mesInicio, $diaInicio, $anoFim, $mesFim, $diaFim);
	$consumosAguaQuente = consumo($con, $id, 1, $anoInicio, $mesInicio, $diaInicio, $anoFim, $mesFim, $diaFim);

	//Calcula o total de consumo
	$totalAguaFria = consumoTotal($consumosAguaFria);
	$totalAguaQuente = consumoTotal($consumosAguaQuente);

	//Valor Nulo
	$consumosAguaQuente[] = array(0, 0);


	// Criamos as colunas
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Unidade' )
	            ->setCellValue('B1', 'Água Fria' )
	            ->setCellValue('C1', 'Água Quente' )
	            ->setCellValue('D1', 'SubTotal' );

	// Definimos o estilo da fonte
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);

	// Podemos configurar diferentes larguras paras as colunas como padrão
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

	//loop de todas as unidades
	for($i = 0; $i < count($consumosAguaFria); $i++){
		$j = count($consumosAguaQuente) - 1;
	    //Verifica unidade são as mesma de agua fria e quente
	    for($k = 0; $k < count($consumosAguaQuente) - 1; $k++){
	        if( strcmp($consumosAguaFria[$i][0],$consumosAguaQuente[$k][0]) == 0){
	          	$j = $k;
	        }
	    }
		// Também podemos escolher a posição exata aonde o dado será inserido (coluna, linha, dado);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $cont, $consumosAguaFria[$i][0]);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $cont, number_format($consumosAguaFria[$i][1] * 1000, 0, '', '') );
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $cont, number_format($consumosAguaQuente[$j][1] * 1000, 0, '', '') );
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $cont, number_format( ($consumosAguaFria[$i][1] + $consumosAguaQuente[$j][1]) * 1000, 0, '', '') );
		$cont++;
	}

	// Definimos o estilo da fonte
	$objPHPExcel->getActiveSheet()->getStyle('A'.$cont)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('B'.$cont)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('C'.$cont)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$cont)->getFont()->setBold(true);
	
	// Também podemos escolher a posição exata aonde o dado será inserido (coluna, linha, dado);
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $cont, 'TOTAL');
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $cont, number_format($totalAguaFria * 1000 , 0, '', '') );
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $cont, number_format($totalAguaQuente * 1000 , 0, '', '') );
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $cont, number_format( ($totalAguaFria + $totalAguaQuente) * 1000 , 0, '', '') );

	// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
	$objPHPExcel->getActiveSheet()->setTitle($nome);

	// Cabeçalho do arquivo para ele baixar
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment;filename=\"{$arquivo}\"");
	header('Cache-Control: max-age=0');
	// Se for o IE9, isso talvez seja necessário
	header('Cache-Control: max-age=1');

	// Acessamos o 'Writer' para poder salvar o arquivo
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

	// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
	$objWriter->save('php://output'); 

	exit;
 ?>