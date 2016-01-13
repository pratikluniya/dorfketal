<?php 
  session_start();
  if($_SESSION['email_id'] ==""){
  header('Location: index.php');
  
}
$role_id=$_SESSION['role_id'];
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
    <link rel="stylesheet" type="text/css" href="css/maps/jquery-jvectormap-2.0.1.css" />
    <link href="css/icheck/flat/green.css" rel="stylesheet" />
    <link href="css/floatexamples.css" rel="stylesheet" type="text/css" />
     <link href="css/datatables/tools/css/dataTables.tableTools.css" rel="stylesheet">

    <script src="js/jquery.min.js"></script>
    <script src="js/nprogress.js"></script>
    <script src="js/sidebar_desable.js"></script>
    <script>
        NProgress.start();
    </script>
    

</head>


<body class="nav-sm" style="overflow-y: scroll;">

    <div class="container body">


        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">                         
                         <a href="container_details.php" class="site_title"><span></span></a> 
                    </div>
                    <div class="clearfix"></div>
                    <!-- menu prile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <!--<img src="images/img.jpg" alt="..." class="img-circle profile_img">-->
                        </div>
                        <div class="profile_info">
                         <!-- <span>Welcome,</span> -->
                            <h2><?php/* echo $_SESSION['first_name'];*/?></h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <h3></h3>
                            <ul class="nav side-menu">
                            <?php 
                             if($role_id == 2)
                             {
                                echo '<li><a style="color:23B944;"><i class="fa fa-home"></i ><a href="customer_dashboard.php">Customer Dashboard</a> <span class="fa fa-chevron-down"></span></a>
                                
                                </li>';
                             }
                             elseif ($role_id == 3) {
                                echo '<li><a style="color:23B944;"><i class="fa fa-home"></i ><a href="manager_dashboard.php">Manager Dashboard</a> <span class="fa fa-chevron-down"></span></a>
                                </li>';
                             }
                             elseif ($role_id == 4) {
                                echo '<li><a style="color:23B944;"><i class="fa fa-home"></i ><a href="user_dashboard.php">User Dashboard</a> <span class="fa fa-chevron-down"></span></a>
                                </li>';
                             }
                             elseif ($role_id == 5) {
                                echo '<li><a style="color:23B944;"><i class="fa fa-home"></i ><a href="guest_dashboard.php">Guest Dashboard</a> <span class="fa fa-chevron-down"></span></a>
                                </li>';
                             }
                             elseif ($role_id == 6) {
                                echo '<li><a style="color:23B944;"><i class="fa fa-home"></i ><a href="document_uploader_dashboard.php">Document Uploader Dashboard</a> <span class="fa fa-chevron-down"></span></a>
                                </li>';
                             }
                             else
                             {
                                echo '<li><a style="color:23B944;"><i class="fa fa-home"></i ><a href="dashboard.php"> Dashboard</a> <span class="fa fa-chevron-down"></span></a>
                                  
                                </li>';
                             }
                            ?>
                                
                               
                            </ul>
                        </div>
                        <?php
                        if($role_id ==1)
                        {

                            echo ' <div class="menu_section">
                                        <h3></h3>
                                        <ul class="nav side-menu">

                                            <li><a style="color:23B944;"><i class="glyphicon glyphicon-user"></i ><a href="create_user.php">Create User</a> <span class="fa fa-chevron-down"></span></a>
                                              
                                            </li>
                                           
                                        </ul>
                                    </div>';
                            echo ' <div class="menu_section">
                                        <h3></h3>
                                        <ul class="nav side-menu">

                                            <li><a style="color:23B944;"><i class="glyphicon glyphicon-user"></i ><a href="tracking_url.php">Tracking Url</a> <span class="fa fa-chevron-down"></span></a>
                                              
                                            </li>
                                           
                                        </ul>
                                    </div>';
                        }
                        ?>
                       
                      
                            </ul>
                        </div>

                    </div>
                    
                </div>
            </div>

          <!-- top navigation -->
            <div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                 <li> <a href="logout.php"><i class="fa fa-sign-out pull-right"></i>Log Out</a></li>
                                <a href="javascript:;" class="user-profile dropdown-toggle"  aria-expanded="false">
                                   
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    <li><a href="javascript:;"></a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="badge bg-red pull-right"></span>
                                            <span></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;"></a>
                                    </li>
                                    <li><a href=""><i class="fa fa-sign-out pull-right"></i> </a>
                                    </li>
                                </ul>
                            </li>

                            <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number"  aria-expanded="false">
                                    <i class=""></i>
                                    <span class=""><!-- AMOL KASKAR --></span>
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
                                    <li>
                                        <a>
                                            <span class="image">
                                        <img src="" alt="Profile Image" />
                                    </span>
                                            <span>
                                        <span></span>
                                            <span class="time"></span>
                                            </span>
                                            <span class="message">
                                       
                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image">
                                        <img src="" alt="Profile Image" />
                                    </span>
                                            <span>
                                        <span>John Smith</span>
                                            <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                        
                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image">
                                        <img src="" alt="Profile Image" />
                                    </span>
                                            <span>
                                        <span></span>
                                            <span class="time"></span>
                                            </span>
                                            <span class="message">
                                       
                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <span class="image">
                                        <img src="" alt="Profile Image" />
                                    </span>
                                            <span>
                                        <span></span>
                                            <span class="time"></span>
                                            </span>
                                            <span class="message">
                                        
                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="text-center">
                                            <a>
                                                <strong><a href=""></strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </nav>
                </div>

            </div>
            <!-- /top navigation -->

             <div class="right_col" role="main">
