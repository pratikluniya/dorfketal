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
	if($result1 != "no")
	{
		echo "Product already in the Cart";
	}
	else
	{
		$sql = "INSERT INTO customer_cart (CUSTOMER_NUMBER, PRODUCT_CODE, ITEM_DESCRIPTION, PACKAGING_SIZE, QUANTITY, REMARK) VALUES ($cust_id,$prod_code,'$prod_desc','$pkgsize',$qty,'$remark')";
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
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "getquoteproduct") ){
	$cat_name = $_REQUEST['cat_name'];
	$prod_code = $_REQUEST['prod_id'];
	$prod_desc = $_REQUEST['prod_desc'];
	$pkg_size = $_REQUEST['pkg_size'];
}

















// Logistic Management AJAX Calls

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