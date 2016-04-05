<?php
include("./classes/functions.php");
$con =new functions();
session_start();

if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "Login") ){
	$sql = "SELECT * FROM login_master WHERE CUSTOMER_NUMBER = ".$_REQUEST['cust_id']." AND PASSWORD = '".md5($_REQUEST['cust_pass'])."'";
	$result=$con->data_select($sql);
	if($result != "no")
	{
		$sql_query="SELECT * FROM user_registration WHERE email_id='".$_REQUEST['cust_id']."'";
		$result1=$con->data_select($sql_query);
		if($_REQUEST['cust_id'] != 1111)
		{
			if($result1 != "no")
			{
				$_SESSION["entity_id"]=$result1[0]['entity_id'];
			}
		}
		$_SESSION["role_id"]=$result1[0]['role_id'];
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
	$ship_to_id = $_REQUEST['ship_to_id'];
	$sold_to = $_REQUEST['sold_to'];
	$sold_to_id = $_REQUEST['sold_to_id'];
	$cont_per = $_REQUEST['cont_per'];
	$del_date = $_REQUEST['del_date'];
	$f_term = $_REQUEST['f_term'];
	$f_chrges = $_REQUEST['f_chrges'];
	$vessal = $_REQUEST['vessal'];
	$pay_term = $_REQUEST['pay_term'];
	$pay_term_id = $_REQUEST['pay_term_id'];
	if($pay_term == "Choose One" && $pay_term_id == "0")
		$pay_term = "NA"; 
	$comments = $_REQUEST['comments'];
	$sql ="INSERT INTO customer_po (CUSTOMER_NUMBER, PO_NUMBER, SOLD_TO, SHIP_TO, CONTACT_PERSON, DELIVERY_DATE, FREIGHT_TERM, FREIGHT_CHARGES, VESSAL_NAME, PAYMENT_TERM, PAYMENT_TERM_ID, FILE_NAME, COMMENT) VALUES ($cust_id, '$po_no', '$sold_to_id', '$ship_to_id', '$cont_per', '$del_date', '$f_term', '$f_chrges', '$vessal', '$pay_term','$pay_term_id','".$_FILES['file']['name']."', '$comments')";
	$result=$con->data_insert($sql);
	echo "Success";
	if(isset($_FILES['file']['name']))
	{
		if ( 0 < $_FILES['file']['error'] ) {
	        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
	    }
	    else {
	        move_uploaded_file($_FILES['file']['tmp_name'], 'uploadedPO/' . $_FILES['file']['name']);
	    }
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
	$result=$con->data_select($sql);
	if($result !="no")
	{	
		foreach ($result as $key => $value) 
		{
		
			echo "<div class='container'>
					<div class='col-md-6'>
						<div class='form-group'>
							<label>Order ID : ".$value['ORACLE_ORDER']."</lable>
						</div>
					</div>
				  </div>
				";
		}
	}
	else
	{
		echo "No result";
	}
}
if($_REQUEST['action'] == "get_quote_history")
{
	$cust_id = $_SESSION['cust_id'];
	$item_per_page = 10;

	if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		//Get page number from Ajax POST
		if(isset($_POST["page"])){
		    $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
		    if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
		}else{
		    $page_number = 1; //if there's no page number, set it to 1
		}
		
		if(isset($_REQUEST['search_value']))
		{
			//To get total count
	        if (is_numeric(trim($_REQUEST['search_value']))){
	            $sql = "SELECT DISTINCT cq.PRODUCT_CODE FROM customer_quotations as cq, xxdkapps_unsegregated_products as up WHERE cq.CUSTOMER_NUMBER = ".$cust_id." and cq.PRODUCT_CODE = up.PRODUCT_CODE and cq.PRODUCT_CODE LIKE '".$_REQUEST['search_value']."%' ORDER BY cq.ID DESC ";
	        }
	        else{
	            $sql = "SELECT DISTINCT cq.PRODUCT_CODE FROM customer_quotations as cq, xxdkapps_unsegregated_products as up WHERE cq.CUSTOMER_NUMBER = ".$cust_id." and cq.PRODUCT_CODE = up.PRODUCT_CODE and up.DESCRIPTION LIKE '".$_REQUEST['search_value']."%' ORDER BY cq.ID DESC ";
	        }
		}
		else{
			//To get total count
			$sql = "SELECT cq.PRODUCT_CODE FROM customer_quotations as cq, xxdkapps_unsegregated_products as up WHERE cq.CUSTOMER_NUMBER = ".$cust_id." and cq.PRODUCT_CODE = up.PRODUCT_CODE ORDER BY cq.ID DESC";
		}
		
		$result = $con -> data_select($sql);
		$get_total_rows = count($result); //hold total records in variable
	    $total_pages = ceil($get_total_rows/$item_per_page);//break records into pages
	    $page_position = (($page_number-1) * $item_per_page);//get starting position to fetch the records 
	     
	    if(isset($_REQUEST['search_value']))
		{
			//Fetch Quations History
	        if (is_numeric(trim($_REQUEST['search_value']))){
	            $sql_quote = "SELECT DISTINCT cq.PRODUCT_CODE, cq.PACKAGING_SIZE, cq.QUANTITY, cq.AVAILABLE_PRICE, cq.REQUESTED_PRICE, cq.REMARK, cq.FILE_NAME, cq.STATUS, up.DESCRIPTION FROM customer_quotations as cq, xxdkapps_unsegregated_products as up WHERE cq.CUSTOMER_NUMBER = ".$cust_id." and cq.PRODUCT_CODE = up.PRODUCT_CODE and cq.PRODUCT_CODE LIKE '".$_REQUEST['search_value']."%' ORDER BY cq.ID DESC LIMIT $page_position, $item_per_page";
	        }
	        else{
	            $sql_quote = "SELECT DISTINCT cq.PRODUCT_CODE, cq.PACKAGING_SIZE, cq.QUANTITY, cq.AVAILABLE_PRICE, cq.REQUESTED_PRICE, cq.REMARK, cq.FILE_NAME, cq.STATUS, up.DESCRIPTION FROM customer_quotations as cq, xxdkapps_unsegregated_products as up WHERE cq.CUSTOMER_NUMBER = ".$cust_id." and cq.PRODUCT_CODE = up.PRODUCT_CODE and up.DESCRIPTION LIKE '".$_REQUEST['search_value']."%' ORDER BY cq.ID DESC LIMIT $page_position, $item_per_page";
	        }
		}
		else{
			//Fetch Quations History
	    	$sql_quote = "SELECT cq.PRODUCT_CODE, cq.PACKAGING_SIZE, cq.QUANTITY, cq.AVAILABLE_PRICE, cq.REQUESTED_PRICE, cq.REMARK, cq.FILE_NAME, cq.STATUS, up.DESCRIPTION FROM customer_quotations as cq, xxdkapps_unsegregated_products as up WHERE cq.CUSTOMER_NUMBER = ".$cust_id." and cq.PRODUCT_CODE = up.PRODUCT_CODE ORDER BY cq.ID DESC LIMIT $page_position, $item_per_page";
		}
	    
		$result_quote_history = $con -> data_select($sql_quote);
	}
	if($result_quote_history != 'no'){
		$html_data = "";
		foreach ($result_quote_history as $key => $value) 
		{
			$html_data .= '<tr class="item">        	
				        	<td>'.$value['DESCRIPTION'].'</td>
				        	<td>'.$value['QUANTITY'].'</td>
				        	<td>'.$value['PACKAGING_SIZE'].'</td>
				            <td>'.$value['AVAILABLE_PRICE'].'</td>
				            <td>'.$value['REQUESTED_PRICE'].'</td>
				            <td>'.$value['REMARK'].'</td>
				            <td><a href="uploadedquotes/'.$value['FILE_NAME'].'" target="_blank">'.$value['FILE_NAME'].'</a></td>
				            <td>'.$value['STATUS'].'</td>
				      	</tr>';	
		}
		echo $html_data;
	}
	else{
		echo '<tr class="item"><td colspan="8" align="center">No Records Found</td></tr>';
	}
}
if($_REQUEST['action'] == "get_po_history")
{
	$cust_id = $_SESSION['cust_id'];
	$item_per_page = 10;

	if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		//Get page number from Ajax POST
		if(isset($_POST["page"])){
		    $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
		    if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
		}else{
		    $page_number = 1; //if there's no page number, set it to 1
		}
		
		if(isset($_REQUEST['search_value']))
		{
			//To get total count
			$sql = "SELECT DISTINCT cp.ID FROM customer_po as cp, xxdkapps_customer_master as cm WHERE cp.CUSTOMER_NUMBER = ".$cust_id." and cp.PO_NUMBER LIKE '".$_REQUEST['search_value']."%' and cp.SHIP_TO = cm.SITE_USE_ID and cm.BUSINESS_CODE = 'SHIP_TO' ORDER BY cp.ID DESC";
		}
		else{
			//To get total count
			$sql = "SELECT cp.ID FROM customer_po as cp, xxdkapps_customer_master as cm WHERE cp.CUSTOMER_NUMBER = ".$cust_id." and cp.SHIP_TO = cm.SITE_USE_ID and cm.BUSINESS_CODE = 'SHIP_TO' ORDER BY cp.ID DESC";
		}
		
		$result = $con -> data_select($sql);
		$get_total_rows = count($result); //hold total records in variable
	    $total_pages = ceil($get_total_rows/$item_per_page);//break records into pages
	    $page_position = (($page_number-1) * $item_per_page);//get starting position to fetch the records 
	     
	    if(isset($_REQUEST['search_value']))
		{
			//Fetch previous PO
	    	$sql_PO = "SELECT DISTINCT cp.PO_NUMBER, cp.SHIP_TO, cp.SOLD_TO, cp.CONTACT_PERSON, cp.DELIVERY_DATE, cp.FREIGHT_TERM, cp.FREIGHT_CHARGES, cp.VESSAL_NAME, cp.PAYMENT_TERM, cp.FILE_NAME, cp.COMMENT, cp.STATUS, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2 , cm.ADDRESS3,cm.ADDRESS4,cm.CITY, cm.COUNTRY) AS SHIP_ADDRESS FROM customer_po as cp, xxdkapps_customer_master as cm WHERE cp.CUSTOMER_NUMBER = ".$cust_id." and cp.PO_NUMBER LIKE '".$_REQUEST['search_value']."%' and cp.SHIP_TO = cm.SITE_USE_ID and cm.BUSINESS_CODE = 'SHIP_TO' ORDER BY cp.ID DESC LIMIT $page_position, $item_per_page";
		}
		else{
			//Fetch previous PO
	    	$sql_PO = "SELECT cp.PO_NUMBER, cp.SHIP_TO, cp.SOLD_TO, cp.CONTACT_PERSON, cp.DELIVERY_DATE, cp.FREIGHT_TERM, cp.FREIGHT_CHARGES, cp.VESSAL_NAME, cp.PAYMENT_TERM, cp.FILE_NAME, cp.COMMENT, cp.STATUS, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2 , cm.ADDRESS3,cm.ADDRESS4,cm.CITY, cm.COUNTRY) AS SHIP_ADDRESS FROM customer_po as cp, xxdkapps_customer_master as cm WHERE cp.CUSTOMER_NUMBER = ".$cust_id." and cp.SHIP_TO = cm.SITE_USE_ID and cm.BUSINESS_CODE = 'SHIP_TO' ORDER BY cp.ID DESC LIMIT $page_position, $item_per_page";
		}
	    
		$result_po_history = $con -> data_select($sql_PO);
	}
	

	
	if($result_po_history != 'no'){
		$html_data = "";
		foreach ($result_po_history as $key => $value) 
		{
	
			$html_data .= '<tr class="item">        	
				        	<td>'.$value['PO_NUMBER'].'</td>
				        	<td>'.$value['SHIP_ADDRESS'].'</td>
				        	<td>'.$value['DELIVERY_DATE'].'</td>
				            <td>'.$value['FREIGHT_TERM'].'</td>
				            <td>'.$value['PAYMENT_TERM'].'</td>
				            <td><a href="uploadedPO/'.$value['FILE_NAME'].'" target="_blank">'.$value['FILE_NAME'].'</a></td>
				            <td>'.$value['COMMENT'].'</td>
				            <td>'.$value['STATUS'].'</td>
				      	</tr>';	
		}
		echo $html_data;
	}
	else{
		echo '<tr class="item"><td colspan="8" align="center">No Records Found</td></tr>';
	}
}







/********  Admin AJAX Calls  *****/
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "updatePO") ){
	$cust_id = $_REQUEST['cust_no'];
	$po_id = $_REQUEST['po_id'];
	$po_no = $_REQUEST['po_no'];
	$ship_to = $_REQUEST['ship_to'];
	$ship_to_id = $_REQUEST['ship_to_id'];
	$sold_to = $_REQUEST['sold_to'];
	$sold_to_id = $_REQUEST['sold_to_id'];
	$cont_per = $_REQUEST['cont_per'];
	$del_date = $_REQUEST['del_date'];
	$f_term = $_REQUEST['f_term'];
	$f_chrges = $_REQUEST['f_chrges'];
	$vessal = $_REQUEST['vessal'];
	$pay_term = $_REQUEST['pay_term'];
	$pay_term_id = $_REQUEST['pay_term_id'];
	$status = $_REQUEST['status'];
	$feedback =$_REQUEST['feedback'];
	$oldfilename = $_REQUEST['old_file_name'];
	if($pay_term == "Choose One" && $pay_term_id == "0")
		$pay_term = "NA"; 
	$comments = $_REQUEST['comments'];
	if(isset($_FILES['file']['name']))
		$filename = $_FILES['file']['name'];
	else
		$filename = $oldfilename;
 	
	$sql ="UPDATE customer_po SET PO_NUMBER ='".$po_no."', SOLD_TO=".$sold_to_id.", SHIP_TO=".$ship_to_id.", CONTACT_PERSON='".$cont_per."', DELIVERY_DATE='".$del_date."', FREIGHT_TERM='".$f_term."', FREIGHT_CHARGES=".$f_chrges.", VESSAL_NAME='".$vessal."', PAYMENT_TERM='".$pay_term."', PAYMENT_TERM_ID=".$pay_term_id.", COMMENT='".$comments."',FILE_NAME='".$filename."' ,STATUS='".$status."', FEEDBACK='".$feedback."' WHERE ID =".$po_id;
	// echo $sql;
	// exit;
	$result=$con->data_update($sql);
	echo "Success";
	if(isset($_FILES['file']['name']))
	{
		if ( 0 < $_FILES['file']['error'] ) {
	        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
	    }
	    else {
	        move_uploaded_file($_FILES['file']['tmp_name'], 'uploadedPO/' . $_FILES['file']['name']);
	    }
	}
}

if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "updatequote") ){
	$cust_id = $_SESSION['cust_id'];
	$quote_pkgsz = $_REQUEST['quote_pkgsz'];
	$agree_price = $_REQUEST['agree_price'];
	$quote_qty = $_REQUEST['quote_qty'];
	$quote_id = $_REQUEST['quote_id'];
	$quote_status = $_REQUEST['quote_status'];
	$feedback =$_REQUEST['admin_feeback'];
	$oldfilename = $_REQUEST['old_file_name'];
	if($agree_price == "" || $agree_price == NULL)
		$agree_price = 0.00000;
	if(isset($_FILES['file']['name']))
	{
		$filename = $_FILES['file']['name'];
	}
	else
	{
		if ($oldfilename == 'undefined') 
		{
			$filename = "";		
		}
		else
		{
			$filename = $oldfilename;
		} 	
	}
	$sql ="UPDATE customer_quotations SET PACKAGING_SIZE = ".$quote_pkgsz.", QUANTITY = ".$quote_qty.", AGREED_PRICE = ".$agree_price.", FEEDBACK = '".$feedback."', FILE_NAME = '".$filename."', STATUS = '".$quote_status."' WHERE ID =".$quote_id;
	$result=$con->data_update($sql);
	echo "Success";
	if(isset($_FILES['file']['name']))
	{
		if ( 0 < $_FILES['file']['error'] ) {
	        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
	    }
	    else {
	        move_uploaded_file($_FILES['file']['tmp_name'], 'uploadedPO/' . $_FILES['file']['name']);
	    }
	}
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
