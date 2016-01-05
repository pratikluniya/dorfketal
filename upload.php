<?php
include("./classes/functions.php");
$obj1 = new functions();
session_start();



$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i <50; $i++) {
	$randomString .= $characters[rand(0, $charactersLength - 1)];
}    

$blog_tiltle =$_POST['blog_tiltle'];

$blog_content = $_POST['blog_content'];

$blog_category =$_POST['blog_category'];

if(isset($_FILES['userImage']))
{
	
	if(is_array($_FILES)) 
	{

		if(is_uploaded_file($_FILES['userImage']['tmp_name'])) 
		{
			$sourcePath = $_FILES['userImage']['tmp_name'];
			$targetPath = "blog_images/".$randomString.".jpeg";
			
			if(move_uploaded_file($sourcePath,$targetPath)) 
			{


				$blog_image12 =  $randomString.".jpeg";
				$sql_insert_blog="INSERT INTO  blog_content(blog_content_headline,blog_content_text,blog_category_id,blog_image,created) VALUES ('".$blog_tiltle."','".$blog_content."' ,".$blog_category.", '".$blog_image12."','".date('Y-m-d H:i:s')."')";	

                    $res=$obj1->data_insert($sql_insert_blog);	

                    echo $res;							
			}
		}
	}

	//echo "graph";
}

