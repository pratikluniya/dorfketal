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
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "track_order") ){
	
}