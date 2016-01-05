<?php
 include "classes/functions.php";
 
 $con =new functions();
 
 if(isset($_REQUEST['cat_prod'])=="1")
 {
    $sql ="SELECT ID, PRODUCT_CODE AS ITEM_CODE, DESCRIPTION, ATTRIBUTE18 as PRODUCT_APPLICATION, ATTRIBUTE17 as PRODUCT_GROUP FROM xxdkapps_unsegregated_products WHERE ATTRIBUTE17 ='".$_REQUEST['cat_name']."' order by ID";
    $result=$con->data_select($sql);
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
                        <h3>'.$result[$key]['DESCRIPTION'].'</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <label class="prod-lables" for="qty">Quantity :</label>
                            <input type="number" name="qty" id="qty" class="prod_qty"> Kg<br>
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
                                <input type="text" name="remark" id="remark" class="prod_qty"/>
                            </div>            
                            <a class="btn btn-default btn-xs center-block add_to_cart_btn" style="margin-top:20px;">Add to Cart</a>
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
        echo "No Data Found ";
        exit;
    }    
} 
?>

