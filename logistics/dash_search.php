<?php
include('class/functions.php');
date_default_timezone_set("Asia/Kolkata"); 
$date4=date('Y-m-d H:i:s');
$con=new functions();
session_start();
$entity_id=$_SESSION['entity_id'];

if(isset($_REQUEST['action'])  &&  $_REQUEST['action'] =="dashboard_load" ){
   $query="";
  if($entity_id == 0 || $entity_id =="" || $entity_id == null)
  {
      $query="SELECT * FROM consignment_details WHERE  dispatch_date between '".$_REQUEST['from_date'] ."' and '".$_REQUEST['to_date'] ."'";
     /* echo $query;
      exit;*/
  }
  else
  {
     $query="SELECT * FROM consignment_details WHERE org_id in (".$entity_id.") and dispatch_date between '".$_REQUEST['from_date'] ."' and '".$_REQUEST['to_date'] ."'";
     
    
  }
  $result=$con->data_select($query);


      if($result!="no") {
         $i=1;
        foreach($result as $key => $val)
        {

          echo "<tr class='even pointer'>";
            echo "<td class='a-right a-right'>".$i."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['cust_po_number']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['freight_terms_code']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['commercial_invoice']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['ref_inv']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['port_of_discharge']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['item_description']."</td>"; 
            echo "<td class='a-right a-right'>".$result[$key]['shipped_quantity']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['currency']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['shipping_value_inr']."</td>";

            
            if($result[$key]['shipped_on_board'] > 0)
            {
              echo "<td class='a-right a-right'><input style='border: 0px none;background-color: #F9F9F9;' value=".$result[$key]['shipped_on_board']." required type='datetime-local' readonly='readonly'></td>";
            }
            else
            {
              echo "<td class='a-right a-right'></td>";
            }  
            if($result[$key]['arrival_date'] > 0)
            {
              echo "<td class='a-right a-right'><input style='border: 0px none;background-color: #F9F9F9;' value=".$result[$key]['arrival_date']." required type='datetime-local' readonly='readonly'></td>";
            }
            else
            {
              echo "<td class='a-right a-right'></td>";
            }                                     
            
            echo "<td class='a-right a-right'>".$result[$key]['require_date']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['remark']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['order_status']."</td>";
            echo '<td class="a-right a-right"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"onclick="return showdocument('.$result[$key]['consignment_id'].') ">Document</button> </td>';
            echo '<td class="a-right a-right"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg2" onclick="return consignmentId('.$result[$key]['consignment_id'].') ">Click here</button></td>';
            echo "</tr>";

          $i++;
         } 

        }
         else
          {
             echo "<div id='hide_error2' ><h1 align='center'>No Data Found </h1></div>";
          }

                                

exit;

}

if(isset($_REQUEST['action'])  &&  $_REQUEST['action'] =="advance_search_load" ){


 $query="";

  if($entity_id == 0 || $entity_id =="" || $entity_id == null)
  {
      $query="SELECT * FROM consignment_details WHERE  1 ";

        if($_REQUEST['adv_status'] !="0"){
           $query.=" and order_status = '".$_REQUEST['adv_status']."'  ";
        }

          if($_REQUEST['adv_customer'] !="0"){
           $query.=" and customer_num = '".$_REQUEST['adv_customer']."'  ";
        }

          if($_REQUEST['adv_entity'] !="0"){
           $query.=" and org_id = '".$_REQUEST['adv_entity']."'  ";
        }

          if($_REQUEST['adv_product'] !=""){
           $query.=" and item_description  = '".$_REQUEST['adv_product']."'  ";
        }

          if($_REQUEST['adv_po'] !=""){

           $query.="and cust_po_number = '".$_REQUEST['adv_po']."'  ";
        }
    }
    else
      {
         $query="SELECT * FROM consignment_details WHERE org_id in (".$entity_id.")";
         if($_REQUEST['adv_status'] !="0"){
             $query.=" and order_status = '".$_REQUEST['adv_status']."'  ";
          }

            if($_REQUEST['adv_customer'] !="0"){
             $query.=" and customer_num = '".$_REQUEST['adv_customer']."'  ";
          }

            if($_REQUEST['adv_entity'] !="0"){
             $query.=" and org_id = '".$_REQUEST['adv_entity']."'  ";
          }

            if($_REQUEST['adv_product'] !=""){
             $query.=" and item_description  = '".$_REQUEST['adv_product']."'";
          }

            if($_REQUEST['adv_po'] !=""){

             $query.="and cust_po_number = '".$_REQUEST['adv_po']."'";
          }
      }
    /*  echo $query;
      exit;*/

    $result=$con->data_select($query);

      if($result!="no") {
         $i=1;
        foreach($result as $key => $val)
        {

            echo "<tr class='even pointer'>";
            echo "<td class='a-right a-right'>".$i."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['cust_po_number']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['freight_terms_code']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['commercial_invoice']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['ref_inv']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['port_of_discharge']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['item_description']."</td>"; 
            echo "<td class='a-right a-right'>".$result[$key]['shipped_quantity']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['currency']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['shipping_value_inr']."</td>";

            
            if($result[$key]['shipped_on_board'] > 0)
            {
              echo "<td class='a-right a-right'><input style='border: 0px none;background-color: #F9F9F9;' value=".$result[$key]['shipped_on_board']." required type='datetime-local' readonly='readonly'></td>";
            }
            else
            {
              echo "<td class='a-right a-right'></td>";
            }  
            if($result[$key]['arrival_date'] > 0)
            {
              echo "<td class='a-right a-right'><input style='border: 0px none;background-color: #F9F9F9;' value=".$result[$key]['arrival_date']." required type='datetime-local' readonly='readonly'></td>";
            }
            else
            {
              echo "<td class='a-right a-right'></td>";
            }                                   
            
            echo "<td class='a-right a-right'>".$result[$key]['require_date']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['remark']."</td>";
            echo "<td class='a-right a-right'>".$result[$key]['order_status']."</td>";
            echo '<td class="a-right a-right"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"onclick="return showdocument('.$result[$key]['consignment_id'].') ">Document</button> </td>';
            echo '<td class="a-right a-right"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg2" onclick="return consignmentId('.$result[$key]['consignment_id'].') ">Click here</button></td>';
          echo "</tr>";
          $i++;
         } 

        }
        else
        {
           echo "<div id='hide_error1' ><h1 align='center'>No Data Found </h1></div>";
        }

  exit;
}


  

?>
<script type="text/javascript">

 var hidedata= function()
 {
    

    $("#hide_error2").removeAttr().fadeOut(3000);
 
 };
 setTimeout(30001);
  $(document).ready(function(){

    $("#hide_error1").removeAttr().fadeOut(3000);
  });
  
</script>