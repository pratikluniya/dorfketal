<?php
ob_start();
include('../classes/functions.php');
date_default_timezone_set("Asia/Kolkata");  
$date4=date('Y-m-d H:i:s');
$con=new functions();
$date= $con->get_datetime_html();
$date1= date('Y-m-d\T00:00:00',strtotime("-1 days"));
session_start();
$entity_id="";
$query="SELECT * FROM consignment_details WHERE dispatch_date between '".date('Y-m-d\ 00:00:00',strtotime("-1 days"))."' and '".date('Y-m-d H:i:s')."'";
$result=$con->data_select($query);
$query_user="";
if($entity_id =="")
{
    $query_user="SELECT DISTINCT customer_num FROM consignment_details ";
    $result1=$con->data_select($query_user);
    $customer_options="<option value ='0'>Select Cutomer</option>";
    foreach($result1 as $key => $val)
    {    
        $customer_options .="<option value  ='".$result1[$key]['customer_num']."'>".$result1[$key]['customer_num']."</option>";  
    }
}
else
{
    $query_user="SELECT DISTINCT customer_num FROM consignment_details WHERE org_id in(".$entity_id.")";
    $result1=$con->data_select($query_user);
    $customer_options="<option value ='0'>Select Cutomer</option>";
    foreach($result1 as $key => $val)
    {
        $customer_options .="<option value  ='".$result1[$key]['customer_num']."'>".$result1[$key]['customer_num']."</option>";
    }
}
$sql_entity ="select org_id,name from org_map";
$entity_data=$con->data_select($sql_entity);
$entity_options="<option value ='0'>Select Entity</option>";
foreach($entity_data as $key => $val)
{
    $entity_options .="<option  value ='".$entity_data[$key]['org_id']."'>".$entity_data[$key]['name']."</option>";
}
?>
<script type="text/javascript">
    function consignmentId(consignmentid)
    {
        var consinement=$("#consignmentid").val(consignmentid);
        $.ajax({
            type: "POST",
            url:"logistics/ajax_service.php",
            data:"consignment_id="+consignmentid+"&action=select_update_consignment",
            dataType:"JSON",
            success: function(data)
            {
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
                    if(data[0].arrival_date == null || data[0].arrival_date == "" || data[0].arrival_date == '' || data[0].arrival_date == null)
                    {
                        $("#customclearance").attr('disabled', 'disabled');
              		    $("#customclearance").attr('readonly', 'true');
                    } 
                    else
                    {
                  	    $("#customclearance").removeAttr('disabled');
                        $("#customclearance").removeAttr('readonly');
                  	}
                    if(data[0].custom_clearance =="yes")
                    {
                        $(':checkbox').prop('checked', true);
                    }
                    else
                    {
                  	    $(':checkbox').prop('checked', false);
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
                    $("#remark").val(data[0].remark);
                    if(data[0].container_number == null || data[0].container_number == "" || data[0].container_number == '')
                    {
                        $("#liknktraking").html("<spam>Container Number</spam>");
                    }
                    else
                    { 
                        if(data[0].container_url == null || data[0].container_url=="" || data[0].container_url =='')
                        {
                     	    $("#edit_container_url").val(data[0].url_logistic);
                     	    $("#add_btn_url").html('<input type="button"  name="btn_edit" id="btn_edit" value="Edit Url" class="col-md-2" onclick="return container_edit_url('+data[0].delivery_details_id+');"/>');
                     	    $("#liknktraking").html("<span class='glyphicon glyphicon-pencil' data-toggle='modal' data-target='.bs-example-modal-lg6' name='btn_tracking' id='btn_tracking' /></span><span style='margin-left:5px;'>Container Number</span><a style='color:#7d8bf0;margin-left: 10px;' href='"+data[0].url_logistic+data[0].container_number+"' style='margin-left:10px; color:green;' target='_blank'>View</a>");
                        }
                        else
                        {
                     	    $("#add_btn_url").html('<input type="button"  name="btn_edit" id="btn_edit" value="Edit Url" class="col-md-2" onclick="return container_edit_url('+data[0].delivery_details_id+');"/>');
                     	    $("#add_default_url").html('<input type="button"  name="btn_edit" id="btn_edit" value="Default Url" class="col-md-2" onclick="return container_default_url('+data[0].delivery_details_id+');"/>');
                     	    $("#edit_container_url").val(data[0].container_url);
                     	    $("#liknktraking").html("<span class='glyphicon glyphicon-pencil' data-toggle='modal' data-target='.bs-example-modal-lg6' name='btn_tracking' id='btn_tracking' /></span><span style='margin-left:5px;'>Container Number</span><a style='color:#7d8bf0;margin-left: 10px;' href='"+data[0].container_url+"' style='margin-left:10px; color:green;' target='_blank'>View</a>");
                        }
                    } 
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
                    trHTML+='<tr id="rows"><td>Shipping Document</td><td><a  href="uploaded/'+ data[0].shipping_document+'">'+ data[0].shipping_document+'</a></td><td>'+data[0].shipping_document_update+'</td><td><a  href="#" onclick="deleteDocument('+data[0].consignment_id+','+"'s'"+');">Delete</a></td></tr>';
                }
                if((data[0].commercial_invoice != "") && (data[0].commercial_invoice !=null) )
                {  
                    trHTML+='<tr id="rowc"><td>Commercial Invoice</td><td><a  href="uploaded/'+ data[0].commercial_invoice+'">'+ data[0].commercial_invoice+'</a></td><td>'+data[0].commercial_invoice_update+'</td><td><a href="#" onclick="deleteDocument('+data[0].consignment_id+','+"'c'"+');">Delete</a></td></tr>';
                }
                if((data[0].india_commercial_invoice != "") && (data[0].india_commercial_invoice !=null) )
                {  
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
            url:"logistics/ajax_service.php",
            data:"consignment_id="+consignmentid_delete+"&document_type="+document_delete+"&action=deleteDocument",     
            success: function(data)
            {
                if(data == "success")
                {

                  	$("#pop").html('<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert"aria-label="Close"><span aria-hidden="true">×</span></button>You have successfully deleted document</div>');
                    $("#pop").fadeOut(5000);
                    $("#row"+document_delete).removeAttr().fadeOut(5000);
                    var expload= function()
                    {
                        location.reload();
                    };
                    setTimeout(expload,5001);
                }
            }
        });  
    }
    function datechaneg()
    {
        var datesd= $("#fromdate").val();
        $("#fromdate").val(datesd);
    }  
</script>
<!-- page content -->
<div class="container">
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
                                <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" data-validate-words="2" value="<?php echo $date1;?>" id="fromdate" name="fromdate" onChange="return datechaneg();" required type="datetime-local">
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
                                <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" data-validate-words="2"value="<?php echo $date;?>" id="todate" name="todate" required type="datetime-local">
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
                                   <input  type ="button" class="btn btn-primary" name="consignsubmit" id="consignsubmit" value="Search"  >
                                </div>
                                <div class="col-md-3">
                                   <input  type ="hidden"class="" name="" id="" value=""  type="">
                                </div>
                                <div class="col-md-3">
                                    <input  type ="button" class="btn btn-primary" name="adv_search" id="adv_search" value=" ADV Search"  >
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
        </div>
    </div>
    <div class="row">                    
        <div class="container table-responsive" style="">
            <table id="example1" class="">
                <thead>
                    <tr class="">
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
                else
                {
                	 echo "<div id='hide_error' ><h1 align='center'>No Data Found </h1></div>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div> 
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
            url: "logistics/dash_search.php",
            data : "from_date="+from_date+"&to_date="+to_date+"&action=dashboard_load",
            success:function(data){    
                    $(".ajax-loader").hide(); 
                    $("body").removeClass("background-overlay");   
                    $("#kkk_data").html(data);
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
            $.ajax({
                url: "logistics/dash_search.php",
                data : "&adv_status="+adv_status+"&adv_customer="+adv_customer+"&adv_entity="+adv_entity+"&adv_po="+adv_po+"&adv_product="+adv_product+"&action=advance_search_load",
                success:function(data){  
                    $(".ajax-loader").hide(); 
                    $("body").removeClass("background-overlay"); 
                    $("#kkk_data").html(data);              
                }
            });
        });
        $("#adv_search").click(function(){
            $("#adv_search_div").toggle();
        });
    }); 
	$(document).ready(function(){
		$("#hide_error").removeAttr().fadeOut(3000);
	});
</script> 
<script type="text/javascript">
$(document).ready(function() {
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
ob_end_flush();
?>