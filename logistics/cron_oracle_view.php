<?php

//date_default_timezone_set("Asia/Kolkata");
$conn = oci_connect('apps','apps','172.25.25.112:1531/TEST');
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }     
 //  $stid3 =oci_parse($conn, "SELECT * FROM xxdk_order_ems_portal");
   //$stid3=oci_parse($conn, "SELECT CUST_PO_NUMBER FROM xxdk_order_ems_portal");
    $stid3 = oci_parse($conn, "SELECT CUST_PO_NUMBER,CUSTOMER_NUM,FREIGHT_TERMS_CODE,ORG_ID,TO_CHAR(REQUIRE_DATE_DESTINATION,'YYYY-MM-DD:HH24:MI:SS')  as REQUIRE_DATE_DESTINATION,
          SHIPPED_QUANTITY,DELIVERY_ID,DESCRIPTION,INVOICE_NUMBER,PORT_OF_DISCHARGE,SHIPPING_STATUS,SHIPPING_VALUE_INR,ORDER_STATUS ,DELIVERY_DETAIL_ID,
          TO_CHAR(HEADER_LUD,'YYYY-MM-DD:HH24:MI:SS') as HEADER_LUD,
          TO_CHAR(LINE_LUD,'YYYY-MM-DD:HH24:MI:SS') as LINE_LUD,
          TO_CHAR(WSH_LUD,'YYYY-MM-DD:HH24:MI:SS')  as WSH_LUD,
          TO_CHAR(WDD_LUD,'YYYY-MM-DD:HH24:MI:SS')  as WDD_LUD ,
          TO_CHAR(WND_LUD,'YYYY-MM-DD:HH24:MI:SS')  as  WND_LUD , 
          TO_CHAR(EMP_LUD,'YYYY-MM-DD:HH24:MI:SS')   as  EMP_LUD,
          TO_CHAR(EML_LUD,'YYYY-MM-DD:HH24:MI:SS')  as   EML_LUD,
          TO_CHAR(JAI_LUD,'YYYY-MM-DD:HH24:MI:SS') as JAI_LUD,
           REF_INV,SHIPPING_VALUE,CURRENCY,TO_CHAR(DISPATCH_DATE,'YYYY-MM-DD:HH24:MI:SS') as DISPATCH_DATE FROM xxdk_order_ems_portal");

    $r = oci_execute($stid3);
    $data =array();
    $i = 0;
    while ($row = oci_fetch_assoc($stid3)) {
      $data[$i] = $row;
      $i++;

    }
echo "<pre>";
print_r($data);

oci_free_statement($stid);
oci_close($conn);




?>