<?php

include_once("/srv/http/ecoflow.net.br/php/Classes/PHPExcel.php");
//include_once("/home2/ecofl253/public_html/php/Classes/PHPExcel.php");

$nome = $_POST['nome'];


try {
    $inputFileType = PHPExcel_IOFactory::identify($nome);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($nome);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($nome,PATHINFO_BASENAME).'": '.$e->getMessage());
}

$sheet = $objPHPExcel->getActiveSheet();

//Limpeza da planilha
$sheet->removeColumnByIndex(14,20);
$sheet->removeColumn('H');
$sheet->removeColumn('F');
$sheet->removeColumn('E');
$sheet->removeColumn('B');

//Verificar a quantidade de itens
$highestRow = $sheet->getHighestRow();

//Verifica as linhas que não possuem ST e calcula
for($i = 2; $i <= $highestRow; $i++){
    $value = $sheet->getCellByColumnAndRow(6,$i)->getValue();

    if($value == NULL){
        $st = '=H'.$i.'*0.17';
        $sheet->setCellValueByColumnAndRow(6, $i, $st);
    }
}

//Calcular Total c/ IPI c/ ST
for($j = 2; $j <= $highestRow; $j++){
    $ipi = '=G'.$j.'+H'.$j;
    $sheet->setCellValueByColumnAndRow(8, $j, $ipi);
}

//Calcular o total com a margem de 1.9
$sheet->setCellValueByColumnAndRow(9, 1, 'Total c/ margem');
for($k = 2; $k <= $highestRow; $k++){
    $margem = '=I'.$k.'*1.9';
    $sheet->setCellValueByColumnAndRow(9, $k, $margem);
}

//Adicionar linha com o total de cada coluna
$sheet->setCellValueByColumnAndRow(0, ($highestRow+2), 'Total');
$sheet->setCellValueByColumnAndRow(2, ($highestRow+2), '=SUM(C2:C'.$highestRow.')');
$sheet->setCellValueByColumnAndRow(3, ($highestRow+2), '=SUM(D2:D'.$highestRow.')');
$sheet->setCellValueByColumnAndRow(6, ($highestRow+2), '=SUM(G2:G'.$highestRow.')');
$sheet->setCellValueByColumnAndRow(7, ($highestRow+2), '=SUM(H2:H'.$highestRow.')');
$sheet->setCellValueByColumnAndRow(8, ($highestRow+2), '=SUM(I2:I'.$highestRow.')');
$sheet->setCellValueByColumnAndRow(9, ($highestRow+2), '=SUM(J2:J'.$highestRow.')');

// Cabeçalho do arquivo para ele baixa
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=\"orcamento.xls\"");
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

unlink ($nome);

?>