<?php
include("./classes/functions.php");
$obj1 = new functions();
session_start();
//print_r($_REQUEST);
if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "Inactive") ){
    $sql_inactive ="update product set status =0 where id =".$_REQUEST['id'];   
    $obj1->data_update($sql_inactive);
    exit;

}