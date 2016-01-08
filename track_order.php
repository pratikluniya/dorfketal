<?php  
  include('classes/functions.php');
  $con = new functions();
  session_start();
  if(isset($_POST['submit']))
  {
    $user_name = $_POST['username'];
    $password = $_POST['password'];
    $qry="SELECT * FROM user_registration WHERE email_id='$user_name' AND password='$password'";
    echo $qry;
        exit;
    $result=$con->data_select($qry);
     //   echo $result[0]['role_id'];
     
    if($result!="no")
    {   
            if($result[0]['role_id'] == 2 )
            {  
                 $_SESSION['user_id']=$result[0]['user_id'];
                 $_SESSION['email_id']=$user_name;
                 $_SESSION['first_name']=$result[0]['first_name'];
                 $_SESSION['role_id']=$result[0]['role_id'];
                 $_SESSION['entity_id']=$result[0]['entity_id'];
                 header('Location: customer_dashboard.php');
            }
            elseif ($result[0]['role_id'] == 4) {

                 $_SESSION['user_id']=$result[0]['user_id'];
                 $_SESSION['email_id']=$user_name;
                 $_SESSION['role_id']=$result[0]['role_id'];
                 $_SESSION['first_name']=$result[0]['first_name'];
                 $_SESSION['entity_id']=$result[0]['entity_id'];
                 header('Location: user_dashboard.php');
            }
            elseif($result[0]['role_id'] == 3)
            {
                 $_SESSION['user_id']=$result[0]['user_id'];
                 $_SESSION['email_id']=$user_name;
                 $_SESSION['role_id']=$result[0]['role_id'];
                 $_SESSION['entity_id']=$result[0]['entity_id']; 
                 $_SESSION['first_name']=$result[0]['first_name'];
                 header('Location: manager_dashboard.php');
            }
             elseif($result[0]['role_id'] == 5)
            {
                 $_SESSION['user_id']=$result[0]['user_id'];
                 $_SESSION['email_id']=$user_name;
                 $_SESSION['role_id']=$result[0]['role_id'];    
                 $_SESSION['entity_id']=$result[0]['entity_id']; 
                 $_SESSION['first_name']=$result[0]['first_name'];
                 header('Location: guest_dashboard.php');
            }
             elseif($result[0]['role_id'] == 6)
            {
                 $_SESSION['user_id']=$result[0]['user_id'];
                 $_SESSION['email_id']=$user_name;
                 $_SESSION['role_id']=$result[0]['role_id'];    
                 $_SESSION['entity_id']=$result[0]['entity_id']; 
                 $_SESSION['first_name']=$result[0]['first_name'];
                 header('Location: document_uploader_dashboard.php');
            }
            else
            {
                $_SESSION['user_id']=$user_id;
                $_SESSION['customer_num']=$result[0]['email_id'];
                $_SESSION['role_id']=$result[0]['role_id'];
                $_SESSION['email_id']=$user_name;
                $_SESSION['first_name']=$result[0]['first_name'];
                header('Location: dashboard.php');
            }
         
      
    }
    else
    {
      echo '<div class="alert-box error" style=""> Invalid Username Or Password.';
      echo '</div>';
    }
  }
  
?>

<section class="login_content">
                    <form >
                        <h1>Logistics Portal</h1>
                        <div>
                            <input type="text" class="form-control" placeholder="Username" name="username" id="username" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Password" name="password" id="passss"required="" />
                        </div>
                        <div>
                           <!-- <a class="btn btn-default submit" href="index.html">Log in</a>-->
                            <input type="button" name="submit" id="login_btn" class="btn btn-default submit" value="Log in"/>
                            
                        </div>
                       
                        
                    </form>
                    <!-- form -->
                </section>


    
   