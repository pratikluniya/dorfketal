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
        <link rel="stylesheet" href="vendor/confirmjs/dist/jquery-confirm.css" />
        <link rel="stylesheet" href="styles/login-style.css">

        <!-- App styles -->
        <link rel="stylesheet" href="styles/style.css">
        <link rel="stylesheet" href="styles/main.css">

        <script src="vendor/jquery/dist/jquery.min.js"></script>
        <script src="scripts/main.js"></script>
        <script src="scripts/search.js"></script>

        <!-- Order Management Dependancies End Here -->
    </head>
<body>
<div id="loading" class="hideloading">
    <img src="images/loading.gif" class="loading-img">
</div>
