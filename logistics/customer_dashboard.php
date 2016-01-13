<?php
ob_start();
include('../classes/functions.php');
date_default_timezone_set("Asia/Kolkata"); 

$date4=date('Y-m-d H:i:s');
$con=new functions();
session_start();

$date= $con->get_datetime_html();
$date1= date('Y-m-d\T00:00:00',strtotime("-1 days"));

//note:  email id = customer_num for customer login
$customer_num= '5033';

//Get all existing Orders
$query="SELECT * FROM consignment_details WHERE customer_num=".$customer_num;
$result=$con->data_select($query);


// Check count of orders for dashboard
$query_booked="SELECT count(order_status) from consignment_details WHERE order_status='BOOKED' and customer_num=".$customer_num;
$result_booked=$con->data_select($query_booked);


$query_despatch="SELECT count(order_status) from consignment_details WHERE order_status='DESPATCH' and customer_num=".$customer_num;
$result_despatch=$con->data_select($query_despatch);


$query_closed="SELECT count(order_status) from consignment_details WHERE order_status='CLOSED' and customer_num=".$customer_num;
$result_closed=$con->data_select($query_closed);


$query_intransit="SELECT count(order_status) from consignment_details WHERE order_status='IN TRANSIT' and customer_num=".$customer_num;
$result_intransit=$con->data_select($query_intransit);


$query_outfor_delivery="SELECT count(order_status) from consignment_details WHERE order_status='OUT FOR DELIVERY' and customer_num=".$customer_num;
$result_outfor_delivery=$con->data_select($query_outfor_delivery);


$query_arrive_port="SELECT count(order_status) from consignment_details WHERE order_status='ARRIVED AT PORT' and customer_num=".$customer_num;
$result_arive_port=$con->data_select($query_arrive_port);


$query_custom="SELECT count(order_status) from consignment_details WHERE order_status='UNDER CUSTOM ClEARENCE' and customer_num=".$customer_num;
$result_custom=$con->data_select($query_custom);

?>
<!-- page content -->
<div class="row">                 
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div>
            <hr width=100%  align=left>
            <div class="col-md-2 col-xs-12 widget widget_tally_box">
                <div class="x_panel">
                    <div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        BOOKED:
                        <span class="required" style="color:red;margin-left: 2px;"> 
                            <?php echo $result_booked[0]['count(order_status)']; ?>
                        </span>
                    </div>
                    <div class="form-group">
                        DESPATCH:<span class="required" style="color:red;margin-left: 2px;"><?php echo $result_despatch[0]['count(order_status)'];?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xs-12 widget widget_tally_box">
                <div class="x_panel">
                    <div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        IN TRANSIT:<span class="required" style="color:red;margin-left: 2px;"><?php echo $result_intransit[0]['count(order_status)'];?></span>
                    </div>
                    <div class="form-group">
                        ARRIVED @ PORT:<span class="required" style="color:red;margin-left: 2px;"><?php echo $result_arive_port[0]['count(order_status)'];?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12 widget widget_tally_box">
                <div class="x_panel">
                    <div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        UNDER CUSTOM CLEARENCE:<span class="required" style="color:red;margin-left: 2px;"><?php echo $result_custom[0]['count(order_status)'];?></span>
                    </div>
                    <div class="form-group">
                        OUT FOR DELIVERY:<span class="required" style="color:red;margin-left: 2px;"><?php echo $result_outfor_delivery[0]['count(order_status)'];?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-xs-12 widget widget_tally_box">
                <div class="x_panel">
                    <div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        CLOSED:<span class="required" style="color:red;margin-left: 2px;"><?php echo $result_closed[0]['count(order_status)'];?></span>
                    </div>
                </div>
            </div>                
            <style>
             .x_panel{
                 background:none !important; 
            border: 0px !important;
             }
            </style>
            <hr width=100%  align=left>
            <div class="x_content table-responsive" style="height:600px;overflow-y:auto;">
                <table id="example1" class="table">
                    <thead>
                        <tr class="headings">
                            <input type="hidden" id="userId" value="<?php echo $user_id;?>" name="userId"/>
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
                    <tbody>
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
                                echo '<td class="a-right a-right"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg4"onclick="return showcustomerdocument('.$result[$key]['consignment_id'].') ">Document</button> </td>';
                                echo '<td class="a-right a-right"> <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg5" onclick="return showshipmentdetails('.$result[$key]['consignment_id'].') ">Click here</button></td>';
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
<?php
 include("customer_document_pop.php");
 include("shipped_deatils_pop.php");
 ob_end_flush();
?>