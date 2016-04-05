<?php
ob_start();
include('admin_sidebar_header.php');
include('../classes/functions.php');
$con=new functions();
session_start();
$user_name=$_SESSION['user_name'];
$_SESSION['success']="no";
if($user_name != "")
{
	$consignment_id=$_GET['consignment_id'];
	$query="SELECT consignment_id, customer_name, account_number, cust_po_number, order_number, ordered_item_id, item_description, unit_selling_price, order_quantity_uom, ordered_quantity, amount, request_date, schedule_ship_date, order_date, status FROM consignment_details WHERE consignment_id=".$consignment_id;
     $result2=$con->data_select($query);
	/* if($result2 !="no")
	 {
		 if(isset($_POST['submit']))
		 {
			  $customer_name=$_POST['customername'];
			  $account_number=$_POST['accountnumber'];
			  $cust_po_number=$_POST['custponumber'];
			  $order_number=$_POST['ordernumber'];
			  $ordered_item_id=$_POST['ordereditemid'];
			  $item_description=$_POST['itemdescription'];
			  $unit_selling_price=$_POST['unitsellingprice'];
			  $order_quantity_uom=$_POST['orderquantityuom'];
			  $ordered_quantity=$_POST['orderedquantity'];
			  $amount=$_POST['amount'];
			  $request_date=$_POST['requestdate'];
			  $schedule_ship_date=$_POST['scheduleshipdate'];
			  $order_date=$_POST['orderdate'];
			  $status=$_POST['status'];
			   $sql_update_container="UPDATE consignment_details SET customer_name='$customer_name',account_number='$account_number',cust_po_number='$cust_po_number',order_number='$order_number',ordered_item_id='$ordered_item_id',item_description='$item_description',unit_selling_price='$unit_selling_price',order_quantity_uom='$order_quantity_uom',ordered_quantity='$ordered_quantity',amount='$amount',request_date='$request_date',schedule_ship_date='$schedule_ship_date',order_date='$order_date',status='$status' WHERE consignment_id=".$consignment_id;
			   $result2=$con->data_update($sql_update_container);
			   if($result2)
			   {
				   $_SESSION['success']="Data Update Successfullly";
				  // header('Location: container_details.php');
			   }

			 
		 }
	 }*/
	 
	 
}


?>
<script>
function updateuser()
	 {
		 $('#ajax_div_edit').html('<img src="images/loader.gif" />');
		 var consignmentid=$("#consignmentid").val();
		 var customername=$("#customername").val();
		 var accountnumber=$("#accountnumber").val();
		 var custponumber=$("#custponumber").val();
		 var ordernumber=$("#ordernumber").val();
		 var ordereditemid= $("#ordereditemid").val();
		 var itemdescription=$("#itemdescription").val();
		 var unitsellingprice=$("#unitsellingprice").val();
		 var orderedquantity=$("#orderedquantity").val();
		 var amount=$("#amount").val();
		 var requestdate=$("#requestdate").val();
		 var status=$("#status").val();
		 var scheduleshipdate=$("#scheduleshipdate").val();
		  var orderdate=$("#orderdate").val();
		  var orderquantityuom=$("#orderquantityuom").val();
		 
		 
		 
		$.ajax({
			  type:"POST",
			  url:"logistics/ajax_service.php",
			  data:"consignment_id="+consignmentid+"&customer_name="+customername+"&account_number="+accountnumber+"&cust_po_number="+custponumber+"&order_number="+ordernumber+"&ordered_item_id="+ordereditemid+"&item_description="+itemdescription+"&unit_selling_price="+unitsellingprice+"&ordered_quantity="+orderedquantity+"&amount="+amount+"&request_date="+requestdate+"&status="+status+"&schedule_ship_date="+scheduleshipdate+"&order_date="+orderdate+"&order_quantity_uom="+orderquantityuom+"&action=updatecontainer",
			 
			  success: function(data)
			  {
				  
			     $('#ajax_div_edit').hide(3000);
	             $("#delete_messag").html('<div class="alert alert-success" role="alert" align="center"><button type="button" class="close" data-dismiss="alert"                 aria-label="Close"><span aria-hidden="true">×</span></button>You have successfully update Container Details</div>');
			    	var explode = function(){					
				     location.href= 'container_details.php';
					};
					setTimeout(explode, 3000);
				
			  }
			  
				
			});
				
			//location.reload();
	}
  $(document).ready(function(){
	    $(".alert").fadeOut(3000);
	  });
  
</script>

  <!-- page content -->
           
		<div class="right_col" role="main">
                <div class="">
                    
                    <div class="clearfix"></div>

                    <div class="row">

                         <div class="clearfix"></div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                              <form class="form-horizontal form-label-left" novalidate method="post" action="">

                                        
                                  <h2 align="center" style="color:#060;"><span class="section">Update Shiping Details</span></h2>
                                     <div id="ajax_div_edit" align="center"></div>
                                    <div id="delete_messag"></div>
                                  <div class="col-md-6">
                                           <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Consignment Id
                                            <span class="required" id=  "errusername"</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                            <span class="required" id="errusername"></span>
                                                <input class="form-control col-md-7 col-xs-12" value=
                                                "<?php echo $result2[0]['consignment_id'];?>" data-validate-length-range="6" 
                                                data-validate-words="2" name="consignmentid" id="consignmentid" placeholder="" readonly="readonly" required type="text">
                                            </div>
                                         </div>
                                          <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Customer Name
                                            <span class="required" id=  "errusername"</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                            <span class="required" id="errusername"></span>
                                                <input class="form-control col-md-7 col-xs-12" value=
                                                "<?php echo $result2[0]['customer_name'];?>" data-validate-length-range="6" 
                                                data-validate-words="2" name="customername" id="customername" placeholder="" required type="text">
                                            </div>
                                         </div>
                                          <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Account Number
                                            <span class="required" id=  "errusername"</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                            <span class="required" id="errusername"></span>
                                                <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                data-validate-words="2" name="accountnumber" id="accountnumber" value=
                                                "<?php echo $result2[0]['account_number'];?>" data-validate-length-range="6" 
                                                data-validate-words="2" placeholder="" required type="text">
                                            </div>
                                         </div>
                                          <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Cust Po Number
                                            <span class="required" id=  "errusername"</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                            <span class="required" id="errusername"></span>
                                                <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                data-validate-words="2" name="custponumber" id="custponumber" value=
                                                "<?php echo $result2[0]['cust_po_number'];?>" data-validate-length-range="6" 
                                                data-validate-words="2" placeholder="" required type="text">
                                            </div>
                                         </div>
                                          <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Order Number
                                            <span class="required" id=  "errusername"</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                            <span class="required" id="errusername"></span>
                                                <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                data-validate-words="2" name="ordernumber" id="ordernumber" value=
                                                "<?php echo $result2[0]['order_number'];?>" data-validate-length-range="6" 
                                                data-validate-words="2"  placeholder="" required type="text">
                                            </div>
                                         </div>
                                          <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Ordered Item Id
                                            <span class="required" id=  "errusername"</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                            <span class="required" id="errusername"></span>
                                                <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                data-validate-words="2" name="ordereditemid" id="ordereditemid" value=
                                                "<?php echo $result2[0]['ordered_item_id'];?>" data-validate-length-range="6" 
                                                data-validate-words="2"  placeholder="" required type="text">
                                            </div>
                                         </div>
                                         <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Item Description
                                            <span class="required" id=  "errusername"</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                            <span class="required" id="errusername"></span>
                                                <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                data-validate-words="2" name="itemdescription" id="itemdescription" value=
                                                "<?php echo $result2[0]['item_description'];?>" data-validate-length-range="6" 
                                                data-validate-words="2" placeholder="" required type="text">
                                            </div>
                                         </div>
                                         <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Unit Selling Price
                                            <span class="required" id=  "errusername"</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                            <span class="required" id="errusername"></span>
                                                <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                data-validate-words="2" name="unitsellingprice" id="unitsellingprice" value=
                                                "<?php echo $result2[0]['unit_selling_price'];?>" data-validate-length-range="6" 
                                                data-validate-words="2" name="customername" placeholder="" required type="text">
                                            </div>
                                         </div>
                                        
                                  </div>
                                  <div class="col-md-6">
                                          <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Ordered Quantity
                                            <span class="required" id=  "errusername"</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                            <span class="required" id="errusername"></span>
                                                <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                data-validate-words="2" name="orderedquantity" id="orderedquantity" value=
                                                "<?php echo $result2[0]['ordered_quantity'];?>" data-validate-length-range="6" 
                                                data-validate-words="2" placeholder="" required type="text">
                                            </div>
                                         </div>
                                          <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Amount
                                            <span class="required" id=  "errusername"</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                            <span class="required" id="errusername"></span>
                                                <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                data-validate-words="2" name="amount" id="amount" value=
                                                "<?php echo $result2[0]['amount'];?>" data-validate-length-range="6" 
                                                data-validate-words="2" placeholder="" required type="text">
                                            </div>
                                         </div>
                                          <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Request Date
                                            <span class="required" id=  "errusername"</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                            <span class="required" id="errusername"></span>
                                                <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                data-validate-words="2" name="requestdate" id="requestdate" value=
                                                "<?php echo $result2[0]['request_date'];?>" data-validate-length-range="6" 
                                                data-validate-words="2"  placeholder="" required type="text">
                                            </div>
                                         </div>
                                          <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Schedule Ship Date
                                            <span class="required" id=  "errusername"</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                            <span class="required" id="errusername"></span>
                                                <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                data-validate-words="2" name="scheduleshipdate" id="scheduleshipdate" 
                                                value="<?php echo $result2[0]['schedule_ship_date'];?>" data-validate-length-range="6" 
                                                data-validate-words="2"  placeholder="" required type="text">
                                            </div>
                                         </div>
                                          <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Order Date
                                            <span class="required" id=  "errusername"</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                            <span class="required" id="errusername"></span>
                                                <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                data-validate-words="2" name="orderdate" id="orderdate" placeholder="" value=
                                                "<?php echo $result2[0]['order_date'];?>" data-validate-length-range="6" 
                                                data-validate-words="2"  required type="text">
                                            </div>
                                         </div>
                                         <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Status
                                            <span class="required" id=  "errusername"</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                            <span class="required" id="errusername"></span>
                                               <select class="form-control col-md-7 col-xs-12" name="status"  id="status">
                                                 
                                                  <option value="Dispatch"<?php if ($result2[0]['status'] == 'Dispatch') echo ' selected="selected"';
												   ?>>Dispatch</option>
                                                  <option value="Intransit"<?php if ($result2[0]['status'] == 'Intransit') echo ' selected="selected"';
												   ?>>Intransit</option>
                                                  <option value="Loding"<?php if ($result2[0]['status'] == 'Loding') echo ' selected="selected"';
												   ?>>Loding</option>
                                                  <option value="Packing"<?php if ($result2[0]['status'] == 'Packing') echo ' selected="selected"';
												   ?>>Packing</option>
                                                  <option value="Completed"<?php if ($result2[0]['status'] == 'Completed') echo ' selected="selected"'; 
												  ?> >Completed</option>
                                                  <option value="undelivered" <?php if ($result2[0]['status'] == 'undelivered') echo ' selected="selected"';
												   ?>>undelivered</option>
                                                  
                                                </select>
                                            </div>
                                         </div>
                                          <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Order Quantity Uom
                                            <span class="required" id=  "errusername"</span>
                                            </label>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                            <span class="required" id="errusername"></span>
                                                <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                data-validate-words="2" name="orderquantityuom" id="orderquantityuom" value=
                                                "<?php echo $result2[0]['order_quantity_uom'];?>" data-validate-length-range="6" 
                                                data-validate-words="2"  placeholder="" required type="text">
                                            </div>
                                         </div>
                                       
                                  </div>
                                   <div class="col-md-12 col-sm-12 col-xs-12">
                                     <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <!--<button type="submit" class="btn btn-primary">Cancel</button>-->
                                               <h1 align="center"> <input type="button" id="submit" onclick="return updateuser();"  name="submit" value="submit" class="btn btn-success"/></h1>
                                            </div>
                                        </div>
                                   </div>
                              </form> 
                             
                        </div>
                      
                    </div>
              </div>

           
<?php
  include('footer.php');
  ob_end_flush();
?>