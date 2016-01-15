<div class="modal fade bs-example-modal-lg4" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:40%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="popupclosecross" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Download Document Details</h4>
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
function showcustomerdocument (consignment_id) {
    $.ajax({
        type:"POST",
        url:"ajax.php",
        data:"consignment_id="+consignment_id+"&action=showcustomerdocument",
        dataType:"JSON",
        success: function(data)
        {
            console.log(data);
            var trHTML = '<table class="table"><tr><th>Document Type</th><th><strong>Document Name</strong></th><th><strong>Upload Date</strong></th></tr>';
            var newHtml="";
            if((data[0].shipping_document != "") && (data[0].shipping_document !=null))
            {
                trHTML+='<tr id="rows"><td>Shipping Document</td><td><a style="color:blue;" target="_blank" href="uploaded/'+data[0].shipping_document+'">'+data[0].shipping_document+'</a></td><td>'+data[0].shipping_document_update+'</td></tr>';
            }
            if((data[0].commercial_invoice != "") && (data[0].commercial_invoice !=null) )
            {  
                trHTML+='<tr id="rowc"><td>Commercial Invoice</td><td><a style="color:blue;" target="_blank" href="uploaded/'+data[0].commercial_invoice+'">'+data[0].commercial_invoice+'</a></td><td>'+data[0].commercial_invoice_update+'</td></tr>';
            }
            trHTML+='</table>';
            $('#documenttable').html(trHTML); 
        }
    });
}
</script>