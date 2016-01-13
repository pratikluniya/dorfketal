<?php 
 //ob_start();
 include_once('class/functions.php');
 

 $con= new functions();
 $_SESSION['success']="no";
  $query="SELECT * FROM org_map";
  $result1=$con->data_select($query);  
  $options ="";  
    foreach($result1 as $key => $val){   
		  $options.="<option value=".$result1[$key]['org_id'].">".$result1[$key]['name']."</option>";												  
	  
   }
	 if(isset($_POST['add']))
		{
						
			$user_name=$_POST['username'];
			$password=$_POST['password'];
			$first_name = $_POST['firstname'];
			$last_name=$_POST['lastname'];			
			$address=$_POST['address'];
			$entity_id=$_POST['entity_id'];	
			$role_user=$_POST['role_user'];
		
      
      $entity=implode(",", $entity_id);

				
				$sql="INSERT INTO user_registration(first_name, last_name, email_id, password, address, role_id, entity_id)
				 VALUES ('$first_name','$last_name','$user_name','$password','$address','$role_user','$entity')";				
				$result=$con->data_insert($sql);				
				if($result > 0)
				{
					$_SESSION['success']="Data has been Added!!!!!";
					header('Location:create_user.php');
					
				}
				else
			    {
				  	$_SESSION['success']="no";	
			    }
	
		}

  include('admin_sidebar_header.php');
?>
<script>
  $(document).ready(function(){
	    $(".alert").fadeOut(3000);
	  });
  
</script>   
<script src="js1/prefixfree.min.js"></script>
<script>
$(function(){
   $("#kkk_msg").fadeOut(3000);
});
</script> 

  <!-- page content -->
           
		<div class="right_col" role="main">
                <div class="">
                   
                    
                    <div class="clearfix"></div>
                    
                    <div class="row">
                  <?php 
                     if($_SESSION['success'] !="no"){
                      echo "<h3 id ='kkk_msg'>".$_SESSION['success']."</h3>";
                     }

                   ?>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                         
                            <div class="x_panel">
                                                           
                                <h2>User Registration</h2>  
                                                               
                                <div class="x_content">
                                <div class="x_title"></div>
                                   <form class="form-horizontal form-label-left" novalidate method="post" action="">

                                        
                                        <!--<span class="section">Personal Info</span>-->

                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email Id<span class="required" 
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
                                               <option value="1">Adminstrator</option>
                                               <option value="2">customer</option>
                                               <option value="3">Manager</option>
                                               <option value="4">User</option>
                                               <option value="5">Guest</option>
                                               <option value="6">Document Uploader</option>
                                               <option value="7">Outsourced</option>
                                               
                                            </select>
                                            
                                            </div>
                                        </div>    
                                         <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Select Entity Name<span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="entity_id[]" id="entity_id" class="form-control col-md-7 col-xs-12" 
                                            data-validate-length-range="6" data-validate-words="6" multiple="multiple">
                                               <!-- <option value="" selected>Select </option> -->
                                              <?php 
                          											      echo $options;
                          											  ?>
                                              
                                            </select>
                                            
                                            </div>
                                        </div>    
                                                                  
                                        </div>                                 
                           
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <!--<button type="submit" class="btn btn-primary">Cancel</button>-->
                                               <h1 align="center"> <input type="submit" id="add"  name="add" value="submit" class="btn btn-success"/></h1>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>

<?php
  include('footer.php');
//  ob_end_flush();
?>