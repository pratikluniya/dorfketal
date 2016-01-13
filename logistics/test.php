<?php
ob_start();
include('class/functions.php');
date_default_timezone_set("Asia/Kolkata"); 
$date4=date('Y-m-d H:i:s');
$con=new functions();
$date= $con->get_datetime_html();
$date1= date('Y-m-d\T00:00:00',strtotime("-1 days"));
//$query="SELECT consignment_details.consignment_id, consignment_details.cust_po_number, consignment_details.shipment_terms,consignment_details.commercial_invoice,consignment_details.port_of_discharge,consignment_details.item_description,consignment_details.ordered_quantity,consignment_details.order_quantity_uom, consignment_details.shipment_value,consignment_details.sailing_date,consignment_details.agent,consignment_details.require_date,consignment_details.remark,consignment_details.status, consignment_update.arrival_date FROM consignment_update INNER JOIN consignment_details ON consignment_update.consignment_id=consignment_details.consignment_id WHERE created_date between '".date('Y-m-d\ 00:00:00',strtotime("-1 days"))."' and '".date('Y-m-d H:i:s')."'";
$query="SELECT * FROM consignment_details WHERE created_date between '".date('Y-m-d\ 00:00:00',strtotime("-1 days"))."' and '".date('Y-m-d H:i:s')."'";

$result=$con->data_select($query);
 
if(isset($_POST['consignsubmit']))
{
  $from_time=$_POST['fromdate'];  
  $to_time=$_POST['todate'];
  $query="SELECT * FROM consignment_details WHERE created_date between '".$from_time."' and '".$to_time."'";
  $result=$con->data_select($query);
  
}
$query="SELECT user_id,email_id FROM user_registration";
$result1=$con->data_select($query);
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
              $("#containername").val(data[0].container_name);
              $("#transhipmentport").val(data[0].transhipment_port);
              $("#transhipmentvesselname").val(data[0].transhipment_vessel_name);
              $("#eta").val(data[0].eta_date);
              $("#arrivaldate").val(data[0].arrival_date);
              $("#customclearancedate").val(data[0].custom_clearance_date); 
               
              if(data[0].arrival_date == "NULL" || data[0].arrival_date == "" || data[0].arrival_date == '' || data[0].arrival_date == null)
              {
               $("#checkbox").removeClass("checkbox").addClass("hidden");
                 //$("#checkbox").css("display","none");
              } 
              else
              {
                 $("#checkbox").removeClass("hidden").addClass("checkbox");
              }

              if(data[0].custom_clearance =="yes")
              {
                                
                $(':checkbox').prop('checked', true);
            
              }
              else
              {
                 $(':checkbox').prop('checked', false);
              }              
              $("#custdelivered").val(data[0].delivered_cutomer_loaction);
              $("#remark").val(data[0].remark);
              

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
                  trHTML+='<tr id="rows"><td>Shipping Document</td><td>'+ data[0].shipping_document+'</td><td>'+data[0].shipping_document_update+'</td><td><a href="#" onclick="deleteDocument('+data[0].consignment_id+','+"'s'"+');">Delete</a></td></tr>';
              }
              
              if((data[0].commercial_invoice != "") && (data[0].commercial_invoice !=null) )
              {  
                  //alert(data[0].commercial_invoice);                
                  trHTML+='<tr id="rowc"><td>Commercial Invoice</td><td>'+ data[0].commercial_invoice+'</td><td>'+data[0].commercial_invoice_update+'</td><td><a href="#" onclick="deleteDocument('+data[0].consignment_id+','+"'c'"+');">Delete</a></td></tr>';
              }
              if((data[0].india_commercial_invoice != "") && (data[0].india_commercial_invoice !=null) )
              {  
                 // alert(data[0].india_commercial_invoice);                
                  trHTML+='<tr id="rowi"><td>India Commercial Invoice</td><td>'+ data[0].india_commercial_invoice+'</td><td>'+data[0].india_commercial_invoice_update+'</td><td><a href="#" onclick="deleteDocument('+data[0].consignment_id+','+"'i'"+');">Delete</a></td></tr>';
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
           
 <div class="row right_col" role="main" style ="">
                <div class="">

                    <div class="page-title">
                        <div class="title_left">
                            <h3>Form Elements</h3>
                        </div>
                        <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                                           <form  class="form-vertical form-label-right" novalidate method="post" action="">
                    <div class="item form-group">
                          <label class="control-label col-md-1 col-sm-1 col-xs-1" for="name">From<span class="required"></span>
                          </label>
                          <div class="col-md-3 col-sm-3 col-xs-3">
                              <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" 
                              data-validate-words="2" value="<?php echo $date1;?>" id="fromdate" name="fromdate" onChange="return datechaneg();" required type="datetime-local">
                          </div>
                      </div>
                      <div class="item form-group">
                          <label class="control-label col-md-1 col-sm-1 col-xs-1" for="name">To<span class="required"></span>
                          </label>
                          <div class="col-md-3 col-sm-3 col-xs-3">
                              <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" 
                              data-validate-words="2"value="<?php echo $date;?>" id="todate" name="todate" required type="datetime-local">
                          </div>
                      </div>
                       <div class="item form-group">
                         
                          <div class="">
                              <input  data-validate-length-range="6" 
                              data-validate-words="2" class="btn btn-primary" name="consignsubmit" id="consignsubmit" value="Go"  type="btn_submit">
                          </div>
                      </div>
                    
                    </form>
                    <hr width=100%  align=left>
                    <h2 style="color:#189B34;">Advanced Search</h2>
                    <form  class="form-vertical form-label-right" novalidate method="post" action="">
                    <div class="item form-group">                                      
                          <div class="col-md-2 col-sm-2 col-xs-2">
                               <label>Status</label></br>
                              <select class="form-control">
                                  <option>Choose option</option>
                                  <option>Option one</option>
                                  <option>Option two</option>
                                  <option>Option three</option>
                                  <option>Option four</option>
                              </select>
                          </div>
                          <div class="col-md-2 col-sm-2 col-xs-2">
                               <label>Entity</label></br>
                              <select class="form-control">
                                  <option>Choose option</option>
                                  <option>Option one</option>
                                  <option>Option two</option>
                                  <option>Option three</option>
                                  <option>Option four</option>
                              </select>
                          </div>
                          <div class="col-md-2 col-sm-2 col-xs-2">
                               <label>Customer</label></br>
                               <select class="form-control">
                                  <option>Choose option</option>
                                  <option>Option one</option>
                                  <option>Option two</option>
                                  <option>Option three</option>
                                  <option>Option four</option>
                                </select>
                          </div>
                          <div class="col-md-2 col-sm-2 col-xs-2">
                               <label>PO#</label></br>
                               <select class="form-control">
                                  <option>Choose option</option>
                                  <option>Option one</option>
                                  <option>Option two</option>
                                  <option>Option three</option>
                                  <option>Option four</option>
                              </select>
                          </div>
                          <div class="col-md-2 col-sm-2 col-xs-2">
                               <label>Product</label></br>
                              <select class="form-control">
                                  <option>Choose option</option>
                                  <option>Option one</option>
                                  <option>Option two</option>
                                  <option>Option three</option>
                                  <option>Option four</option>
                              </select>
                          </div>
                            <div class="item form-group">
                         <label>&nbsp;</label></br>
                          <div class="col-md-2 col-sm-2 col-xs-2">
                              <input  data-validate-length-range="6" 
                              data-validate-words="2" class="btn btn-primary" name="add" id="add" value="Go" required type="SUBMIT">
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
                <!-- /page content -->


            </div>

             <div class="right_col" role="main">
                <div class="">

                    <div class="page-title">
                        <div class="title_left">
                            <h3>Form Elements</h3>
                        </div>
                        <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_content" style="">
                        <table id="example" class="table table-striped responsive-utilities jambo_table">
                            <thead>
                                <tr class="headings">
                                 <input type="hidden" id="userId" value="<?php echo $user_id;?>" name="userId"/>
                                 
                                    <th>No</th>
                                    <th>PO&nbsp;Number</th>
                                    <th>Shipment&nbsp;Terms</th>
                                    <th>Commercial&nbsp;Invoice</th>
                                    <th>Port&nbsp;Of&nbsp;Discharge</th>
                                    <th>Product&nbsp;Name&nbsp;-&nbsp;Qty</th>
                                    <th>Shipment&nbsp;Value</th>                                                     
                                    <th>Sailing&nbsp;Date</th>
                                    <th>Arrival&nbsp;Date&nbsp;@&nbsp;Destination</th>
                                    <th>Agent&nbsp;in&nbsp;Case&nbsp;of&nbsp;EX-&nbsp;Work&nbsp;&&nbsp;FOB</th>
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
                                        echo "<td class='a-right a-right'>".$result[$key]['port_of_discharge']."</td>";
                                        echo "<td class='a-right a-right'>".$result[$key]['item_description'].",".$result[$key]['ordered_quantity']." ".$result[$key]['order_quantity_uom']."</td>"; 
                                        echo "<td class='a-right a-right'>".$result[$key]['shipment_value']."</td>";
                                        echo "<td class='a-right a-right'>".$result[$key]['sailing_date']."</td>";
                                        if($result[$key]['arrival_date'] > 0)
                                        {
                                          echo "<td class='a-right a-right'><input style='border: 0px none;background-color: #F9F9F9;' value=".$result[$key]['arrival_date']." required type='datetime-local' readonly='readonly'></td>";
                                        }
                                        else
                                        {
                                          echo "<td class='a-right a-right'></td>";
                                        }
                                        
                                        echo "<td class='a-right a-right'>".$result[$key]['agent']."</td>";
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
                    </div>

                 


                   
                </div>
                <!-- /page content -->


            </div>
  
  <script type="text/javascript">
   $(function(){
      
      $("#consignsubmit").click(function(){

        var from_date = $("#fromdate").val();
        var to_date = $("#todate").val();

             $.ajax({
              url: "dash_search.php",
              data : "from_date="+from_date+"&to_date="+to_date+"&action=dashboard_load",
              success:function(data){                
                 $("#kkk_data").html(data);
                 //location.reload();
              }
            });

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
.nav_menu{
      position: fixed;
}
  </style>         
}


<?php
 include("dash_pop.php");
  include('footer.php');
  ob_end_flush();
?>