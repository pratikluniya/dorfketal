<?php
include "classes/functions.php";
include "classes/paginate_function.php";
session_start();
$con =new functions();
$cust_id = $_SESSION['cust_id'];

/******** Global Search Query ***********/
if(isset($_REQUEST['search_category']) && ($_REQUEST['search_category'] == "1") )
{
    $sql ="SELECT DISTINCT PRODUCT_CODE,DESCRIPTION FROM xxdkapps_unsegregated_products WHERE PRODUCT_CODE LIKE '%".$_REQUEST['auto_search_value']."%' order by PRODUCT_CODE";
    $result= $con->data_select($sql);

    $data = array();
    if($result == 'no'){
		array_push($data, 'No Data');
	}
	else{
		foreach ($result as $key => $value) {
			array_push($data, array("id" => $result[$key]['PRODUCT_CODE'], "desc" => $result[$key]['DESCRIPTION'])); 	    	
	    }
	}	
    echo json_encode($data);
}

if(isset($_REQUEST['search_category']) && ($_REQUEST['search_category'] == "2") )
{
    $sql ="SELECT DISTINCT DESCRIPTION FROM xxdkapps_unsegregated_products WHERE DESCRIPTION LIKE '%".$_REQUEST['auto_search_value']."%' order by DESCRIPTION";
    $result= $con->data_select($sql);

    $data = array();
    if($result == 'no'){
		array_push($data, 'No Data');
	}
	else{
		foreach ($result as $key => $value) {
	    	array_push($data, $result[$key]['DESCRIPTION']);
	    }
	}
    echo json_encode($data);    
}

if(isset($_REQUEST['search_category']) && ($_REQUEST['search_category'] == "3") )
{    
    $sql="SELECT DISTINCT ATTRIBUTE18 FROM xxdkapps_unsegregated_products WHERE ATTRIBUTE18 LIKE '%".$_REQUEST['auto_search_value']."%' order by ID";
    $result= $con->data_select($sql);

    $data = array();
    if($result == 'no'){
		array_push($data, 'No Data');
	}
	else{
		foreach ($result as $key => $value) {
	    	array_push($data, $result[$key]['ATTRIBUTE18']);
	    }
	}
    echo json_encode($data);    
}

if(isset($_REQUEST['search_category']) && ($_REQUEST['search_category'] == "4") )
{
    $sql ="SELECT DISTINCT ATTRIBUTE17 FROM xxdkapps_unsegregated_products WHERE ATTRIBUTE17 LIKE '%".$_REQUEST['auto_search_value']."%' order by ID";
    $result= $con->data_select($sql);

    $data = array();
    if($result == 'no'){
		array_push($data, 'No Data');
	}
	else{
		foreach ($result as $key => $value) {
	    	array_push($data, $result[$key]['ATTRIBUTE17']);
	    }
	}
    echo json_encode($data);
}

if(isset($_REQUEST['search_category']) && ($_REQUEST['search_category'] == "5") )
{            
    $sql ="SELECT DISTINCT ofd.ORACLE_ORDER FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and ofd.ORACLE_ORDER LIKE '%".$_REQUEST['auto_search_value']."%' and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID ORDER BY ofd.ORACLE_ORDER";
    $result= $con->data_select($sql);

    $data = array();
    if($result == 'no'){
		array_push($data, 'No Data');
	}
	else{
		foreach ($result as $key => $value) {
	    	array_push($data, $result[$key]['ORACLE_ORDER']);
	    }
	}
    echo json_encode($data);
    
}

if(isset($_REQUEST['search_category']) && ($_REQUEST['search_category'] == "6") )
{        
    $sql ="SELECT DISTINCT ofd.ORDER_WEB_ID FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and ofd.ORDER_WEB_ID LIKE '%".$_REQUEST['auto_search_value']."%' and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID ORDER BY ofd.ORDER_WEB_ID";
    $result= $con->data_select($sql);

    $data = array();
    if($result == 'no'){
		array_push($data, 'No Data');
	}
	else{
		foreach ($result as $key => $value) {
	    	array_push($data, $result[$key]['ORDER_WEB_ID']);
	    }
	}
    echo json_encode($data);
    
}

?>