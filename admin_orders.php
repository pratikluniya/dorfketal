<?php
include "classes/functions.php";
include "classes/paginate_function.php";
session_start();
$con =new functions();
$cust_id = $_SESSION['cust_id'];
$item_per_page = 10;

if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
    //Get page number from Ajax POST
    if(isset($_POST["page"]))
    {
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number))
        {
            die('Invalid page number!');
        } //incase of invalid page number
    }
    else
    {
        $page_number = 1; //if there's no page number, set it to 1
    }

    if(isset($_REQUEST['search_value']) && isset($_REQUEST['search_cat']))
    {
        if($_REQUEST['search_cat'] == 1)
        {
            $sql1 ="SELECT op.ORDER_ID FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and op.PRODUCT_CODE LIKE '".$_REQUEST['search_value']."%' ORDER BY ofd.ORDER_DATE DESC";   
        }
        else if($_REQUEST['search_cat'] == 2)
        {
            $sql1 ="SELECT op.ORDER_ID FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and up.DESCRIPTION LIKE '".$_REQUEST['search_value']."%' ORDER BY ofd.ORDER_DATE DESC";
        }
        else if($_REQUEST['search_cat'] == 3)
        {
            $sql1 ="SELECT op.ORDER_ID FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and ofd.ORACLE_ORDER = '".$_REQUEST['search_value']."' ORDER BY ofd.ORDER_DATE DESC"; 
        }
        else if($_REQUEST['search_cat'] == 4)
        {
            $sql1 ="SELECT op.ORDER_ID FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and ofd.ORDER_WEB_ID = '".$_REQUEST['search_value']."'  ORDER BY ofd.ORDER_DATE DESC";
        }
        else if($_REQUEST['search_cat'] == 5)
        {
            $sql1 ="SELECT op.ORDER_ID FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and ofd.PO LIKE '".$_REQUEST['search_value']."%'  ORDER BY ofd.ORDER_DATE DESC";
        }
        else if($_REQUEST['search_cat'] == 6)
        {
            $sql1 ="SELECT op.ORDER_ID FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and op.OSTATUS LIKE '".$_REQUEST['search_value']."%'  ORDER BY ofd.ORDER_DATE DESC";
        }
        //To get total count    
        $result= $con->data_select($sql1);

        $get_total_rows = count($result); //hold total records in variable
        $total_pages = ceil($get_total_rows/$item_per_page);//break records into pages
        $page_position = (($page_number-1) * $item_per_page);//get starting position to fetch the records  

        if($_REQUEST['search_cat'] == 1)
        {
            $sql2 ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and op.PRODUCT_CODE LIKE '".$_REQUEST['search_value']."%' ORDER BY ofd.ORDER_DATE DESC LIMIT $page_position, $item_per_page";
        }
        else if($_REQUEST['search_cat'] == 2)
        {
            $sql2 ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and up.DESCRIPTION LIKE '".$_REQUEST['search_value']."%' ORDER BY ofd.ORDER_DATE DESC LIMIT $page_position, $item_per_page";   
        }
        else if($_REQUEST['search_cat'] == 3)
        {
            $sql2 ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and ofd.ORACLE_ORDER = '".$_REQUEST['search_value']."' ORDER BY ofd.ORDER_DATE DESC LIMIT $page_position, $item_per_page";  
        }
        else if($_REQUEST['search_cat'] == 4)
        {
            $sql2 ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and ofd.ORDER_WEB_ID = '".$_REQUEST['search_value']."' ORDER BY ofd.ORDER_DATE DESC LIMIT $page_position, $item_per_page";   
        }
        else if($_REQUEST['search_cat'] == 5)
        {
            $sql2 ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and ofd.PO LIKE '".$_REQUEST['search_value']."%' ORDER BY ofd.ORDER_DATE DESC LIMIT $page_position, $item_per_page";   
        }
        else if($_REQUEST['search_cat'] == 6)
        {
            $sql2 ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and op.OSTATUS LIKE '".$_REQUEST['search_value']."%' ORDER BY ofd.ORDER_DATE DESC LIMIT $page_position, $item_per_page";   
        }
            
        $result= $con->data_select($sql2);
        $sql_sold_to = "SELECT distinct  SITE_USE_ID as ID, PRIMARY_FLAG, CONCAT_WS(',',ADDRESS1,ADDRESS2, ADDRESS3,ADDRESS4,CITY,COUNTRY) AS SHIP_ADDRESS FROM xxdkapps_customer_master WHERE BUSINESS_CODE ='BILL_TO' and CUSTOMER_NUMBER = ".$cust_id." and ACCOUNT_STATUS='A' order by PRIMARY_FLAG DESC";
        $sold_to = $con->data_select($sql_sold_to);
    }
    else
    {
        //To get total count
        $sql ="SELECT op.ORDER_ID FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID ORDER BY ofd.ORDER_DATE DESC";
        $result= $con->data_select($sql);

        $get_total_rows = count($result); //hold total records in variable
        $total_pages = ceil($get_total_rows/$item_per_page);//break records into pages
        $page_position = (($page_number-1) * $item_per_page);//get starting position to fetch the records  
            
        $sql ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID ORDER BY ofd.ORDER_DATE DESC LIMIT $page_position, $item_per_page";
        $result= $con->data_select($sql);
       
    }
    if($result != "no")
    {
    ?>
        <div class="container animated bounceInRight">
            <div class="container animated bounceInRight">
                <div class="row adminfilters">
                    <form>
                        <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <label for="adminstartdate">Start Date :</label>
                            <input type="date" id="adminstartdate" class="form-control" placeholder"Start Date" />
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <label for="adminenddate">End Date :</label>
                            <input type="date" id="adminenddate" class="form-control" placeholder"End Date" />
                        </div>
                        <div class="form-group col-xs-12 col-sm-12 col-md-1 col-lg-1">
                            <button type="button" class="btn btn-primary middle_btn" id="datefilter_btn">Search</button>
                        </div>
                    </form>                
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 local-search-div admin_order_search">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button type="button" class="btn local-search-dropdown-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="admin_order_cat">Select Search By <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a data-value="1" data-category="Product Code">Product Code</a></li>
                                    <li><a data-value="2" data-category="Product Name">Product Name</a></li>
                                    <li><a data-value="3" data-category="Order Number">Order Number</a></li>
                                    <li><a data-value="4" data-category="Order Web Id">Order Web Id</a></li>
                                    <li><a data-value="5" data-category="PO# Number">PO# Number</a></li>
                                    <li><a data-value="6" data-category="Order Status">Order Status</a></li>                                           
                                </ul>
                            </div> 
                            <!-- btn-group -->
                            <input type="text" class="form-control" id="admin_order_search_box" aria-label="..." placeholder="Search ">
                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            <input type="hidden" id="admin_src_ord_cat" value="0">
                            <input type="hidden" id="admin_pagtn_src_ord_histry" value="">
                            <input type="hidden" id="admin_pagtn_src_ord_histry_cat" value="">
                        </div>
                    </div> 
                </div>
                <div class="panel panel-default">
                    <div class="panel-body table-responsive">
                        <table class="table table-condensed table-striped" style="border-collapse:collapse;">
                            <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th>ORDER WEB ID</th>
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
                                    $sql_sold_to = "SELECT distinct  SITE_USE_ID as ID, PRIMARY_FLAG, CONCAT_WS(',',ADDRESS1,ADDRESS2, ADDRESS3,ADDRESS4,CITY,COUNTRY) AS SHIP_ADDRESS FROM xxdkapps_customer_master WHERE BUSINESS_CODE ='BILL_TO' and CUSTOMER_NUMBER = ".$result[$key]['CUSTOMER_NUMBER']." and ACCOUNT_STATUS='A' order by PRIMARY_FLAG DESC";
                                    $sold_to = $con->data_select($sql_sold_to);
                                    $result[$key] = array_map('trim', $result[$key]);
                            ?>
                                    <tr data-toggle="collapse" data-target="#demo<?php echo $key;?>" class="accordion-toggle">
                                        <td>
                                            <button class="btn btn-default btn-xs">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                            </button>
                                        </td>
                                        <td>
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
                                                <div class="container col-md-6 col-xs-6 col-lg-6 col-sm-6" style="border-right:1px dotted #c9c9c9;">
                                                    <div class="form-group">
                                                        <label class="history_label">Order Number: </label><?php echo ($result[$key]['ORACLE_ORDER']);?>
                                                    </div>
                                                     <div class="form-group">
                                                        <label class="history_label">Order Date: </label><?php echo ($result[$key]['ORDER_DATE']);?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="history_label">Shipping Address : </label><?php echo ($result[$key]['SHIP_ADDRESS']);?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="history_label">Billing Address : </label><?php echo ($sold_to[0]['SHIP_ADDRESS']);?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="history_label">Freight Terms : </label><?php echo ($result[$key]['FREIGHT_TERMS']);?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="history_label">Vessel Name : </label><?php echo ($result[$key]['VESSEL']);?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="history_label">Pay Terms : </label><?php echo ($result[$key]['ATTRIBUTE12']);?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="history_label">Comments : </label><?php echo ($result[$key]['COMMENTS']);?>
                                                    </div>
                                                </div>
                                                <div class="container col-md-6 col-xs-6 col-lg-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="history_label">Product Name : </label><?php echo ($result[$key]['DESCRIPTION']);?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="history_label">Quantity : </label><?php echo ($result[$key]['QUANTITY']." KG");?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="history_label">Packaging Size : </label><?php echo ($result[$key]['PACKAGE_QTY']." Drum/Tank");?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="history_label">Price : </label><?php echo ($result[$key]['UNIT_PRICE']." /KG");?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="history_label">Contact Person : </label><?php echo ($result[$key]['CONTACT_PERSON']);?>
                                                    </div>
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
                        if(isset($_REQUEST['search_value']))
                        {
                        ?>
                            <div class="container text-center">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="admin_order_loc_src_pagtn">
                                        <?php                                
                                            echo paginate_function($item_per_page, $page_number, $get_total_rows, $total_pages);
                                        ?>
                                    </div>                        
                                </div>    
                            </div>
                        <?php
                        }
                        else
                        {
                        ?>
                            <div class="container text-center">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="admin_order_pagination">
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
        </div>
    <?php
    }
    else
    {
    ?>
        <div class="container">
            <h4>
                No Orders Found
            </h4>
        </div>
    <?php
    }
}
?>