<?php  

    include('classes/functions.php');
    session_start();
    if(isset($_SESSION['cust_id']))
    {
        header('Location: home.php');
    }
	
?>  
<title>Dorfketal</title>
<link rel="shortcut icon" type="image/ico" href="images/favicon.ico" />
<link rel="stylesheet" href="styles/login-style.css">
<div class="loginwrapper">
    <div class="logincontainer">
        <span>
            <img src="images/dk-logo.png">
        </span>
        <form class="loginform">
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
<script src="scripts/main.js"></script>
<?php

    include('footer.php');

?>