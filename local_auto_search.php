<?php
include "classes/functions.php";
include "classes/paginate_function.php";
session_start();
$con =new functions();
$cust_id = $_SESSION['cust_id'];

/******** Product List ***********/
if(isset($_REQUEST['search_category']) && ($_REQUEST['action'] == "product_search") )
{

	if (is_numeric(trim($_REQUEST['auto_search_value']))){
        $sql ="SELECT DISTINCT PRODUCT_CODE,DESCRIPTION FROM xxdkapps_unsegregated_products WHERE PRODUCT_CODE LIKE '%".$_REQUEST['auto_search_value']."%' order by PRODUCT_CODE";
    }
    else{
        $sql ="SELECT DISTINCT DESCRIPTION FROM xxdkapps_unsegregated_products WHERE DESCRIPTION LIKE '%".$_REQUEST['auto_search_value']."%' order by DESCRIPTION";
    	
    }

    $result= $con->data_select($sql);

    $data = array();
    if($result == 'no'){
		array_push($data, 'No Data');
		echo json_encode($data);
	}
	else{
		echo json_encode($result);
	}    
    exit;    
}

/******** Quotation History ***********/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "quote_search")
{	
    if (is_numeric(trim($_REQUEST['auto_search_value']))){
        $sql = "SELECT DISTINCT cq.PRODUCT_CODE,up.DESCRIPTION FROM customer_quotations as cq, xxdkapps_unsegregated_products as up WHERE cq.CUSTOMER_NUMBER = ".$cust_id." and cq.PRODUCT_CODE = up.PRODUCT_CODE and cq.PRODUCT_CODE LIKE '%".$_REQUEST['auto_search_value']."%' ORDER BY cq.PRODUCT_CODE DESC ";
    }
    else{
        $sql = "SELECT DISTINCT up.DESCRIPTION FROM customer_quotations as cq, xxdkapps_unsegregated_products as up WHERE cq.CUSTOMER_NUMBER = ".$cust_id." and cq.PRODUCT_CODE = up.PRODUCT_CODE and up.DESCRIPTION LIKE '%".$_REQUEST['auto_search_value']."%' ORDER BY up.DESCRIPTION DESC ";
    }

    $result= $con->data_select($sql);

    $data = array();
    if($result == 'no'){
		array_push($data, 'No Data');
		echo json_encode($data);
	}
	else{
		echo json_encode($result);
	}
    exit;    
}

/******** PO History ***********/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "po_search")
{	
    $sql = "SELECT DISTINCT cp.PO_NUMBER FROM customer_po as cp, xxdkapps_customer_master as cm WHERE cp.CUSTOMER_NUMBER = ".$cust_id." and cp.PO_NUMBER LIKE '%".$_REQUEST['auto_search_value']."%' and cp.SHIP_TO = cm.SITE_USE_ID and cm.BUSINESS_CODE = 'SHIP_TO' ORDER BY cp.PO_NUMBER DESC";

    $result= $con->data_select($sql);

    $data = array();
    if($result == 'no'){
		array_push($data, 'No Data');
		echo json_encode($data);
	}
	else{
		echo json_encode($result);
	}
    exit;    
}

/******** Order History *********/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "order_history_search"){
    if(isset($_REQUEST['search_category']) && ($_REQUEST['search_category'] == "1") )
    {
        $sql ="SELECT DISTINCT op.PRODUCT_CODE,up.DESCRIPTION FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and op.PRODUCT_CODE LIKE '%".$_REQUEST['auto_search_value']."%' order by PRODUCT_CODE";   
        $result= $con->data_select($sql);    
        $data = array();
        if($result == 'no'){
            array_push($data, 'No Data');
            echo json_encode($data);
        }
        else{            
            echo json_encode($result);                       
        }
        exit;
    }
    if(isset($_REQUEST['search_category']) && ($_REQUEST['search_category'] == "2") )
    {
        $sql ="SELECT DISTINCT up.DESCRIPTION FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and up.DESCRIPTION LIKE '%".$_REQUEST['auto_search_value']."%' ORDER BY up.DESCRIPTION";
        $result= $con->data_select($sql);    
        $data = array();
        if($result == 'no'){
            array_push($data, 'No Data');
            echo json_encode($data);
        }
        else{        
            foreach ($result as $key => $value) {
                array_push($data, $result[$key]['DESCRIPTION']);
            }
            echo json_encode($data);
        }   
        exit;
    }
    if(isset($_REQUEST['search_category']) && ($_REQUEST['search_category'] == "3") )
    {
        $sql ="SELECT DISTINCT ofd.ORACLE_ORDER FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and ofd.ORACLE_ORDER = '".$_REQUEST['auto_search_value']."' ORDER BY ofd.ORACLE_ORDER";
        $result= $con->data_select($sql);    
        $data = array();
        if($result == 'no'){
            array_push($data, 'No Data');
            echo json_encode($data);
        }
        else{        
            foreach ($result as $key => $value) {
                array_push($data, $result[$key]['ORACLE_ORDER']);
            }
            echo json_encode($data);
        }   
        exit;
    }
    if(isset($_REQUEST['search_category']) && ($_REQUEST['search_category'] == "4") )
    {
        $sql ="SELECT DISTINCT ofd.ORDER_WEB_ID FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and ofd.ORDER_WEB_ID = '".$_REQUEST['auto_search_value']."'  ORDER BY ofd.ORDER_WEB_ID";
        $result= $con->data_select($sql);    
        $data = array();
        if($result == 'no'){
            array_push($data, 'No Data');
            echo json_encode($data);
        }
        else{        
            foreach ($result as $key => $value) {
                array_push($data, $result[$key]['ORDER_WEB_ID']);
            }
            echo json_encode($data);
        }   
        exit;
    }
    if(isset($_REQUEST['search_category']) && ($_REQUEST['search_category'] == "5") )
    {
        $sql ="SELECT DISTINCT ofd.PO FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and ofd.PO LIKE '%".$_REQUEST['auto_search_value']."%'  ORDER BY ofd.PO";
        $result= $con->data_select($sql);    
        $data = array();
        if($result == 'no'){
            array_push($data, 'No Data');
            echo json_encode($data);
        }
        else{        
            foreach ($result as $key => $value) {
                array_push($data, $result[$key]['PO']);
            }
            echo json_encode($data);
        }   
        exit;
    }
}


?>