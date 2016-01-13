<?php
ob_start();
include('class/functions.php');
date_default_timezone_set("Asia/Kolkata"); 
$date4=date('Y-m-d H:i:s');

$con=new functions();
$date= $con->get_datetime_html();

$date1= date('Y-m-d\T00:00:00',strtotime("-1 days"));

$query="SELECT * FROM consignment_details WHERE created_date between '".date('Y-m-d\ 00:00:00',strtotime("-1 days"))."' and '".date('Y-m-d H:i:s')."'";

$result=$con->data_select($query);

if(isset($_POST['submit']))
{
  $from_time=$_POST['fromdate'];
  $to_time=$_POST['todate'];
  $query="SELECT * FROM consignment_details WHERE created_date between '".$from_time."' and '".$to_time."'";

  $result=$con->data_select($query);
  
}

$query="SELECT user_id,user_name FROM user_registration";
$result1=$con->data_select($query);


$_SESSION['success']="no";
if(isset($_FILES) && !empty($_FILES))
{
	
 if(is_array($_FILES)) {
  if(is_uploaded_file($_FILES['containerdetails']['tmp_name'])) {
    $sourcePath = $_FILES['containerdetails']['tmp_name'];
          $user="k";
		 
        $targetPath = "uploaded/container".$user.".csv";
        $i=0;
        if(move_uploaded_file($sourcePath,$targetPath)) 
        {
          $file = fopen("uploaded/container".$user.".csv","r");          
          while (($line = fgetcsv($file)) !== FALSE) {
           
           $sql_insert_product="INSERT INTO consignment_details(customer_name, account_number, cust_po_number, order_number, ordered_item_id, item_description, unit_selling_price, order_quantity_uom, ordered_quantity, amount, request_date, schedule_ship_date, order_date) VALUES ('".$line[0]."','".$line[1]."','".$line[2]."','".$line[3]."','".$line[4]."','".$line[5]."',".$line[6].",'".$line[7]."','".$line[8]."','".$line[9]."','".$line[10]."','".$line[11]."','".$line[12]."')";

            $result2=$con->data_insert($sql_insert_product);
          }
		  if($result2 >0)
		  {
			   $_SESSION['success']="Data has been uploaded!!!!!!";
               fclose($file);
		  }
          
          
        }
      }
      
    }
    header("Location:container_details.php");
}
include('admin_sidebar_header.php');
?>

  <!-- page content -->
           
		<div class="right_col" role="main">
                <div class="">
                   
                    
                    <div class="clearfix"></div>
                    
                    <div class="row">                 
                   
                        <div class="col-md-12 col-sm-12 col-xs-12">
                         
                            <div class="">                         
                                
                                <h2 style="color:#189B34;">Dashboard</h2>
                                <hr width=100%  align=left>
                                <form  class="form-vertical form-label-right" novalidate method="post" action="">
                                <div class="item form-group">
                                      <label class="control-label col-md-1 col-sm-1 col-xs-1" for="name">From<span class="required"></span>
                                      </label>
                                      <div class="col-md-3 col-sm-3 col-xs-3">
                                          <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" 
                                          data-validate-words="2" value="<?php echo $date1;?>" id="fromdate" name="fromdate" required type="datetime-local">
                                      </div>
                                  </div>
                                  <div class="item form-group">
                                      <label class="control-label col-md-1 col-sm-1 col-xs-1" for="name">To<span class="required"></span>
                                      </label>
                                      <div class="col-md-3 col-sm-3 col-xs-3">
                                          <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" 
                                          data-validate-words="2"value="<?php echo $date;?>" id="todate" name="todate" required type="datetime-local">
                                      </div>
                                  </div>
                                   <div class="item form-group">
                                     
                                      <div class="">
                                          <input  data-validate-length-range="6" 
                                          data-validate-words="2" class="btn btn-primary" name="submit" id="submit" value="Go" required type="SUBMIT">
                                      </div>
                                  </div>
                                
                                </form>
                                <hr width=100%  align=left>
                                <h2 style="color:#189B34;">Advanced Search</h2>
                                <form  class="form-vertical form-label-right" novalidate method="post" action="">
                                <div class="item form-group">                                      
                                      <div class="col-md-2 col-sm-2 col-xs-2">
                                           <label>Status</label></br>
                                          <select class="form-control">
                                                    <option>Choose option</option>
                                                    <option>Option one</option>
                                                    <option>Option two</option>
                                                    <option>Option three</option>
                                                    <option>Option four</option>
                                                </select>
                                      </div>
                                      <div class="col-md-2 col-sm-2 col-xs-2">
                                           <label>Entity</label></br>
                                          <select class="form-control">
                                                    <option>Choose option</option>
                                                    <option>Option one</option>
                                                    <option>Option two</option>
                                                    <option>Option three</option>
                                                    <option>Option four</option>
                                                </select>
                                      </div>
                                      <div class="col-md-2 col-sm-2 col-xs-2">
                                           <label>Customer</label></br>
                                           <select class="form-control">
                                                    <option>Choose option</option>
                                                    <option>Option one</option>
                                                    <option>Option two</option>
                                                    <option>Option three</option>
                                                    <option>Option four</option>
                                                </select>
                                      </div>
                                      <div class="col-md-2 col-sm-2 col-xs-2">
                                           <label>Po#</label></br>
                                           <select class="form-control">
                                                    <option>Choose option</option>
                                                    <option>Option one</option>
                                                    <option>Option two</option>
                                                    <option>Option three</option>
                                                    <option>Option four</option>
                                                </select>
                                      </div>
                                      <div class="col-md-2 col-sm-2 col-xs-2">
                                           <label>Product</label></br>
                                          <select class="form-control">
                                                    <option>Choose option</option>
                                                    <option>Option one</option>
                                                    <option>Option two</option>
                                                    <option>Option three</option>
                                                    <option>Option four</option>
                                                </select>
                                      </div>
                                        <div class="item form-group">
                                     <label>&nbsp;</label></br>
                                      <div class="col-md-2 col-sm-2 col-xs-2">
                                          <input  data-validate-length-range="6" 
                                          data-validate-words="2" class="btn btn-primary" name="submit" id="submit" value="Go" required type="SUBMIT">
                                      </div>
                                  </div>

                                  </div>
                                   
                                 
                                     
                                      
                                 
                                
                                </form>
                                <hr width=100%  align=left>
                                <div class="x_content">
                                    <table id="example" class="table table-striped responsive-utilities jambo_table">
                                        <thead>
                                            <tr class="headings">
                                             <input type="hidden" id="userId" value="<?php echo $user_id;?>" name="userId"/>
                                             
                                                <th>Consign Id</th>
                                                <th>Po Number</th>                                                  
                                                <th>Sailing Date</th>
                                                <th>Arrival Date at Destination</th>
                                                <th>Agent</th>
                                                <th>Require Date</th>
                                                <th>Remark</th>
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

                        													  echo "<tr class='even pointer'>";
                                                    echo "<td class='a-right a-right'>".$result[$key]['consignment_id']."</td>";
                        													  echo "<td class='a-right a-right'>".$result[$key]['cust_po_number']."</td>";

                                                                                                    
                                                    echo "<td class='a-right a-right'>".$result[$key]['sailing_date']."</td>";
                                                    echo "<td class='a-right a-right'>".$result[$key]['arrival_at_destination_date']."</td>";
                                                    echo "<td class='a-right a-right'>".$result[$key]['agent']."</td>";
                                                    echo "<td class='a-right a-right'>".$result[$key]['require_date']."</td>";
                                                    echo "<td class='a-right a-right'>".$result[$key]['remark']."</td>";
                                                    echo "<td class='a-right a-right'>".$result[$key]['status']."</td>";
                        													  echo '<td class="a-right a-right"><a href="edit_shiping_details.php?consignment_id='.$result[$key]['consignment_id'].'" class="btn btn-primary btn-xs" >Edit</a><a href="#test-popup" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-example-modal-lg" onclick="return selectdocument(12);">Document</a></td>';
                        													  echo "</tr>";
                        												} 
                        											  }
                        											?>
                                            
                                           
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

 
                    </div>
              </div>
                <div class="col-md-6 col-sm-6 col-xs-12">                     
                           
                            <div class="x_content">

                                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                     
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <button type="button" class="close" id="popupclosecross" data-dismiss="modal"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">Document Details</h4>
                                                <div class="x_content bs-example-popovers" id="pop">
                    
                                               </div>
                                            </div>
                                            <div class="modal-body">
                                         <form  class="form-vertical form-label-right" novalidate method="post" action="">
                                            <div class="item form-group">
                                                  <label class="control-label col-md-1 col-sm-1 col-xs-1" for="name">From<span class="required"></span>
                                                  </label>
                                                  <div class="col-md-3 col-sm-3 col-xs-3">
                                                      <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" 
                                                      data-validate-words="2"  id="fromdate" name="fromdate" required type="text">
                                                  </div>
                                              </div>
                                              <div class="item form-group">
                                                  <label class="control-label col-md-1 col-sm-1 col-xs-1" for="name">To<span class="required"></span>
                                                  </label>
                                                  <div class="col-md-3 col-sm-3 col-xs-3">
                                                      <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" 
                                                      data-validate-words="2"value="<?php echo $date;?>" id="todate" name="todate" required type="text">
                                                  </div>
                                              </div>
                                               <div class="item form-group">
                                                 
                                                  <div class="">
                                                      <input  data-validate-length-range="6" 
                                                      data-validate-words="2" class="btn btn-primary" name="submit" id="submit" value="Go" required type="SUBMIT">
                                                  </div>
                                              </div>
                                            
                                            </form>
										 
                                        </div>
                                    </div>
                                </div>
                            </div>                       
                    </div>
<!-- popup box css   -->                      
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://dimsemenov-static.s3.amazonaws.com/dist/jquery.magnific-popup.min.js'></script>
<script src="js1/index.js"></script>  
        <!-- end popup box css   -->  
           
<?php
  include('footer.php');
  ob_end_flush();
?>