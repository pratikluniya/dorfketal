<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include('../classes/functions.php');
$con =new functions();
//$getdata_mysql="SELECT id, DELIVERY_DETAIL_ID FROM logistic_view ORDER BY id ASC LIMIT 1";
$getdata_mysql="SELECT * FROM logistic_view WHERE DELIVERY_DETAIL_ID = ( SELECT MAX( DELIVERY_DETAIL_ID ) 
FROM logistic_view )";
$result_mysql=$con->data_select($getdata_mysql);
//$logistic_view_data= array();
if($result_mysql != 'no')
{
	
	 $DELIVERY_DETAIL_ID = $result_mysql[0]['DELIVERY_DETAIL_ID'];


		$conn = oci_connect('apps','apps','172.25.25.112:1531/TEST');
		if (!$conn) {
		    $e = oci_error();
		    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}

			
		$stid3 = oci_parse($conn, "SELECT CUST_PO_NUMBER,CUSTOMER_NUM,FREIGHT_TERMS_CODE,ORG_ID,TO_CHAR(
		REQUIRE_DATE_DESTINATION,'YYYY-MM-DD:HH24:MI:SS')  as REQUIRE_DATE_DESTINATION,
	    SHIPPED_QUANTITY,DELIVERY_ID,DESCRIPTION,INVOICE_NUMBER,PORT_OF_DISCHARGE,SHIPPING_STATUS,
	    SHIPPING_VALUE_INR,ORDER_STATUS, 
	    DELIVERY_DETAIL_ID,
	    TO_CHAR(HEADER_LUD,'YYYY-MM-DD:HH24:MI:SS') as HEADER_LUD,
	    TO_CHAR(LINE_LUD,'YYYY-MM-DD:HH24:MI:SS') as LINE_LUD,
	    TO_CHAR(WSH_LUD,'YYYY-MM-DD:HH24:MI:SS')  as WSH_LUD,
	    TO_CHAR(WDD_LUD,'YYYY-MM-DD:HH24:MI:SS')  as WDD_LUD ,
	    TO_CHAR(WND_LUD,'YYYY-MM-DD:HH24:MI:SS')  as  WND_LUD , 
	    TO_CHAR(EMP_LUD,'YYYY-MM-DD:HH24:MI:SS')   as  EMP_LUD,
	    TO_CHAR(EML_LUD,'YYYY-MM-DD:HH24:MI:SS')  as   EML_LUD,
	    TO_CHAR(JAI_LUD,'YYYY-MM-DD:HH24:MI:SS') as JAI_LUD,
	    REF_INV,SHIPPING_VALUE,CURRENCY,TO_CHAR(DISPATCH_DATE,'YYYY-MM-DD:HH24:MI:SS') as DISPATCH_DATE
	    FROM xxdk_order_ems_portal WHERE DELIVERY_DETAIL_ID  > '".$result_mysql[0]['DELIVERY_DETAIL_ID']."'");

		$r = oci_execute($stid3);
		$data =array();
		$i = 0;
		while ($row = oci_fetch_assoc($stid3)) {
		  $data[$i] = $row;
		  $i++;

		}
		/*echo "<pre>";
		print_r($data);
		exit;*/
		
		foreach ($data as $key => $value) {
 			
		   $order_status="";
			   if($data[$key]['ORDER_STATUS'] == "CLOSED" )
			   {
			      $order_status="DESPATCH";
			      $sql="INSERT INTO logistic_view(CUST_PO_NUMBER, CUSTOMER_NUM, ORG_ID, FREIGHT_TERMS_CODE, SHIPPED_QUANTITY, DELIVERY_ID, DESCRIPTION, INVOICE_NUMBER, PORT_OF_DISCHARGE, SHIPPING_STATUS, SHIPPING_VALUE_INR, ORDER_STATUS, DELIVERY_DETAIL_ID, REQUIRE_DATE_DESTINATION, HEADER_LUD, LINE_LUD, WSH_LUD, WDD_LUD, WND_LUD, EMP_LUD, EML_LUD, JAI_LUD,REF_INV,SHIPPING_VALUE,CURRENCY,DISPATCH_DATE) VALUES ('".$data[$key]['CUST_PO_NUMBER']."','".$data[$key]['CUSTOMER_NUM']."','".$data[$key]['ORG_ID']."','".$data[$key]['FREIGHT_TERMS_CODE']."','".$data[$key]['SHIPPED_QUANTITY']."','".$data[$key]['DELIVERY_ID']."','".$data[$key]['DESCRIPTION']."','".$data[$key]['INVOICE_NUMBER']."','".$data[$key]['PORT_OF_DISCHARGE']."','".$data[$key]['SHIPPING_STATUS']."','".$data[$key]['SHIPPING_VALUE_INR']."','".$order_status."','".$data[$key]['DELIVERY_DETAIL_ID']."','".$data[$key]['REQUIRE_DATE_DESTINATION']."','".$data[$key]['HEADER_LUD']."','".$data[$key]['LINE_LUD']."','".$data[$key]['WSH_LUD']."','".$data[$key]['WDD_LUD']."','".$data[$key]['WND_LUD']."','".$data[$key]['EMP_LUD']."','".$data[$key]['EML_LUD']."','".$data[$key]['JAI_LUD']."','".$data[$key]['REF_INV']."','".$data[$key]['SHIPPING_VALUE']."','".$data[$key]['CURRENCY']."','".$data[$key]['DISPATCH_DATE']."')";
			      
			   }
			   else
			   {
			      $order_status=$data[$key]['ORDER_STATUS'];
			      $sql="INSERT INTO logistic_view(CUST_PO_NUMBER, CUSTOMER_NUM, ORG_ID, FREIGHT_TERMS_CODE, SHIPPED_QUANTITY, DELIVERY_ID, DESCRIPTION, INVOICE_NUMBER, PORT_OF_DISCHARGE, SHIPPING_STATUS, SHIPPING_VALUE_INR, ORDER_STATUS, DELIVERY_DETAIL_ID, REQUIRE_DATE_DESTINATION, HEADER_LUD, LINE_LUD, WSH_LUD, WDD_LUD, WND_LUD, EMP_LUD, EML_LUD, JAI_LUD,REF_INV,SHIPPING_VALUE,CURRENCY,DISPATCH_DATE) VALUES ('".$data[$key]['CUST_PO_NUMBER']."','".$data[$key]['CUSTOMER_NUM']."','".$data[$key]['ORG_ID']."','".$data[$key]['FREIGHT_TERMS_CODE']."','".$data[$key]['SHIPPED_QUANTITY']."','".$data[$key]['DELIVERY_ID']."','".$data[$key]['DESCRIPTION']."','".$data[$key]['INVOICE_NUMBER']."','".$data[$key]['PORT_OF_DISCHARGE']."','".$data[$key]['SHIPPING_STATUS']."','".$data[$key]['SHIPPING_VALUE_INR']."','".$order_status."','".$data[$key]['DELIVERY_DETAIL_ID']."','".$data[$key]['REQUIRE_DATE_DESTINATION']."','".$data[$key]['HEADER_LUD']."','".$data[$key]['LINE_LUD']."','".$data[$key]['WSH_LUD']."','".$data[$key]['WDD_LUD']."','".$data[$key]['WND_LUD']."','".$data[$key]['EMP_LUD']."','".$data[$key]['EML_LUD']."','".$data[$key]['JAI_LUD']."','".$data[$key]['REF_INV']."','".$data[$key]['SHIPPING_VALUE']."','".$data[$key]['CURRENCY']."','".$data[$key]['DISPATCH_DATE']."')";
			   }
			  
			    
			    $result=$con->data_insert($sql);
		 

		 }
		$getdata_mysql_consignment_details="SELECT  MAX(delivery_details_id) FROM consignment_details";
		$result_mysql=$con->data_select($getdata_mysql_consignment_details);
		

		if($result_mysql != "no")
		{
			
		   $sql="SELECT CUST_PO_NUMBER, CUSTOMER_NUM, ORG_ID, FREIGHT_TERMS_CODE, SHIPPED_QUANTITY, DELIVERY_ID, DESCRIPTION, INVOICE_NUMBER, PORT_OF_DISCHARGE, SHIPPING_STATUS, SHIPPING_VALUE_INR, ORDER_STATUS, SHIPPED_DATE, DELIVERY_DETAIL_ID, REQUIRE_DATE_DESTINATION, HEADER_LUD, LINE_LUD, WSH_LUD, WDD_LUD, WND_LUD, EMP_LUD, EML_LUD, JAI_LUD,REF_INV,SHIPPING_VALUE,CURRENCY,DISPATCH_DATE
		   FROM logistic_view WHERE DELIVERY_DETAIL_ID  > '".$result_mysql[0]['MAX(delivery_details_id)']."'";
		  
		   $result=$con->data_select($sql);
			if($result != "no")
			{
				
			    foreach ($result as $key => $value) {

			        $sql_consignment_details="INSERT INTO consignment_details(cust_po_number,customer_num,org_id,
			      	freight_terms_code,shipped_quantity,delivery_id,item_description,commercial_invoice,
			      	port_of_discharge,shipping_status,shipping_value_inr,order_status,
			        delivery_details_id,require_date,
			        Header_lud,line_lud,wsh_lud,wdd_lud,wnd_lud,emp_lud,eml_lud,jai_lud,ref_inv,shipping_value,currency,dispatch_date)
			        VALUES ('".$result[$key]['CUST_PO_NUMBER']."','".$result[$key]['CUSTOMER_NUM']."','".$result[$key]['ORG_ID']."',
			        	'".$result[$key]['FREIGHT_TERMS_CODE']."','".$result[$key]['SHIPPED_QUANTITY']."','".$result[$key]['DELIVERY_ID']."'
			        	,'".$result[$key]['DESCRIPTION']."','".$result[$key]['INVOICE_NUMBER']."','".$result[$key]['PORT_OF_DISCHARGE']."',
			        	'".$result[$key]['SHIPPING_STATUS']."','".$result[$key]['SHIPPING_VALUE_INR']."','".$result[$key]['ORDER_STATUS']."',
			        	'".$result[$key]['DELIVERY_DETAIL_ID']."','".$result[$key]['REQUIRE_DATE_DESTINATION']."',
			        	'".$result[$key]['HEADER_LUD']."','".$result[$key]['LINE_LUD']."','".$result[$key]['WSH_LUD']."','".$result[$key]['WDD_LUD']."','".$result[$key]['WND_LUD']."',
			        	'".$result[$key]['EMP_LUD']."','".$result[$key]['EML_LUD']."','".$result[$key]['JAI_LUD']."',
			        	'".$result[$key]['REF_INV']."','".$result[$key]['SHIPPING_VALUE']."','".$result[$key]['CURRENCY']."','".$result[$key]['DISPATCH_DATE']."')";
			        $result_consignment_details=$con->data_insert($sql_consignment_details);
			       
			    }
			   
		   }
		}
		else
		{
			$sql="SELECT CUST_PO_NUMBER, CUSTOMER_NUM, ORG_ID, FREIGHT_TERMS_CODE, SHIPPED_QUANTITY, DELIVERY_ID, DESCRIPTION, INVOICE_NUMBER, PORT_OF_DISCHARGE, SHIPPING_STATUS, SHIPPING_VALUE_INR, ORDER_STATUS, SHIPPED_DATE, DELIVERY_DETAIL_ID, REQUIRE_DATE_DESTINATION, HEADER_LUD, LINE_LUD, WSH_LUD, WDD_LUD, WND_LUD, EMP_LUD, EML_LUD, JAI_LUD,REF_INV,SHIPPING_VALUE,CURRENCY,DISPATCH_DATE
		   FROM logistic_view";
			
			$result=$con->data_select($sql);
			if($result != "no")
			{

			    foreach ($result as $key => $value) {

			   $sql_consignment_details="INSERT INTO consignment_details(cust_po_number,customer_num,org_id,
			      	freight_terms_code,shipped_quantity,delivery_id,item_description,commercial_invoice,
			      	port_of_discharge,shipping_status,shipping_value_inr,order_status,
			        delivery_details_id,require_date,
			        Header_lud,line_lud,wsh_lud,wdd_lud,wnd_lud,emp_lud,eml_lud,jai_lud,ref_inv,shipping_value,currency,dispatch_date)
			        VALUES ('".$result[$key]['CUST_PO_NUMBER']."','".$result[$key]['CUSTOMER_NUM']."','".$result[$key]['ORG_ID']."',
			        	'".$result[$key]['FREIGHT_TERMS_CODE']."','".$result[$key]['SHIPPED_QUANTITY']."','".$result[$key]['DELIVERY_ID']."'
			        	,'".$result[$key]['DESCRIPTION']."','".$result[$key]['INVOICE_NUMBER']."','".$result[$key]['PORT_OF_DISCHARGE']."',
			        	'".$result[$key]['SHIPPING_STATUS']."','".$result[$key]['SHIPPING_VALUE_INR']."','".$result[$key]['ORDER_STATUS']."',
			        	'".$result[$key]['DELIVERY_DETAIL_ID']."','".$result[$key]['REQUIRE_DATE_DESTINATION']."',
			        	'".$result[$key]['HEADER_LUD']."','".$result[$key]['LINE_LUD']."','".$result[$key]['WSH_LUD']."','".$result[$key]['WDD_LUD']."','".$result[$key]['WND_LUD']."',
			        	'".$result[$key]['EMP_LUD']."','".$result[$key]['EML_LUD']."','".$result[$key]['JAI_LUD']."',
			        	'".$result[$key]['REF_INV']."','".$result[$key]['SHIPPING_VALUE']."','".$result[$key]['CURRENCY']."','".$result[$key]['DISPATCH_DATE']."')";
			        $result_consignment_details=$con->data_insert($sql_consignment_details);
			       
			    }
			   
		   }
		}
		
	 exit;
	

}
else
{

	    echo "first time ";
		$conn = oci_connect('apps','apps','172.25.25.112:1531/TEST');
		if (!$conn) {
		    $e = oci_error();
		    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}			
		/*$stid3 = oci_parse($conn, "SELECT * FROM (SELECT * FROM xxdk_order_ems_portal  order by   
			     DELIVERY_DETAIL_ID asc) WHERE rownum <= 5") ;*/
		$stid3 = oci_parse($conn, "SELECT CUST_PO_NUMBER,CUSTOMER_NUM,FREIGHT_TERMS_CODE,ORG_ID,TO_CHAR(REQUIRE_DATE_DESTINATION,'YYYY-MM-DD:HH24:MI:SS')  as REQUIRE_DATE_DESTINATION,
		      SHIPPED_QUANTITY,DELIVERY_ID,DESCRIPTION,INVOICE_NUMBER,PORT_OF_DISCHARGE,SHIPPING_STATUS,SHIPPING_VALUE_INR,ORDER_STATUS, 
		      DELIVERY_DETAIL_ID,
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
		
		foreach ($data as $key => $value) {
 
		  if($data[$key]['ORDER_STATUS'] == "CLOSED" )
		   {
		      $order_status="DESPATCH";
		      $sql="INSERT INTO logistic_view(CUST_PO_NUMBER, CUSTOMER_NUM, ORG_ID, FREIGHT_TERMS_CODE, SHIPPED_QUANTITY, DELIVERY_ID, DESCRIPTION, INVOICE_NUMBER, PORT_OF_DISCHARGE, SHIPPING_STATUS, SHIPPING_VALUE_INR, ORDER_STATUS, DELIVERY_DETAIL_ID, REQUIRE_DATE_DESTINATION, HEADER_LUD, LINE_LUD, WSH_LUD, WDD_LUD, WND_LUD, EMP_LUD, EML_LUD, JAI_LUD,REF_INV,SHIPPING_VALUE,CURRENCY,DISPATCH_DATE) VALUES ('".$data[$key]['CUST_PO_NUMBER']."','".$data[$key]['CUSTOMER_NUM']."','".$data[$key]['ORG_ID']."','".$data[$key]['FREIGHT_TERMS_CODE']."','".$data[$key]['SHIPPED_QUANTITY']."','".$data[$key]['DELIVERY_ID']."','".$data[$key]['DESCRIPTION']."','".$data[$key]['INVOICE_NUMBER']."','".$data[$key]['PORT_OF_DISCHARGE']."','".$data[$key]['SHIPPING_STATUS']."','".$data[$key]['SHIPPING_VALUE_INR']."','".$order_status."','".$data[$key]['DELIVERY_DETAIL_ID']."','".$data[$key]['REQUIRE_DATE_DESTINATION']."','".$data[$key]['HEADER_LUD']."','".$data[$key]['LINE_LUD']."','".$data[$key]['WSH_LUD']."','".$data[$key]['WDD_LUD']."','".$data[$key]['WND_LUD']."','".$data[$key]['EMP_LUD']."','".$data[$key]['EML_LUD']."','".$data[$key]['JAI_LUD']."','".$data[$key]['REF_INV']."','".$data[$key]['SHIPPING_VALUE']."','".$data[$key]['CURRENCY']."','".$data[$key]['DISPATCH_DATE']."')";
		      
		   }
		   else
		   {
		      $order_status=$data[$key]['ORDER_STATUS'];
		      $sql="INSERT INTO logistic_view(CUST_PO_NUMBER, CUSTOMER_NUM, ORG_ID, FREIGHT_TERMS_CODE, SHIPPED_QUANTITY, DELIVERY_ID, DESCRIPTION, INVOICE_NUMBER, PORT_OF_DISCHARGE, SHIPPING_STATUS, SHIPPING_VALUE_INR, ORDER_STATUS, DELIVERY_DETAIL_ID, REQUIRE_DATE_DESTINATION, HEADER_LUD, LINE_LUD, WSH_LUD, WDD_LUD, WND_LUD, EMP_LUD, EML_LUD, JAI_LUD,REF_INV,SHIPPING_VALUE,CURRENCY,DISPATCH_DATE) VALUES ('".$data[$key]['CUST_PO_NUMBER']."','".$data[$key]['CUSTOMER_NUM']."','".$data[$key]['ORG_ID']."','".$data[$key]['FREIGHT_TERMS_CODE']."','".$data[$key]['SHIPPED_QUANTITY']."','".$data[$key]['DELIVERY_ID']."','".$data[$key]['DESCRIPTION']."','".$data[$key]['INVOICE_NUMBER']."','".$data[$key]['PORT_OF_DISCHARGE']."','".$data[$key]['SHIPPING_STATUS']."','".$data[$key]['SHIPPING_VALUE_INR']."','".$order_status."','".$data[$key]['DELIVERY_DETAIL_ID']."','".$data[$key]['REQUIRE_DATE_DESTINATION']."','".$data[$key]['HEADER_LUD']."','".$data[$key]['LINE_LUD']."','".$data[$key]['WSH_LUD']."','".$data[$key]['WDD_LUD']."','".$data[$key]['WND_LUD']."','".$data[$key]['EMP_LUD']."','".$data[$key]['EML_LUD']."','".$data[$key]['JAI_LUD']."','".$data[$key]['REF_INV']."','".$data[$key]['SHIPPING_VALUE']."','".$data[$key]['CURRENCY']."','".$data[$key]['DISPATCH_DATE']."')";
		   }
		  
		    
		    $result=$con->data_insert($sql);
	 

		}
		$sql="SELECT CUST_PO_NUMBER, CUSTOMER_NUM, ORG_ID, FREIGHT_TERMS_CODE, SHIPPED_QUANTITY, DELIVERY_ID, DESCRIPTION, INVOICE_NUMBER, PORT_OF_DISCHARGE, SHIPPING_STATUS, SHIPPING_VALUE_INR, ORDER_STATUS, SHIPPED_DATE, DELIVERY_DETAIL_ID, REQUIRE_DATE_DESTINATION, GREATEST( HEADER_LUD, LINE_LUD, WSH_LUD, WDD_LUD, WND_LUD, EMP_LUD, EML_LUD, JAI_LUD ) AS date1
		FROM logistic_view";
		$result=$con->data_select($sql);

		if($result != "no")
		{

		    foreach ($result as $key => $value) {

		  
		      $sql_consignment_details="INSERT INTO consignment_details(cust_po_number,customer_num,org_id,
			      	freight_terms_code,shipped_quantity,delivery_id,item_description,commercial_invoice,
			      	port_of_discharge,shipping_status,shipping_value_inr,order_status,
			        delivery_details_id,require_date,
			        Header_lud,line_lud,wsh_lud,wdd_lud,wnd_lud,emp_lud,eml_lud,jai_lud,ref_inv,shipping_value,currency,dispatch_date)
			        VALUES ('".$result[$key]['CUST_PO_NUMBER']."','".$result[$key]['CUSTOMER_NUM']."','".$result[$key]['ORG_ID']."',
			        	'".$result[$key]['FREIGHT_TERMS_CODE']."','".$result[$key]['SHIPPED_QUANTITY']."','".$result[$key]['DELIVERY_ID']."'
			        	,'".$result[$key]['DESCRIPTION']."','".$result[$key]['INVOICE_NUMBER']."','".$result[$key]['PORT_OF_DISCHARGE']."',
			        	'".$result[$key]['SHIPPING_STATUS']."','".$result[$key]['SHIPPING_VALUE_INR']."','".$result[$key]['ORDER_STATUS']."',
			        	'".$result[$key]['DELIVERY_DETAIL_ID']."','".$result[$key]['REQUIRE_DATE_DESTINATION']."',
			        	'".$result[$key]['HEADER_LUD']."','".$result[$key]['LINE_LUD']."','".$result[$key]['WSH_LUD']."','".$result[$key]['WDD_LUD']."','".$result[$key]['WND_LUD']."',
			        	'".$result[$key]['EMP_LUD']."','".$result[$key]['EML_LUD']."','".$result[$key]['JAI_LUD']."',
			        	'".$result[$key]['REF_INV']."','".$result[$key]['SHIPPING_VALUE']."','".$result[$key]['CURRENCY']."','".$result[$key]['DISPATCH_DATE']."')";
			        $result_consignment_details=$con->data_insert($sql_consignment_details);
		       
		    }
		   
		}

	 exit;
}

oci_free_statement($stid3);
oci_close($conn);

?>