<?php  

    include('classes/functions.php');
	
?>  
<link rel="shortcut icon" type="image/ico" href="images/favicon.ico" />
<link rel="stylesheet" href="styles/login-style.css">
<div class="wrapper">
    <div class="container">
        <span>
            <img src="images/dk-logo.png">
        </span>
        <form class="form">
            <input type="text" id="login_cust_id" placeholder="Customer ID">
            <input type="password" id="login_cust_pass" placeholder="Password">
            <lable name="login-error" id="login-error"></lable>
            <button type="button" id="login-button">Login</button>
        </form>
    </div>
    <ul class="bg-bubbles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<script src="vendor/jquery/dist/jquery.min.js"></script>
<script src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="scripts/main.js"></script>
<?php

    include('footer.php');

?>