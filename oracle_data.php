<?php
include('class/functions.php');
$con=new functions();
date_default_timezone_set("Asia/Kolkata");
$conn = oci_connect('apps','apps','172.25.25.112:1531/TEST');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid3 = oci_parse($conn, "SELECT SALES_AGREEMENT_NUMBER, SALES_AGREEMENT_NAME, CUSTOMER_NAME, CUSTOMER_NUMBER, SALES_AGREEMENT_DATE, LINE_ID, DELIVERY_ID, ORG_ID, HEADER_ID, LINE_NUMBER, ORDERED_ITEM, ORDER_QUANTITY_UOM, DESCRIPTION, START_DATE_ACTIVE, END_DATE_ACTIVE, SALESREP_ID, CUST_PO_NUMBER, PRICE_LIST,TERMS, SHIPPING_METHOD_CODE, FREIGHT_TERMS_CODE, SHIP_FROM_LOCATION, SHIP_TO, SHIP_TO_LOCATION, SHIP_TO_ADDRESS1, SHIP_TO_ADDRESS2, SHIP_TO_ADDRESS3, SHIP_TO_ADDRESS4, INVOICE_TO, INVOICE_TO_LOCATION, INVOICE_TO_ADDRESS1, INVOICE_TO_ADDRESS2, INVOICE_TO_ADDRESS3, INVOICE_TO_ADDRESS4, INVOICE_TO_ADDRESS5, DELIVER_TO, DELIVER_TO_LOCATION, DELIVER_TO_ADDRESS1, DELIVER_TO_ADDRESS2, DELIVER_TO_ADDRESS3, DELIVER_TO_ADDRESS4, DELIVER_TO_ADDRESS5, BLANKET_MAX_QUANTITY, BLANKET_MIN_QUANTITY, RELEASED_QUANTITY, FULFILLED_QUANTITY, RETURNED_QUANTITY, UNRELEASED_QUANTITY, UNFULFILLED_QUANTITY, RELEASED_AMOUNT, FULFILLED_AMOUNT, RETURNED_AMOUNT, SHIP_FROM_ORG_ID, SHIP_TO_ORG_ID, INVOICE_TO_ORG_ID, DELIVER_TO_ORG_ID, SOLD_TO_ORG_ID, INVENTORY_ITEM_ID
    FROM xxdk_order_ems_portal");

$r = oci_execute($stid3);


$data =array();

$i = 0;
while ($row = oci_fetch_assoc($stid3)) {
  $data[$i] = $row;

  $i++;

}


oci_free_statement($stid);
oci_close($conn);

foreach ($data as $key => $value) {
 
    $sql="INSERT INTO sales_agreement_view (SALES_AGREEMENT_NUMBER, SALES_AGREEMENT_NAME, CUSTOMER_NAME, CUSTOMER_NUMBER, SALES_AGREEMENT_DATE, LINE_ID, DELIVERY_ID, ORG_ID, HEADER_ID, LINE_NUMBER, ORDERED_ITEM, ORDER_QUANTITY_UOM, DESCRIPTION, START_DATE_ACTIVE, END_DATE_ACTIVE, SALESREP_ID, CUST_PO_NUMBER, PRICE_LIST,TERMS, SHIPPING_METHOD_CODE, FREIGHT_TERMS_CODE, SHIP_FROM_LOCATION, SHIP_TO, SHIP_TO_LOCATION, SHIP_TO_ADDRESS1, SHIP_TO_ADDRESS2, SHIP_TO_ADDRESS3, SHIP_TO_ADDRESS4, INVOICE_TO, INVOICE_TO_LOCATION, INVOICE_TO_ADDRESS1, INVOICE_TO_ADDRESS2, INVOICE_TO_ADDRESS3, INVOICE_TO_ADDRESS4, INVOICE_TO_ADDRESS5, DELIVER_TO, DELIVER_TO_LOCATION, DELIVER_TO_ADDRESS1, DELIVER_TO_ADDRESS2, DELIVER_TO_ADDRESS3, DELIVER_TO_ADDRESS4, DELIVER_TO_ADDRESS5, BLANKET_MAX_QUANTITY, BLANKET_MIN_QUANTITY, RELEASED_QUANTITY, FULFILLED_QUANTITY, RETURNED_QUANTITY, UNRELEASED_QUANTITY, UNFULFILLED_QUANTITY, RELEASED_AMOUNT, FULFILLED_AMOUNT, RETURNED_AMOUNT, SHIP_FROM_ORG_ID, SHIP_TO_ORG_ID, INVOICE_TO_ORG_ID, DELIVER_TO_ORG_ID, SOLD_TO_ORG_ID, INVENTORY_ITEM_ID) 
      VALUES ('"
        .$data[$key]['SALES_AGREEMENT_NUMBER']."','"
        .$data[$key]['SALES_AGREEMENT_NAME']."','"
        .$data[$key]['CUSTOMER_NAME']."','"
        .$data[$key]['CUSTOMER_NUMBER']."','"
        .$data[$key]['SALES_AGREEMENT_DATE']."','"
        .$data[$key]['LINE_ID']."','"
        .$data[$key]['ORG_ID']."','"
        .$data[$key]['HEADER_ID']."','"
        .$data[$key]['LINE_NUMBER']."','"
        .$data[$key]['ORDERED_ITEM']."','"
        .$data[$key]['ORDER_QUANTITY_UOM']."','"
        .$data[$key]['DESCRIPTION']."','"
        .$data[$key]['START_DATE_ACTIVE']."','"
        .$data[$key]['END_DATE_ACTIVE']."','"
        .$data[$key]['SALESREP_ID']."','"
        .$data[$key]['CUST_PO_NUMBER']."','"
        .$data[$key]['PRICE_LIST']."','"
        .$data[$key]['TERMS']."','"
        .$data[$key]['SHIPPING_METHOD_CODE']."','"
        .$data[$key]['FREIGHT_TERMS_CODE']."','"
        .$data[$key]['SHIP_FROM_LOCATION']."','"
        .$data[$key]['SHIP_TO']."','"
        .$data[$key]['SHIP_TO_LOCATION']."','"
        .$data[$key]['SHIP_TO_ADDRESS1']."','"
        .$data[$key]['SHIP_TO_ADDRESS2']."','"
        .$data[$key]['SHIP_TO_ADDRESS3']."','"
        .$data[$key]['SHIP_TO_ADDRESS4']."','"
        .$data[$key]['INVOICE_TO']."','"
        .$data[$key]['INVOICE_TO_LOCATION']."','"
        .$data[$key]['INVOICE_TO_ADDRESS1']."','"
        .$data[$key]['INVOICE_TO_ADDRESS2']."','"
        .$data[$key]['INVOICE_TO_ADDRESS3']."','"
        .$data[$key]['INVOICE_TO_ADDRESS4']."','"
        .$data[$key]['INVOICE_TO_ADDRESS5']."','"
        .$data[$key]['DELIVER_TO']."','"
        .$data[$key]['DELIVER_TO_LOCATION']."','"
        .$data[$key]['DELIVER_TO_ADDRESS1']."','"
        .$data[$key]['DELIVER_TO_ADDRESS2']."','"
        .$data[$key]['DELIVER_TO_ADDRESS3']."','"
        .$data[$key]['DELIVER_TO_ADDRESS4']."','"
        .$data[$key]['DELIVER_TO_ADDRESS5']."','"
        .$data[$key]['BLANKET_MAX_QUANTITY']."','"
        .$data[$key]['BLANKET_MIN_QUANTITY']."','"
        .$data[$key]['RELEASED_QUANTITY']."','"
        .$data[$key]['FULFILLED_QUANTITY']."','"
        .$data[$key]['RETURNED_QUANTITY']."','"
        .$data[$key]['UNRELEASED_QUANTITY']."','"
        .$data[$key]['UNFULFILLED_QUANTITY']."','"
        .$data[$key]['RELEASED_AMOUNT']."','"
        .$data[$key]['FULFILLED_AMOUNT']."','"
        .$data[$key]['RETURNED_AMOUNT']."','"
        .$data[$key]['SHIP_FROM_ORG_ID']."','"
        .$data[$key]['SHIP_TO_ORG_ID']."','"
        .$data[$key]['INVOICE_TO_ORG_ID']."','"
        .$data[$key]['DELIVER_TO_ORG_ID']."','"
        .$data[$key]['SOLD_TO_ORG_ID']."','"
        .$data[$key]['INVENTORY_ITEM_ID']."')";
        $result=$con->data_insert($sql);
}
exit;


?>