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

	//Fetch Cart Products
	$sql_prod ="SELECT up.ID, up.PRODUCT_CODE AS  ITEM_CODE, up.DESCRIPTION, up.ATTRIBUTE18 as  PRODUCT_APPLICATION, up.ATTRIBUTE17 as PRODUCT_GROUP, cc.CUSTOMER_NUMBER, cc.QUANTITY, cc.PACKAGING_SIZE, cc.AVAILABLE_PRICE, cc.REMARK FROM customer_cart as cc, xxdkapps_unsegregated_products as up WHERE cc.CUSTOMER_NUMBER= '" . $_SESSION['cust_id']."' and cc.PRODUCT_CODE = up.PRODUCT_CODE";
    $result_prod=$con->data_select($sql_prod);
?>

<div class="container">
	<div class="col-md-6 animated fadeInUp">
		<form id="checkout_data">
			<div class="form-group">
				<label for="PO_number">#PO : </label>
				<input class="form-control" type="number" name="PO_number" id="PO_number" placeholder="#PO" required>
			</div>
			<div class="form-group">
				<label for="sold_to">Sold To : </label>
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
				<label for="ship_to">Ship To : </label>
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
				<label for="contact_person">Contact Person : </label>
				<input class="form-control" type="text" name="contact_person" id="contact_person" placeholder="Contact Person" required>
			</div>
			<div class="form-group">
				<label for="delivery_date">Delivery Date : </label>
				<input class="form-control" type="date" name="delivery_date" id="delivery_date" placeholder="Delivery Date" required>
			</div>
			<div class="form-group">
				<label for="freight_term">Freight Term : </label>
				<select class="form-control" id="freight_term">
					<option value="0">Choose One</option>
					<option value="Ex-Work">Ex-Work</option>
					<option value="At Site">At Site</option>
				</select>
			</div>
			<div class="form-group">
				<label for="freight_charges">Freight Charges : </label>
				<input class="form-control" type="text" name="contact_person" id="contact_person" placeholder="Freight Charges" required>
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
				<button type="button" class="btn btn-primary" id="place_order"><i class="fa fa-check"></i> SUBMIT</button>
			</div>
		</form>
	</div>

	<div class="col-md-6" style="border-left: 1px dotted #c9c9c9;">
		<h3>Products in Cart</h3>
		<?php
        foreach ($result_prod as $key => $value) 
        { 
        ?>  <div class="animated bounceInRight">
                <div class="hpanel">
                    <div class="panel-heading hbuilt">
                        <div class="panel-tools">
                            <span class="label label-default cat-tags"><?php echo $result_prod[$key]['PRODUCT_APPLICATION']; ?></span>
                            <span class="label label-default cat-tags"><?php echo $result_prod[$key]['PRODUCT_GROUP']; ?></span>
                        </div>
                        <h4 id="prod_desc"><?php echo $result_prod[$key]['DESCRIPTION']; ?></h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <label class="prod-lables" for="qty">Quantity :</label>
                            <input type="text" name="qty" id="qty" class="prod_qty" value="<?php echo $result_prod[$key]['QUANTITY'];?>" readonly> Kg<br>
                        </div>
                        <div class="col-lg-12">
                            <label class="prod-lables" for="qty">Packaging Size :</label>
                            <select id="pkg_size" disabled>
				        		<option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "ANY" ) echo 'selected' ; ?> value="ANY">ANY</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "1" ) echo 'selected' ; ?> value="1">1</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "5" ) echo 'selected' ; ?> value="5">5</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "10" ) echo 'selected' ; ?> value="10">10</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "20" ) echo 'selected' ; ?> value="20">20</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "25" ) echo 'selected' ; ?> value="25">25</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "30" ) echo 'selected' ; ?> value="30">30</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "35" ) echo 'selected' ; ?> value="35">35</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "40" ) echo 'selected' ; ?> value="40">40</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "45" ) echo 'selected' ; ?> value="45">45</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "50" ) echo 'selected' ; ?> value="50">50</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "100" ) echo 'selected' ; ?> value="100">100</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "150" ) echo 'selected' ; ?> value="150">150</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "165" ) echo 'selected' ; ?> value="165">165</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "170" ) echo 'selected' ; ?> value="170">170</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "175" ) echo 'selected' ; ?> value="175">175</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "180" ) echo 'selected' ; ?> value="180">180</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "185" ) echo 'selected' ; ?> value="185">185</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "190" ) echo 'selected' ; ?> value="190">190</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "200" ) echo 'selected' ; ?> value="200">200</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "220" ) echo 'selected' ; ?> value="220">220</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "227" ) echo 'selected' ; ?> value="227">227</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "900" ) echo 'selected' ; ?> value="900">900</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "1000" ) echo 'selected' ; ?> value="1000">1000</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "16000" ) echo 'selected' ; ?> value="16000">16000</option>
		                        <option <?php if ($result_prod[$key]['PACKAGING_SIZE'] == "20000" ) echo 'selected' ; ?> value="20000">20000</option>
	                    	</select>
	                    </div>
	                    <div class="col-lg-12">
	                    	<label class="prod-lables" for="remark">Available Price :</label>
	                    		<?php 
                				if($result_prod[$key]['AVAILABLE_PRICE']== '0.00000')
                					echo "NA";
                				else
                					echo ($result_prod[$key]['AVAILABLE_PRICE']."/ Kg");
	                			?>
	                    </div>
	                    <div class="col-lg-12">
                            <label class="prod-lables" for="remark">Remark :</label>
                            <input type="text" name="remark" id="remark" class="prod_qty" value="<?php echo $result_prod[$key]['REMARK']; ?>" readonly/>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    	}           
        exit;
    ?>
	</div>
</div>