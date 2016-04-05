<?php
ob_start();
include('admin_sidebar_header.php');
include('../classes/functions.php');
session_start();
$con=new functions();
$user_name=$_SESSION['user_name'];

if($user_name!="")
{
	$query="SELECT user_registration.user_id,    user_registration.first_name,user_registration.last_name,user_registration.user_name,user_registration.address,user_registration.type,user_registration.status, entity.entity_name
	FROM entity
	INNER JOIN user_registration
	ON entity.entity_id=user_registration.entity_id;";
	$result=$con->data_select($query);

	
	  $query="SELECT entity_id, entity_name FROM entity";
	  $result1=$con->data_select($query);  
	  $options ="";  
		foreach($result1 as $key => $val){   
			  $options.="<option value=".$result1[$key]['entity_id'].">".$result1[$key]['entity_name']."</option>";												  
		  
	   }
	  $query="SELECT role_id, role_name FROM user_role";
	  $result_role=$con->data_select($query);
	  $role_options ="";
	  $role_array =array();
	   foreach($result_role as $key => $val){   
			  $role_options.="<option value=".$result_role[$key]['role_id'].">".$result_role[$key]['role_name']."</option>";												              $role_array[$result_role[$key]['role_id']] = $result_role[$key]['role_name'];
		  
	   }
	
}
else
{
	header('Location:admin_login.php');
}



?>
<script type="text/javascript">
  function showdocument(user_id)
	{
		
		
		$.ajax({
			  type:"POST",
			  url:"ajax_service.php",
			  data:"user_id="+user_id+"&action=userdetails",
			  dataType:"json",
			  success: function(data)
			  {
				 console.log(data);
				 $("#userid").val(data[0].user_id);
				 $("#username").val(data[0].user_name);
				 $("#passsword").val(data[0].password);
				 $("#firstname").val(data[0].first_name);
				 $("#lastname").val(data[0].last_name);
				 $("#address").val(data[0].address);
				 $("#role_user").val(data[0].type);
				 $("#entity_id").val(data[0].entity_id);
				 
				 $("#status").val(data[0].status);
				 
			    //alert(data[0].entity_id);
			
			  }
				
			});
	}
	
	 function updateuser()
	 {
		 $('#ajax_div').html('<img src="images/loader.gif" />');
		 var user_id=$("#userid").val();
		 var user_name=$("#username").val();
		 var password=$("#passsword").val();
		 var first_name=$("#firstname").val();
		 var last_name=$("#lastname").val();
		 var address= $("#address").val();
		 var type=$("#role_user").val();
		 var entity_id=$("#entity_id").val();
		 var status=$("#status").val();
		 alert(user_id);
		 
		$.ajax({
			  type:"POST",
			  url:"logistics/ajax_service.php",
			  data:"user_id="+user_id+"&user_name="+user_name+"&password="+password+"&first_name="+first_name+"&last_name="+last_name+"&address="+address+
			  "&type="+type+"&entity_id="+entity_id+"&status="+status+"&action=updateuser",
			 
			  success: function(data)
			  {
				 
			   // alert(data);
			     $('#ajax_div').hide(3000);
	             $("#pop").html('<div class="alert alert-success" role="alert" align="center"><button type="button" class="close" data-dismiss="alert"                 aria-label="Close"><span aria-hidden="true">×</span></button>You have successfully update User</div>');
			    	var explode = function(){					
				     location.reload();
					};
					setTimeout(explode, 3000);
									
			
				 
			  }
			  
				
			});
				
			//location.reload();
	}
	 function deleteuser(user_id)
	 {
		 $('#ajax_div_delete').html('<img src="images/loader.gif" />');
		// var user_id=$("#userid").val();
		
		 
		$.ajax({
			  type:"POST",
			  url:"logistics/ajax_service.php",
			  data:"user_id="+user_id+"&action=deleteuser",
			 
			  success: function(data)
			  {
				 
			   $('#ajax_div_delete').hide(3000);
	             $("#delete_messag").html('<div class="alert alert-success" role="alert" align="center"><button type="button" class="close" data-dismiss="alert"                 aria-label="Close"><span aria-hidden="true">×</span></button>You have successfully Delete User</div>');
			    	var explode = function(){
					  location.reload();
					};
					setTimeout(explode, 2000);
									
			
				 
			  }
			  
				
			});
				
			//location.reload();
	}
	
	

</script>

<div class="right_col" id="show" role="main">
                <div class="">
                   
                    
                    <div class="clearfix"></div>
                    
                    <div class="row">
                 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                         
                            <div class="x_panel">
                             <div id="ajax_div_delete"></div>
                             <div id="delete_messag"></div>
                                <h2>User Details</h2>
                                 <div class="x_title"></div>
                                <div class="x_content">
                                  <h1 align="left"><a href="user_registration.php" class="btn btn-primary btn-xs">Add User</a></h1>
                                  <table id="example" class="table table-striped responsive-utilities jambo_table">
                                        <thead>
                                            <tr class="headings">
                                             <input type="hidden" id="userId" value="<?php echo $user_name;?>" name="userId" />
                                               <!-- <th>
                                                    <input type="checkbox" class="tableflat">
                                                   
                                                </th>-->
                                                <th>Sr_no</th>
                                             
                                                <th>first_name</th>
                                                <th>last_name</th>
                                                <th>user_name</th>
                                            
                                                <th>address</th>
                                                <th>type</th> 
                                                <th>status</th>
                                                <th>entity_name</th>
                                                <th>Action</th>
                                            
                                            </tr>
                                        </thead>

                                        <tbody>
                                         <?php
											if($result!="no")
											 {
												 
												foreach($result as $key => $val)
												{
													  $sr = $key +1;
													echo "<tr>";
													echo "<td>".$sr."</td>";
													 foreach($result[$key] as $key2 => $val2)
													 {
														 if($key2 =="user_id"){
															  continue;
															 }
													     if($key2=="type"){
															  echo "<td>".$role_array[$val2]."</td>";
															 }
													      else{
															   echo "<td>".$val2."</td>";
															  }		 		 
														
													 }
													  echo '<td><a href="#test-popup" class="btn btn-primary btn-xs"  data-toggle="modal" data-target=".bs-example-modal-lg" onclick="return showdocument('.$result[$key]["user_id"].');">Edit</a><a href="#test-popup" class="btn btn-primary btn-xs" onclick="deleteuser('.$result[$key]["user_id"].')">Delete</a></td>';
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
										 <div id="ajax_div" align="center"></div>
                                          <div class="x_content bs-example-popovers" id="pop">
                    
                                               </div>

                                            <div class="modal-header">
                                                <button type="button" class="close" id="popupclosecross" data-dismiss="modal"><span aria-hidden="true">×</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">Document Details</h4>
                                                <div class="x_content bs-example-popovers" id="pop">
                    
                                               </div>
                                            </div>
                                            <div class="modal-body">
                                                     <form class="form-horizontal form-label-left" novalidate method="post" action="">
        
                                                
                                                <!--<span class="section">Personal Info</span>-->
        										 <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">User Id<span class="required" 
                                                    id="errusername"></span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <span class="required" id="errusername"></span>
                                                        <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                        data-validate-words="2" name="userid" id="userid" placeholder="" readonly="readonly" required type="text" 
                                                        onChange="return formvalidation();">
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">User Name<span class="required" 
                                                    id="errusername"></span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <span class="required" id="errusername"></span>
                                                        <input class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                        data-validate-words="2" name="username" id="username" placeholder="" required type="text" 
                                                        onChange="return formvalidation();">
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Password<span class="required"></span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                        data-validate-words="2" name="password" id="passsword" placeholder="" required type="text">
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">First Name<span class="required"></span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                        data-validate-words="2" name="firstname" id="firstname" placeholder="" required type="text">
                                                    </div>
                                                </div>
                                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Last Name<span class="required"></span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                        data-validate-words="2" name="lastname" id="lastname" placeholder="" required type="text">
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Address<span class="required"></span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input  class="form-control col-md-7 col-xs-12" data-validate-length-range="6" 
                                                        data-validate-words="2" name="address" id="address" placeholder="" required type="text">
                                                    </div>
                                                </div>
                                                 <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Select Role<span class="required"></span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <select name="role_user" id="role_user" class="form-control col-md-7 col-xs-12" 
                                                    data-validate-length-range="6" data-validate-words="6">
                                                       <option value="" selected>Select </option>                                              
                                                        <?php 
                                                          echo $role_options;
                                                      ?>
                                                       
                                                    </select>
                                                    
                                                    </div>
                                                </div>    
                                                 <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Select Entity Name<span class="required"></span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <select name="entity_id" id="entity_id" class="form-control col-md-7 col-xs-12" 
                                                    data-validate-length-range="6" data-validate-words="6">
                                                       <option value="" selected>Select </option>
                                                      <?php 
                                                          echo $options;
                                                      ?>
                                                      
                                                    </select>
                                                    
                                                    </div>
                                                </div>    
                                                 <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Status<span class="required"></span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <select name="status" id="status" class="form-control col-md-7 col-xs-12" 
                                                    data-validate-length-range="6" data-validate-words="2">
                                                       <option value="" selected>Select Status</option>
                                                       <option value="Active">Active</option>
                                                       <option value="Inactive">Inactive</option>
                                                    </select>
                                                    
                                                    </div>
                                                </div>                          
                                                                              
                                   
                                                <div class="ln_solid"></div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-3">
                                                        <!--<button type="submit" class="btn btn-primary">Cancel</button>-->
                                                       <h1 align="center"> <input type="button" id="add"  name="add" onclick="return updateuser();" value="Update" class="btn btn-success"/></h1>
                                                    </div>
                                                </div>
                                            </div>    
                                          </form>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>                       
                    </div>
<!-- popup box css   -->   
              
<?php
  include('footer.php');
  ob_end_flush();
?>