<?php 
	include_once("../conexao.php");
	include_once("funcaoPlanta.php");
	include_once("../php/Classes/PHPExcel.php");

	//variavel
	$planilha = 0;

	//Variavel POST
	$id = $_POST['id_grupo'];
	$anoInicio = $_POST['anoInicio'];
	$mesInicio = $_POST['mesInicio'];
	$diaInicio = $_POST['diaInicio'];
	$anoFim = $_POST['anoFim'];
	$mesFim = $_POST['mesFim'];
	$diaFim = $_POST['diaFim'];

	//Consultar Grupo
	$result = mysqli_query($con, "SELECT * from grupo WHERE id = '$id'");
	$grupo = mysqli_fetch_object($result);

	//Consultar plantas
	$plantas = mysqli_query($con, "SELECT * FROM planta WHERE id_grupo_fk = '$id' ORDER BY nome");
	
	// Nome do Arquivo do Excel que será gerado
	$arquivo = $grupo->nome.' '.$diaInicio.'-'.$mesInicio.'-'.$anoInicio.' '.$diaFim.'-'.$mesFim.'-'.$anoFim.'.xls';

	// Instanciamos a classe
	$objPHPExcel = new PHPExcel();

	//Loop por planta
	while( $planta = mysqli_fetch_object($plantas) ){
		$cont = 2;

		// Criando uma nova planilha dentro do arquivo
		$objPHPExcel->createSheet();

		//Consulta o Banco de dados e retorna vetor com nome da unidade e consumo
		$consumos = consumo($con, $planta->idecoflow, 2, $anoInicio, $mesInicio, $diaInicio, $anoFim, $mesFim, $diaFim);

		//Calcula o total de consumo
		$total = consumoTotal($consumos);

		// Criamos as colunas
		$objPHPExcel->setActiveSheetIndex($planilha)
		            ->setCellValue('A1', 'Unidade' )
		            ->setCellValue('B1', 'Consumo' );

		// Definimos o estilo da fonte
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);

		// Podemos configurar diferentes larguras paras as colunas como padrão
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

		//loop de todas as unidades
		for($i = 0; $i < count($consumos); $i++){
			// Também podemos escolher a posição exata aonde o dado será inserido (coluna, linha, dado);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $cont, $consumos[$i][0]);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $cont, round($consumos[$i][1], 4));
			$cont++;
		}

		// Definimos o estilo da fonte
		$objPHPExcel->getActiveSheet()->getStyle('A'.$cont)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$cont)->getFont()->setBold(true);
		
		// Também podemos escolher a posição exata aonde o dado será inserido (coluna, linha, dado);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $cont, 'TOTAL');
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $cont, round($total, 4));

		// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
		$objPHPExcel->getActiveSheet()->setTitle($planta->nome);

		$planilha++;
	}

	// Define a planilha como ativa sendo a primeira, assim quando abrir o arquivo será a que virá aberta como padrão
	$objPHPExcel->setActiveSheetIndex(0);

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