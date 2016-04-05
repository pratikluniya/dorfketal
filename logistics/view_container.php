<?php
ob_start();
include('../classes/functions.php');
$con=new functions();
$result=$con->data_select("SELECT dispatch_id, transaction_number, start_address, destination, status FROM dspatch_details");

  include('user_sidebar_header.php');
?>
<script>
function selectDispatch(dispatchId)
 {
	
	 $.ajax({
		type:"POST",
		url:"logistics/action_ajax.php",
		data:"dispatch_id="+dispatchId+"&action=selectDispatch",
		dataType:"JSON",
		success: function(data)
			{
				//alert(data[0].dispatch_id);
				if(data == "no record found")
				{
					alert("no record found");
				}
				$("#dispatchId").val(data[0].dispatch_id);
				/*$("#firstname1").val(data[0].First_name);
				$("#mobile1").val(data[0].Mobile);
				$("#age1").val(data[0].Age);
				$("#cliniclocation").val(data[0].Clinic_location);*/
				

				
		    }
		});
 }
function updateroute()
{
	    var routename=$("#routename").val();
		var dispatchId=$("#dispatchId").val();
		
	    $.ajax({
	
			type:"POST",
			url:"action_ajax.php",
			data:"route_name="+routename+"&dispach_id="+dispatchId+"&action=insert",                          
			success: function(data)
			{
				//alert(data);
				if(data == "success")
				{
					
					alert("Updated successfully");
					
					location.reload();
				}
				else
				{
					alert("route name not Updated");
				}
				
			}
			
			
		});
}
function updatestaus()
{


	    var routename=$("#routename").val();
		
		var dispatchId=$("#dispatchId").val();
		
		var status=$("#status").val();		
	    $.ajax({	
			type:"POST",
			url:"action_ajax.php",
			data:"route_name="+routename+"&dispach_id="+dispatchId+"&status="+status+"&action=updateDestination",                          
			success: function(data)
			{
				
				alert(data);
				console.log(data);
				
			}
			
			
		});
}
function selectuser()
{


	    var routename=$("#routename").val();
		
		var dispatchId=$("#dispatchId").val();
		
		var status=$("#status").val();		
	    $.ajax({	
			type:"POST",
			url:"action_ajax.php",
			data:"&action=selectuser",
			dataType:"JSON",
			                          
			success: function(data)
			{
				
				alert(data);
				$("#")
				console.log(data);
				
			}
			
			
		});
}

</script>
   <link rel='stylesheet prefetch' href='http://dimsemenov-static.s3.amazonaws.com/dist/magnific-popup.css'>

<style>
.textbox
{
	width:100%;
}

/* text-based popup styling */
.white-popup {
  position: relative;
  background: #FFF;
  padding: 25px;
  width: auto;
  max-width: 400px;
  margin: 0 auto;
}



====== Zoom-out effect ======

*/
.mfp-zoom-out {
  /* start state */
  /* animate in */
  /* animate out */
}
.mfp-zoom-out .mfp-with-anim {
  opacity: 0;
  transition: all 0.3s ease-in-out;
  transform: scale(1.3);
}
.mfp-zoom-out.mfp-bg {
  opacity: 0;
  transition: all 0.3s ease-out;
}
.mfp-zoom-out.mfp-ready .mfp-with-anim {
  opacity: 1;
  transform: scale(1);
}
.mfp-zoom-out.mfp-ready.mfp-bg {
  opacity: 0.8;
}
.mfp-zoom-out.mfp-removing .mfp-with-anim {
  transform: scale(1.3);
  opacity: 0;
}
.mfp-zoom-out.mfp-removing.mfp-bg {
  opacity: 0;
}

/* 

====== "Hinge" close effect ======

*/
@keyframes hinge {
  0% {
    transform: rotate(0);
    transform-origin: top left;
    animation-timing-function: ease-in-out;
  }
  20%, 60% {
    transform: rotate(80deg);
    transform-origin: top left;
    animation-timing-function: ease-in-out;
  }
  40% {
    transform: rotate(60deg);
    transform-origin: top left;
    animation-timing-function: ease-in-out;
  }
  80% {
    transform: rotate(60deg) translateY(0);
    opacity: 1;
    transform-origin: top left;
    animation-timing-function: ease-in-out;
  }
  100% {
    transform: translateY(700px);
    opacity: 0;
  }
}
.hinge {
  animation-duration: 1s;
  animation-name: hinge;
}

.mfp-with-fade .mfp-content, .mfp-with-fade.mfp-bg {
  opacity: 0;
  transition: opacity .5s ease-out;
}
.mfp-with-fade.mfp-ready .mfp-content {
  opacity: 1;
}
.mfp-with-fade.mfp-ready.mfp-bg {
  opacity: 0.8;
}
.mfp-with-fade.mfp-removing.mfp-bg {
  opacity: 0;
}




    </style>

    
        <script src="js1/prefixfree.min.js"></script>
    

  <!-- page content -->
           
		<div class="right_col" role="main">
                <div class="">
                    
                    <div class="clearfix"></div>

                    <div class="row">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>Customer Details</h2>
                                   
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
                                                <th>Sr_no</th>
                                                <th>Dispatch_id</th>
                                                <th>Transaction_number</th>
                                                <th>Start_address</th>
                                                <th>Destination_address</th>
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
													 echo "<td>".$key."</td>";
													 foreach($result[$key] as $key2 => $val2)
													 {
														 echo "<td>".$val2."</td>";
													 }
													  echo "<td><a href='#test-popup' class='btn btn-primary btn-xs hinge' onclick='selectDispatch(".$result[$key]['dispatch_id'].")'>Update</a>
																<a class='btn btn-primary btn-xs hinge' href='#test-popup1'   onclick='return selectDispatch(".$result[$key]['dispatch_id'].")'>Update Status</a>
													  </td>";
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
<!-- popup box css   -->            
<div id="test-popup" class="white-popup mfp-with-anim mfp-hide">
  <form>
   
   <input type="hidden"  name="dispatchId" id="dispatchId"/>
   <label>Route Name</label>
   <input type="text" name="routename" id="routename"/>
   <input type="button" value="submit" id="submit" name="submit" onclick='return updateroute();' class="js-open-modal btn"/>
   
  </form>
 </div>
 <div id="test-popup1" class="white-popup mfp-with-anim mfp-hide">
  <form>
   
   <input type="hidden"  name="dispatchId" id="dispatchId"/>
   <label>Route Name</label>
   <input type="text" name="routename" id="routename"/>
   <label>Select Status</label>
   <select name="status" id="status">
      <option>Select Status</option>
      <option value="Delivery">Delivery</option>
      <option value="Pending">Pending</option>
      <option value="Return">Return</option>
   </select>
   <input type="button" value="submit" id="submit" name="submit" onclick='return updatestaus();' class="js-open-modal btn"/>
  
   
  </form>
 </div>            
       <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://dimsemenov-static.s3.amazonaws.com/dist/jquery.magnific-popup.min.js'></script>

        <script src="js1/index.js"></script>  
        <!-- end popup box css   -->  
           
<?php
  include('footer.php');
  ob_end_flush();
?>