<?php
include "classes/functions.php";
session_start();
$cust_id = $_SESSION['cust_id'];
$con =new functions();

	// FEtch Quations History
	$sql_quote = "SELECT cq.PRODUCT_CODE, cq.PACKAGING_SIZE, cq.QUANTITY, cq.AVAILABLE_PRICE, cq.REQUESTED_PRICE, cq.REMARK, cq.FILE_NAME, cq.STATUS, up.DESCRIPTION FROM customer_quotations as cq, xxdkapps_unsegregated_products as up WHERE cq.CUSTOMER_NUMBER = ".$cust_id." and cq.PRODUCT_CODE = up.PRODUCT_CODE ORDER BY cq.ID DESC";
	$result_quote_history = $con -> data_select($sql_quote);
	
?>

<div class="container">
	<div class="col-md-6 col-xs-6 col-lg-6 col-sm-6 animated fadeInRight req-quote-div">
		<form>
			<div class="form-group">
				<label for="q_cat">Category<sup class="required_field">*</sup> : </label>
				<select id="q_cat" class="form-control" required>
					<option value="0">Select One</option>
					<option>Refinery</option>
					<option>Petrochemicals</option>
					<option>Additives & Cargo</option>
					<option>Catalysts</option>
					<option>Custom</option>
					<option>Oil Field</option>
				</select>
			</div>
			<div class="form-group">
				<label for="q_prod">Product<sup class="required_field">*</sup> :</label>
				<select id="q_prod" class="form-control" disabled required>
					<option value="0" selected>Select Product</option>
				</select>
			</div>
			<div class="form-group">
				<label for="q_packaging_size">Packaging Size<sup class="required_field">*</sup> :</label>
				<select id="q_packaging_size" class="form-control" disabled required>
					<option value="0" selected="selected">ANY</option>
			        <option>1</option>
			        <option>5</option>
			        <option>10</option>
			        <option>20</option>
			        <option>25</option>
			        <option>30</option>
			        <option>35</option>
			        <option>40</option>
			        <option>45</option>
			        <option>50</option>
			        <option>100</option>
			        <option>150</option>
			        <option>165</option>
			        <option>170</option>
			        <option>175</option>
			        <option>180</option>
			        <option>185</option>
			        <option>190</option>
			        <option>200</option>
			        <option>220</option>
			        <option>227</option>
			        <option>900</option>
			        <option>1000</option>
			        <option>16000</option>
			        <option>20000</option>
				</select>
				<input type="hidden" id="packaging_code" value="">
			</div>
			<div class="form-group">
				<label for="q_quantity">Quantity<sup class="required_field">*</sup> :</label>
				<input type="text" class="form-control" id="q_quantity" name="q_quantity" placeholder="Quantity" disabled required>
			</div>
			<div class="form-group">
				<label for="q_price">Available Price :</label>
				<input type="text" class="form-control" id="q_price" name="q_price" placeholder="Available Price" disabled required>
			</div>
			<div class="form-group">
				<label for="q_price">Request Price<sup class="required_field">*</sup> :</label>
				<input type="text" class="form-control" id="q_req_price" name="q_req_price" placeholder="Request Price" disabled required>
			</div>
			<div class="form-group">
				<label for="q_remark">Remark :</label>
				<input type="text" class="form-control" id="q_remark" name="q_remark" placeholder="Remark">
			</div>
			<div class="form-group">
				<button type="button" class="btn btn-primary" id="upload_quote_doc_btn"><i class="fa fa-paperclip"></i> Attach Quotation</button>
			</div>
			<div class="form-group">
				<input type="file" name="uploaded_quote" id="uploaded_quote" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" style="visibility:hidden;">
				<button type="button" class="btn btn-primary" id="req_q_btn">SUBMIT</button>
			</div>
		</form>
	</div>
	<div class="container animated bounceInRight quote-history-div" style="display:none;">
	    <table id="cart_table" class="table table-bordered table-striped">
	    	<thead>
	      		<tr class="headings">
	        		<th>PRODUCT NAME</th>
	        		<th>QUANTITY (KG)</th>
	        		<th>PACKAGING SIZE (Drum/Tank)</th>
	        		<th>AVAILABLE PRICE (PER KG)</th>
	        		<th>REQUESTED PRICE (PER KG)</th>
	        		<th>REMARK</th>
	        		<th>FILE_NAME</th>
	        		<th>STATUS</th>
	      		</tr>
	    	</thead>
	    	<tbody>
	    	<?php
	        	foreach ($result_quote_history as $key => $value) 
	        	{
	        ?>
	        		<tr class="item">
			        	<td>
			        		<?php echo $value['DESCRIPTION']; ?>
			        	</td>
			        	<td>
			        		<?php echo $value['QUANTITY']; ?>
			        	</td>
			        	<td>
			        		<?php echo $value['PACKAGING_SIZE']; ?>
		                </td>
		                <td>
		                	<?php echo $value['AVAILABLE_PRICE']; ?>
		                </td>
		                <td>
		                	<?php echo $value['REQUESTED_PRICE']; ?>
		                </td>
		                <td>
		                	<?php echo $value['REMARK']; ?>
		                </td>
		                <td>
		                	<?php echo $value['FILE_NAME']; ?>
		                </td>
		                <td>
		                	<?php echo $value['STATUS']; ?>
		                </td>
			      	</tr>
			<?php 
			}
			?>
			</tbody>
		</table>
	</div>
</div>