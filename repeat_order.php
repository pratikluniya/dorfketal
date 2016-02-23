<?php
include "classes/functions.php";
include "classes/paginate_function.php";

session_start();
$con =new functions();
$cust_id = $_SESSION['cust_id'];
$item_per_page = 10;

if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
//Get page number from Ajax POST
if(isset($_POST["page"])){
    $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
    if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
}else{
    $page_number = 1; //if there's no page number, set it to 1
}

if(isset($_REQUEST['search_category']) && ($_REQUEST['search_category'] == "5") )
{            
    $sql ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, cm.SITE_USE_ID, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and ofd.ORACLE_ORDER = ".$_REQUEST['search_value']." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID";
    $result= $con->data_select($sql);
    $sql_sold_to = "SELECT distinct  SITE_USE_ID as ID, PRIMARY_FLAG, CONCAT_WS(',',ADDRESS1,ADDRESS2, ADDRESS3,ADDRESS4,CITY,COUNTRY) AS SHIP_ADDRESS FROM xxdkapps_customer_master WHERE BUSINESS_CODE ='BILL_TO' and CUSTOMER_NUMBER = ".$cust_id." and ACCOUNT_STATUS='A' order by PRIMARY_FLAG DESC";
    $sold_to = $con->data_select($sql_sold_to);
}
else if(isset($_REQUEST['search_category']) && ($_REQUEST['search_category'] == "6") )
{        
    $sql ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, cm.SITE_USE_ID, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and ofd.ORDER_WEB_ID = '".$_REQUEST['search_value']."' and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID";
    $result= $con->data_select($sql);
    $sql_sold_to = "SELECT distinct  SITE_USE_ID as ID, PRIMARY_FLAG, CONCAT_WS(',',ADDRESS1,ADDRESS2, ADDRESS3,ADDRESS4,CITY,COUNTRY) AS SHIP_ADDRESS FROM xxdkapps_customer_master WHERE BUSINESS_CODE ='BILL_TO' and CUSTOMER_NUMBER = ".$cust_id." and ACCOUNT_STATUS='A' order by PRIMARY_FLAG DESC";
    $sold_to = $con->data_select($sql_sold_to);
}
else if(isset($_REQUEST['search_value']) && isset($_REQUEST['search_cat']))
{
    if($_REQUEST['search_cat'] == 1)
    {
        $sql1 ="SELECT op.ORDER_ID FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and op.PRODUCT_CODE = '".$_REQUEST['search_value']."' ORDER BY ofd.ORDER_DATE DESC";   
    }
    else if($_REQUEST['search_cat'] == 2)
    {
        $sql1 ="SELECT op.ORDER_ID FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and up.DESCRIPTION LIKE '%".$_REQUEST['search_value']."%' ORDER BY ofd.ORDER_DATE DESC";
    }
    else if($_REQUEST['search_cat'] == 3)
    {
        $sql1 ="SELECT op.ORDER_ID FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and ofd.ORACLE_ORDER = '".$_REQUEST['search_value']."' ORDER BY ofd.ORDER_DATE DESC"; 
    }
    else if($_REQUEST['search_cat'] == 4)
    {
        $sql1 ="SELECT op.ORDER_ID FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and ofd.ORDER_WEB_ID = '".$_REQUEST['search_value']."'  ORDER BY ofd.ORDER_DATE DESC";
    }
    //To get total count    
    $result= $con->data_select($sql1);

    $get_total_rows = count($result); //hold total records in variable
    $total_pages = ceil($get_total_rows/$item_per_page);//break records into pages
    $page_position = (($page_number-1) * $item_per_page);//get starting position to fetch the records  

    if($_REQUEST['search_cat'] == 1)
    {
        $sql2 ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and op.PRODUCT_CODE = '".$_REQUEST['search_value']."' ORDER BY ofd.ORDER_DATE DESC LIMIT $page_position, $item_per_page";
    }
    else if($_REQUEST['search_cat'] == 2)
    {
        $sql2 ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and up.DESCRIPTION LIKE '%".$_REQUEST['search_value']."%' ORDER BY ofd.ORDER_DATE DESC LIMIT $page_position, $item_per_page";   
    }
    else if($_REQUEST['search_cat'] == 3)
    {
        $sql2 ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and ofd.ORACLE_ORDER = '".$_REQUEST['search_value']."' ORDER BY ofd.ORDER_DATE DESC LIMIT $page_position, $item_per_page";  
    }
    else if($_REQUEST['search_cat'] == 4)
    {
        $sql2 ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and ofd.ORDER_WEB_ID = '".$_REQUEST['search_value']."' ORDER BY ofd.ORDER_DATE DESC LIMIT $page_position, $item_per_page";   
    }
        
    $result= $con->data_select($sql2);
    $sql_sold_to = "SELECT distinct  SITE_USE_ID as ID, PRIMARY_FLAG, CONCAT_WS(',',ADDRESS1,ADDRESS2, ADDRESS3,ADDRESS4,CITY,COUNTRY) AS SHIP_ADDRESS FROM xxdkapps_customer_master WHERE BUSINESS_CODE ='BILL_TO' and CUSTOMER_NUMBER = ".$cust_id." and ACCOUNT_STATUS='A' order by PRIMARY_FLAG DESC";
    $sold_to = $con->data_select($sql_sold_to);
}
else
{
    $sql ="SELECT op.ORDER_ID FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID ORDER BY ofd.ORDER_DATE DESC";
    $result= $con->data_select($sql);

    $get_total_rows = count($result); //hold total records in variable
    $total_pages = ceil($get_total_rows/$item_per_page);//break records into pages
    $page_position = (($page_number-1) * $item_per_page);//get starting position to fetch the records
        
    $sql ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, cm.SITE_USE_ID, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID ORDER BY ofd.ORDER_DATE DESC LIMIT $page_position, $item_per_page";
    $result= $con->data_select($sql);
    $sql_sold_to = "SELECT distinct  SITE_USE_ID as ID, PRIMARY_FLAG, CONCAT_WS(',',ADDRESS1,ADDRESS2, ADDRESS3,ADDRESS4,CITY,COUNTRY) AS SHIP_ADDRESS FROM xxdkapps_customer_master WHERE BUSINESS_CODE ='BILL_TO' and CUSTOMER_NUMBER = ".$cust_id." and ACCOUNT_STATUS='A' order by PRIMARY_FLAG DESC";
    $sold_to = $con->data_select($sql_sold_to);
}

if($result != "no")
{
?>
    <div class="container animated bounceInRight">
        <div class="panel panel-default">
            <div class="panel-body table-responsive">
                <table class="table table-condensed table-striped" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>ORDER NUMBER</th>
                            <th>PO#</th>
                            <th>ORDER DATE</th>
                            <th>PRODUCT NAME</th>
                            <th>PRICE</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($result as $key => $value) 
                        {
                            $result[$key] = array_map('trim', $result[$key]);
                    ?>
                            <tr data-toggle="collapse" data-target="#demo<?php echo $key;?>" class="accordion-toggle">
                                <td>
                                    <button class="btn btn-default btn-xs">
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </button>
                                </td>
                                <td id="order_web_id">
                                    <?php echo ("#".$result[$key]['ORDER_WEB_ID']); ?>
                                </td>
                                <td>
                                    <?php echo ("#".$result[$key]['PO']); ?>
                                </td>
                                <td>
                                    <?php echo $result[$key]['ORDER_DATE']; ?> 
                                </td>
                                <td>
                                    <?php echo $result[$key]['DESCRIPTION']; ?>
                                </td>
                                <td>
                                    <?php echo trim($result[$key]['UNIT_PRICE']); ?>
                                </td>
                                <td>
                                    <?php echo $result[$key]['OSTATUS']; ?> 
                                </td>
                            </tr>
                            <tr>
                                <td colspan="12" class="hiddenRow">
                                    <div class="accordian-body collapse" id="demo<?php echo $key;?>"> 
                                        <div class="container col-md-6" style="border-right:1px dotted #c9c9c9;">
                                            <input type="hidden" id="sold_to_id" value="<?php echo ($sold_to[0]['ID']);?>">
                                            <input type="hidden" id="ship_to_id" value="<?php echo ($result[$key]['SITE_USE_ID']);?>">
                                            <input type="hidden" id="PO" value="<?php echo ($result[$key]['PO']);?>">
                                            <label class="history_label">Shipping Address : </label>
                                            <span id="ship_address"><?php echo ($result[$key]['SHIP_ADDRESS']);?></span><br><br>
                                            <label class="history_label">Billing Address : </label>
                                            <span id="sold_address"><?php echo ($sold_to[0]['SHIP_ADDRESS']);?></span><br><br>
                                            <label class="history_label">Freight Terms : </label>
                                            <span id="fright_term"><?php echo ($result[$key]['FREIGHT_TERMS']);?></span><br><br>
                                            <label class="history_label">Vessel Name : </label>
                                            <span id="vessel"><?php echo ($result[$key]['VESSEL']);?></span><br><br>
                                            <label class="history_label">Contact Person : </label>
                                            <span id="con_person"><?php echo ($result[$key]['CONTACT_PERSON']);?></span><br><br>
                                            <label class="history_label">Pay Terms : </label>
                                            <span id="pay_term"><?php echo ($result[$key]['ATTRIBUTE12']);?></span><br><br>
                                        </div>
                                        <div class="container col-md-6 col-xs-6 col-lg-6 col-sm-6">
                                            <label class="history_label">Oracle Order : </label>
                                            <span id="oracle_order"><?php echo ($result[$key]['ORACLE_ORDER']);?></span><br><br>
                                            <label class="history_label">Order Date: </label>
                                            <span id="order_date"><?php echo ($result[$key]['ORDER_DATE']);?></span><br><br>
                                            <label class="history_label">Product Name : </label>
                                            <span id="rep_prod_desc"><?php echo ($result[$key]['DESCRIPTION']);?></span>/<br><br>
                                            <label class="history_label">Quantity : </label>
                                            <span id="qty"><?php echo ($result[$key]['QUANTITY']." KG");?></span><br><br>
                                            <label class="history_label">Packaging Size : </label>
                                            <span id="pkg_size"><?php echo ($result[$key]['PACKAGE_QTY']." Drum/Tank");?></span><br><br>
                                            <label class="history_label">Price : </label>
                                            <span id="operand"><?php echo ($result[$key]['UNIT_PRICE']." /KG");?></span><br><br>
                                            <label class="history_label">Comments : </label>
                                            <span id="comments"><?php echo ($result[$key]['COMMENTS']);?></span><br><br>
                                            <label class="history_label">Remark : </label>
                                            <?php if(($result[$key]['REMARKS']) == "") ?>
                                                <span id="remark"><?php echo ($result[$key]['REMARKS']);?></span><br><br>
                                            <button id="repeat_order" class="btn btn-primary pull-right">Repeat Order</button><br><br>
                                        </div>
                                  </div> 
                              </td>
                            </tr>
                        <?php 
                        } 
                        ?>
                    </tbody>
                </table>
                <?php
                    if(!isset($_REQUEST['search_category']) )
                    { 
                ?>
                        <div class="row text-center">
                            <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
                                <div class="repeat_order_pagination">
                                    <?php                                
                                        echo paginate_function($item_per_page, $page_number, $get_total_rows, $total_pages);
                                    ?>
                                </div>                                               
                            </div>                    
                        </div>
                <?php 
                    }
                ?>                
            </div>   
        </div> 
    </div>
<?php
}
else
{
?>
    <div class="container">
        <h4>
            No Orders Yet
        </h4>
        <button type="button" id="continue_shop_btn">Continue Buying</button>
    </div>
<?php
}
}
?>