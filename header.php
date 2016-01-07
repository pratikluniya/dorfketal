<?php
session_start();
if(!isset($_SESSION['cust_id']))
{
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Page title -->
        <title>Dorfketal</title>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="shortcut icon" type="image/ico" href="images/favicon.ico" />
        
        <!-- Order Management Dependancies Start Here -->
        <!-- Vendor styles -->
        <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css" />
        <link rel="stylesheet" href="vendor/metisMenu/dist/metisMenu.css" />
        <link rel="stylesheet" href="vendor/animate.css/animate.css" />
        <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.css" />
        <link rel="stylesheet" href="styles/login-style.css">

        <!-- App styles -->
        <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
        <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/helper.css" />
        <link rel="stylesheet" href="styles/style.css">
        <link rel="stylesheet" href="styles/main.css">

        <script src="vendor/jquery/dist/jquery.min.js"></script>
        <script src="vendor/jquery-ui/jquery-ui.min.js"></script>
        <script src="scripts/main.js"></script>

        <!-- Order Management Dependancies End Here -->

        <!-- Logistics Management Dependancies Start Here -->
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

        <script src="js/nprogress.js"></script>
        <script src="js/sidebar_desable.js"></script>
        <script>
            NProgress.start();
        </script>
    </head>
<body>
