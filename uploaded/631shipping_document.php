<?php

ob_start();
include('admin_sidebar_header.php');
include('class/functions.php');
$con=new functions();
date_default_timezone_set("Asia/Kolkata"); 
$date4=date('Y-m-d H:i:s');


  $ldapserver = 'dorfketal.local:389';
  $ldapuser      = 'CN=maspl admin  ,DC=DORFKETAL,DC=local';  
  $ldappass     = 'password1!';
  $ldaptree    = "dc=dorfketal,dc=local";
  $ldaprdn = 'dorfketal' . "\\" .'mspladmin';
  $group=array(); 
  // connect 
  $ldapconn = ldap_connect($ldapserver) or die("Could not connect to LDAP server.");
  ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
  ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
  if($ldapconn) {
    // binding to ldap server
    $ldapbind = ldap_bind($ldapconn , $ldaprdn , $ldappass) or die ("Error trying to bind: ".ldap_error($ldapconn));
    // verify binding
    if ($ldapbind) {
      $query = "(&(objectCategory=user))";
      //$query="(&(objectcategory=group)(name=ASC))";
      $result = ldap_search($ldapconn,$ldaptree, $query) or die ("Error in search query: ".ldap_error($ldapconn));
      ldap_sort($ldapconn, $result, "objectCategory");
      $data = ldap_get_entries($ldapconn, $result);
      for($i=0;$i<$data[count];$i++)
      {
       /*  echo "<pre>";
        print_r($data);
        exit;*/
        //$groupNameTemp=$data[$i][displayname][0];
        //$groupNameTemp=$data[$i][title][0];
        //$group[$i]=array('GroupName'=> $groupNameTemp);
        $group[$i]['name'] = $data[$i][displayname][0];
        $group[$i]['user_name'] = $data[$i][samaccountname][0];
        $group[$i]['mail'] = $data[$i][mail][0];
        /*$group[$i]['department'] = $data[$i][department][0];        
        $group[$i]['proxyaddress'] = $data[$i][proxyaddress][0];
        $group[$i]['mail'] = $data[$i][mail][0];
        $group[$i]['position'] = $data[$i][title][0];
        $group[$i]['managed'] = $data[$i][manager][0];*/
      }
     

       $options ="";
      foreach ($group as $key => $value) {
        if($group[$key]['name'] != ""){
             $options .="<option value='".$group[$key]['mail']."-".$group[$key]['user_name'] ."'>".$group[$key]['name'].  "</option>";
        }
     
        
      }

      //echo "<pre>";
      //$group = array_unique($group);
     // print_r($options);
      //echo json_encode($group);
    } 
    else 
    {
      echo "LDAP bind failed...";
    }
  }
  ldap_close($ldapconn);

$query="SELECT * FROM user_registration";

$result=$con->data_select($query);

$query1="SELECT * FROM org_map";
$result2=$con->data_select($query1);
/*echo"<pre>";
print_r($result2);
exit;*/
$entity="";
foreach ($result2 as $key => $value) {

  $entity.="<input type='checkbox' name='products[]' value='".$result2[$key]['org_id']."'/>&nbsp;" .$result2[$key]['name']."<br>";

  
}



?>


  <!-- page content -->
           
 <div class="right_col" role="main">
    <div class="">
       
        
        <div class="clearfix"></div>
        
        <div class="row">                 
       
            <div class="col-md-12 col-sm-12 col-xs-12">
             
                <div class="">                         
                    
                    <h2 style="color:#189B34;">User Management</h2>
                    <hr width=100%  align=left>
                    <form  class="form-vertical form-label-right" id ="frm_use_role"  method="" action="">
                    <div class="item form-group">
                          <label class="control-label col-md-1 col-sm-1 col-xs-1" for="name">User<span class="required"></span>
                          </label>
                          <div class="col-md-3 col-sm-3 col-xs-3">
                               <select class="form-control" id ="user" name ="user">
                                                         <?php  echo  $options; ?>
                                                      </select>
                          </div>
                      </div>
                     
                       <div class="item form-group">
                         
                          <div class="col-md-7 col-sm-1 col-xs-1">
                          <label class="control-label col-md-2 col-sm-1 col-xs-1" for="name">or Create User<span class="required"></span>
                          </label>
                              <a href="user_registration.php" class="btn btn-primary">Create User</a>
                              <!-- <input  data-validate-length-range="6" 
                              data-validate-words="2" class="btn btn-primary" name="consignsubmit" id="consignsubmit" value="Go" required type="SUBMIT"> -->
                          </div>
                      </div>
                    
                   
                    <hr width=100%  align=left>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel" style="overflow-y: scroll; height: 235px;">
                            <div class="x_title">
                                <h2>Entity</h2>
                               
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">                               
                            <?php echo $entity; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel" style="overflow-y: scroll;height: 235px;">
                            <div class="x_title">
                                <h2>Role</h2>
                                
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="bs-example" data-example-id="simple-jumbotron">
                                    <input type="radio" name="role" value="1" checked>Administrator
                                      <br>
                                    <input type="radio" name="role" value="2">Manager
                                     <br>
                                    <input type="radio" name="role" value="3">Customer
                                     <br>
                                    <input type="radio" name="role" value="4">User
                                     <br>
                                    <input type="radio" name="role" value="5">Guest
                                     <br>
                                    <input type="radio" name="role" value="6">Document Uploader
                                     <br>
                                    <input type="radio" name="role" value="7">Outsourced(Only Mail Alert)
                                </div>

                            </div>
                        </div>
                    </div>



                     <div class="item form-group">
                          
                          <div class="col-md-3 col-sm-3 col-xs-3">
                               <input type ="button" id ="btn_user_add"  class ="btn btn-primary" name ="btn_user_add" value="Add User">
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
                                 
                                    <th>No </th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Delete</th>
                                                                                  
                                
                                </tr>
                            </thead>

                            <tbody>
                             <?php
                                  if($result!="no")
                                   {
                                     $i=1;
                                    foreach($result as $key => $val)
                                    {

                                      echo "<tr class='even pointer'>";
                                      echo "<td class='a-right a-right'>".$i."</td>";
                                      echo "<td class='a-right a-right'>".$result[$key]['created_date']."</td>";
                                      echo "<td class='a-right a-right'>".$result[$key]['first_name'].$result[$key]['last_name']."</td>";
                                      echo "<td class='a-right a-right'>".$result[$key]['email_id']."</td>";
                                      echo '<td class="a-right a-right"> <button type="button" class="btn btn-primary" onclick="return showdocument('.$result[$key]['user_id'].') ">Delete</button> </td>';

                                      echo "</tr>";
                                      $i++;
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
             



<script>





$(function(){  

     $("#btn_user_add").click(function(){

     var kk =  $("#frm_use_role").serialize();

     $.ajax({
              url: "ajax_service.php",
              data : "data="+kk+"&action=user_role_add",
              success:function(data){    

                 alert(data);
                 //location.reload();
              }
            });
   


     });
});


</script>
<?php
 include("dash_pop.php");
  include('footer.php');
  ob_end_flush();
?>