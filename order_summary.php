<?php
include("./classes/functions.php");
$con =new functions();
session_start();
date_default_timezone_set("Asia/Kolkata");

// Fetch Cart Products
$sql_prod ="SELECT up.ID, up.PRODUCT_CODE AS  ITEM_CODE, up.DESCRIPTION, up.ATTRIBUTE18 as  PRODUCT_APPLICATION, up.ATTRIBUTE17 as PRODUCT_GROUP, cc.CUSTOMER_NUMBER, cc.QUANTITY, cc.PACKAGING_SIZE, cc.AVAILABLE_PRICE, cc.REMARK FROM customer_cart as cc, xxdkapps_unsegregated_products as up WHERE cc.CUSTOMER_NUMBER= '" . $_SESSION['cust_id']."' and cc.PRODUCT_CODE = up.PRODUCT_CODE";
$result_prod=$con->data_select($sql_prod);


// Order Form Data Fields
$ORDER_WEB_ID = 0;
$PO = $_REQUEST['po_no'];
$CUSTOMER_NUMBER = $_SESSION['cust_id'];
$CUSTOMER_ACCOUNT_NUMBER = "";
$SOLD_TO = $_REQUEST['sold_to'];
$SOLD_TO_ID = $_REQUEST['sold_to_id'];
$SHIP_TO = $_REQUEST['ship_to'];
$SHIP_TO_ID = $_REQUEST['ship_to_id'];
$UPLOAD_TYPE = "ORDER";
$CONTACT_PERSON = $_REQUEST['cont_per'];
$DELIVERY_DATE = $_REQUEST['del_date'];
$ORDERED_FROM = "PORTAL";
$STATUS = "ENTRY";
$TRANSACTIONAL_CURR_CODE = "USD";
$ORDER_TYPE = "";
$SALESREP_ID = "";
$ORG_ID = "";
$PRICE_LIST_ID = "";
$SHIP_FROM_ORG_ID = "";
$CREATED_BY = "";
$PAYMENT_TERM = $_REQUEST['pay_term'];
$PAYMENT_TERM_ID = $_REQUEST['pay_term_id'];
$VESSEL = $_REQUEST['vessal'];
$COMMENTS = $_REQUEST['comments'];
$ATTRIBUTE12 = $_REQUEST['pay_term']; //Payment Term Desc
$FREIGHT_TERMS = $_REQUEST['f_term'];
$FREIGHT_VALUE = $_REQUEST['f_chrges'];
$DAY_SEQUENCE = 0;
if($FREIGHT_TERMS == "Ex-Work")
{
	$FREIGHT_VALUE = "NA";
}



// Fetch Customer Data
$sql_cust_data = "SELECT CUSTOMER_NUMBER ,CUST_ACCOUNT_ID , (select SITE_USE_ID  FROM xxdkapps_customer_master  WHERE BUSINESS_CODE ='BILL_TO' and CUSTOMER_NUMBER = ".$CUSTOMER_NUMBER." limit 1) as INVOICE_ORG_ID FROM xxdkapps_customer_master WHERE CUSTOMER_NUMBER = ".$CUSTOMER_NUMBER;
$result_cust_data=$con->data_select($sql_cust_data);
$SOLD_TO_ORG_ID = $result_cust_data[0]['CUST_ACCOUNT_ID'];
$INVOICE_TO_ORG_ID = $result_cust_data[0]['INVOICE_ORG_ID'];


/******* FETCH PRODUCT GROUP WISE ENTITY FOR CUSTOMER *****/
$pgEntityArr  = array();
$sql_pg_entity = "SELECT * FROM  xxdkapps_customer_pg_entity where CUSTOMER_NUMBER=". $CUSTOMER_NUMBER;
$pgEntityArr = $con->data_select($sql_pg_entity);
$pgCustomerEntityArr = array();
if($pgEntityArr !="no")
{
	foreach($pgEntityArr as $pgId =>$eArr)
	{
		$group = str_replace(' ','-',trim(strtolower($eArr['ATTRIBUTE17'])));
		$pgCustomerEntityArr[$group] = 	$eArr['ORG_ID'];				
	}
}
foreach($result_prod as $key=>$value)
{
	$id = $value['ITEM_CODE'];
    $cart[$id] = array( 'ID' => $value['ID'],'ITEM_CODE'=>$value['ITEM_CODE'],'DESCRIPTION'=>$value['DESCRIPTION'],'PRODUCT_APPLICATION'=>$value['PRODUCT_APPLICATION'],'PRODUCT_GROUP'=>$value['PRODUCT_GROUP'],'CUSTOMER_NUMBER'=>$value['CUSTOMER_NUMBER'],'QUANTITY'=>$value['QUANTITY'],'PACKAGING_SIZE'=>$value['PACKAGING_SIZE'],'AVAILABLE_PRICE'=>$value['AVAILABLE_PRICE'],'REMARK'=>$value['REMARK'] );
}
$cartCount =$_SESSION['cart_count'];
$pcdArr = array();
$prodDetArr = array();
$orgWiseProducts = array();
$i=0;
$firstProductCode="";
foreach($cart as $id=>$cartItem)
{	
	$pcdArr[] =$cartItem['ITEM_CODE'];
	$prodDetArr[$cartItem['ITEM_CODE']]['uom']="KG";
	$prodDetArr[$cartItem['ITEM_CODE']]['pack'] =$cartItem['PACKAGING_SIZE'];
	$prodDetArr[$cartItem['ITEM_CODE']]['inventory_id']="697596";			
	$prodDetArr[$cartItem['ITEM_CODE']]['price_list_id']="1017352";
	$prodDetArr[$cartItem['ITEM_CODE']]['price_list_name']="DKCT Default Web App Price List";
	
	if($cartItem['AVAILABLE_PRICE']=="0.00000")
	{
		$prodDetArr[$cartItem['ITEM_CODE']]['AVAILABLE_PRICE']=1;
	
	}
	else
	{
		$prodDetArr[$cartItem['ITEM_CODE']]['AVAILABLE_PRICE']=$cartItem['AVAILABLE_PRICE'];
	}
	
	$prodDetArr[$cartItem['ITEM_CODE']]['item_code']="399999-000000";
	$prodDetArr[$cartItem['ITEM_CODE']]['curr_code']="USD";
	$prodDetArr[$cartItem['ITEM_CODE']]['quantity']=$cartItem['QUANTITY'];
	$prodDetArr[$cartItem['ITEM_CODE']]['pack_code']="000000";
	$prodDetArr[$cartItem['ITEM_CODE']]['org_id']="722";
	$prodDetArr[$cartItem['ITEM_CODE']]['remarks']=$cartItem['REMARK'];
	
}

/***********
	For each freq purchase of product code and pack fetch org Id and inventory code  -- 
	if not found fetch from freq entity and set org_id
	else set default org
********************/
			

$sql_freq_purchase = "SELECT up.PRODUCT_CODE, up.ATTRIBUTE17, fp.ORG_ID, fp.CUSTOMER_NUMBER	FROM xxdkapps_unsegregated_products AS up LEFT JOIN xxdkapps_customer_freq_purchase AS fp ON up.PRODUCT_CODE = fp.PRODUCT_SEGMENT1 AND fp.CUSTOMER_NUMBER ='".$CUSTOMER_NUMBER."' WHERE up.PRODUCT_CODE IN ('".implode("','",$pcdArr)."')";
$productDetailsRes = array();
$productDetailsRes = $con->data_select($sql_freq_purchase);

foreach($productDetailsRes as $id=> $pResArr)
{
	$pcode =$pResArr['PRODUCT_CODE'];
	$prodDetArr[$pcode]['ATTRIBUTE17'] =$pResArr['ATTRIBUTE17']; 
	$group = str_replace(' ','-',trim(strtolower($pResArr['ATTRIBUTE17'])));
	if($pResArr['ORG_ID'] =="") 
	{
		if(isset($pgCustomerEntityArr[$group]))
		{
			$prodDetArr[$pcode]['org_id'] = $pgCustomerEntityArr[$group];	
		}
		else
		{
			$prodDetArr[$pcode]['org_id'] = "722";
			
		}
	}
	else
	{
		$prodDetArr[$pcode]['org_id'] =$pResArr['ORG_ID'];
		
	}
}
foreach( $prodDetArr as $pcode => $pValuesArr)
{
    if($pValuesArr['pack']!="ANY" && $pValuesArr['pack']!=1 )
    {
 	    $sql_trans_curr_code =" SELECT ORG_ID, PRICE_LIST_ID, PRICE_LIST_NAME, CURR_CODE, p.ITEM_CODE,PRODUCT_CODE,inv.INVENTORY_ITEM_ID, PACKAGING_CODE, OPERAND FROM xxdkapps_price_list_master as p, xxdkapps_product_inventory as inv where inv.ITEM_CODE=p.ITEM_CODE and p.ACCOUNT_NUMBER=". $CUSTOMER_NUMBER." AND p.BUSINESS_CODE='SHIP_TO' AND p.ACCOUNT_STATUS='A' AND p.SITE_USE_ID=".$SHIP_TO_ID."
		AND p.PRODUCT_CODE= ". $pcode ." AND p.PACKAGING_CODE like '%".$pValuesArr['pack']."' limit 1";
		$priceListArr = $con->data_select($sql_trans_curr_code);
		if($priceListArr !="no")
	    {
			$prodDetArr[$pcode]['price_list_id']=$priceListArr[0]['PRICE_LIST_ID'];
			$prodDetArr[$pcode]['price_list_name']=$priceListArr[0]['PRICE_LIST_NAME'];
			$prodDetArr[$pcode]['unit_price']=$priceListArr[0]['OPERAND'];
			$prodDetArr[$pcode]['item_code']=$priceListArr[0]['ITEM_CODE'];
			$prodDetArr[$pcode]['inventory_id']=$priceListArr[0]['INVENTORY_ITEM_ID'];
			$prodDetArr[$pcode]['curr_code']=$priceListArr[0]['CURR_CODE'];							
			$prodDetArr[$pcode]['pack_code']=$priceListArr[0]['PACKAGING_CODE'];
			$prodDetArr[$pcode]['org_id']=$priceListArr[0]['ORG_ID'];			
	    }		
    }
} 	
$i=0;
foreach($prodDetArr as $p => $res)
{
	$orgWiseProducts[$res['org_id']][]=$p ;
	if($i==0)
	{
		$firstProductCode=$res['item_code'];
	}
	$i++;
}
/************** 
	for each of organization insert into order details
*********/

$orderIdArr=array();

if($orgWiseProducts !="no")
{
	$webOrderIdStr = "";
	foreach($orgWiseProducts as $org=>$prodArr)
	{
		$lastOrderIdSql  ="SELECT DATE_FORMAT( ORDER_DATE,  '%Y-%m-%d' ) AS perday, MAX( DAY_SEQUENCE ) AS max FROM order_form_details WHERE DATE_FORMAT( ORDER_DATE,  '%Y-%m-%d' ) =CURDATE( ) GROUP BY DATE( ORDER_DATE ) ";
		$maxIdArr = $con->data_select($lastOrderIdSql);
		if($maxIdArr !="no")
		{
			$lastId = $maxIdArr[0]['max']+1;
		}
		else
		{
			$lastId =1;
		}
		if($org=="")
		{
			$org ="722";
		}
		$orderDate =date("Y-m-d H:i:s");
		$day =date("ymdH");
		$orgStr = str_pad($org, 4, "0", STR_PAD_LEFT); 
		$orderWebId = "DKP".$orgStr.$day."T".$lastId;
		$webOrderIdStr.=$orderWebId.",";


		//Fetch order type					
		$orderTypeRes = array();
		$orderTypeSql = "SELECT ORDER_TYPE_ID FROM xxdkapps_customer_ship_order_types WHERE CUSTOMER_NUMBER=". $CUSTOMER_NUMBER ." and  SHIP_TO_ORG_ID=".$SHIP_TO_ID ." and   PRODUCT_CODE='".$firstProductCode."' limit 1";
		$orderTypeRes = $con->data_select($orderTypeSql);
		if(isset($orderTypeRes[0]['ORDER_TYPE_ID']))
		{
			$orderType =$orderTypeRes[0]['ORDER_TYPE_ID'];
		}
		else
		{
			$orderType ="1434";
		}


		//Fetch payment terms
		$salesRepArr = array();
		$salesRep="";
		$salesRepSql = "SELECT SALESREP_ID, ORG_ID,SHIP_TO_ORG_ID,CUSTOMER_NUMBER FROM xxdkapps_customer_ship_salesrep where CUSTOMER_NUMBER =".$CUSTOMER_NUMBER." AND ORG_ID =".$org. " AND SHIP_TO_ORG_ID=".$SHIP_TO_ID ." limit 1";
		$salesRepArr = $con->data_select($salesRepSql);
		if($salesRepArr !="no")
		{
			$salesRep=trim($salesRepArr[0]['SALESREP_ID']);
		}
		$attribute12 = $PAYMENT_TERM;
		$paymentTermId= $PAYMENT_TERM_ID;
		
		if($attribute12 = "Choose One")
		{
			$paymentSql ="SELECT * FROM  xxdkapps_customer_payment_terms WHERE  CUSTOMER_NUMBER =".$CUSTOMER_NUMBER." AND  ORG_ID =".$org." limit 1";
			$paymentRes = $con->data_select($paymentSql);
			if($paymentRes !="no")
			{
				$attribute12 =$paymentRes[0]['PAYMENT_TERM_NAME'];
				$paymentTermId=$paymentRes[0]['PAYMENT_TERM_ID'];
			}
		}
		$orgSql ="select ATTRIBUTE_NAME, ATTRIBUTE_VALUE, ATTRIBUTE_ID, ENTITY_ID from xxdkapps_default_attributes where ATTRIBUTE_NAME in ('ORDER_TYPE','DEFAULT_WAREHOUSE','SALES_PERSON','PAYMENT_TERMS','DEFAULT_APP_PRICE_LIST','CURRENCY_CODE','CREATED_BY') and ENTITY_ID in (0, ".$org.")";
		$orgData = $con->data_select($orgSql);
		$defaultWarehouse ="502";
		$currCode ="INR";
		$defaultPriceList ="1017352";
		$defaultPriceListName ="DKCT Default Web App Price List";
		$createdBy="1970";
		foreach($orgData as $id=>$orgD)
		{
			if($orgD['ATTRIBUTE_NAME']=="ORDER_TYPE")
			{
				if($orderType=="1434")
				{
					$orderType =$orgD['ATTRIBUTE_ID'];
				}
			}
			if($orgD['ATTRIBUTE_NAME']=="DEFAULT_WAREHOUSE")
			{
				$defaultWarehouse =$orgD['ATTRIBUTE_ID'];
			}
			if($orgD['ATTRIBUTE_NAME']=="SALES_PERSON" )
			{
				if($salesRep==""||$salesRep==0)
				{
					$salesRep =$orgD['ATTRIBUTE_ID'];
				}
			}
			if($orgD['ATTRIBUTE_NAME']=="PAYMENT_TERMS")
			{
				if($attribute12=="" && $paymentTermId=="")
				{
					$paymentTermId =$orgD['ATTRIBUTE_ID'];	
					$attribute12=$orgD['ATTRIBUTE_VALUE'];
				}
			}
			if($orgD['ATTRIBUTE_NAME']=="CURRENCY_CODE")
			{
				$currCode =$orgD['ATTRIBUTE_VALUE'];
			}
			if($orgD['ATTRIBUTE_NAME']=="DEFAULT_APP_PRICE_LIST")
			{
				$defaultPriceList =$orgD['ATTRIBUTE_ID'];
				$defaultPriceListName =$orgD['ATTRIBUTE_VALUE'];
			}
			if($orgD['ATTRIBUTE_NAME']=="CREATED_BY")
			{
				$createdBy=$orgD['ATTRIBUTE_ID'];
			}
		}
		$curr_date = date('Y-m-d H:i:s');
		$sql_order_form_insert = "INSERT INTO order_form_details (ID, PO, CUSTOMER_NUMBER,ORDER_DATE, SOLD_TO, SHIP_TO, CONTACT_PERSON, DELIVERY_DATE, ORDERED_FROM, ORDER_WEB_ID, UPLOAD_TYPE, TRANSACTIONAL_CURR_CODE, ORDER_TYPE, SALESREP_ID, ORG_ID, PRICE_LIST_ID, SHIP_FROM_ORG_ID, SOLD_TO_ORG_ID, CREATED_BY, PAYMENT_TERM_ID, INVOICE_TO_ORG_ID, VESSEL, COMMENTS, ATTRIBUTE12, FREIGHT_TERMS, FREIGHT_VALUE, DAY_SEQUENCE) 
		VALUES (NULL, '$PO', $CUSTOMER_NUMBER , '$curr_date', $SOLD_TO_ID, $SHIP_TO_ID, '$CONTACT_PERSON', '$DELIVERY_DATE', 'PORTAL', '$orderWebId', 'ORDER', '$currCode', $orderType, $salesRep, $org, $defaultPriceList, $defaultWarehouse, $SOLD_TO_ORG_ID, $createdBy, $paymentTermId, $INVOICE_TO_ORG_ID, '$VESSEL', '$COMMENTS', '$ATTRIBUTE12', '$FREIGHT_TERMS', '$FREIGHT_VALUE', $lastId	)";
		$lastInsertId=$con->data_insert_return_id($sql_order_form_insert);
		foreach ($prodArr as $id=>$pC)
		{
			$pcl = $prodDetArr[$pC]['price_list_id'];
			$pkcd = $prodDetArr[$pC]['pack_code'];
			$icd = $prodDetArr[$pC]['item_code'];
			$ivd = $prodDetArr[$pC]['inventory_id'];
			$pksz = $prodDetArr[$pC]['pack'];
			$qty = $prodDetArr[$pC]['quantity'];
			$uom = $prodDetArr[$pC]['uom'];
			$up = $prodDetArr[$pC]['AVAILABLE_PRICE'];
			$oid = $prodDetArr[$pC]['org_id'];
			$rmk = $prodDetArr[$pC]['remarks'];
			$tot = ($up *  $qty);
			$sql_order_products_insert = "INSERT INTO order_products (ID, ORDER_ID, PRICE_LIST_ID, PRODUCT_CODE, PACKAGE_CODE, ITEM_CODE, INVENTORY_ITEM_ID, PACKAGE_QTY, PRODUCT_TOTAL, QUANTITY, UOM, UNIT_PRICE,	ORG_ID, REMARKS) 
			VALUES (NULL, $lastInsertId, $pcl , $pC, '$pkcd', $icd, $ivd, '$pksz', '$tot', '$qty', '$uom', $up, $oid, '$rmk') ";
			$lastInsertId=$con->data_insert_return_id($sql_order_products_insert);
		}
	}
}



//Remove Products From Cart

$sql_empty_cart =  "DELETE FROM customer_cart WHERE CUSTOMER_NUMBER =".$CUSTOMER_NUMBER;
$result=$con->data_delete($sql_empty_cart);
$_SESSION['cart_count'] = "0";




//Send mail to customer, sales person and customer service.
?>
<div class="container">
	<div class="row animated fadeInRight">
		<h1>Thanks for Buying with DorfKetal.</h1>
	</div>
</div>