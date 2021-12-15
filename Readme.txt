Hei ! Readme of the invoicing demo 
We have written a small Libraries for the demo : \lib_invoice\class_lib_invoice.php


1- Parsing json receive from  pdf : Via curl   function :  function CallAPI($method, $token, $url, $data = false)
   Result : the api call return : 404 (unauthorised ). 

Because of the unauthorization we decide to download the xls file :  
   Schema deﬁnition: https://ﬁle.ﬁnanssiala.ﬁ/ﬁnvoice/Finvoice3.0.xsd Data list:    https://ﬁle.ﬁnanssiala.ﬁ/ﬁnvoice/Finvoice_def_3_0.xls 
   After that we have to convert xls into xml so that data could be easily manipulated. 
  
2- getting xml from : excel  
   nb : from api call we have 404 ( not authorized ). 
   2.1- use  BasicExcel(invoicing-demo\BasicExcel) : does not work 
        At first we used  BasicExcel ( class from php classes group ). However it does not work  

   2.2- use composer (Composer is a tool for dependency management in PHP. It allows you to declare the libraries your project depends on and it will manage (install/update) them for you.) : 
     We then install a composer to manipulate xls file(use PhpOffice\PhpSpreadsheet\Spreadsheet;)
   
    - install composer from  :  https://getcomposer.org/download/ 
    - setting up composer . 
Once composer installed, we can now convert data
 
3- retrieve important data ( However after data convertion the format of the csv do not fit with the original schema definition)
4- display them in a webpage
