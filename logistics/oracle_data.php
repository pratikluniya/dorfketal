<?php
include('../classes/functions.php');
$con=new functions();
date_default_timezone_set("Asia/Kolkata");
$conn = oci_connect('apps','apps','172.25.25.112:1531/TEST');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid3 = oci_parse($conn, "SELECT CUST_PO_NUMBER,CUSTOMER_NUM,FREIGHT_TERMS_CODE,ORG_ID,TO_CHAR(REQUIRE_DATE_DESTINATION,'YYYY-MM-DD:HH24:MI:SS')  as REQUIRE_DATE_DESTINATION,
      SHIPPED_QUANTITY,DELIVERY_ID,DESCRIPTION,INVOICE_NUMBER,PORT_OF_DISCHARGE,SHIPPING_STATUS,SHIPPING_VALUE_INR,ORDER_STATUS, 
      TO_CHAR(SHIPPED_DATE,'YYYY-MM-DD:HH24:MI:SS') as SHIPPED_DATE ,DELIVERY_DETAIL_ID,
      TO_CHAR(HEADER_LUD,'YYYY-MM-DD:HH24:MI:SS') as HEADER_LUD,
      TO_CHAR(LINE_LUD,'YYYY-MM-DD:HH24:MI:SS') as LINE_LUD,
      TO_CHAR(WSH_LUD,'YYYY-MM-DD:HH24:MI:SS')  as WSH_LUD,
      TO_CHAR(WDD_LUD,'YYYY-MM-DD:HH24:MI:SS')  as WDD_LUD ,
      TO_CHAR(WND_LUD,'YYYY-MM-DD:HH24:MI:SS')  as  WND_LUD , 
      TO_CHAR(EMP_LUD,'YYYY-MM-DD:HH24:MI:SS')   as  EMP_LUD,
      TO_CHAR(EML_LUD,'YYYY-MM-DD:HH24:MI:SS')  as   EML_LUD,
      TO_CHAR(JAI_LUD,'YYYY-MM-DD:HH24:MI:SS') as JAI_LUD FROM xxdk_order_ems_portal");

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
 
   $order_status="";
   if($data[$key]['ORDER_STATUS'] == "CLOSED" )
   {
      $order_status="DESPATCH";
      $sql="INSERT INTO logistic_view(CUST_PO_NUMBER, CUSTOMER_NUM, ORG_ID, FREIGHT_TERMS_CODE, SHIPPED_QUANTITY, DELIVERY_ID, DESCRIPTION, INVOICE_NUMBER, PORT_OF_DISCHARGE, SHIPPING_STATUS, SHIPPING_VALUE_INR, ORDER_STATUS, SHIPPED_DATE, DELIVERY_DETAIL_ID, REQUIRE_DATE_DESTINATION, HEADER_LUD, LINE_LUD, WSH_LUD, WDD_LUD, WND_LUD, EMP_LUD, EML_LUD, JAI_LUD) VALUES ('".$data[$key]['CUST_PO_NUMBER']."','".$data[$key]['CUSTOMER_NUM']."','".$data[$key]['ORG_ID']."','".$data[$key]['FREIGHT_TERMS_CODE']."','".$data[$key]['SHIPPED_QUANTITY']."','".$data[$key]['DELIVERY_ID']."','".$data[$key]['DESCRIPTION']."','".$data[$key]['INVOICE_NUMBER']."','".$data[$key]['PORT_OF_DISCHARGE']."','".$data[$key]['SHIPPING_STATUS']."','".$data[$key]['SHIPPING_VALUE_INR']."','".$order_status."','".$data[$key]['SHIPPED_DATE']."','".$data[$key]['DELIVERY_DETAIL_ID']."','".$data[$key]['REQUIRE_DATE_DESTINATION']."','".$data[$key]['HEADER_LUD']."','".$data[$key]['LINE_LUD']."','".$data[$key]['WSH_LUD']."','".$data[$key]['WDD_LUD']."','".$data[$key]['WND_LUD']."','".$data[$key]['EMP_LUD']."','".$data[$key]['EML_LUD']."','".$data[$key]['JAI_LUD']."')";
      
   }
   else
   {
      $order_status=$data[$key]['ORDER_STATUS'];
      $sql="INSERT INTO logistic_view(CUST_PO_NUMBER, CUSTOMER_NUM, ORG_ID, FREIGHT_TERMS_CODE, SHIPPED_QUANTITY, DELIVERY_ID, DESCRIPTION, INVOICE_NUMBER, PORT_OF_DISCHARGE, SHIPPING_STATUS, SHIPPING_VALUE_INR, ORDER_STATUS, SHIPPED_DATE, DELIVERY_DETAIL_ID, REQUIRE_DATE_DESTINATION, HEADER_LUD, LINE_LUD, WSH_LUD, WDD_LUD, WND_LUD, EMP_LUD, EML_LUD, JAI_LUD) VALUES ('".$data[$key]['CUST_PO_NUMBER']."','".$data[$key]['CUSTOMER_NUM']."','".$data[$key]['ORG_ID']."','".$data[$key]['FREIGHT_TERMS_CODE']."','".$data[$key]['SHIPPED_QUANTITY']."','".$data[$key]['DELIVERY_ID']."','".$data[$key]['DESCRIPTION']."','".$data[$key]['INVOICE_NUMBER']."','".$data[$key]['PORT_OF_DISCHARGE']."','".$data[$key]['SHIPPING_STATUS']."','".$data[$key]['SHIPPING_VALUE_INR']."','".$order_status."','".$data[$key]['SHIPPED_DATE']."','".$data[$key]['DELIVERY_DETAIL_ID']."','".$data[$key]['REQUIRE_DATE_DESTINATION']."','".$data[$key]['HEADER_LUD']."','".$data[$key]['LINE_LUD']."','".$data[$key]['WSH_LUD']."','".$data[$key]['WDD_LUD']."','".$data[$key]['WND_LUD']."','".$data[$key]['EMP_LUD']."','".$data[$key]['EML_LUD']."','".$data[$key]['JAI_LUD']."')";
   }
  
    
    $result=$con->data_insert($sql);
 

}
$sql="SELECT CUST_PO_NUMBER, CUSTOMER_NUM, ORG_ID, FREIGHT_TERMS_CODE, SHIPPED_QUANTITY, DELIVERY_ID, DESCRIPTION, INVOICE_NUMBER, PORT_OF_DISCHARGE, SHIPPING_STATUS, SHIPPING_VALUE_INR, ORDER_STATUS, SHIPPED_DATE, DELIVERY_DETAIL_ID, REQUIRE_DATE_DESTINATION, GREATEST( HEADER_LUD, LINE_LUD, WSH_LUD, WDD_LUD, WND_LUD, EMP_LUD, EML_LUD, JAI_LUD ) AS date1
FROM logistic_view";
$result=$con->data_select($sql);

if($result != "no")
{

    foreach ($result as $key => $value) {

  
      $sql_consignment_details="INSERT INTO consignment_details(cust_po_number,customer_num,org_id,freight_terms_code,shipped_quantity,
        delivery_id,item_description,commercial_invoice,port_of_discharge,shipping_status,shipment_value,order_status,
        schedule_ship_date,delivery_details_id,require_date,created_date)
        VALUES ('".$result[$key]['CUST_PO_NUMBER']."','".$result[$key]['CUSTOMER_NUM']."','".$result[$key]['ORG_ID']."',
          '".$result[$key]['FREIGHT_TERMS_CODE']."','".$result[$key]['SHIPPED_QUANTITY']."','".$result[$key]['DELIVERY_ID']."',
          '".$result[$key]['DESCRIPTION']."','".$result[$key]['INVOICE_NUMBER']."',
          '".$result[$key]['PORT_OF_DISCHARGE']."','".$result[$key]['SHIPPING_STATUS']."',
          '".$result[$key]['SHIPPING_VALUE_INR']."','".$result[$key]['ORDER_STATUS']."',
          '".$result[$key]['SHIPPED_DATE']."','".$result[$key]['DELIVERY_DETAIL_ID']."',
          '".$result[$key]['REQUIRE_DATE_DESTINATION']."','".$result[$key]['date1']."')";

         
        $result_consignment_details=$con->data_insert($sql_consignment_details);
       
    }
   
}

 exit;


?>