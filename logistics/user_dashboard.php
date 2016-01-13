<?php
ob_start();
include('class/functions.php');
date_default_timezone_set("Asia/Kolkata"); 
$date4=date('Y-m-d H:i:s');
$con=new functions();
$date= $con->get_datetime_html();
$date1= date('Y-m-d\T00:00:00',strtotime("-1 days"));
session_start();
$entity_id=$_SESSION['entity_id'];
$role_id=$_SESSION['role_id'];
/*echo $entity_id;
//echo $role_id;
exit;*/

//$query="SELECT consignment_details.consignment_id, consignment_details.cust_po_number, consignment_details.shipment_terms,consignment_details.commercial_invoice,consignment_details.port_of_discharge,consignment_details.item_description,consignment_details.ordered_quantity,consignment_details.order_quantity_uom, consignment_details.shipment_value,consignment_details.sailing_date,consignment_details.agent,consignment_details.require_date,consignment_details.remark,consignment_details.status, consignment_update.arrival_date FROM consignment_update INNER JOIN consignment_details ON consignment_update.consignment_id=consignment_details.consignment_id WHERE created_date between '".date('Y-m-d\ 00:00:00',strtotime("-1 days"))."' and '".date('Y-m-d H:i:s')."'";
$query_dashboard="SELECT * FROM consignment_details WHERE org_id in(".$entity_id.") and dispatch_date between '".date('Y-m-d\ 00:00:00',strtotime("-1 days"))."' and '".date('Y-m-d H:i:s')."'";

$result=$con->data_select($query_dashboard);



//customer get in select box
$query_user="";
if($entity_id =="")
{
  $query_user="SELECT DISTINCT customer_num FROM consignment_details ";
  $result1=$con->data_select($query_user);

  $customer_options="<option value ='0'>Select Cutomer</option>";
  foreach($result1 as $key => $val){
    
      $customer_options .="<option value  ='".$result1[$key]['customer_num']."'>".$result1[$key]['customer_num']."</option>";
   
    
  }
}
else
{
    $query_user="SELECT DISTINCT customer_num FROM consignment_details WHERE org_id in(".$entity_id.")";
    $result1=$con->data_select($query_user);

    $customer_options="<option value ='0'>Select Cutomer</option>";
    foreach($result1 as $key => $val){

        $customer_options .="<option value  ='".$result1[$key]['customer_num']."'>".$result1[$key]['customer_num']."</option>";
    
      
    }
}
//End customer number get select box

$sql_entity ="select org_id,name from org_map where org_id IN (".$entity_id.")";
$entity_data=$con->data_select($sql_entity);

$entity_options="<option value ='0'>Select Entity</option>";
foreach($entity_data as $key => $val){
  $entity_options .="<option  value ='".$entity_data[$key]['org_id']."'>".$entity_data[$key]['name']."</option>";
}

include('admin_sidebar_header.php');
?>
<script type="text/javascript">
  function consignmentId(consignmentid)
  {
    var consinement=$("#consignmentid").val(consignmentid);
    $.ajax({
        type: "POST",
        url:"ajax_service.php",
       // id, consigneement_addrss, mode_of_shipment, vessel_name, etd_date, shipped_on_board, transhipment_port, transhipment_vessel_name, eta_date, arrival_date, custom_clearance_date, custom_clearance, delivered_cutomer_loaction, remark, consignment_id
        data:"consignment_id="+consignmentid+"&action=select_update_consignment",
        dataType:"JSON",
        success: function(data)
        {
          console.log(data);  

           if(data !="no")
           {
              
              $("#consignmentid").val(data[0].consignment_id);
              $("#consigneeaddress").val(data[0].consignment_address);
              $("#modeofshipment").val(data[0].mode_of_shipment);
              $("#vesselname").val(data[0].vessel_name);
              $("#etd").val(data[0].etd_date);
              $("#shippedonboard").val(data[0].shipped_on_board);
              $("#containername").val(data[0].container_number);
              $("#transhipmentport").val(data[0].transhipment_port);
              $("#transhipmentvesselname").val(data[0].transhipment_vessel_name);
              $("#eta").val(data[0].eta_date);
              $("#arrivaldate").val(data[0].arrival_date);                            
              if(data[0].arrival_date == "NULL" || data[0].arrival_date == "" || data[0].arrival_date == '' || data[0].arrival_date == null)
              {
               //$("#checkbox").removeClass("checkbox").addClass("hidden");
                // $("#customclearance").attr('readonly','readonly');
                $("#customclearance").attr('disabled', 'disabled');
          		  $("#customclearance").attr('readonly', 'true');
              } 
              else
              {
              	 $("#customclearance").removeAttr('disabled');
                 $("#customclearance").removeAttr('readonly');
              	// $("#checkbox").css("display","none");
                // $("#checkbox").removeClass("hidden").addClass("checkbox");
              }

              if(data[0].custom_clearance =="yes")
              {
                                
                $(':checkbox').prop('checked', true);
                // $("#custdelivered").val(data[0].delivered_cutomer_loaction).attr('readonly',false);
            
              }
              else
              {
              	 
                 $(':checkbox').prop('checked', false);
                 //$("#custdelivered").val(data[0].delivered_cutomer_loaction).attr('readonly','readonly');
              } 
              if(data[0].custom_clearance =="yes")
              {
              	$("#customclearancedate").val(data[0].custom_clearance_date).attr('readonly',false); 
              	$("#custdelivered").val(data[0].delivered_cutomer_loaction).attr('readonly',false);
              	 
              }
              else
              {
              	 $("#customclearancedate").val(data[0].custom_clearance_date).attr('readonly','readonly'); 
         	     $("#custdelivered").val(data[0].delivered_cutomer_loaction).attr('readonly','readonly');
              }
             // $("#customclearancedate").val(data[0].custom_clearance_date); 
             // $("#custdelivered").val(data[0].delivered_cutomer_loaction);
              $("#remark").val(data[0].remark);
             
               // alert("inside if");
              $("#liknktraking").html("<spam>Container Number</spam>");


              

          }
        }
      
    });
     
  }
  function showdocument(consignment_id)
  {
    var consigmantid=$("#consignmentid1").val(consignment_id);
   
    $.ajax({
      type:"POST",
      url:"ajax_service.php",
      data:"consigment_id="+consignment_id+"&action=showdocument",
      dataType:"JSON",
      success: function(data)
      {

       var  data1 = $.parseJSON(data[0].shipping_document_details);
        
        $("#serviceprovider").val(data[0].service_provider);
        $("#createddate").val(data[0].created_date);


        if(data1.bill_of_laden != 'undefined')
        {
         
           $('#bill_of_laden').prop('checked', true);            
          
        }
        if(data1.packing_list != 'undefined')
        {
           
          $('#packing_list').prop('checked', true);             
         
      
        }
       if(data1.certificate_of_analysis != 'undefined')
        {
              
          $('#certificate_of_analysis').prop('checked', true);              
         
        }
        if(data1.certificate_of_origin != 'undefined')
        {             
           $('#certificate_of_origin').prop('checked', true);       
        }
       if(data1.gsp != 'undefined')
        {
           $('#gsp').prop('checked', true);
        }
        if(data1.haz_declaraition != 'undefined')
        {
           $('#haz_declaraition').prop('checked', true);      
         
        }
        if(data1.non_hAZ_declaraition != 'undefined')
        {
           $('#non_hAZ_declaraition').prop('checked', true);               
          
        }
        if(data1.msds != 'undefined')
        {
           $('#msds').prop('checked', true);               
         
        }
        if(data1.heat_treatment_certification != 'undefined')
        {
             
            $('#heat_treatment_certification').prop('checked', true);             
         
        }
        if(data1.benificary_declaration != 'undefined')
        {
            
            $('#benificary_declaration').prop('checked', true);         
        
        }
        if(data1.certificate_quantity != 'undefined')
        {
            $('#certificate_quantity').prop('checked', true);                     
      
        }
    
          var trHTML = '<table class="table"><tr><th>Document Type</th><th><strong>Document Name</strong></th><th><strong>Upload Date</strong></th><th><strong>Action<strong></th></tr>';
               var newHtml="";
              if((data[0].shipping_document != "") && (data[0].shipping_document !=null))
              {
                  //newHtml+="heloo";
                  trHTML+='<tr id="rows"><td>Shipping Document</td><td><a  href="uploaded/'+ data[0].shipping_document+'">'+ data[0].shipping_document+'</a></td><td>'+data[0].shipping_document_update+'</td><td><a  href="#" onclick="deleteDocument('+data[0].consignment_id+','+"'s'"+');">Delete</a></td></tr>';
              }
              
              if((data[0].commercial_invoice != "") && (data[0].commercial_invoice !=null) )
              {  
                  //alert(data[0].commercial_invoice);                
                  trHTML+='<tr id="rowc"><td>Commercial Invoice</td><td><a  href="uploaded/'+ data[0].commercial_invoice+'">'+ data[0].commercial_invoice+'</a></td><td>'+data[0].commercial_invoice_update+'</td><td><a href="#" onclick="deleteDocument('+data[0].consignment_id+','+"'c'"+');">Delete</a></td></tr>';
              }
              if((data[0].india_commercial_invoice != "") && (data[0].india_commercial_invoice !=null) )
              {  
                 // alert(data[0].india_commercial_invoice);                
                  trHTML+='<tr id="rowi"><td>India Commercial Invoice</td><td><a  href="uploaded/'+ data[0].india_commercial_invoice+'">'+ data[0].india_commercial_invoice+'</a></td><td>'+data[0].india_commercial_invoice_update+'</td><td><a href="#" onclick="deleteDocument('+data[0].consignment_id+','+"'i'"+');">Delete</a></td></tr>';
              }
            
        trHTML+='</table>';
        $('#targetLayer').html(trHTML); 
        
      }
        
    });
  }
function deleteDocument(consignmentid_delete,document_delete)
{
     
   $.ajax({  
      type:"POST",
      url:"ajax_service.php",
      data:"consignment_id="+consignmentid_delete+"&document_type="+document_delete+"&action=deleteDocument",     
      success: function(data)
      {
           if(data == "success")
           {

                $("#pop").html('<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert"aria-label="Close"><span aria-hidden="true">×</span></button>You have successfully deleted document</div>');
                 $("#pop").fadeOut(5000);
                 $("#row"+document_delete).removeAttr().fadeOut(5000);
                 var expload= function(){
                  location.reload();

                 };
                 setTimeout(expload,5001);
           }

      }
      
      
    });
  
}

  $('#fromdate').change(function() {
    // $(this).val() will work here
    alert("ldakfasd");

    
});
  function datechaneg()
  {
    var datesd= $("#fromdate").val();
    $("#fromdate").val(datesd);
    //alert(datesd);
  }
  
</script>

  <!-- page content -->
           

        
        <div class="row">                 
       
            <div class="col-md-12 col-sm-12 col-xs-12">
             
                <div class="">                         
                    
                    <h2 style="color:#189B34;">Dashboard</h2>
                    <hr width=100%  align=left>
                    <form  class="form-vertical form-label-right" novalidate method="post" action="">
                
                  
                       <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                            <div class="x_panel">
                                                <div class="">
                                                    <h2>From Date</h2>
                                              
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="form-group">
                                                 
                                                  
                                                       <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" 
                              data-validate-words="2" value="<?php echo $date1;?>" id="fromdate" name="fromdate" onChange="return datechaneg();" required type="datetime-local">
                         
                                                  
                                                </div>
                                            
                                            </div>
                        </div>


                                 <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                            <div class="x_panel">
                                                <div class="">
                                                    <h2>To Date</h2>
                                              
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="form-group">
                                                 
                                                  
                                                   <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" 
                              data-validate-words="2"value="<?php echo $date;?>" id="todate" name="todate" required type="datetime-local">
                                                  
                                                </div>
                                            
                                            </div>
                                     </div>

                                       <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                            <div class="x_panel">
                                                <div class="">
                                                    <h2>Search</h2>
                                              
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="form-group">
                                                 
                                                   <div class="col-md-3">
                                                  
                                                       <input  type ="button"
                                                              class="btn btn-primary" name="consignsubmit" id="consignsubmit" value="Search"  >
                                                    </div>

                                                    <div class="col-md-3">
                                                  
                                                       <input  type ="hidden"
                                                            class="" name="" id="" value=""  type="">
                                                    </div>

                                                <div class="col-md-3">
                                                  
                                                       <input  type ="button"
                                                           class="btn btn-primary" name="adv_search" id="adv_search" value=" ADV Search"  >
                                                    </div>

                                                   
                                                </div>
                                            
                                            </div>
                                      </div>      


                              </div>

                    
                    </form>
               


        </div>
        
        <div class ="row" id ="adv_search_div">
             <div class="col-md-12 col-sm-12 col-xs-12">
             
                <div class="">  
                  
                    <h2 style="color:#189B34;">Advanced Search</h2>
                    <form  class="form-vertical form-label-right" novalidate method="post" action="">
                


                         <div class="col-md-2 col-xs-12 widget widget_tally_box">
                                            <div class="x_panel">
                                                <div class="">
                                                    <h2>Status</h2>
                                              
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="form-group">
                                                 
                                                  
                                                       <select class="form-control" id ="adv_status" name ="adv_status">
                                                          <option value ="0">Select Status</option>
                                                          <option value ="ClOSED">CLOSED</option>
                                                          <option value="IN TRANSIT">IN TRANSIT</option>
                                                           <option value ="UNDER CUSTOM ClEARENCE">UNDER CUSTOM ClEARENCE</option>
                                                           <option value ="ARRIVED AT PORT">ARRIVED AT PORT</option>
                                                           <option value ="OUT FOR DELIVERY">OUT FOR DELIVERY</option>
                                                           <option value ="BOOKED">BOOKED</option>
                                                           <option value ="DESPATCH">DESPATCH</option>
                                                      </select>
                                                  
                                                </div>
                                            
                                            </div>
                            </div>


                          <div class="col-md-2 col-xs-12 widget widget_tally_box">
                                            <div class="x_panel">
                                                <div class="">
                                                    <h2>Entity</h2>
                                              
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="form-group">
                                                 
                                                  
                                                       <select class="form-control" id ="adv_entity" name ="adv_entity" >
                                                           <?php echo $entity_options; ?>
                                                      </select>
                                                  
                                                </div>
                                            
                                            </div>
                            </div>


                              <div class="col-md-2 col-xs-12 widget widget_tally_box">
                                            <div class="x_panel">
                                                <div class="">
                                                    <h2>Customer</h2>
                                              
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="form-group">
                                                 
                                                  
                                                      <select class="form-control" id ="adv_customer" name ="adv_customer">
                                                         <?php  echo  $customer_options; ?>
                                                      </select>
                                                  
                                                </div>
                                            
                                            </div>
                            </div>




                              <div class="col-md-2 col-xs-12 widget widget_tally_box">
                                            <div class="x_panel">
                                                <div class="">
                                                    <h2>PO#</h2>
                                              
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="form-group">
                                                 <input  class="form-control " value="" id="adv_po" name="adv_po" >
                                                  
                                                     
                                                  
                                                </div>
                                            
                                            </div>
                            </div>



                              <div class="col-md-2 col-xs-12 widget widget_tally_box">
                                            <div class="x_panel">
                                                <div class="">
                                                    <h2>Product</h2>
                                              
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="form-group">
                                                 
                                                                         <input  class="form-control "  value="" id="adv_product" name="adv_product" >
                         
                                                   
                                                  
                                                </div>
                                            
                                            </div>
                            </div>




                                 <div class="col-md-2 col-xs-12 widget widget_tally_box">
                                            <div class="x_panel">
                                                <div class="">
                                                    <h2></h2>
                                              
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="form-group">
                                                  <input   class="btn btn-primary" name="adv_conf_search" id="adv_conf_search" value="GO"  type="button">
                                                  
                                                </div>
                                            
                                            </div>
                                 </div>


                      </div>
                    <style type="text/css">
                      td{
                            background-color: #F9F9F9;
                           
                        }
                        td:hover{
                            background-color: #F9F9F9;
                           
                        }
                    </style>
                    </form>

                  </div>
                  </div>  

        </div>

        <div class="row">

                    
                    <div class="" style="">
                        <table id="example1" class="">
                            <thead>
                                <tr class="">
                                <!--  <input type="hidden" id="userId" value="" name="userId"/> -->
                                 
                                    <th>No</th>
                                    <th>PO&nbsp;Number</th>
                                    <th>Shipment&nbsp;Terms</th>
                                    <th>Commercial&nbsp;Invoice</th>
                                    <th>Reference&nbsp;Number</th>
                                    <th>Port&nbsp;Of&nbsp;Discharge</th>
                                    <th>Product&nbsp;Name&nbsp;</th>
                                    <th>Quantity&nbsp;</th>
                                    <th>Currency&nbsp;</th>
                                    <th>Shipment&nbsp;Value</th>                                                     
                                    <th>Sailing&nbsp;Date</th>
                                    <th>Arrival&nbsp;Date&nbsp;@&nbsp;Destination</th>
                                    <th>Require&nbsp;Date&nbsp;@&nbsp;Destination</th>
                                    <th>Remarks</th>
                                    <th>Order&nbsp;Status</th>
                                    <th>Documentation</th>
                                    <th>Shipping&nbsp;Status</th>                                              
                                
                                </tr>
                            </thead>

                            <tbody id="kkk_data">

                             <?php
                                  if($result!="no")
                                   {
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
                                        echo "<td class='a-right a-right'>".$result[$key]['shipped_on_board']."</td>";
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
                                  ?>
                                
                               
                            </tbody>

                        </table>
                    </div>
         </div>
      

<!-- <div align="center" class="ajax-loader" style="display:none" ><img src="images/ajax-loader.gif"></div> -->
<div align="center" class="ajax-loader" style="display:none" ></div>
  <style>
  .background-overlay{
    background-color: black;
    opacity: 0.5;
    pointer-events: none;
  }
  .ajax-loader{
    position: fixed;
    top: 50%;
    left: 50%;
   

      display: block;
  
    width: 150px;
    height: 150px;
    margin: 10px 0 0 -75px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #3498db;

    -webkit-animation: spin 2s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
    animation: spin 2s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
  }


   .ajax-loader:before {
        content: "";
        position: absolute;
        top: 5px;
        left: 5px;
        right: 5px;
        bottom: 5px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #e74c3c;

        -webkit-animation: spin 3s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
        animation: spin 3s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
    }

   .ajax-loader:after {
        content: "";
        position: absolute;
        top: 15px;
        left: 15px;
        right: 15px;
        bottom: 15px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #f9c922;

        -webkit-animation: spin 1.5s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
          animation: spin 1.5s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
    }

    @-webkit-keyframes spin {
        0%   { 
            -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(0deg);  /* IE 9 */
            transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
        }
        100% {
            -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(360deg);  /* IE 9 */
            transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
        }
    }
    @keyframes spin {
        0%   { 
            -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(0deg);  /* IE 9 */
            transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
        }
        100% {
            -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: rotate(360deg);  /* IE 9 */
            transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
        }
    }
  </style>
  <script type="text/javascript">
   $(function(){
     $("#adv_search_div").hide();
      
      $("#consignsubmit").click(function(){

        $(".ajax-loader").show();        
        $("body").addClass("background-overlay");
       
        var from_date = $("#fromdate").val();
          var to_date = $("#todate").val();

             $.ajax({
              url: "dash_search.php",
              data : "from_date="+from_date+"&to_date="+to_date+"&action=dashboard_load",
              success:function(data){    

                   //alert(data); 
                   $(".ajax-loader").hide(); 
                   $("body").removeClass("background-overlay");
                   $("#kkk_data").html(data);
                 //location.reload();
              }
            });

      });

      $("#adv_conf_search").click(function(){

          $(".ajax-loader").show();        
          $("body").addClass("background-overlay");
           var adv_status =$("#adv_status").val();


           var  adv_entity =$("#adv_entity").val();
           var  adv_customer =$("#adv_customer").val();
           var  adv_po =$("#adv_po").val();
           var  adv_product =$("#adv_product").val();

           //alert("&adv_status="+adv_status+"&adv_customer="+adv_customer+"&adv_entity="+adv_entity+"&adv_po="+adv_po+"&adv_product="+adv_product+"&action=advance_search_load");

             $.ajax({
              url: "dash_search.php",
              data : "&adv_status="+adv_status+"&adv_customer="+adv_customer+"&adv_entity="+adv_entity+"&adv_po="+adv_po+"&adv_product="+adv_product+"&action=advance_search_load",
              success:function(data){  
                $(".ajax-loader").hide(); 
                $("body").removeClass("background-overlay"); 
                $("#kkk_data").html(data);              
                 //alert(data);
                 //console.log(data);
                 //location.reload();
              }
            });
      });


      $("#adv_search").click(function(){
           
           //$("#adv_search_div").show();
           $("#adv_search_div").toggle();
      });

   });
  </script> 

<link href="css/fixed_table_rc.css" rel="stylesheet">


    
<script src="js/fixed_table_rc.js"></script>
<script type="text/javascript" src="js/sortable_table.js"></script>
<script type="text/javascript">
   $(document).ready(function() {
  $('#example1').fxdHdrCol({
    fixedCols:  0,
    width:     "100%",
    height:    300,
    colModal: [
         { width: 50, align: 'center' },
         { width: 110, align: 'center' },
         { width: 170, align: 'left' },
         { width: 250, align: 'left' },
         { width: 100, align: 'left' },
         { width: 70, align: 'left' },
         { width: 100, align: 'left' },
         { width: 100, align: 'center' },
         { width: 90, align: 'left' },
         { width: 400, align: 'left' },
         { width: 400, align: 'left' },

             { width: 100, align: 'left' },
         { width: 70, align: 'left' },
         { width: 100, align: 'left' },
         { width: 100, align: 'center' },
         { width: 90, align: 'left' },
         { width: 400, align: 'left' }
    ],
    sort: true
  });
   });
</script>
  <style type="text/css">
    html, body{
       min-height: 100%;
    }

    body {
      overflow-x: scroll;
      background-color: #fff;
    }

    .x_panel{
       background:inherit; 
         border: 0; 
    }

    #example1 thead th{
      border : 0px solid !important;
    }
  </style>         
<?php
 include("dash_pop.php");
 include('footer.php');
 ob_end_flush();
?>