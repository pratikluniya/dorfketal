<div class="modal fade bs-example-modal-lg5" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:40%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="popupclosecross" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Consignment Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7" id="showshipmentdetails" class="table-responsive">                      
                         
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function showshipmentdetails (consignmentid) {
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data:"consignment_id="+consignmentid+"&action=customershippeddetails",
        dataType:"JSON",
        success: function(data)
        {
            var data_html='<table class="table" style="width: 182%; max-width: 174%;">'
            +'<tr><td style="width: 56%;">Purchase Order Number</td><td>'+data[0].cust_po_number+'</td></tr>'
            +'<tr><td style="width: 56%;">Consignee Address</td><td>'+data[0].consignment_address+'</td></tr>'
            +'<tr><td style="width: 56%;">Mode Of Shipment</td><td>'+data[0].mode_of_shipment+'</td></tr>'
            +'<tr><td style="width: 56%;">Vessel Name</td><td>'+data[0].vessel_name+'</td></tr>'
            +'<tr><td style="width: 56%;">Expected Date Of Departure</td><td>'+data[0].etd_date+'</td></tr>'
            +'<tr><td style="width: 56%;">Container Number</td><td><a href="'+data[0].url_logistic+data[0].container_number+'">'+data[0].container_number+'</a></td></tr>'
            +'<tr><td style="width: 56%;">Shipped On Board</td><td>'+data[0].shipped_on_board+'</td></tr>'
            +'<tr><td style="width: 56%;">Transhipment Port</td><td>'+data[0].transhipment_port+'</td></tr>'
            +'<tr><td style="width: 56%;">Transhipment Vessel Name</td><td>'+data[0].transhipment_vessel_name+'</td></tr>'
            +'<tr><td style="width: 56%;">Expected Date Of Arrival</td><td>'+data[0].eta_date+'</td></tr>'
            +'<tr><td style="width: 56%;">Arrival Date @ Destination</td><td>'+data[0].arrival_date+'</td></tr>'
            +'<tr><td style="width: 56%;">Customer clearance Date</td><td>'+data[0].custom_clearance_date+'</td></tr>'
            +'<tr><td style="width: 56%;">Delivered at Customer Location</td><td>'+data[0].delivered_cutomer_loaction+'</td></tr>'
            +'<tr><td style="width: 56%;">Document Courier tracking Number</td><td>'+data[0].purchase_order_number+'</td></tr>'
            +'<tr><td style="width: 56%;">Document Corier Tracking Date</td><td>'+data[0].purchase_order_number+'</td></tr>'
            +'<tr><td style="width: 56%;">Document Corier Tracking Service</td><td>'+data[0].purchase_order_number+'</td></tr>'
            +'<tr><td style="width: 56%;">Remark</td><td>'+data[0].remark+'</td></tr>'
            +'</table>';
            $("#showshipmentdetails").html(data_html);
        }
    });
}
</script>