<?php
	include "classes/functions.php";
	include "classes/paginate_function.php";
	session_start();
	$con =new functions();
	$cust_id = $_SESSION['cust_id'];
	if(isset($_REQUEST['action']) && ($_REQUEST['action'] == "datefilter")){
		$start_date = $_REQUEST['startdate'];
		$end_date = $_REQUEST['enddate'];
		$sql ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and (ofd.ORDER_DATE BETWEEN str_to_date('".$start_date."','%Y-%m-%d') AND str_to_date('".$end_date."','%Y-%m-%d')) ORDER BY ofd.ORDER_DATE ASC";
	}
	else
	{
		$sql ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.ORDER_WEB_ID, (DATE_FORMAT( ofd.ORDER_DATE,  '%d/%m/%Y' )) AS ORDER_DATE, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.FREIGHT_TERMS, ofd.VESSEL, ofd.ATTRIBUTE12, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2, cm.ADDRESS3,cm.ADDRESS4,cm.CITY,cm.COUNTRY) AS SHIP_ADDRESS FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up, xxdkapps_customer_master as cm WHERE op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID and ofd.SHIP_TO = cm.SITE_USE_ID and (ofd.ORDER_DATE BETWEEN str_to_date('2016-02-05','%Y-%m-%d') AND str_to_date('2016-02-28','%Y-%m-%d')) ORDER BY ofd.ORDER_DATE DESC";
	}
	$result= $con->data_select($sql);
    if($result != "no") 
    {
	   $html_data = "";
?>
        <div class="container animated bounceInRight">
        	<div class="row adminfilters">
        		<form>
        			<div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        				<label for="adminstartdate">Start Date :</label>
        				<input type="date" id="adminstartdate" class="form-control" placeholder"Start Date" />
        			</div>
        			<div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        				<label for="adminenddate">End Date :</label>
        				<input type="date" id="adminenddate" class="form-control" placeholder"End Date" />
        			</div>
        			<div class="form-group col-xs-12 col-sm-12 col-md-4 col-lg-4">
        				<button type="button" class="btn btn-primary" id="datefilter_btn">Search</button>
        			</div>
        		</form>
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
                    			echo ('
                                <tr data-toggle="collapse" data-target="#demo'.$key.'" class="accordion-toggle">
                                    <td>
                                        <button class="btn btn-default btn-xs">
                                            <span class="glyphicon glyphicon-eye-open"></span>
                                        </button>
                                    </td>
                                    <td>
                                        '.$result[$key]['ORDER_WEB_ID'].'
                                    </td>
                                    <td>
                                        #'.$result[$key]['PO'].'
                                    </td>
                                    <td>
                                        '.$result[$key]['ORDER_DATE'].' 
                                    </td>
                                    <td>
                                        '.$result[$key]['DESCRIPTION'].'
                                    </td>
                                    <td>
                                        '.trim($result[$key]['UNIT_PRICE']).'
                                    </td>
                                    <td>
                                        '.$result[$key]['OSTATUS'].' 
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="12" class="hiddenRow">
                                        <div class="accordian-body collapse" id="demo'.$key.'"> 
                                            <div class="container col-md-6 col-xs-6 col-lg-6 col-sm-6" style="border-right:1px dotted #c9c9c9;">
                                                <div class="form-group">
                                                    <label class="history_label">Order Number: </label>'.$result[$key]['ORACLE_ORDER'].'
                                                </div>
                                                 <div class="form-group">
                                                    <label class="history_label">Order Date: </label>'.$result[$key]['ORDER_DATE'].'
                                                </div>
                                                <div class="form-group">
                                                    <label class="history_label">Shipping Address : </label>'.$result[$key]['SHIP_ADDRESS'].'
                                                </div>
                                                <div class="form-group">
                                                    <label class="history_label">Billing Address : </label>'.$sold_to[0]['SHIP_ADDRESS'].'
                                                </div>
                                                <div class="form-group">
                                                    <label class="history_label">Freight Terms : </label>'.$result[$key]['FREIGHT_TERMS'].'
                                                </div>
                                                <div class="form-group">
                                                    <label class="history_label">Vessel Name : </label>'.$result[$key]['VESSEL'].'
                                                </div>
                                                <div class="form-group">
                                                    <label class="history_label">Pay Terms : </label>'.$result[$key]['ATTRIBUTE12'].'
                                                </div>
                                                <div class="form-group">
                                                    <label class="history_label">Comments : </label>'.$result[$key]['COMMENTS'].'
                                                </div>
                                            </div>
                                            <div class="container col-md-6 col-xs-6 col-lg-6 col-sm-6">
                                                <div class="form-group">
                                                    <label class="history_label">Product Name : </label>'.$result[$key]['DESCRIPTION'].'
                                                </div>
                                                <div class="form-group">
                                                    <label class="history_label">Quantity : </label>'.$result[$key]['QUANTITY']." KG".'
                                                </div>
                                                <div class="form-group">
                                                    <label class="history_label">Packaging Size : </label>'.$result[$key]['PACKAGE_QTY'].' Drum/Tank)
                                                </div>
                                                <div class="form-group">
                                                    <label class="history_label">Price : </label>'.$result[$key]['UNIT_PRICE'].' /KG
                                                </div>
                                                <div class="form-group">
                                                    <label class="history_label">Contact Person : </label>'.$result[$key]['CONTACT_PERSON'].'
                                                </div>
                                            </div>
                                        </div> 
                                    </td>
                                </tr>');
                            }
                            //echo $html_data; 
                        ?>
                        </tbody>
                    </table>             
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
?>