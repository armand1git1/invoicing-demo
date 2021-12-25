<?php 
/*
Copyrigt Armand Thierry Djappi
*/


/*
Those libraries Are called in the case we have an xml file to treat since in the first try the Api called returned 404
*/
require 'vendor/autoload.php'; // libraries for manipulating xls, csv, pdf file in php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\Writer\Csv;


class  class_lib_invoiceclass  
{


 // Call function to get data from api Call 
 // it return xml data or infos regarding the error
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
          //'Content-Type:application/json',
          'Content-Type:application/xml',
          'Authorization: Basic '. $token
      );
    } else {
      $headers = array(
          //'Content-Type:application/json'
          'Content-Type:application/xml'
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

  /* This function retrieves needed variable from xml and return a simple array  */     
  function get_arrayfrom_xml($xml_data)                                                     
  {   
   $tab_index    =Array();               
   if (isset($xml_data))
   { 
    $i =0;
    foreach($xml_data as $inv_data) {
      if(isset($inv_data->BuyerOrganisationUnitNumber))              $tab_index[$i]['BuyerOrganisationUnitNumber']         = $inv_data->BuyerOrganisationUnitNumber."";
      if(isset($inv_data->BuyerPartyDetails->BuyerOrganisationName)) $tab_index[$i]['BuyerOrganisationName']               = $inv_data->BuyerPartyDetails->BuyerOrganisationName."";
      if(isset($inv_data->BuyerPartyDetails->BuyerPostalAddressDetails->BuyerTownName)) $tab_index[$i]['BuyerTownName']    = $inv_data->BuyerPartyDetails->BuyerPostalAddressDetails->BuyerTownName."";
      if(isset($inv_data->BuyerPartyDetails->BuyerPostalAddressDetails->BuyerPostCodeIdentifier)) $tab_index[$i]['BuyerPostCodeIdentiﬁer']    = $inv_data->BuyerPartyDetails->BuyerPostalAddressDetails->BuyerPostCodeIdentifier."";
      if(isset($inv_data->InvoiceDetails->InvoiceTotalVatIncludedAmount)) $tab_index[$i]['InvoiceTotalVatIncludedAmount']  = $inv_data->InvoiceDetails->InvoiceTotalVatIncludedAmount."";

      $date = new DateTime($inv_data->InvoiceDetails->PaymentTermsDetails->InvoiceDueDate."");
      
      if(isset($inv_data->InvoiceDetails->PaymentTermsDetails->InvoiceDueDate)) $tab_index[$i]['InvoiceDueDate']           = $date->format('Y-m-d');;
      $i++;
    }   
   }  
   return($tab_index);                                      
  }
 
  // Convert excel file into csv ->xml format for parsing (could be used if we download the files )
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
}                                               
?>