<?php
include "classes/functions.php";
include "getorderdetail.php";
session_start();
$con =new functions();
$cust_id = $_SESSION['cust_id'];

$sql ="SELECT op.ORDER_ID, op.PRODUCT_CODE, op.PACKAGE_QTY, op.QUANTITY, op.UNIT_PRICE, op.OSTATUS, op.REMARKS, up.DESCRIPTION, ofd.ID, ofd.ORACLE_ORDER, ofd.CUSTOMER_NUMBER, ofd.PO, ofd.DELIVERY_DATE, ofd.CONTACT_PERSON, ofd.COMMENTS, ofd.ATTRIBUTE12 FROM order_form_details as ofd, order_products as op, xxdkapps_unsegregated_products as up WHERE ofd.CUSTOMER_NUMBER= " . $cust_id." and op.PRODUCT_CODE = up.PRODUCT_CODE and op.ORDER_ID = ofd.ID";    
$result=$con->data_select($sql);
// echo "<pre>";
// print_r($result);
if($result != "no")
{
?>
    <div class="container table-responsive animated bounceInRight">
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="headings">
                    <th>Order ID</th>
                    <th>PO</th>
                    <th>Product</th>
                    <th>Comments</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
        <?php
        foreach ($result as $key => $value) 
        {
            $result[$key] = array_map('trim', $result[$key]);
        ?>
                <tr>
                    <td> 
                        <?php echo ("#".$result[$key]['ORACLE_ORDER']); ?> 
                    </td>
                    <td> 
                        <?php echo ("#".$result[$key]['PO']); ?> 
                    </td>
                    <td>
                        <?php echo $result[$key]['DESCRIPTION']; ?>    
                    </td>
                    <td>
                        <?php echo trim($result[$key]['COMMENTS']); ?> 
                    </td>
                    <td>
                        <?php echo $result[$key]['OSTATUS']; ?> 
                    </td>
                    <td>
                        <button class="btn btn-primary" id="getorderdetails_btn" data-toggle="modal" data-target=".bs-example-modal-lg4" onclick= getorderdetail(<?php echo ($result[$key]['ORDER_ID'].','.$result[$key]['ORACLE_ORDER']); ?>);>Details</button>
                    </td>
                </tr>
        <?php 
        }
        ?>
            </tbody>
        </table>
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
?>
    </div>
<div class="modal fade bs-example-modal-lg4" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="popupclosecross" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Order Details</h4>
            </div>
            <div class="modal-body table-responsive"  id="documenttable">
                <div class="row">
                    <div class="col-md-7">                      
                          
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function getorderdetail (order_id,oracle_order) {
    $.ajax({
        type:"POST",
        url:"ajax.php",
        data:"order_id="+order_id+"&oracle_order="+oracle_order+"&action=getorderdetail",
        dataType:"JSON",
        success: function(data)
        {
            console.log(data);
            $('#documenttable').html(data); 
        }
    });
}
</script>
