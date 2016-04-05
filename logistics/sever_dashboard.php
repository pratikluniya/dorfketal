<?php
ob_start();
include('../classes/functions.php');
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
$query="SELECT user_id,user_name FROM user_registration";
$result1=$con->data_select($query);
include('admin_sidebar_header.php');
?>
<script type="text/javascript">
  function consignmentId(consignmentid)
  {
    var consinement=$("#consignmentid").val(consignmentid);
    $.ajax({
        type: "POST",
        url:"logistics/ajax_service.php",
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
      url:"logistics/ajax_service.php",
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
      url:"logistics/ajax_service.php",
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


</script>

  <!-- page content -->
           
    <div class="right_col" role="main">
                <div class="">
                   
                    
                    <div class="clearfix"></div>
                    
                    <div class="row">                 
                   
                        <div class="col-md-12 col-sm-12 col-xs-12">
                         
                            <div class="">                         
                                
                                <h2 style="color:#189B34;">Dashboard</h2>
                                <hr width=100%  align=left>
                                <form  class="form-vertical form-label-right" novalidate method="post" action="">
                                <div class="item form-group">
                                      <label class="control-label col-md-1 col-sm-1 col-xs-1" for="name">From<span class="required"></span>
                                      </label>
                                      <div class="col-md-3 col-sm-3 col-xs-3">
                                          <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" 
                                          data-validate-words="2" value="<?php echo $date1;?>" id="fromdate" name="fromdate" required type="datetime-local">
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
                                          data-validate-words="2" class="btn btn-primary" name="consignsubmit" id="consignsubmit" value="Go" required type="SUBMIT">
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
                     
                                </form>
                                <hr width=100%  align=left>
                                <div class="x_content">
                                    <table id="example" class="table table-striped responsive-utilities jambo_table">
                                        <thead>
                                            <tr class="headings">
                                             <input type="hidden" id="userId" value="<?php echo $user_id;?>" name="userId"/>
                                             
                                                <th>Consign ID</th>
                                                <th>PO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Number</th>
                                                <th>Shipment Terms</th>
                                                <th>Commercial Invoice</th>
                                                <th>Port Of Discharge</th>
                                                <th>Product Name-Qty</th>                                                     
                                                <th>Sailing Date</th>
                                                <th>Arrival Date at Destination</th>
                                                <th>Agent</th>
                                                <th>Require Date</th>
                                                <th>Remark</th>
                                                <th>Status</th>
                                                <th>Action</th>                                               
                                            
                                            </tr>
                                        </thead>

                                        <tbody>
                                         <?php
                                              if($result!="no")
                                               {
                                                 
                                                foreach($result as $key => $val)
                                                {

                                                    echo "<tr class='even pointer'>";
                                                    echo "<td class='a-right a-right'>".$result[$key]['consignment_id']."</td>";
                                                    echo "<td class='a-right a-right'>".$result[$key]['cust_po_number']."</td>";
                                                     echo "<td class='a-right a-right'>".$result[$key]['shipment_terms']."</td>";
                                                     echo "<td class='a-right a-right'>".$result[$key]['commercial_invoice']."</td>";
                                                     echo "<td class='a-right a-right'>".$result[$key]['port_of_discharge']."</td>";
                                                     echo "<td class='a-right a-right'>".$result[$key]['item_description'].",".$result[$key]['ordered_quantity']." ".$result[$key]['order_quantity_uom']."</td>";                                               
                                                    echo "<td class='a-right a-right'>".$result[$key]['sailing_date']."</td>";
                                                    echo "<td class='a-right a-right'>".$result[$key]['arrival_date']."</td>";
                                                    echo "<td class='a-right a-right'>".$result[$key]['agent']."</td>";
                                                    echo "<td class='a-right a-right'>".$result[$key]['require_date']."</td>";
                                                    echo "<td class='a-right a-right'>".$result[$key]['remark']."</td>";
                                                    echo "<td class='a-right a-right'>".$result[$key]['status']."</td>";
                                                    echo '<td class="a-right a-right"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"onclick="return showdocument('.$result[$key]['consignment_id'].') ">Document</button>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg2" onclick="return consignmentId('.$result[$key]['consignment_id'].') ">Click here</button>

                                                    </td>';
                                                    echo "</tr>";
                                                } 
                                                }
                                              ?>
                                            
                                           
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

 
                    </div>
              </div>
             

<?php
 include("dash_pop.php");
  include('footer.php');
  ob_end_flush();
?>