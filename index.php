<?php 

require_once("lib_invoice/class_lib_invoice.php");
$Obj_invoice        =   new class_lib_invoiceclass();
// treat the Json script present into the pdf 
$json_invoices_list =   json_decode('{  "invoices": [    {      "id": "559b966f-aceb-4534-ff0d-08d9031f90c6",      "url": "https://assets.ctfassets.net/bt30rfipzm8p/49tNP2w8WX5m3eAUuubwZY/ 5338d47d9d68cff35173dc13f5c38640/invoice-example-1.xml"    },    {      "id": "5c07a71d-e6ea-4340-fc3a-08d8f201ca19",      "url": "https://assets.ctfassets.net/bt30rfipzm8p/76v3SvRAKGTuc9r2UXHV3U/ 28bce8941821f0454f213e53d496fbae/invoice-example-2.xml"    },    {      "id": "c5ffa4e4-2f28-48c2-fc35-08d8f201ca19",      "url": "https://assets.ctfassets.net/bt30rfipzm8p/3a6wRJXNFhlpkL5nDAVat7/ b103ba3bfa3635d6be186100cbcb1fdb/invoice-example-3.xml"    }  ] }');

$invoices_details   = Array();

if (isset($json_invoices_list)) {
  if (isset($json_invoices_list->invoices) && count($json_invoices_list->invoices)>0) { 
    $i=0;
    foreach ($json_invoices_list->invoices as $list_invoice) 
    {           
      
      $invoices_details[$i]   = $Obj_invoice->CallAPI("GET",$list_invoice->id, $list_invoice->url);
      $i++;  
    }
  }
}  

//$Obj_invoice->xlsx_to_csv();



?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="language" content="en">
  <meta http-equiv="content-language" content="en">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, init5ial-scale=1">

  <meta name="theme-color" content="#33691e">
  <title>Invoicing Demo</title>
  <meta name="description" content="Parsing data from different source">
  <!--
  <base href="" target="_self">
 -->
  <meta name="viewport" content="width=device-width, initial-scale=1">  
  <link rel="stylesheet" href="css/style.css">
</head>





 <form method="get" name="api_form">
 <div  class=" menu1 div2" >
 <table>
  <tr>
   <td colspan="4"><span class="smallsubsubtitlealert"></span>&nbsp;
    <span class="smallsubsubtitle">Invoicing Demo</span>
   </td>
  </tr>
  <tr><td height="15">&nbsp;</td></tr>
 </table>
 

 <?php if(isset($invoices_details) && is_array($invoices_details)) {
    // print_r($invoices_details);
   for($i=0; $i<count($invoices_details); $i++) {  
 
 ?>
 <fieldset  class="fieldset_index">
  <legend class="legend_index"><strong><?php if(isset($invoices_details[$i]["url"])) echo $invoices_details[$i]["url"]; ?></strong></legend>
 
  <table align="center" width="300">
   <tr height="25">
    <td align="left" valign="top" colspan="1" nowrap="nowrap">Response code:</td>
    <td valign="top" colspan="2" align="left"><strong> <?php if(isset($invoices_details[$i]["http_code"])) echo $invoices_details[$i]["http_code"];  ?></strong></td>                                                
   </tr>

   <tr height="5">
    <td width="5" align="right" valign="top" colspan="1">Total time:</td>
    <td width="5" valign="top" colspan="2" align="left"><?php if(isset($invoices_details[$i]["total_time"])) echo $invoices_details[$i]["total_time"];  ?></td>                                                
   </tr>   

   <tr height="5">
    <td width="5" align="right" valign="top" colspan="1">size download:</td>
    <td width="5" valign="top" colspan="2" align="left"><?php if(isset($invoices_details[$i]["size_download"])) echo $invoices_details[$i]["size_download"];  ?></td>                                                
   </tr> 


   <tr height="5">
    <td width="5" align="right" valign="top" colspan="1">Primary Ip:</td>
    <td width="5" valign="top" colspan="2" align="left"><?php if(isset($invoices_details[$i]["primary_ip"])) echo $invoices_details[$i]["primary_ip"];  ?></td>                                                
   </tr> 

   <tr height="5">
    <td width="5" align="right" valign="top" colspan="1">size download:</td>
    <td width="5" valign="top" colspan="2" align="left"><?php if(isset($invoices_details[$i]["size_download"])) echo $invoices_details[$i]["size_download"];  ?></td>                                                
   </tr> 
  </table>    
   </fieldset>
   <br />
  <?php 
   }
  } 
  ?>
  
  </div> 
 </form>                                      

