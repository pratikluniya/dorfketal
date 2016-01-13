<?php
include('class/functions.php');
$con=new functions();
date_default_timezone_set("Asia/Kolkata");
$conn = oci_connect('apps','apps','115.112.201.89:1531/TEST');
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}


$stid3 = oci_parse($conn, "SELECT DISTINCT CUSTOMER_NUM FROM xxdk_order_ems_portal");


$r = oci_execute($stid3);


$data =array();

$i = 0;
while ($row = oci_fetch_assoc($stid3)) {
  $data[$i] = $row;

  $i++;

}
oci_free_statement($stid);
oci_close($conn);
/*echo "<pre>";
print_r($data);*/
foreach ($data as $key => $value) {
  $sql="INSERT INTO user_registration(email_id,password,role_id) VALUES ('".$data[$key]['CUSTOMER_NUM']."',
  '".$data[$key]['CUSTOMER_NUM']."',3)";

  $result=$con->data_insert($sql);
 
}

//echo $sql;
   exit;
?>