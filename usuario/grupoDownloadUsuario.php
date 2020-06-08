<?php 
	include_once("../conexao.php");
	include_once("../php/Classes/PHPExcel.php");

	//variavel
	$planilha = 0;

	//Variavel POST
	$id = $_GET['id_grupo'];

	//Consultar Grupo
	$result = mysqli_query($con, "SELECT * from grupo WHERE id = '$id'");
	$grupo = mysqli_fetch_object($result);

	//Consultar plantas
	$plantas = mysqli_query($con, "SELECT * FROM planta WHERE id_grupo_fk = '$id' ORDER BY nome");
	
	// Nome do Arquivo do Excel que será gerado
	$arquivo = $grupo->nome.'.xls';

	// Instanciamos a classe
	$objPHPExcel = new PHPExcel();

	//Loop por planta
	while( $planta = mysqli_fetch_object($plantas) ){
		$cont = 2;

		// Criando uma nova planilha dentro do arquivo
		$objPHPExcel->createSheet();

		//Seleciona todos os usuarios da planta ativos com perfil usuario
		$usuarios = mysqli_query($con, "SELECT * FROM usuario WHERE id_planta = '$planta->idecoflow' AND tipo LIKE 'usuario' AND status = 'ativo' ORDER BY nome");

		// Criamos as colunas
		$objPHPExcel->setActiveSheetIndex($planilha)
		            ->setCellValue('A1', 'Nome' )
		            ->setCellValue('B1', 'Login' )
		            ->setCellValue('C1', 'Senha' );

		// Definimos o estilo da fonte
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);

		// Podemos configurar diferentes larguras paras as colunas como padrão
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

		//loop de todas as unidades
		while( $usuario = mysqli_fetch_object($usuarios) ){
			// Também podemos escolher a posição exata aonde o dado será inserido (coluna, linha, dado);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $cont, $usuario->nome );
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $cont, $usuario->login );
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $cont, $usuario->senha );
			$cont++;
		}

		// Definimos o estilo da fonte
		$objPHPExcel->getActiveSheet()->getStyle('A'.$cont)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$cont)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$cont)->getFont()->setBold(true);

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