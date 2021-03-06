<?php
include "classes/functions.php";
session_start();
$cust_id = $_SESSION['cust_id'];
$con =new functions();
//Fetching Sold_To droupdown values
	$sql_sold_to = "SELECT distinct  SITE_USE_ID as ID, PRIMARY_FLAG,
		   CONCAT_WS(',',ADDRESS1,ADDRESS2, ADDRESS3,ADDRESS4,CITY,COUNTRY) AS SHIP_ADDRESS		  
		   FROM xxdkapps_customer_master WHERE BUSINESS_CODE ='BILL_TO'
		   and CUSTOMER_NUMBER = ".$cust_id."
		   and ACCOUNT_STATUS='A'
		   order by PRIMARY_FLAG DESC";
	$result_sold_to=$con->data_select($sql_sold_to);
	
	//Fetching Ship_To droupdown values
	$sql_ship_to = "SELECT distinct SITE_USE_ID as ID, PRIMARY_FLAG,
		   CONCAT_WS(',',ADDRESS1,ADDRESS2 , ADDRESS3,ADDRESS4,CITY, COUNTRY) AS SHIP_ADDRESS		  
		   FROM xxdkapps_customer_master WHERE BUSINESS_CODE ='SHIP_TO'
		   and CUSTOMER_NUMBER = ".$cust_id."
		   and ACCOUNT_STATUS='A'
		   order by PRIMARY_FLAG DESC";
	$result_ship_to = $con -> data_select($sql_ship_to);
	
	//Fetching Payment Terms droupdown values
	$sql_payment_terms = "SELECT TERM_ID, DESCRIPTION FROM xxdkapps_payment_terms";
	$result_payment_terms = $con -> data_select($sql_payment_terms);
?>

<div class="container">
	<div class="col-md-6 col-xs-6 col-lg-6 col-sm-6 animated fadeInUp">
		<form id="checkout_data">
			<div class="form-group">
				<label for="PO_number">#PO<sup class="required_field">*</sup> : </label>
				<input class="form-control" type="text" name="PO_number" id="PO_number" placeholder="#PO" required>
			</div>
			<div class="form-group">
				<label for="sold_to">Sold To<sup class="required_field">*</sup> : </label>
				<select class="form-control" id="sold_to">
					<option value="0">Choose One</option>
					<?php
					foreach($result_sold_to as $key => $value):
						echo '<option value="'.$value['ID'].'">'.$value['SHIP_ADDRESS'].'</option>'; //close your tags!!
					endforeach;
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="ship_to">Ship To<sup class="required_field">*</sup> : </label>
				<select class="form-control" id="ship_to">
					<option value="0">Choose One</option>
					<?php
					foreach($result_ship_to as $key => $value):
						echo '<option value="'.$value['ID'].'">'.$value['SHIP_ADDRESS'].'</option>'; //close your tags!!
					endforeach;
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="contact_person">Contact Person<sup class="required_field">*</sup> : </label>
				<input class="form-control" type="text" name="contact_person" id="contact_person" placeholder="Contact Person" required>
			</div>
			<div class="form-group">
				<label for="delivery_date">Delivery Date<sup class="required_field">*</sup> : </label>
				<input class="form-control" type="date" name="delivery_date" id="delivery_date" placeholder="Delivery Date" required>
			</div>
			<div class="form-group">
				<label for="freight_term">Freight Term<sup class="required_field">*</sup> : </label>
				<select class="form-control" id="freight_term">
					<option value="0">Choose One</option>
					<option value="Ex-Work">Ex-Work</option>
					<option value="At Site">At Site</option>
				</select>
			</div>
			<div class="form-group fc_div">
				<label for="freight_charges">Freight Charges<sup class="required_field">*</sup> : </label>
				<input class="form-control" type="text" name="freight_charges" id="freight_charges" placeholder="Freight Charges" required>
			</div>
			<div class="form-group">
				<label for="vessel_name">Vessel Name : </label>
				<input class="form-control" type="text" name="vessel_name" id="vessel_name" placeholder="Vessel Name" required>
			</div>
			<div class="form-group">
				<label for="payment_term">Payment Terms : </label>
				<select class="form-control" id="payment_term">
					<option value="0">Choose One</option>
					<?php
						foreach($result_payment_terms as $key => $value):
							echo '<option value="'.$value['TERM_ID'].'">'.$value['DESCRIPTION'].'</option>'; 
						endforeach;
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="comments">Comments : </label>
				<textarea class="form-control" id="comments" name="comments" placeholder="Comments"></textarea>
			</div>
			<div class="form-group">
				<button type="button" class="btn btn-primary" id="repeat_place_order"><i class="fa fa-check"></i> SUBMIT</button>
			</div>
		</form>
	</div>
</div>