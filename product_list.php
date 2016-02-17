<?php
 include "classes/functions.php";
 include "classes/paginate_function.php";

 session_start();
 $con =new functions();
 ?>
<input type="hidden" name="cat_name" id="cat_name" value="<?php echo $_REQUEST['cat_name']; ?>">                       
<?php
$item_per_page = 8;

if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
//Get page number from Ajax POST
if(isset($_POST["page"])){
    $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
    if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
}else{
    $page_number = 1; //if there's no page number, set it to 1
}

if(isset($_REQUEST['cat_prod']) && ($_REQUEST['cat_prod'] == "1") )
{
    $sql ="SELECT ID FROM xxdkapps_unsegregated_products WHERE ATTRIBUTE17 ='".$_REQUEST['cat_name']."' order by ID";
    $result= $con->data_select($sql);

    $get_total_rows = count($result); //hold total records in variable
    //break records into pages
    $total_pages = ceil($get_total_rows/$item_per_page);

    //get starting position to fetch the records
    $page_position = (($page_number-1) * $item_per_page);

    $sql ="SELECT ID, PRODUCT_CODE AS ITEM_CODE, DESCRIPTION, ATTRIBUTE18 as PRODUCT_APPLICATION, ATTRIBUTE17 as PRODUCT_GROUP FROM xxdkapps_unsegregated_products WHERE ATTRIBUTE17 ='".$_REQUEST['cat_name']."' order by ID LIMIT $page_position, $item_per_page";
    $result=$con->data_select($sql);
}
if(isset($_REQUEST['cat_prod']) && ($_REQUEST['cat_prod'] == "2") )
{
    $sql ="SELECT up.ID FROM xxdkapps_regular_products as rp, xxdkapps_unsegregated_products as up WHERE rp.CUSTOMER_NUMBER= " . $_SESSION['cust_id']." and rp.PRODUCT_CODE = up.PRODUCT_CODE order by SEQUENCE DESC ";
    $result= $con->data_select($sql);

    $get_total_rows = count($result); //hold total records in variable
    //break records into pages
    $total_pages = ceil($get_total_rows/$item_per_page);

    //get starting position to fetch the records
    $page_position = (($page_number-1) * $item_per_page);

    $sql ="SELECT up.ID, up.PRODUCT_CODE AS  ITEM_CODE, up.DESCRIPTION, up.ATTRIBUTE18 as  PRODUCT_APPLICATION, up.ATTRIBUTE17 as PRODUCT_GROUP, rp.CUSTOMER_NUMBER FROM xxdkapps_regular_products as rp, xxdkapps_unsegregated_products as up WHERE rp.CUSTOMER_NUMBER= " . $_SESSION['cust_id']." and rp.PRODUCT_CODE = up.PRODUCT_CODE order by SEQUENCE DESC LIMIT $page_position, $item_per_page";
    $result=$con->data_select($sql);
}
if(isset($_REQUEST['cat_prod']) && ($_REQUEST['cat_prod'] == "3") )
{
    $sql="SELECT ID FROM xxdkapps_unsegregated_products WHERE ATTRIBUTE17 ='".$_REQUEST['cat_name']."' AND PGID = '".$_REQUEST['pgid']."' order by ID";
    $result= $con->data_select($sql);

    $get_total_rows = count($result); //hold total records in variable
    //break records into pages
    $total_pages = ceil($get_total_rows/$item_per_page);

    //get starting position to fetch the records
    $page_position = (($page_number-1) * $item_per_page);

    $sql="SELECT ID, PRODUCT_CODE AS ITEM_CODE, DESCRIPTION, ATTRIBUTE18 as PRODUCT_APPLICATION, ATTRIBUTE17 as PRODUCT_GROUP FROM xxdkapps_unsegregated_products WHERE ATTRIBUTE17 ='".$_REQUEST['cat_name']."' AND PGID = '".$_REQUEST['pgid']."' order by ID LIMIT $page_position, $item_per_page";
    $result=$con->data_select($sql);
}
    if($result != "no")
    {
        foreach ($result as $key => $value) 
        {
            echo '
            <div class="col-lg-6 animated bounceInRight prod_list">
                <div class="hpanel">
                    <div class="panel-heading hbuilt">
                        <div class="panel-tools">
                            <span class="label label-default cat-tags">'.$result[$key]['PRODUCT_APPLICATION'].'</span>
                            <span class="label label-default cat-tags">'.$result[$key]['PRODUCT_GROUP'].'</span>
                        </div>
                        <h4 id="prod_desc">'.$result[$key]['DESCRIPTION'].'</h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12 form-prod">
                            <label class="prod-lables" for="qty">Quantity<sup class="required_field">*</sup> :</label>
                            <input type="text" name="qty" id="qty" class="form-control qty prod_qty"> Kg<br>
                            <label class="prod-lables" for="qty">Packaging Size :</label>
                            <select id="pkg_size" class="form-control pkg_size">
                                <option selected="selected">ANY</option>
                                <option>1</option>
                                <option>5</option>
                                <option>10</option>
                                <option>20</option>
                                <option>25</option>
                                <option>30</option>
                                <option>35</option>
                                <option>40</option>
                                <option>45</option>
                                <option>50</option>
                                <option>100</option>
                                <option>150</option>
                                <option>165</option>
                                <option>170</option>
                                <option>175</option>
                                <option>180</option>
                                <option>185</option>
                                <option>190</option>
                                <option>200</option>
                                <option>220</option>
                                <option>227</option>
                                <option>900</option>
                                <option>1000</option>
                                <option>16000</option>
                                <option>20000</option>
                            </select> Drum / Tank
                            <div>
                                <label class="prod-lables" for="remark">Remark </label>
                                <input type="text" name="remark" id="remark" class="prod_qty remark form-control" value=""/>
                            </div>            
                            <a class="btn btn-default btn-xs center-block add_to_cart_btn" style="margin-top:20px;">Add to Cart</a>
                            <input type="hidden" name="prod_code" id="prod_code" value="'.$result[$key]['ITEM_CODE'].'">
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
        if(isset($_REQUEST['cat_prod']) && ($_REQUEST['cat_prod'] == "1") )
        {
            echo '<div class="row text-center">
                    <div class="col-md-12">
                        <div class="cat_prod_pagination1">';                                                            
                            echo paginate_function($item_per_page, $page_number, $get_total_rows, $total_pages);                   
            echo'       </div>                        
                    </div>                    
                </div>';
        }  

        if(isset($_REQUEST['cat_prod']) && ($_REQUEST['cat_prod'] == "2") )
        {
            echo '<div class="row text-center">
                    <div class="col-md-12">
                        <div class="cat_prod_pagination2">';                                                            
                            echo paginate_function($item_per_page, $page_number, $get_total_rows, $total_pages);                   
            echo'       </div>                        
                    </div>                    
                </div>';
        } 

         if(isset($_REQUEST['cat_prod']) && ($_REQUEST['cat_prod'] == "3") )
        {
            echo '<div class="row text-center">
                    <div class="col-md-12">
                        <div class="cat_prod_pagination3">';                                                            
                            echo paginate_function($item_per_page, $page_number, $get_total_rows, $total_pages);                   
            echo'       </div>                        
                    </div>                    
                </div>';
        }        
        exit;
    }
    else
    {
        echo "No Product Found ";
        exit;
    }
    } 
?>

