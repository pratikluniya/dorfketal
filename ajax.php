<?php
include("./classes/functions.php");
$con =new functions();
session_start();

if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "Login") ){
	$sql = "SELECT * FROM login_master WHERE CUSTOMER_NUMBER = ".$_REQUEST['cust_id']." AND PASSWORD = '".md5($_REQUEST['cust_pass'])."'";
	$result=$con->data_select($sql);
	if($result != "no")
	{
		$_SESSION["cust_id"]=$_REQUEST['cust_id'];
		$_SESSION["cust_email"]=$result[0]['EMAIL'];
		echo "Success";
	}
	else{
		echo "Invalied CUSTOMER_NUMBER or PASSWORD";
	}
}
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "Logout") ){
	session_destroy();
    session_unset();
    header('Location: index.php');
}
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "F-Vertical") ){
	$sql = "SELECT FAVOURITE_VERTICAL FROM login_master WHERE CUSTOMER_NUMBER = ".$_SESSION['cust_id'];
	$result=$con->data_select($sql);
	echo ($result[0]['FAVOURITE_VERTICAL']);
}
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "updatefcat") ){
	$sql = "UPDATE login_master SET FAVOURITE_VERTICAL = '".$_REQUEST['cat_name']."' WHERE CUSTOMER_NUMBER = ".$_SESSION['cust_id'];
	$result=$con->data_update($sql);
	echo "Success";
}
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "cartonload") ){
	$sql = "SELECT COUNT(*) FROM customer_cart WHERE CUSTOMER_NUMBER = '".$_SESSION['cust_id']."'";
	$result=$con->data_select($sql);
	$_SESSION["cart_count"]=$result[0]['COUNT(*)'];
	echo $_SESSION['cart_count'];
}
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "insertcart") ){
	$prod_code = $_REQUEST['prod_code'];
	$prod_desc = $_REQUEST['prod_desc'];
	$remark = $_REQUEST['remark'];
	$qty =	$_REQUEST['qty'];
	$pkgsize = $_REQUEST['pkgsize'];
	$cust_id = $_SESSION['cust_id'];
	$cart_count= $_SESSION['cart_count'];
	$increment = 1;
	$sql1= "SELECT CUSTOMER_NUMBER PRODUCT_CODE FROM customer_cart WHERE PRODUCT_CODE =".$prod_code." AND CUSTOMER_NUMBER=".$cust_id;
	$result1=$con->data_select($sql1);
	$sql2 = "SELECT ID, PACKAGING_CODE, OPERAND, ACCOUNT_NUMBER, PRODUCT_CODE FROM xxdkapps_price_list_master WHERE PACKAGING_CODE LIKE '%".$pkgsize."' AND ACCOUNT_NUMBER = '".$cust_id."' AND PRODUCT_CODE = '".$prod_code."' ORDER BY ID DESC LIMIT 1";
	$result2 = $con->data_select($sql2);
	if($result2 != "no")
		$price = $result2[0]['OPERAND'];
	else
		$price = 0.00000;
	if($result1 != "no")
	{
		echo "Product already in the Cart";
	}
	else
	{
		$sql = "INSERT INTO customer_cart (CUSTOMER_NUMBER, PRODUCT_CODE, ITEM_DESCRIPTION, PACKAGING_SIZE, QUANTITY, AVAILABLE_PRICE, REMARK) VALUES ($cust_id,$prod_code,'$prod_desc','$pkgsize','$qty','$price','$remark')";
		$result=$con->data_insert($sql);
		$_SESSION['cart_count'] = ( $cart_count+ $increment) ;
		echo $_SESSION['cart_count'];
	}
}
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "removecart") ){
	$prod_code = $_REQUEST['prod_code'];
	$cust_id = $_SESSION['cust_id'];
	$cart_count= $_SESSION['cart_count'];
	$increment = 1;
	$sql = "DELETE FROM customer_cart WHERE PRODUCT_CODE =".$prod_code. " AND CUSTOMER_NUMBER =".$cust_id ;
	$result=$con->data_delete($sql);
	$_SESSION['cart_count'] = ( $cart_count - $increment) ;
	echo $_SESSION['cart_count'];
}
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "updatecart") ){
	$prod_code = $_REQUEST['prod_code'];
	$remark = $_REQUEST['remark'];
	$qty =	$_REQUEST['qty'];
	$pkgsize = $_REQUEST['pkgsize'];
	$cust_id = $_SESSION['cust_id'];
	$sql = "UPDATE customer_cart SET QUANTITY = '".$qty."', PACKAGING_SIZE ='".$pkgsize."', REMARK = '".$remark."' WHERE CUSTOMER_NUMBER = ".$_SESSION['cust_id']." AND PRODUCT_CODE = ".$prod_code;
	$result=$con->data_update($sql);
	echo "success";
}
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "getcatapplication") ){
	$cat_name = $_REQUEST['cat_name'];
	$sql = "SELECT * FROM xxdkapps_product_group_application WHERE PG = '".$cat_name."'";
	$result=$con->data_select($sql);
	echo json_encode($result);
}
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "getquoteproduct") ){
	$cat_name = $_REQUEST['cat_name'];
	$sql ="SELECT ID, PRODUCT_CODE AS ITEM_CODE, DESCRIPTION, ATTRIBUTE18 as PRODUCT_APPLICATION, ATTRIBUTE17 as PRODUCT_GROUP FROM xxdkapps_unsegregated_products WHERE ATTRIBUTE17 ='".$cat_name."' order by ID";
	$result=$con->data_select($sql);
	echo json_encode($result);
}
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "getquoteprice") ){
	$cat_name = $_REQUEST['cat_name'];
	$prod_code = $_REQUEST['prod_id'];
	$prod_desc = $_REQUEST['prod_desc'];
	$pkg_size = $_REQUEST['pkg_size'];
	$cust_id = $_SESSION['cust_id'];
	$sql = "SELECT ID, PACKAGING_CODE, OPERAND, ACCOUNT_NUMBER, PRODUCT_CODE FROM xxdkapps_price_list_master WHERE PACKAGING_CODE LIKE '%".$pkg_size."' AND ACCOUNT_NUMBER = '".$cust_id."' AND PRODUCT_CODE = '".$prod_code."' ORDER BY ID DESC LIMIT 1";
	$result=$con->data_select($sql);
	if($result !="no")
	{
		$data = array('price' => $result[0]['OPERAND'], 'PACKAGING_CODE' => $result[0]['PACKAGING_CODE'],'status' => 'Success' );
		echo json_encode($data);
	}
	else
	{
		$data = array('status' =>'NA');
		echo json_encode($data);
	}
}
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "insertquote") ){
	$cat_name = $_REQUEST['cat_name'];
	$prod_code = $_REQUEST['prod_id'];
	$pkg_size = $_REQUEST['pkg_size'];
	$qty = $_REQUEST['qty'];
	$price = $_REQUEST['price'];
	$req_price = $_REQUEST['req_price'];
	$cust_id = $_SESSION['cust_id'];
	$remark = $_REQUEST['remark'];
	$filename = $_FILES['file']['name'];
	$sql = "INSERT INTO customer_quotations (CUSTOMER_NUMBER, PRODUCT_CODE, PACKAGING_SIZE, QUANTITY, AVAILABLE_PRICE, REQUESTED_PRICE, REMARK, FILE_NAME, STATUS) VALUES ($cust_id, $prod_code, $pkg_size, $qty, '$price', $req_price, '$remark', '$filename', 'SUBMITTED')";
	$result=$con->data_insert($sql);
	echo "Success";
	if ( 0 < $_FILES['file']['error'] ) 
	{
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else 
    {
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploadedquotes/' . $filename);
        unset($_FILES);
    }
}
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "uploadPO") ){
	$cust_id = $_SESSION['cust_id'];
	$po_no = $_REQUEST['po_no'];
	$ship_to = $_REQUEST['ship_to'];
	$sold_to = $_REQUEST['sold_to'];
	$cont_per = $_REQUEST['cont_per'];
	$del_date = $_REQUEST['del_date'];
	$f_term = $_REQUEST['f_term'];
	$f_chrges = $_REQUEST['f_chrges'];
	$vessal = $_REQUEST['vessal'];
	$pay_term = $_REQUEST['pay_term'];
	if($pay_term == "Choose One")
		$pay_term = "NA"; 
	$comments = $_REQUEST['comments'];
	$sql ="INSERT INTO customer_po (CUSTOMER_NUMBER, PO_NUMBER, SOLD_TO, SHIP_TO, CONTACT_PERSON, DELIVERY_DATE, FREIGHT_TERM, FREIGHT_CHARGES, VESSAL_NAME, PAYMENT_TERM, FILE_NAME, COMMENT) VALUES ($cust_id, '$po_no', '$sold_to', '$ship_to', '$cont_per', '$del_date', '$f_term', '$f_chrges', '$vessal', '$pay_term','".$_FILES['file']['name']."', '$comments')";
	$result=$con->data_insert($sql);
	echo "Success";
	if ( 0 < $_FILES['file']['error'] ) 
	{
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else 
    {
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploadedPO/' . $_FILES['file']['name']);
    }
}
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "getcartcount") ){
	echo $_SESSION['cart_count'];
}
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "getorderdetail") ){
	$cust_id = $_SESSION['cust_id'];
	$order_id = $_REQUEST['order_id'];
	$oracle_order = $_REQUEST['oracle_order'];
	$sql ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.ATTRIBUTE12 FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = " .$order_id." and ofd.ORACLE_ORDER = ".$oracle_order;    
	echo $sql;
	exit;
	$result=$con->data_select($sql);
	echo "<pre>";
	print_r($result);
}














/********  Logistic Management AJAX Calls  *****/

if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "chkuser") ){
	$sql = "SELECT role_id FROM user_registration WHERE email_id = ".$_SESSION['cust_id'];
	$result=$con->data_select($sql);
	echo $result[0]['role_id'];
}

if($_REQUEST['action'] == "showcustomerdocument")
{
	$query="SELECT  service_provider, shipping_document, shipping_document_update, commercial_invoice, commercial_invoice_update, india_commercial_invoice,india_commercial_invoice_update, created_date, consignment_id FROM document_detatils WHERE consignment_id=".$_REQUEST['consignment_id'];
	$result=$con->data_select($query);
	if($result !="no")
	{
	 	echo json_encode($result);
		exit;  
	}
	else
	{
	}
}
if($_REQUEST['action'] == "customershippeddetails")
{
	$query_link="SELECT tracking_url FROM  tracking_url WHERE  id =1";
	$result_link=$con->data_select($query_link);
	$url_logistic=$result_link[0]['tracking_url'];
	$query="SELECT * FROM consignment_details WHERE consignment_id=".$_REQUEST['consignment_id'];
	$result=$con->data_select($query);
	if($result !="no")
	{
		$result[0]['url_logistic'] = $url_logistic;
	 	echo json_encode($result);
	}
	else
	{
	}
    exit; 
}