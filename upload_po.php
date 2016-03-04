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

<div class="container table-responsive">
	<div class="col-md-6 col-xs-6 col-lg-6 col-sm-6 animated fadeInRight po-form-div">
		<form id="checkout_data">
			<div class="form-group">
				<label for="PO_number">PO#<sup class="required_field">*</sup> : </label>
				<input class="form-control" type="text" name="PO_number" id="PO_number" placeholder="PO#" required>
			</div>
			<div class="form-group">
				<label for="sold_to">Sold To<sup class="required_field">*</sup> : </label>
				<select class="form-control" id="PO_sold_to">
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
				<select class="form-control" id="PO_ship_to">
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
				<input class="form-control" type="text" name="contact_person" id="PO_contact_person" placeholder="Contact Person" required>
			</div>
			<div class="form-group">
				<label for="delivery_date">Delivery Date<sup class="required_field" min="">*</sup> : </label>
				<input class="form-control" type="date" name="delivery_date" id="PO_delivery_date" placeholder="Delivery Date" required>
			</div>
			<div class="form-group">
				<label for="freight_term">Freight Term<sup class="required_field">*</sup> : </label>
				<select class="form-control" id="PO_freight_term">
					<option value="0">Choose One</option>
					<option value="Ex-Work">Ex-Work</option>
					<option value="At Site">At Site</option>
				</select>
			</div>
			<div class="form-group fc_div">
				<label for="freight_charges">Freight Charges<sup class="required_field">*</sup> : </label>
				<input class="form-control" type="text" name="freight_charges" id="PO_freight_charges" placeholder="Freight Charges" required>
			</div>
			<div class="form-group">
				<label for="vessel_name">Vessel Name : </label>
				<input class="form-control" type="text" name="vessel_name" id="PO_vessel_name" placeholder="Vessel Name" required>
			</div>
			<div class="form-group">
				<label for="payment_term">Payment Terms : </label>
				<select class="form-control" id="PO_payment_term" required>
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
				<textarea class="form-control" id="PO_comments" name="comments" placeholder="Comments"></textarea>
			</div>
			<div class="form-group">
				<button type="button" class="btn btn-primary" id="upload_po_doc_btn"><i class="fa fa-paperclip"></i> Attach PO#</button>
			</div>
			<input type="file" name="uploaded_po" id="uploaded_po" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" style="visibility:hidden;">
			<div class="form-group">
				<input type="button" class="btn btn-primary" id="submit_po" value="SUBMIT"></button>
			</div>
		</form>
	</div>
	<div class="container table-responsive animated bounceInRight po-history-div" style="display:none;">
	    <table id="cart_table" class="table table-bordered table-striped">
	    	<thead>
	      		<tr class="headings">
	        		<th>PO# NUMBER</th>
	        		<th>SHIP ADDRESS</th>
	        		<th>DELIVERY DATE</th>
	        		<th>FREIGHT TERM</th>
	        		<th>PAYMENT TERM</th>
	        		<th>FILE</th>
	        		<th>COMMENT</th>
	        		<th>STATUS</th>
	      		</tr>
	    	</thead>
	    	<tbody id="po_history_table">
	    	
			</tbody>
		</table>
		<?php
		if(isset($_REQUEST['search_value']))
		{			
		?>
		<div class="container text-center">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="po_history_loc_src_pagtn">
                    <?php                                
                        echo paginate_function($item_per_page, $page_number, $get_total_rows, $total_pages);
                    ?>
                </div>                        
            </div>    
        </div>
	    <?php
	    }
	    ?>
		
	</div>
</div>