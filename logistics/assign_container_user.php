<?php
ob_start();
include('class/functions.php');
$con=new functions();
session_start();
$user_id=$_SESSION['user_id'];
$first_name=$_SESSION['first_name'];
if($user_id != "")
{
     $result=$con->data_select("SELECT assign_id, user_id, consignment_id, orign_location, destination_location, picup_date_time, status FROM assign_consignment WHERE user_id=".$user_id);
}

include('user_sidebar_header.php');
?>


  <!-- page content -->
           
		<div class="right_col" role="main">
                <div class="">
                    
                    <div class="clearfix"></div>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2 style="color:#060;">Assign Container</h2>
                                   
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <table id="example" class="table table-striped responsive-utilities jambo_table">
                                        <thead>
                                            <tr class="headings">
                                             <input type="hidden" id="userId" value="<?php echo $user_id;?>" name="userId" />
                                               <!-- <th>
                                                    <input type="checkbox" class="tableflat">
                                                   
                                                </th>-->
                                               <!-- <th>CONSIG ID</th>
                                                <th>CUST NAME</th>
                                                <th>ACC NO</th>
                                                <th>CUST PO NO</th>
                                                <th>ORDER NO</th>
                                                <th>ORDER ITEM ID</th>
                                                <th>ITEM DESC</th>
                                                <th>UNIT SELL PRICE</th>
                                                <th>ORDER QUAN UOM</th>
                                                <th>ORDER QUAN</th>
                                                <th>AMOUNT</th>
                                                <th>REQ DATE</th>
                                                <th>SCHE SHIP DATE</th>
                                                <th>ORDER DATE</th>-->
                                                
                                                <th>Sr no</th>
                                              
                                                <th>Consignment_Id</th>
                                                <!--<th>cust po no</th>
                                                <th>order no</th>
                                                <th>order item id</th>
                                                <th>item dec</th>
                                                <th>unit sell price</th>
                                                <th>order quan uom</th>
                                                <th>order quan</th>
                                                <th>amount</th>-->
                                                <th>Orgin Location</th>
                                                <th>Destination_location</th>
                                                <th>Picup Date/Time</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            
                                            </tr>
                                        </thead>

                                        <tbody>
                                         <?php
											if($result!="no")
											 {
												 
												foreach($result as $key => $val)
												{
													echo "<tr>";
												     $srno=$key+1;
													 echo "<td>".$srno."</td>";
													 
													 foreach($result[$key] as $key2 => $val2)
													 {
														 if($key2 == 'assign_id')
														 {
															 continue;
														 }
														 if($key2 == 'user_id')
														 {
															 continue;
														 }
														 else
														 {
															 echo "<td>".$val2."</td>";
														 }
														 
													 }
													  echo '<td><a href="update_location.php?consignment_id='.$result[$key]["consignment_id"].'" 
													  class="btn btn-primary btn-xs" >Update </a></td>';
													 echo "</tr>";
												} 
											  }
											?>
                                            <!--<tr class="even pointer">
                                                <td class="a-center ">
                                                    <input type="checkbox" class="tableflat">
                                                </td>
                                                <td class=" ">121000040</td>
                                                <td class=" ">May 23, 2014 11:47:56 PM </td>
                                                <td class=" ">121000210 <i class="success fa fa-long-arrow-up"></i>
                                                </td>
                                                <td class=" ">John Blank L</td>
                                                <td class=" ">Paid</td>
                                                <td class="a-right a-right ">$7.45</td>
                                                <td class=" last"><a href="#">View</a>
                                                </td>
                                            </tr>-->
                                           
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

 
                    </div>
              </div>

           
<?php
  include('footer.php');
  ob_end_flush();
?>