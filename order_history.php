<?php
include "classes/functions.php";
session_start();
$con =new functions();
$cust_id = $_SESSION['cust_id'];

$sql ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID";    
$result= $con->data_select($sql);
$sql_sold_to = "SELECT distinct  SITE_USE_ID as ID, PRIMARY_FLAG, CONCAT_WS(',',ADDRESS1,ADDRESS2, ADDRESS3,ADDRESS4,CITY,COUNTRY) AS SHIP_ADDRESS FROM xxdkapps_customer_master WHERE BUSINESS_CODE ='BILL_TO' and CUSTOMER_NUMBER = ".$cust_id." and ACCOUNT_STATUS='A' order by PRIMARY_FLAG DESC";
$sold_to = $con->data_select($sql_sold_to);
if($result != "no")
{
?>
    <div class="container table-responsive table-boredered animated bounceInRight">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-condensed table-striped" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>ORDER NUMBER</th>
                            <th>PO#</th>
                            <th>ORDER DATE</th>
                            <th>PRODUCT NAME</th>
                            <th>PRICE</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($result as $key => $value) 
                        {
                            $result[$key] = array_map('trim', $result[$key]);
                    ?>
                            <tr data-toggle="collapse" data-target="#demo<?php echo $key;?>" class="accordion-toggle">
                                <td>
                                    <button class="btn btn-default btn-xs">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </button>
                                </td>
                                <td>
                                    <?php echo ("#".$result[$key]['ORDER_WEB_ID']); ?>
                                </td>
                                <td>
                                    <?php echo ("#".$result[$key]['PO']); ?>
                                </td>
                                <td>
                                    <?php echo $result[$key]['ORDER_DATE']; ?> 
                                </td>
                                <td>
                                    <?php echo $result[$key]['DESCRIPTION']; ?>
                                </td>
                                <td>
                                    <?php echo trim($result[$key]['UNIT_PRICE']); ?>
                                </td>
                                <td>
                                    <?php echo $result[$key]['OSTATUS']; ?> 
                                </td>
                            </tr>
                            <tr>
                                <td colspan="12" class="hiddenRow">
                                    <div class="accordian-body collapse" id="demo<?php echo $key;?>"> 
                                        <div class="container col-md-6" style="border-right:1px dotted #c9c9c9;">
                                            <div class="form-group">
                                                <label class="history_label">Oracle Order : </label><?php echo ($result[$key]['ORACLE_ORDER']);?>
                                            </div>
                                             <div class="form-group">
                                                <label class="history_label">Order Date: </label><?php echo ($result[$key]['ORDER_DATE']);?>
                                            </div>
                                            <div class="form-group">
                                                <label class="history_label">Shipping Address : </label><?php echo ($result[$key]['SHIP_ADDRESS']);?>
                                            </div>
                                            <div class="form-group">
                                                <label class="history_label">Billing Address : </label><?php echo ($sold_to[0]['SHIP_ADDRESS']);?>
                                            </div>
                                            <div class="form-group">
                                                <label class="history_label">Freight Terms : </label><?php echo ($result[$key]['FREIGHT_TERMS']);?>
                                            </div>
                                            <div class="form-group">
                                                <label class="history_label">Vessel Name : </label><?php echo ($result[$key]['VESSEL']);?>
                                            </div>
                                            <div class="form-group">
                                                <label class="history_label">Pay Terms : </label><?php echo ($result[$key]['ATTRIBUTE12']);?>
                                            </div>
                                            <div class="form-group">
                                                <label class="history_label">Comments : </label><?php echo ($result[$key]['COMMENTS']);?>
                                            </div>
                                        </div>
                                        <div class="container col-md-6">
                                            <div class="form-group">
                                                <label class="history_label">Product Name : </label><?php echo ($result[$key]['DESCRIPTION']);?>
                                            </div>
                                            <div class="form-group">
                                                <label class="history_label">Quantity : </label><?php echo ($result[$key]['QUANTITY']." KG");?>
                                            </div>
                                            <div class="form-group">
                                                <label class="history_label">Packaging Size : </label><?php echo ($result[$key]['PACKAGE_QTY']." Drum/Tank");?>
                                            </div>
                                            <div class="form-group">
                                                <label class="history_label">Price : </label><?php echo ($result[$key]['UNIT_PRICE']." /KG");?>
                                            </div>
                                            <div class="form-group">
                                                <label class="history_label">Contact Person : </label><?php echo ($result[$key]['CONTACT_PERSON']);?>
                                            </div>
                                        </div>
                                    </div> 
                                </td>
                            </tr>
                    <?php 
                        } 
                    ?>
                    </tbody>
                </table>
            </div>    
        </div>     
    </div>
<?php
}
else
{
?>
    <div class="container">
        <h4>
            No Orders Yet
        </h4>
        <button type="button" id="continue_shop_btn">Continue Buying</button>
    </div>
<?php
}
?>