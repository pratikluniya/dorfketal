<?php
 include "classes/functions.php";
 session_start();
 $con =new functions();
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "getcart") )
{
	$sql ="SELECT up.ID, up.PRODUCT_CODE AS  ITEM_CODE, up.DESCRIPTION, up.ATTRIBUTE18 as  PRODUCT_APPLICATION, up.ATTRIBUTE17 as PRODUCT_GROUP, cc.CUSTOMER_NUMBER, cc.QUANTITY, cc.PACKAGING_SIZE, cc.REMARK FROM customer_cart as cc, xxdkapps_unsegregated_products as up WHERE cc.CUSTOMER_NUMBER= '" . $_SESSION['cust_id']."' and cc.PRODUCT_CODE = up.PRODUCT_CODE";
    $result=$con->data_select($sql);
}
if($result != "no")
    {
    	?>
    	<table class="table table-striped cart-table">
		    	<thead>
		      		<tr>
		        		<th>PRODUCT</th>
		        		<th>QUANTITY (KG)</th>
		        		<th>PACKAGING SIZE (Drum/Tank)</th>
		        		<th>REMARK</th>
		        		<th></th>
		      		</tr>
		    	</thead>
		    	<tbody>
		<?php
        foreach ($result as $key => $value) 
        {
        ?>
		      	<tr>
		        	<td> <?php echo $result[$key]['DESCRIPTION']; ?> </td>

		        	<td>
		        		<input type="number" class="cart-qty cart-input" value=" <?php echo $result[$key]['QUANTITY']; ?> ">
		        	</td>
		        	<td>
		        		<select class="cart-pck-size cart-input">
			        		<option <?php if ($result[$key]['PACKAGING_SIZE'] == "ANY" ) echo 'selected' ; ?> value="ANY">ANY</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "1" ) echo 'selected' ; ?> value="1">1</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "5" ) echo 'selected' ; ?> value="5">5</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "10" ) echo 'selected' ; ?> value="10">10</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "20" ) echo 'selected' ; ?> value="20">20</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "25" ) echo 'selected' ; ?> value="25">25</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "30" ) echo 'selected' ; ?> value="30">30</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "35" ) echo 'selected' ; ?> value="35">35</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "40" ) echo 'selected' ; ?> value="40">40</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "45" ) echo 'selected' ; ?> value="45">45</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "50" ) echo 'selected' ; ?> value="50">50</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "100" ) echo 'selected' ; ?> value="100">100</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "150" ) echo 'selected' ; ?> value="150">150</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "165" ) echo 'selected' ; ?> value="165">165</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "170" ) echo 'selected' ; ?> value="170">170</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "175" ) echo 'selected' ; ?> value="175">175</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "180" ) echo 'selected' ; ?> value="180">180</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "185" ) echo 'selected' ; ?> value="185">185</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "190" ) echo 'selected' ; ?> value="190">190</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "200" ) echo 'selected' ; ?> value="200">200</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "220" ) echo 'selected' ; ?> value="220">220</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "227" ) echo 'selected' ; ?> value="227">227</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "900" ) echo 'selected' ; ?> value="900">900</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "1000" ) echo 'selected' ; ?> value="1000">1000</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "16000" ) echo 'selected' ; ?> value="16000">16000</option>
	                        <option <?php if ($result[$key]['PACKAGING_SIZE'] == "20000" ) echo 'selected' ; ?> value="20000">20000</option>
	                    </select>
	                </td>
	                <td>
	                	<input type="text" class="cart-remark cart-input" value=" <?php echo $result[$key]['REMARK']; ?> ">
	                	<input type="hidden" class="prod_id" value=" <?php echo $result[$key]['ITEM_CODE']; ?> ">
	                </td>
	                <td class="remove_product_btn">
	                	<span>
	                		REMOVE <span class="badge" style="background-color:red;"> - </span>
	                	</span>
	                </td>
	                <td class="save_product_btn">
	                	<span>
	                		SAVE
	                	</span>
	                </td>
		      	</tr>
		<?php 
		}
		?>
			</tbody>
		</table>
		<button type="button" id="continue_shop_btn">Continue Shopping</button>
		<button type="button" id="checkout_btn" style="float:right;margin-right:10%;">Checkout</button>
	<?php
	}
	else
	{
		?>
		<div class="container">
			<h4>
				No Items in your Shopping Cart
			</h4>
			<button type="button" id="continue_shop_btn">Continue Shopping</button>
		</div>
	<?php
	}
?>

