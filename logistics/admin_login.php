<?php  
	include('class/functions.php');
	$con = new functions();
	session_start();
	if(isset($_POST['submit']))
	{
		$user_name = $_POST['username'];
		$password = $_POST['password'];
		$qry="SELECT * FROM user_registration WHERE email_id='$user_name' AND password='$password'";
		/*echo $qry;
        exit;*/
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


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Logistics</title>

    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">


    <script src="js/jquery.min.js"></script>

    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>

<body style="background:#F7F7F7;">
    
    <div class="">
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper">
            <div id="login" class="animate form">
                <section class="login_content">
                    <form method="post" action="">
                        <h1>Logistics Portal</h1>
                        <div>
                            <input type="text" class="form-control" placeholder="Username" name="username" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Password" name="password" required="" />
                        </div>
                        <div>
                           <!-- <a class="btn btn-default submit" href="index.html">Log in</a>-->
                            <input type="submit" name="submit" class="btn btn-default submit" value="Log in"/>
                            <a class="reset_pass" href="#"></a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">

                            <p class="change_link">
                                <a href="#toregister" class="to_register"></a>
                            </p>
                            <div class="clearfix"></div>
                            <br/>
                            <div>
                               
                            </div>
                        </div>
                    </form>
                    <!-- form -->
                </section>
                <!-- content -->
            </div>
            <div id="register" class="animate form">
                <section class="login_content">
                    <form>
                        <h1>Create Account</h1>
                        <div>
                            <input type="text" class="form-control" placeholder="Username" required="" />
                        </div>
                        <div>
                            <input type="email" class="form-control" placeholder="Email" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Password" required="" />
                        </div>
                        <div>
                            <a class="btn btn-default submit" href="index.html">Submit</a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">

                            <p class="change_link">Already a member ?
                                <a href="#tologin" class="to_register"> Log in </a>
                            </p>
                            <div class="clearfix"></div>
                            <br />
                            <div>
                                <h1><i class="fa fa-paw" style="font-size: 26px;"></i> Tracking System</h1>

                                <p></p>
                            </div>
                        </div>
                    </form>
                    <!-- form -->
                </section>
                <!-- content -->
            </div>
        </div>
    </div>

</body>

</html>