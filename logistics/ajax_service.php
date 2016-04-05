<?php
include('../classes/functions.php');
$con= new functions();
session_start();
date_default_timezone_set("Asia/Kolkata"); 
$date4=date('Y-m-d H:i:s');
$role_id= $_SESSION['role_id'];
if($_REQUEST['action']=="insertupdateconsignment")
{
	$query="UPDATE consignment_details SET consignment_address='".$_REQUEST['consignment_address']."',mode_of_shipment='".$_REQUEST['mode_of_shipment']."',vessel_name='".$_REQUEST['vessel_name']."',etd_date='".$_REQUEST['etd_date']."',container_number='".$_REQUEST['container_name']."',shipped_on_board='".$_REQUEST['shipped_on_board']."',transhipment_port='".$_REQUEST['transhipment_port']."',transhipment_vessel_name='".$_REQUEST['transhipment_vessel_name']."',eta_date='".$_REQUEST['eta_date']."',arrival_date='".$_REQUEST['arrival_date']."',custom_clearance_date='".$_REQUEST['custom_clearance_date']."',custom_clearance='".$_REQUEST['custom_clearance']."',delivered_cutomer_loaction='".$_REQUEST['delivered_cutomer_loaction']."',remark='".$_REQUEST['remark']."' WHERE consignment_id=".$_REQUEST['consignment_id'];
	$result0=$con->data_update($query);
	if($result0 > 0)
	{
	        //$query="SELECT  consigneement_addrss, mode_of_shipment, vessel_name, etd_date, container_number, shipped_on_board, transhipment_port, transhipment_vessel_name, eta_date, arrival_date, custom_clearance_date, custom_clearance, delivered_cutomer_loaction, remark, consignment_id FROM consignment_update WHERE consignment_id=".$_REQUEST['consignment_id'];
            $query="SELECT consignment_address, mode_of_shipment, vessel_name, etd_date, container_number, shipped_on_board, transhipment_port, transhipment_vessel_name, eta_date, arrival_date, custom_clearance_date, custom_clearance, delivered_cutomer_loaction, remark, consignment_id FROM consignment_details WHERE consignment_id=".$_REQUEST['consignment_id'];
            $result=$con->data_select($query);
			$edt_date=$result[0]['etd_date'];
			if($edt_date > $date4)
			{
				
				$query="UPDATE consignment_details SET order_status='IN TRANSIT' WHERE consignment_id=".$_REQUEST['consignment_id'];
				$result1=$con->data_update($query);					
				if($result[0]['arrival_date'] > 0)
				{
					
					$query="UPDATE consignment_details SET order_status='ARRIVED AT PORT' WHERE consignment_id=".$_REQUEST['consignment_id'];
					$result2=$con->data_update($query);

					if($result[0]['custom_clearance'] == "yes")
					{
						
						$query="UPDATE consignment_details SET order_status='UNDER CUSTOM ClEARENCE' WHERE consignment_id=".$_REQUEST['consignment_id'];
						$result3=$con->data_update($query);					
						if($result[0]['custom_clearance_date'] > 0)
						{
							
							$query="UPDATE consignment_details SET order_status='OUT FOR DELIVERY' WHERE consignment_id=".$_REQUEST['consignment_id'];
							$result4=$con->data_update($query);

							if($result[0]['delivered_cutomer_loaction'] > 0)
							{
								
								$query="UPDATE consignment_details SET order_status='CLOSED' WHERE consignment_id=".$_REQUEST['consignment_id'];
								$result5=$con->data_update($query);

							}

						}

					}

				}

			}
		echo "success";		
	}		
	exit;

}
if($_REQUEST['action'] == "showdocument")
{
//	alert("helloo");
	$query="SELECT  service_provider, shipping_document_details, shipping_document, shipping_document_update, commercial_invoice, commercial_invoice_update, india_commercial_invoice,india_commercial_invoice_update, created_date, consignment_id FROM document_detatils WHERE consignment_id=".$_REQUEST['consigment_id'];
	
	$result=$con->data_select($query);
	 
	 if($result !="no"){
		 	echo json_encode($result);
	         exit;  
	  }else{
		  
		  }
          
}
if($_REQUEST['action']=="select_update_consignment")
{

	$query_link="SELECT tracking_url FROM  tracking_url WHERE  id =1";
	$result_link=$con->data_select($query_link);
	$url_logistic=$result_link[0]['tracking_url'];
	$query="SELECT consignment_address, delivery_details_id, container_url, mode_of_shipment, vessel_name, etd_date, container_number, shipped_on_board, transhipment_port, transhipment_vessel_name, eta_date, arrival_date, custom_clearance_date, custom_clearance, delivered_cutomer_loaction, remark, consignment_id FROM consignment_details WHERE consignment_id=".$_REQUEST['consignment_id'];
   
	$result=$con->data_select($query);
	if($result !="no")
	{ 
		
		$result[0]['url_logistic'] = $url_logistic;
		$result[0]['role_id'] = $role_id;
		echo json_encode($result);
		exit;
	}
	else
	{
		echo "no";
		exit;
	}
	exit;
	
	 
}  
if($_REQUEST['action']=="insertassignconsignment")
{
	$query="INSERT INTO assign_consignment(user_id, consignment_id, orign_location, destination_location, status) VALUES 
	(".$_REQUEST['user_id'].",".$_REQUEST['consigmant_id'].",'".$_REQUEST['orign_location']."','".$_REQUEST['destination_location']."','".$_REQUEST['status']."')";
	
	$result=$con->data_insert($query);
	if($result > 0)
	{
		echo "success";
		exit;
	}
	
	
	 
}
if($_REQUEST['action']=="deleteDocument")
{
	
	
	if($_REQUEST['document_type'] == 's')
	{
		$query="UPDATE document_detatils SET shipping_document='', shipping_document_update='' WHERE consignment_id=".$_REQUEST['consignment_id'];
	
		$result=$con->data_delete($query);
		if($result >0)
		{
			echo "success";
		}
	}
	
	if($_REQUEST['document_type'] == 'c')
	{
		$query="UPDATE document_detatils SET commercial_invoice='', commercial_invoice_update='' WHERE consignment_id=".$_REQUEST['consignment_id'];
		$result=$con->data_delete($query);
		if($result >0)
		{
			echo "success";
		}
	}
	if($_REQUEST['document_type'] == 'i')
	{
		$query="UPDATE document_detatils SET india_commercial_invoice='', india_commercial_invoice_update='' WHERE consignment_id=".$_REQUEST['consignment_id'];
		$result=$con->data_delete($query);
		if($result >0)
		{
			echo "success";
		}
	}
	exit;
}

if($_REQUEST['action'] == "selectconsignmentstatus")
{
	
	 
      $querey="SELECT  status, date_time FROM route_name WHERE consigment_id=".$_REQUEST['consignment_id'];
	 
	  $result=$con->data_select($querey);
	 
	  echo json_encode($result);
	  
	  exit;         
	               
}



if($_REQUEST['action'] == "userdetails")
{
	 $query="SELECT user_id, first_name, last_name, user_name, password, address, type, created_date, status, entity_id FROM user_registration 
	 WHERE user_id=".$_REQUEST['user_id'];
     $result=$con->data_select($query);
	 echo json_encode($result);
	  
	 exit;    
	               
}
if($_REQUEST['action'] == "updateuser")
{
    $query="UPDATE user_registration SET first_name='".$_REQUEST['first_name']."',last_name='".$_REQUEST['last_name']."',user_name='".$_REQUEST['user_name']."',password='".$_REQUEST['password']."',address='".$_REQUEST['address']."',type=".$_REQUEST['type'].",status='".$_REQUEST['status']."',entity_id=".$_REQUEST['entity_id']." WHERE user_id=".$_REQUEST['user_id'];
	$result=$con->data_update($query);
	if($result >0)
	  {
		echo "success";
	  }
	  exit;                    
}
if($_REQUEST['action'] == "deleteuser")
{
    $query="DELETE FROM user_registration WHERE user_id=".$_REQUEST['user_id'];
	$result=$con->data_delete($query);
	if($result >0)
	{
		echo "success";
	}
	else
	{
		echo "fail";
	}	
	exit;               
}
if($_REQUEST['action'] == "updatecontainer")
{
      $query="UPDATE consignment_details SET customer_name='".$_REQUEST['customer_name']."',account_number='".$_REQUEST['account_number']."',cust_po_number='".$_REQUEST['cust_po_number']."',order_number='".$_REQUEST['order_number']."',ordered_item_id='".$_REQUEST['ordered_item_id']."',item_description='".$_REQUEST['item_description']."',unit_selling_price=".$_REQUEST['unit_selling_price'].",order_quantity_uom='".$_REQUEST['order_quantity_uom']."',ordered_quantity=".$_REQUEST['ordered_quantity'].",amount=".$_REQUEST['amount'].",request_date='".$_REQUEST['request_date']."',schedule_ship_date='".$_REQUEST['schedule_ship_date']."',order_date='".$_REQUEST['order_date']."',status='".$_REQUEST['status']."' WHERE consignment_id=".$_REQUEST['consignment_id'];
	  $result=$con->data_update($query);
	  if($result > 0)
	  {
		  echo "success";
	  }
	  exit;       
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
	{}
}
if($_REQUEST['action'] == "customershippeddetails")
{
	$query_link="SELECT tracking_url FROM  tracking_url WHERE  id =1";
	$result_link=$con->data_select($query_link);
	$url_logistic=$result_link[0]['tracking_url'];
    $query="SELECT * FROM consignment_details WHERE consignment_id=".$_REQUEST['consignment_id'];
	$result=$con->data_select($query);
	if($result !="no"){						
	        $result[0]['url_logistic'] = $url_logistic;
	    	echo json_encode($result);	         
	  }else{
		  
		}
		exit; 
}
if($_REQUEST['action'] == "user_role_add")
{
    $sql="INSERT INTO user_registration(first_name,password,email_id, role_id, entity_id) VALUES ('".$_REQUEST['name']."','".$_REQUEST['name']."','".$_REQUEST['emailAddress']."',".$_REQUEST['role'].",'".$_REQUEST['entities']."')";    
    $result=$con->data_insert($sql);
    if($result > 0)
    {
        echo "success";
    }
	exit;

}
if($_REQUEST['action'] == "change_url")
{
    $sql="UPDATE tracking_url SET tracking_url='".$_REQUEST['tracking_url']."' WHERE id=1";    
    $result=$con->data_insert($sql);
    if($result > 0)
    {
    	echo "success";
    }
	exit;

}
if($_REQUEST['action'] == "container_url_edit")
{
    $sql="UPDATE consignment_details SET container_url='".$_REQUEST['tracking_url']."' WHERE delivery_details_id='".$_REQUEST['delivery_details_id']."'"; 
    $result=$con->data_update($sql);
    if($result > 0)
    {
    	echo "Successfully update Url";
    }
	exit;
}
if($_REQUEST['action'] == "container_Default_url")
{
    $default_url="";
    $sql="UPDATE consignment_details SET container_url='".$default_url."'    WHERE delivery_details_id='".$_REQUEST['delivery_details_id']."'"; 
    $result=$con->data_update($sql);
    if($result > 0)
    {
    	echo "Successfully Set Default  Url";
    }
	exit;
}

?>