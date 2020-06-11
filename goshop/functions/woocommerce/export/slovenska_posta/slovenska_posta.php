<?php
require 'vendor/autoload.php';
 
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet_name = CONTENT_FUNCTIONS.'/export/slovenska_posta/files/doporuceny-list-formular.xls';


$file_to_save = CONTENT_FUNCTIONS.'/export/slovenska_posta/files/slovenska_posta_export-'.time().'.xls';



$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($spreadsheet_name);

$worksheet = $spreadsheet->getActiveSheet();

$processed_ids = array();



foreach ( $post_ids as $key=>$post_id ) {
  $order = wc_get_order( $post_id );
  
  $order_data = $order->get_data();
  $line = $key+2;
  
  $worksheet->getCell('A'.$line)->setValue( get_option('option_zodpovedna_osoba') );    // Meno a priezvisko odosielatela
  $worksheet->getCell('B'.$line)->setValue( get_option('option_company') );     // Organizácia odosielatela
  $worksheet->getCell('C'.$line)->setValue( get_option('option_adresa_ulica') );       // Ulica odosielatela
  $worksheet->getCell('D'.$line)->setValue( get_option('option_adresa_mesto') );         // Obec odosielatela
  $worksheet->getCell('E'.$line)->setValue( get_option('option_adresa_psc') );              // PSC Pošty
  $worksheet->getCell('H'.$line)->setValue( get_option('option_e_mail') );    // Email odosielatela 
  $worksheet->getCell('I'.$line)->setValue('5');                  // Spôsob úhrady za zásielky (poštovné)
  $worksheet->getCell('J'.$line)->setValue('1');                  // Druh zásielky 
  
  $worksheet->getCell('M'.$line)->setValue($order_data['shipping']['first_name'].' '.$order_data['shipping']['last_name']);  // Meno a priezvisko adresáta
  // $worksheet->getCell('N'.$line)->setValue('1');  // Organizácia adresáta
  $worksheet->getCell('O'.$line)->setValue($order_data['shipping']['address_1']. ' '. $order_data['shipping']['address_2']);  // Ulica adresáta
  $worksheet->getCell('P'.$line)->setValue($order_data['shipping']['city']);  // Obec  adresáta
  $worksheet->getCell('Q'.$line)->setValue($order_data['shipping']['postcode']);  // PSC Pošty
  $worksheet->getCell('R'.$line)->setValue('SK');  // Krajina adresáta
  $worksheet->getCell('T'.$line)->setValue($order_data['billing']['email']);  // Email adresáta
  
  $worksheet->getCell('W'.$line)->setValue('2');  // Trieda                   get_option('option_e_mail')

  if($order_data['payment_method'] == 'cod'){
    $worksheet->getCell('X'.$line)->setValue($order_data['total']); // Výška Dobierky
    $worksheet->getCell('Z'.$line)->setValue(get_option('option_bankove_spojenie')); // cislo uctu iba ak je AB = 5
    $worksheet->getCell('AB'.$line)->setValue('5'); // Druh dobierky
  }
  $worksheet->getCell('AA'.$line)->setValue($order_data['id']);  // Variabilný symbol
  $worksheet->getCell('AE'.$line)->setValue('G'); //Obsah zásielky - fix

}

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
$writer->save($file_to_save);
 
if(file_exists($file_to_save)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file_to_save).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_to_save));
    flush(); // Flush system output buffer
    readfile($file_to_save);
    unset($file_to_save);
    exit;
}

