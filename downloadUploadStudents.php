<?php
session_start();
error_reporting(0);
include('includes/check.php');
include('includes/config.php');

date_default_timezone_set("Asia/Kolkata");
ini_set('php_gd2', TRUE);
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 300);
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
/** Include PHPExcel */
require_once ('Classes/PHPExcel.php');
try
{
	$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
	$cacheSettings = array( 'memoryCacheSize' => '128M');
	PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	$styleArray = array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size'  => 15,
       // 'name'  => 'Verdana',
    ));
	$objPHPExcel->getActiveSheet()->setTitle('Student Upload');//EXCEL SHEET NAME
	$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray);//APLLY BOLD LETTER FONT,SIZE AND COLOR FOR first ROW
	$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray(
    array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => '496CAD')
        )
    )
);
$columns = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H' , 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P' ,'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X' ,'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF' , 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN' ,'AO', 'AP', 'AQ', 'AR', 'AS', 'AT','AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

foreach ( $columns as $column ) {

    $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
}
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
// $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
// $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
// $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
// $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
// $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
// $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
// $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
// $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);

// Heading
$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1', 'sl no')
		->setCellValue('B1', 'sic no')
        ->setCellValue('C1', 'Hostel')
        ->setCellValue('D1', 'Room No')
        ->setCellValue('E1', 'Bed No')	
        ->setCellValue('F1', 'From Date');	
          
/*for($row=2;$row<=5000;$row++)
{*/	 
    /*$objPHPExcel->getActiveSheet()
    ->getStyle('F1:F10')
    ->getNumberFormat()
    ->setFormatCode(
        PHPExcel_Style_NumberFormat::FORMAT_TEXT
    );*/		
/*}*/	
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
 $objPHPExcel->setActiveSheetIndex(0);

 ob_end_clean();
 header('Content-Type: application/vnd.ms-excel');
 header('Content-Disposition: attachment;filename="StudentUploadTemplate.xls"');//EXCEL FILE NAME
 //header('Cache-Control: max-age=0');
 $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 $objWriter->save('php://output');
}catch (Exception $e) {
    echo "PARSER ERROR: ".$e->getMessage()."<br />\n";

} 
 exit;
?><?php

?>