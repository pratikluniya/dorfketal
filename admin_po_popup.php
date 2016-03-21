<?php
  include "classes/functions.php";
    $con =new functions();
    $id = $_REQUEST['id'];
    $qryMem = "SELECT * FROM `customer_po` WHERE `ID`='$id'";
    $mem = $con -> data_select($qryMem);
    $cust_id = $mem[0]['CUSTOMER_NUMBER'];  

    //Fetching Sold_To droupdown values
    $sql_sold_to = "SELECT distinct  SITE_USE_ID as ID, PRIMARY_FLAG,
           CONCAT_WS(',',ADDRESS1,ADDRESS2, ADDRESS3,ADDRESS4,CITY,COUNTRY) AS SHIP_ADDRESS       
           FROM xxdkapps_customer_master WHERE BUSINESS_CODE ='BILL_TO'
           and CUSTOMER_NUMBER = ".$cust_id."
           and ACCOUNT_STATUS='A'
           order by PRIMARY_FLAG DESC";
    $result_sold_to=$con->data_select($sql_sold_to);
    
    //Fetching Ship_To droupdown values
    $sql_ship_to = "SELECT distinct SITE_USE_ID as ID, PRIMARY_FLAG,
           CONCAT_WS(',',ADDRESS1,ADDRESS2 , ADDRESS3,ADDRESS4,CITY, COUNTRY) AS SHIP_ADDRESS         
           FROM xxdkapps_customer_master WHERE BUSINESS_CODE ='SHIP_TO'
           and CUSTOMER_NUMBER = ".$cust_id."
           and ACCOUNT_STATUS='A'
           order by PRIMARY_FLAG DESC";
    $result_ship_to = $con -> data_select($sql_ship_to);
    
    //Fetching Payment Terms droupdown values
    $sql_payment_terms = "SELECT TERM_ID, DESCRIPTION FROM xxdkapps_payment_terms";
    $result_payment_terms = $con -> data_select($sql_payment_terms);
?>
<form>
    <div class="modal-body">             
        <div class="row">
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <input type="hidden" id="po_id" value="<?php echo $id; ?>"/>
                <label for="admin_po_number">PO# Number : </label>
                <input type="text" id="admin_po_number" class="form-control" name="admin_po_number" value="<?php echo $mem[0]['PO_NUMBER'];?>"/>
            </div>  
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_cust_no">Customer Number : </label>
                <input type="text" id="admin_cust_no" class="form-control" name="admin_cust_no" value="<?php echo $mem[0]['CUSTOMER_NUMBER'];?>" readonly="true"/>
            </div>  
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_sold_to">Billing Address : </label>
                <select class="form-control" id="admin_sold_to">
                    <?php
                    foreach($result_sold_to as $key => $value):
                        echo '<option value="'.$value['ID'].'">'.$value['SHIP_ADDRESS'].'</option>'; //close your tags!!
                    endforeach;
                    ?>
                </select>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_ship_to">Shipping Address : </label>
                <select class="form-control" id="admin_ship_to">
                    <?php
                    foreach($result_ship_to as $key => $value):
                        echo '<option value="'.$value['ID'].'">'.$value['SHIP_ADDRESS'].'</option>'; //close your tags!!
                    endforeach;
                    ?>
                </select>
            </div>  
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_con_per">Contact Person : </label>
                <input type="text" id="admin_con_per" class="form-control" name="admin_con_per" value="<?php echo $mem[0]['CONTACT_PERSON']; ?>" />
            </div>  
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_del_date">Delivery Date : </label>
                <input type="date" id="admin_del_date" class="form-control" name="admin_del_date" value="<?php echo $mem[0]['DELIVERY_DATE']; ?>" />
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_fterm">Freight Term : </label>
                <select class="form-control" id="admin_fterm">
                    <option <?php if($mem[0]['FREIGHT_TERM'] == "Ex-Works") { echo 'selected'; } ?>>Ex-Works</option>
                    <option <?php if($mem[0]['FREIGHT_TERM'] == "At Site") { echo 'selected'; } ?>>At Site</option>
                </select>
            </div>
            <?php if($mem[0]['FREIGHT_TERM'] == "At Site") {?>
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_fcharges">Freight Charges : </label>
                <input type="text" id="admin_fcharges" class="form-control" name="admin_fcharges" value="<?php echo $mem[0]['FREIGHT_CHARGES']; ?>" />
            </div>
            <?php } ?>
            
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_vessal">Vessal Name : </label>
                <input type="text" id="admin_vessal" class="form-control" name="admin_vessal" value="<?php echo $mem[0]['VESSAL_NAME']; ?>" />
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_payment_term">Payment Terms : </label>
                <select class="form-control" name="admin_payment_term" id="admin_payment_term">
                    <option value="0">Select One</option>
                    <?php
                        foreach($result_payment_terms as $key => $value):
                            echo '<option value="'.$value['TERM_ID'].'">'.$value['DESCRIPTION'].'</option>'; 
                        endforeach;
                    ?>
                </select>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_client_comment">Comment :</label>
                <textarea name="admin_client_comment" id="admin_client_comment" class="form-control"><?php echo $mem[0]['COMMENT']; ?></textarea>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_feeback">Feedback/Note :</label>
                <textarea name="admin_feeback" id="admin_feeback" class="form-control" placeholder="Leave your comment/note here..."><?php echo $mem[0]['FEEDBACK']; ?></textarea>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_po_status">Status : </label>
                <select class="form-control" id="admin_po_status">
                    <option <?php if($mem[0]['STATUS'] == "Uploaded") { echo 'selected'; } ?>>Uploaded</option>
                    <option <?php if($mem[0]['STATUS'] == "On Hold") { echo 'selected'; } ?>>On Hold</option>
                    <option <?php if($mem[0]['STATUS'] == "Terminated") { echo 'selected'; } ?>>Terminated</option>
                    <option <?php if($mem[0]['STATUS'] == "Accepted") { echo 'selected'; } ?>>Accepted</option>
                </select>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <input type="hidden" id="old_file_name" value="<?php echo $mem[0]['FILE_NAME']; ?>"/>
                <button type="button" class="btn btn-primary" id="admin_upload_po_doc_btn"><i class="fa fa-paperclip"></i> Change PO# File</button>
            </div>
            <input type="file" name="admin_change_po" id="admin_change_po" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" style="visibility:hidden;">
        </div>
    </div>
    <div class="modal-footer">
        <br>
        <button type="button" class="btn btn-primary" name="submit_admin_po" id="submit_admin_po">Update</button>&nbsp;
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>&nbsp;
        <button type="button" class="btn btn-primary" id="complete_order" name="comple_order" style="float:left;">Complete Order</button>
    </div>
</form>
<script>
var ship_to = "<?php echo $mem[0]['SHIP_TO'];?>";
$("#admin_ship_to").val(ship_to);
var pay_term = "<?php echo $mem[0]['PAYMENT_TERM_ID']; ?>";
$('#admin_payment_term').val(pay_term);
</script>