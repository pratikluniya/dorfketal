<?php
include("./classes/functions.php");
$con =new functions();
session_start();
date_default_timezone_set("Asia/Kolkata");
//print_r($_REQUEST);
$cust_id = $_SESSION['cust_id'];
$order_id = $_REQUEST['order_id'];
$oracle_order = $_REQUEST['oracle_order'];
$sql ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.ATTRIBUTE12 FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = " .$order_id." and ofd.ORACLE_ORDER = ".$oracle_order;    
$result=$con->data_select($sql);
echo "<pre>";
print_r($result);
?>


<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Order Details</h4>
</div>
<div class="modal-body">
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
</div>