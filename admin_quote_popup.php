<?php
  include "classes/functions.php";
    $con =new functions();
    $id = $_REQUEST['id'];
    $qryMem = "SELECT cq.*, up.DESCRIPTION FROM customer_quotations as cq, xxdkapps_unsegregated_products as up WHERE cq.ID ='$id' and cq.PRODUCT_CODE = up.PRODUCT_CODE";
    $mem = $con -> data_select($qryMem);
    $cust_id = $mem[0]['CUSTOMER_NUMBER'];  
?>
<form>
    <div class="modal-body">             
        <div class="row">
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <input type="hidden" id="quote_id" value="<?php echo $id; ?>"/>
                <label for="admin_quote_prod">Product : </label>
                <input type="text" id="admin_quote_prod" class="form-control" name="admin_quote_prod" value="<?php echo $mem[0]['DESCRIPTION'];?>" readonly="true"/>
            </div>  
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_cust_no">Customer Number : </label>
                <input type="text" id="admin_cust_no" class="form-control" name="admin_cust_no" value="<?php echo $mem[0]['CUSTOMER_NUMBER'];?>" readonly="true"/>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_quote_qty">Quantity : </label>
                <input type="text" id="admin_quote_qty" class="form-control" name="admin_quote_qty" value="<?php echo $mem[0]['QUANTITY']; ?>" />
            </div>  
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_quote_pkgsize">Packaging Size : </label>
                <select class="form-control" id="admin_quote_pkgsize">
                    <option <?php if($mem[0]['PACKAGING_SIZE']==1) echo 'selected'; ?>>1</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==5) echo 'selected'; ?>>5</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==10) echo 'selected'; ?>>10</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==20) echo 'selected'; ?>>20</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==25) echo 'selected'; ?>>25</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==30) echo 'selected'; ?>>30</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==35) echo 'selected'; ?>>35</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==40) echo 'selected'; ?>>40</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==45) echo 'selected'; ?>>45</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==50) echo 'selected'; ?>>50</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==100) echo 'selected'; ?>>100</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==150) echo 'selected'; ?>>150</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==165) echo 'selected'; ?>>165</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==170) echo 'selected'; ?>>170</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==175) echo 'selected'; ?>>175</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==180) echo 'selected'; ?>>180</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==185) echo 'selected'; ?>>185</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==190) echo 'selected'; ?>>190</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==200) echo 'selected'; ?>>200</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==220) echo 'selected'; ?>>220</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==227) echo 'selected'; ?>>227</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==900) echo 'selected'; ?>>900</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==1000) echo 'selected'; ?>>1000</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==16000) echo 'selected'; ?>>16000</option>
                    <option <?php if($mem[0]['PACKAGING_SIZE']==20000) echo 'selected'; ?>>20000</option>
                </select>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_quote_avai_price">Available Price : </label>
                <input type="text" id="admin_quote_avai_price" class="form-control" name="admin_quote_avai_price" value="<?php echo $mem[0]['AVAILABLE_PRICE']; ?>" readonly="true" />
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_quote_req_price">Requested Price : </label>
                <input type="text" class="form-control" id="admin_quote_req_price" name="admin_quote_req_price" value="<?php echo $mem[0]['REQUESTED_PRICE']; ?>" readonly="true" />
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_quote_agree_price">Agreed Price : </label>
                <input type="text" class="form-control" id="admin_quote_agree_price" name="admin_quote_agree_price" value="<?php if(($mem[0]['AGREED_PRICE'] > 0)) echo $mem[0]['AGREED_PRICE']; ?>" placeholder="Enter agreed price.." />
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_quote_status">Status : </label>
                <select class="form-control" id="admin_quote_status">
                    <option <?php if($mem[0]['STATUS'] == "Submitted") { echo 'selected'; } ?>>Submitted</option>
                    <option <?php if($mem[0]['STATUS'] == "On Hold") { echo 'selected'; } ?>>On Hold</option>
                    <option <?php if($mem[0]['STATUS'] == "Terminated") { echo 'selected'; } ?>>Terminated</option>
                    <option <?php if($mem[0]['STATUS'] == "Accepted") { echo 'selected'; } ?>>Accepted</option>
                </select>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_cust_remark">Customer Remark :</label>
                <textarea name="admin_cust_remark" id="admin_cust_remark" class="form-control" readonly="true"><?php echo $mem[0]['REMARK']; ?></textarea>
            </div>
            <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label for="admin_feeback">Feedback/Note :</label>
                <textarea name="admin_feeback" id="admin_feeback" class="form-control" placeholder="Leave your comment/note here..."><?php echo $mem[0]['FEEDBACK']; ?></textarea>
            </div>
            <?php
            if(!$mem[0]['FILE_NAME']==""){ ?> 
                <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <input type="hidden" id="old_file_name" value="<?php echo $mem[0]['FILE_NAME']; ?>"/>
                    <button type="button" class="btn btn-primary" id="admin_upload_quote_doc_btn"><i class="fa fa-paperclip"></i> Change Quotation File</button>
                </div>
            <?php } ?>
            <input type="file" name="admin_change_quote" id="admin_change_quote" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/*" style="visibility:hidden;">
        </div>
    </div>
    <div class="modal-footer">
        <br>
        <button type="button" class="btn btn-primary" name="submit_admin_quote" id="submit_admin_quote">Update</button>&nbsp;
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</form>