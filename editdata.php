<?php
	include "classes/functions.php";
    $con =new functions();
    $id = $_REQUEST['id'];  

    if (isset($_POST['submit'])) {
    	$id = $_POST['id'];
    	$name = $_POST['name'];
    	$phone = $_POST['phone'];
    	$address = $_POST['address'];
    	$email = $_POST['email'];
    	$qryUpt = "UPDATE `customer_po` SET `name` = '$name', `phone` = '$phone', `address`='$address', `email`='$email' WHERE `sn`=$id";
    	mysql_query($qryUpt) or die(mysql_error());
    	header("location:index.php");
    }

    $qryMem = "SELECT * FROM `customer_po` WHERE `ID`='$id'";
    $mem = $con -> data_select($qryMem);
  
?>
<form method="post" action="editdata.php" role="form">
	<div class="modal-body">             
		<div class="form-group">
			<label for="name">ID
				<input type="text" id="id" name="id" value="<?php echo $mem[0]['ID'];?>" readonly="true"/>
			</label>
		</div>	
		<div class="form-group">
			<label for="name">Name
				<input type="text" id="name" name="name" value="<?php echo $mem[0]['PO_NUMBER'];?>" />
			</label>
		</div>	
		<div class="form-group">
			<label>Phone
				<input type="text" id="job" name="phone" value="<?php echo $mem[0]['FILE_NAME'];?>" />
			</label>
		</div>	
		<div class="form-group">
			<label>Address
				<input type="text" id="service" name="address" value="<?php echo $mem[0]['COMMENT'];?>" />
			</label>
		</div>	
		<div class="form-group">
			<label>Email
				<input type="text" id="education" name="email" value="<?php echo $mem[0]['STATUS'];?>" />
			</label>
		</div>	
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" name="submit_admin_po">Update</button>&nbsp;
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	</form>
</body>
</html>
