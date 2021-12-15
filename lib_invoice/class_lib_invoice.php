<?php 
/*
Copyrigt Armand Thierry Djappi
*/


require 'vendor/autoload.php'; // libraries for manipulating xls, csv, pdf file in php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\Writer\Csv;

class  class_lib_invoiceclass  
{


 // Call function to get data from api 
 function CallAPI($method, $token, $url, $data = false)
 {
    $curl = curl_init();  
    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    if($token != "") {
      $headers = array(
          'Content-Type:application/json',
          'Authorization: Basic '. $token
      );
    } else {
      $headers = array(
          'Content-Type:application/json'
      );
    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
    

    $info = curl_getinfo($curl);
    curl_close($curl);

    //print_r($info);
    if($info['http_code'] < 400) {
      return $result;
    } else {
      //return null;
      return $info;
    }
  }
 
  // Convert excel file into csv ->xml format for parsing
 function xlsx_to_csv() {
  
  $xls_file      = "Finvoice_def_3_0.xls";
  $arr_xls_file  = explode(".",$xls_file);
  $file_name     = "Finvoice"; 
  if (isset($arr_xls_file) && is_array($arr_xls_file))  $file_name = $arr_xls_file[0];


  $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($xls_file);
  $reader->setReadDataOnly(true);
  $spreadsheet = $reader->load($xls_file);
 
  $loadedSheetNames = $spreadsheet->getSheetNames();
  $writer = new Csv($spreadsheet);
 
   foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
     $writer->setSheetIndex($sheetIndex);
     //$writer->save($loadedSheetName.'.csv');
     $writer->save($file_name.'.csv');
   }    
 }

  /* This function will treat the variable $xml  for the file home  */     
 function language_xml_menu($xml,$lang)                                                     // Sorting the tag Sport
 {   
  $tab_index    =Array();               
  if (isset($xml))
  {  
   if (isset($lang)) 
   {  
     foreach($xml->$lang as $k1=>$language) 
     {                    
       if(isset($language))
       {             
          $tab_index['menu1']               = $language->menu1."";
          $tab_index['menu2']               = $language->menu2."";
          $tab_index['menu3']               = $language->menu3."";
          $tab_index['menu4']               = $language->menu4."";
          $tab_index['menu5']               = $language->menu5."";   
          $tab_index['menu6']               = $language->menu6."";        
          $tab_index['menu5_title']         = $language->menu5_title."";
        }   
      }    
    }
  } 
  return($tab_index);                                      
 }

 // Treat xml file and transform into array
 function get_array_xml($file)
 {
  $xml                  = Array(); 
  if (isset($file))
  {
   $index_menu       =strpos($file,"menu");                      // checking if the file name contains the character "lss_menu"  
   if ((isset($index_menu) && $index_menu!==FALSE))     $indice  ="menu";  
    
   $index_index      =strpos($file,"index");                      // checking if the file name contains the character "lss_menu"  
   if ((isset($index_index) && $index_index!==FALSE))   $indice  ="index";  
                     
   if(file_exists($file) && filesize($file)>0)                      // if file exits and the file's size is more than zero 
   {    
    $xml = simplexml_load_file($file);       
   }            
  }
 return($xml);
 }
}                                               
?>