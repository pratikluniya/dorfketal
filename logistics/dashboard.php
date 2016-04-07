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
      
</script>
<!-- page content -->
<div class="container table-responsive">
    <div class="row">                 
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">                         
                <form>
                    <div class="form-group col-md-3 col-xs-12"> 
                        <label for="fromdate" name="fromdate">From Date : </label>
                        <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" data-validate-words="2" value="<?php echo $date1;?>" id="fromdate" name="fromdate" onChange="return datechaneg();" required type="datetime-local">
                    </div>
                    <div class="form-group col-md-3 col-xs-12">
                        <label for="todate" name="todate">To Date : </label>
                        <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" data-validate-words="2"value="<?php echo $date;?>" id="todate" name="todate" required type="datetime-local">
                    </div>
                    <div class="form-group col-md-6 col-xs-12">
                        <div class="col-md-3">
                           <input  type ="button" class="btn btn-primary middle_btn" name="consignsubmit" id="consignsubmit" value="Search"  >
                        </div>
                        <div class="col-md-3">
                            <input  type ="button" class="btn btn-primary middle_btn" name="adv_search" id="adv_search" value=" Advance Search"  >
                        </div>
                    </div>
                </form>  
            </div>
            <div class ="row" id ="adv_search_div">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h4>Advanced Search</h4>
                    <form>
                        <div class="col-md-2 col-xs-12 form-group">
                            <label for="adv_status" name="adv_status">Status : </label>
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
                        <div class="col-md-2 col-xs-12 form-group">
                            <label for="adv_entity" name="adv_entity">Entity : </label>
                            <select class="form-control" id ="adv_entity" name ="adv_entity" >
                                <?php echo $entity_options; ?>
                            </select>
                        </div>
                        <div class="col-md-2 col-xs-12 form-group">
                            <label for="adv_customer" name="adv_customer">Customer : </label>       
                            <select class="form-control" id ="adv_customer" name ="adv_customer">
                                <?php  echo  $customer_options; ?>
                            </select>
                        </div>
                        <div class="col-md-2 col-xs-12 form-group">
                            <label for="adv_po" name="adv_po">PO# : </label>
                            <input  class="form-control" id="adv_po" name="adv_po" >
                        </div>
                        <div class="col-md-2 col-xs-12 form-group">
                            <label name="adv_product" for="adv_product">Product : </label>
                            <input  class="form-control" id="adv_product" name="adv_product" >
                        </div>
                        <div class="col-md-2 col-xs-12 form-group">
                            <input class="btn btn-primary middle_btn" name="adv_conf_search" id="adv_conf_search" value="GO"  type="button">
                        </div>
                    </form>
                </div>
            </div>  
        </div>
    </div>
    <hr width=100%  align=left>
    <div class="row">                    
        <div class="container table-responsive" style="height:400px;overflow-y:auto;">
            <table id="example1"  class="table table-striped">
                <thead>
                    <tr class="headings">
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
                        echo "<tr>";
                        echo "<td>".$i."</td>";
                        echo "<td>".$result[$key]['cust_po_number']."</td>";
                        echo "<td>".$result[$key]['freight_terms_code']."</td>";
                        echo "<td>".$result[$key]['commercial_invoice']."</td>";
                        echo "<td>".$result[$key]['ref_inv']."</td>";
                        echo "<td>".$result[$key]['port_of_discharge']."</td>";
                        echo "<td>".$result[$key]['item_description']."</td>"; 
                        echo "<td>".$result[$key]['shipped_quantity']."</td>";
                        echo "<td>".$result[$key]['currency']."</td>";
                        echo "<td>".$result[$key]['shipping_value_inr']."</td>";
                        echo "<td>".$result[$key]['shipped_on_board']."</td>";
                        if($result[$key]['arrival_date'] > 0)
                        {
                            echo "<td class='a-right a-right'><input style='border: 0px none;background-color: #F9F9F9;' value=".$result[$key]['arrival_date']." required type='datetime-local' readonly='readonly'></td>";
                        }
                        else
                        {
                            echo "<td</td>";
                        }                                     
                        echo "<td>".$result[$key]['require_date']."</td>";
                        echo "<td>".$result[$key]['remark']."</td>";
                        echo "<td>".$result[$key]['order_status']."</td>";
                        echo '<td> <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg"onclick="return showdocument('.$result[$key]['consignment_id'].') ">Document</button> </td>';
                        echo '<td> <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg2" onclick="return consignmentId('.$result[$key]['consignment_id'].') ">Click here</button></td>';
                        echo "</tr>";
                        $i++;
                    } 
                }
                else
                {
                	 echo "<div id='hide_error' ><h3 align='center'>No Data Found </h3></div>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div> 
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
<?php
include('dash_pop2.php');
include('shipment_pop.php');
ob_end_flush();
?>