<script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );

  $( function() {
    $( "#datepicker2" ).datepicker();
  } );
  </script>

<?php 
// for testing purpose 05.2021
require __DIR__ . '/vendor/autoload.php';

include_once("lib_invoice/class_lib_invoice.php");
$Obj_invoice        =   new class_lib_invoiceclass();
$json_invoices_list =   json_decode('{  "invoices": [    {      "id": "559b966f-aceb-4534-ff0d-08d9031f90c6",      "url": "https://assets.ctfassets.net/bt30rfipzm8p/49tNP2w8WX5m3eAUuubwZY/ 5338d47d9d68cff35173dc13f5c38640/invoice-example-1.xml"    },    {      "id": "5c07a71d-e6ea-4340-fc3a-08d8f201ca19",      "url": "https://assets.ctfassets.net/bt30rfipzm8p/76v3SvRAKGTuc9r2UXHV3U/ 28bce8941821f0454f213e53d496fbae/invoice-example-2.xml"    },    {      "id": "c5ffa4e4-2f28-48c2-fc35-08d8f201ca19",      "url": "https://assets.ctfassets.net/bt30rfipzm8p/3a6wRJXNFhlpkL5nDAVat7/ b103ba3bfa3635d6be186100cbcb1fdb/invoice-example-3.xml"    }  ] }');
//print_r($json_invoices_list); 
if (isset($json_invoices_list)) {
  if (isset($json_invoices_list->invoices)) { 
    foreach ($json_invoices_list->invoices as $list_invoice) 
    {         
      //echo $list_invoice->id; echo "=="; echo $list_invoice->url;  echo "<br />";

      //$invoices_details   = $Obj_invoice->CallAPI("GET",$list_invoice->id, $list_invoice->url);
      $invoices_details   = $Obj_invoice->CallAPI_Curl("GET",$list_invoice->id, $list_invoice->url);
      
      //print_r($invoices_details); 
     // die();
    }
  }
}  

$Obj_invoice->xlsx_to_csv();


die();

?>

<div class="row">
<div id="div_1" class="container">
 <form action="" method="post" name="search_trans">

   <?php if(isset($_SESSION['error_transaction']) && (!empty($_SESSION['error_transaction']) && ($_SESSION['error_transaction']==TRUE)))                   {   
  ?>
       <table width="70%" style="margin-left: 70px ">
       
        <?php if(isset($_SESSION['error_transaction']) && $_SESSION['error_transaction']==TRUE) {  ?>
        <tr>
          <td class="text" style="height:3px" width="200" align="center" colspan="4" bgcolor="#26a69a">
            <label  class="darktext" > <?php if (isset($tab_value['details7'])) echo $tab_value['details7'];?>  </label>
          </td>
        </tr>
     <?php  
       if (isset($_SESSION['error_transaction'])) unset($_SESSION['error_transaction']);
      }  ?>
       </table>
  <?php }  ?>





  	<h5 class="header center boutique section-title"><?php if (isset($tab_value['subtitle'])) echo $tab_value['subtitle'];?></h5>
  
<div class="row">
      <div class="input-field col s6">      
        <input id="datepicker" type="text" class="validate"  name="date_from" value="<?php if(isset($_POST['date_from'])) {echo $_POST['date_from'];}else{if(isset($_SESSION["date1"])) echo $_SESSION["date1"];}   ?>" autocomplete="off">
        <label for="datepicker">From:(mm/dd/yyyy)</label>
      </div>

      <div class="input-field col s6">
        <input id="datepicker2" type="text" class="validate" name="date_to" value="<?php if(isset($_POST['date_to'])) {echo $_POST['date_to'];}else{if(isset($_SESSION["date2"]))  echo $_SESSION["date2"];} ?>" autocomplete="off">
        <label for="date_to">To:(mm/dd/yyyy)</label>
      </div>
 </div>   


 <div class="row">
    <div class="input-field col s6">
      <input class="btn" type="submit" name="paiement_method" value="Search" >
    </div>  
 </div> 

     <table style="border-spacing: 0px; width:100%; margin-left:auto;margin-right:auto;">
     <!-- Transactions -->
     <thead>
     <tr>
      <th>
          <?php if (isset($tab_value['charac3'])) echo $tab_value['charac3'];?>
     </th>
    
     <th>
          <?php if (isset($tab_value['charac1'])) echo $tab_value['charac1'];?>
     </th>
    
     <th>
          <?php if (isset($tab_value['charac2'])) echo $tab_value['charac2'];?>
     </th>
     
     <th>
           <?php if (isset($tab_value['charac4'])) echo $tab_value['charac4'];?>
     </th>
     <th>
          <?php if (isset($tab_value['charac5'])) echo $tab_value['charac5'];?>
     </th>
     <th>
          <?php if (isset($tab_value['charac6'])) echo $tab_value['charac6'];?>
     </th>
     <th>
          <?php if (isset($tab_value['charac7'])) echo $tab_value['charac7'];?>
     </th>
      <th>
          <?php if (isset($tab_value['charac8'])) echo $tab_value['charac8'];?>
     </th>
   
    </tr>
    </thead>

    <tbody>
  
    <?php
         
     // list transactions 
     if (isset($list_all_transactions)) // Checking if the array exists and contains value
     {       
      $i=0;      

        if (isset($list_all_transactions->_embedded->transactionDetailList)) {
         foreach ($list_all_transactions->_embedded->transactionDetailList as $transaction) 
         {         
         $i++; 
         $transaction->id;
         $style="height: 5px; background-color: #D3D3D3";    
         $result1 =($i % 2);
        if ($result1==True)    $style="height: 5px; background-color: #FFFFFF"; 
   
        $link_transaction_details=$link_transactions."&action=details"."&view=".base64_encode($i); 
     ?>
        <tr style="<?php if (isset($style)) echo $style; ?> ">
         <td style="height:3px; border-radius:0px;" width="50" colspan="1">
         <a href="<?php echo $link_transaction_details; ?>" style="font-weight: bold; color:#000;text-decoration: underline">
          <strong>
           <?php 
              $prefix    ='1000000'; 
              
              if (strlen('100000')>strlen($transaction->id)){
               $nbr_diff =strlen('100000')-strlen($transaction->id); 
               $prefix   =substr($prefix, 0, (strlen('100000')-1));    
               echo $prefix.$transaction->id;
              }else{
                echo $transaction->id;
              }
           ?>
          </strong> 
         </a> 
        </td>

        <td>
          <?php if (isset($transaction->createDate)) echo strftime("%a, %d %b %g - %Hh %M", strtotime($transaction->createDate)); ?>
        </td>

         <td>
           <?php
                 if (isset($transaction->transactionStatus->status)) echo $transaction->transactionStatus->status; 
           ?>
        </td>


        <td>

        </td>


        <td>
          <?php if(isset($transaction->receiveBankAccount->owner)) echo $transaction->receiveBankAccount->owner;  ?>
        </td>

        <td>
          <?php if(isset($transaction->receiveBankAccount->bankMethod)) echo $transaction->receiveBankAccount->bankMethod;   ?>
        </td>

        <td>
           <?php
           // case of id cards 
             if (isset($transaction->receiveBankAccount))
             {
               if(isset($transaction->receiveBankAccount->cardNumber)) {
                 echo substr($transaction->receiveBankAccount->cardNumber, 0,4);
                 echo "********";
                 echo substr($transaction->receiveBankAccount->cardNumber, 12,16);
               }
              }
            //Case of mobile money  
              if (isset($transaction->receiveBankAccount->mobileMoneyId))
              {
               echo substr($transaction->receiveBankAccount->mobileMoneyId, 0,4);
               echo "********";
               echo substr($transaction->receiveBankAccount->mobileMoneyId, 12,16);
               }
              ?>
        </td>

         <td>
             <?php if (isset($transaction->amount)) echo number_format($transaction->amount,0);  ?> &nbsp;xaf
        </td>
       </tr>

        <?php        
      }
     }        
    } 
   ?>
    </tbody>
   </table>
   <table style="margin-bottom:10px;align:right;width:100%">
   <tr valign="bottom">
    <td style="text-align: right;" colspan="7">
    
   <?php
 //echo base64_decode($_GET['pg']); echo "==";
       if(isset($list_all_transactions->page->totalPages) && $list_all_transactions->page->totalPages>0) {         
          for($i=1;$i<=$list_all_transactions->page->totalPages;$i++)
          {
           $class ="ui-button-active";
           $link  =$link_transactions."&pg=".base64_encode($i)."";
           if (isset($_GET["srchdate"]))  $link  =$link_transactions."&pg=".base64_encode($i)."&srchdate";           
           if (isset($_GET["srchstatus"]))  $link  =$link_transactions."&pg=".base64_encode($i)."&srchstatus";
           if (isset($_GET["srchstatus"]) && isset($_GET["srchdate"]))  $link  =$link_transactions."&pg=".base64_encode($i)."&srchdate&srchstatus"; 
            if(
                (!isset($_GET['pg']) && $i==1)
                             ||
                  (isset($_GET['pg']) && base64_decode($_GET['pg'])==$i)
              )
            {
             $class="ui-button";
            }        
    ?>
     <a href="<?php echo $link; ?>"><label class="<?php  echo $class; ?>" ><?php echo $i; ?></label></a>&nbsp;
    <?php }                                                           }  ?>

   </td>
  </tr>
  </table>
  </form>

</div>
</div>
