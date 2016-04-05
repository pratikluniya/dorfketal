<?php
include('../classes/functions.php');
 date_default_timezone_set("Asia/Kolkata"); 
 $date=date('Y-m-d H:i:s');
 $con= new functions();
 
  if(is_array($_FILES)) {
  	
     $consigment_id=$_REQUEST['consignmentid1'];
     $service_provider=$_REQUEST['serviceprovider'];
     $to_date=$_REQUEST['createddate'];
     $document_type=$_REQUEST['documenttype'];
     $bill_of_laden=$_REQUEST['bill_of_laden'];
     $packing_list=$_REQUEST['packing_list'];
     $certificate_of_analysis=$_REQUEST['certificate_of_analysis'];
     $certificate_of_origin=$_REQUEST['certificate_of_origin'];
     $gsp=$_REQUEST['gsp'];
     $haz_declaraition=$_REQUEST['haz_declaraition'];
     $non_hAZ_declaraition=$_REQUEST['non_hAZ_declaraition'];
     $msds=$_REQUEST['msds'];
     $heat_treatment_certification=$_REQUEST['heat_treatment_certification'];
     $benificary_declaration=$_REQUEST['benificary_declaration'];
     $certificate_quantity=$_REQUEST['certificate_quantity'];
     
     $query="SELECT * FROM document_detatils WHERE consignment_id=".$consigment_id;
     $result=$con->data_select($query);
     if($result != "no")
     {
     	$arr = array('bill_of_laden' => $bill_of_laden, 'packing_list' => $packing_list, 
					'certificate_of_analysis' => $certificate_of_analysis, 'certificate_of_origin' => $certificate_of_origin,
					 'gsp' => $gsp, 'haz_declaraition' => $haz_declaraition, 
					 'non_hAZ_declaraition' => $non_hAZ_declaraition, 'msds' => $msds,
					  'heat_treatment_certification' => $heat_treatment_certification, 'benificary_declaration' => $benificary_declaration,
					  'certificate_quantity' => $certificate_quantity);
					$json_data= json_encode($arr);
					
	    if(is_uploaded_file($_FILES['document']['tmp_name'])) {
		$sourcePath = $_FILES['document']['tmp_name'];
		$document_name=pathinfo($_FILES['document']['name']);
		$extension=$document_name['extension'];
		if($document_type == "Shipping Documents")
		{
			if($result[0]['shipping_document'] > 0)
			{
				$shipping_document=$result[0]['shipping_document'];
				$query="UPDATE document_detatils SET service_provider='$service_provider',shipping_document_details='$json_data', shipping_document='$shipping_document', shipping_document_update='$date' WHERE consignment_id=".$consigment_id;
				$result=$con->data_update($query);
				if($result > 0)
				{
					$targetPath = "../uploaded/".$shipping_document;
					
					//echo "success";
				}

			}
			else
			{
				$shipping_document=$consigment_id."shipping_document".".".$extension;	
				$query="UPDATE document_detatils SET service_provider='$service_provider',shipping_document_details='$json_data', shipping_document='$shipping_document', shipping_document_update='$date' WHERE consignment_id=".$consigment_id;
				$result=$con->data_update($query);
				if($result > 0)
				{
					
					$targetPath = "../uploaded/".$shipping_document;
					//echo "success";
				}
			}
			
		}
		elseif($document_type == "Commercial Invoice")
		{
			if($result[0]['commercial_invoice'] > 0)
			{
				$commercial_document=$result[0]['commercial_invoice'];
				$query="UPDATE document_detatils SET service_provider='$service_provider',shipping_document_details='$json_data', commercial_invoice='$commercial_document', commercial_invoice_update='$date' WHERE consignment_id=".$consigment_id;
				$result=$con->data_update($query);
				if($result >0)
				{
					$targetPath = "../uploaded/".$commercial_document;

					//echo "success";
				}
			}
			else
			{
				$commercial_document=$consigment_id."commercial_invoice".".".$extension;
				$query="UPDATE document_detatils SET service_provider='$service_provider',shipping_document_details='$json_data', commercial_invoice='$commercial_document', commercial_invoice_update='$date' WHERE consignment_id=".$consigment_id;
				$result=$con->data_update($query);
				if($result >0)
				{
					$targetPath = "../uploaded/".$commercial_document;
					//echo "success";
				}
			}
			
		}
		else
		{
			if($result[0]['india_commercial_invoice'] > 0)
			{
				$india_commercial_document=$result[0]['india_commercial_invoice'];
				$query="UPDATE document_detatils SET service_provider='$service_provider',shipping_document_details='$json_data', india_commercial_invoice='$india_commercial_document', india_commercial_invoice_update='$date' WHERE consignment_id=".$consigment_id;
				$result=$con->data_update($query);
				if($result >0)
				{
					$targetPath = "../uploaded/".$india_commercial_document;
					//echo "success";
				}
			}
			else
			{
				$india_commercial_document=$consigment_id."India_Commercial_Invoice".".".$extension;
				$query="UPDATE document_detatils SET service_provider='$service_provider',shipping_document_details='$json_data', india_commercial_invoice='$india_commercial_document', india_commercial_invoice_update='$date' WHERE consignment_id=".$consigment_id;
				$result=$con->data_update($query);
				if($result >0)
				{
					$targetPath = "../uploaded/".$india_commercial_document;
					//echo "success";
				}
			}
			
		}

			if(move_uploaded_file($sourcePath,$targetPath)) {

					echo "success";
					exit;
		   }  
       
       }
	      
     }
     else
     { 

            $arr = array('bill_of_laden' => $bill_of_laden, 'packing_list' => $packing_list, 
					'certificate_of_analysis' => $certificate_of_analysis, 'certificate_of_origin' => $certificate_of_origin,
					 'gsp' => $gsp, 'haz_declaraition' => $haz_declaraition, 
					 'non_hAZ_declaraition' => $non_hAZ_declaraition, 'msds' => $msds,
					  'heat_treatment_certification' => $heat_treatment_certification, 'benificary_declaration' => $benificary_declaration,
					  'certificate_quantity' => $certificate_quantity);
					$json_data= json_encode($arr);
					
	    if(is_uploaded_file($_FILES['document']['tmp_name'])) {
		$sourcePath = $_FILES['document']['tmp_name'];
		$document_name=pathinfo($_FILES['document']['name']);
		$extension=$document_name['extension'];
		if($document_type == "Shipping Documents")
		{
			
				$shipping_document=$consigment_id."shipping_document".".".$extension;	
				$query="INSERT INTO document_detatils(service_provider, shipping_document_details, shipping_document, shipping_document_update, created_date, consignment_id) VALUES ('$service_provider','$json_data','$shipping_document','$date','$to_date',$consigment_id)";
				$result=$con->data_update($query);
				if($result > 0)
				{
					
					$targetPath = "../uploaded/".$shipping_document;
					//echo "success";
				}
			
		}
		elseif($document_type == "Commercial Invoice")
		{
			
				$commercial_document=$consigment_id."commercial_invoice".".".$extension;
				$query="INSERT INTO document_detatils(service_provider, shipping_document_details, commercial_invoice, commercial_invoice_update, created_date, consignment_id) VALUES ('$service_provider','$json_data','$commercial_document','$date','$to_date',$consigment_id)";
				
				$result=$con->data_update($query);
				if($result >0)
				{
					$targetPath = "../uploaded/".$commercial_document;
					//echo "success";
				}
			
			
		}
		else
		{
			
				$india_commercial_document=$consigment_id."India_Commercial_Invoice".".".$extension;
				$query="INSERT INTO document_detatils(service_provider, shipping_document_details, india_commercial_invoice, india_commercial_invoice_update, created_date, consignment_id) VALUES ('$service_provider','$json_data','$india_commercial_document','$date','$to_date',$consigment_id)";
				$result=$con->data_update($query);
				if($result >0)
				{
					$targetPath = "../uploaded/".$india_commercial_document;
					//echo "success";
				}
			
			
		}

			if(move_uploaded_file($sourcePath,$targetPath)) {
					echo "success";
					exit;
		   }  
       
       }
     }
}
?>