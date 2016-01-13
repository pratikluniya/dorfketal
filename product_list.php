<?php
 include "classes/functions.php";
 session_start();
 $con =new functions();
 ?>

<div class="container cat-tabs">
    <input type="hidden" name="cat_name" id="cat_name" value="<?php echo $_REQUEST['cat_name']; ?>">
    <button type="button" class="by_product btn btn-primary" id="by_product">By Products</button>
    <button type="button" class="by_application btn btn-primary inactive-cat-tab" id="by_application">By Application</button><br>
    <select id="cat_applications">
    </select>
    <hr>
</div>

<?php
if(isset($_REQUEST['cat_prod']) && ($_REQUEST['cat_prod'] == "1") )
{
    $sql ="SELECT ID, PRODUCT_CODE AS ITEM_CODE, DESCRIPTION, ATTRIBUTE18 as PRODUCT_APPLICATION, ATTRIBUTE17 as PRODUCT_GROUP FROM xxdkapps_unsegregated_products WHERE ATTRIBUTE17 ='".$_REQUEST['cat_name']."' order by ID";
    $result=$con->data_select($sql);
}
if(isset($_REQUEST['cat_prod']) && ($_REQUEST['cat_prod'] == "2") )
{
    $sql ="SELECT up.ID, up.PRODUCT_CODE AS  ITEM_CODE, up.DESCRIPTION, up.ATTRIBUTE18 as  PRODUCT_APPLICATION, up.ATTRIBUTE17 as PRODUCT_GROUP, rp.CUSTOMER_NUMBER FROM xxdkapps_regular_products as rp, xxdkapps_unsegregated_products as up WHERE rp.CUSTOMER_NUMBER= " . $_SESSION['cust_id']." and rp.PRODUCT_CODE = up.PRODUCT_CODE order by SEQUENCE DESC ";
    $result=$con->data_select($sql);
}
if(isset($_REQUEST['cat_prod']) && ($_REQUEST['cat_prod'] == "3") )
{
    $sql="SELECT ID, PRODUCT_CODE AS ITEM_CODE, DESCRIPTION, ATTRIBUTE18 as PRODUCT_APPLICATION, ATTRIBUTE17 as PRODUCT_GROUP FROM xxdkapps_unsegregated_products WHERE ATTRIBUTE17 ='".$_REQUEST['cat_name']."' AND PGID = '".$_REQUEST['pgid']."' order by ID";
    $result=$con->data_select($sql);
}
    if($result != "no")
    {
        foreach ($result as $key => $value) 
        {
            echo '
            <div class="col-lg-6 animated bounceInRight">
                <div class="hpanel">
                    <div class="panel-heading hbuilt">
                        <div class="panel-tools">
                            <span class="label label-default cat-tags">'.$result[$key]['PRODUCT_APPLICATION'].'</span>
                            <span class="label label-default cat-tags">'.$result[$key]['PRODUCT_GROUP'].'</span>
                        </div>
                        <h4 id="prod_desc">'.$result[$key]['DESCRIPTION'].'</h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <label class="prod-lables" for="qty">Quantity :</label>
                            <input type="number" name="qty" id="qty" class="prod_qty" value="0"> Kg<br>
                            <label class="prod-lables" for="qty">Packaging Size :</label>
                            <select id="pkg_size">
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
                                <input type="text" name="remark" id="remark" class="prod_qty" value=""/>
                            </div>            
                            <a class="btn btn-default btn-xs center-block add_to_cart_btn" style="margin-top:20px;">Add to Cart</a>
                            <input type="hidden" name="prod_code" id="prod_code" value="'.$result[$key]['ITEM_CODE'].'">
                        </div>
                    </div>
                </div>
            </div>
            ';
        }           
        exit;
    }
    else
    {
        echo "No Product Found ";
        exit;
    } 
?>

