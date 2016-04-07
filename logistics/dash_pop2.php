<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="popupclosecross" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">Document Details</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="col-md-7">
                        <form  id="uploadForm">
                            <div class="row">
                                <div class="item form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>Consignment No </label></br>
                                    <input class="form-control" data-validate-length-range="6" data-validate-words="2" id="consignmentid1" name="consignmentid1" required type="text" readonly="readonly">
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>Service Provider</label></br>
                                    <input class="form-control" data-validate-length-range="6" data-validate-words="2" id="serviceprovider" name="serviceprovider" required type="text">
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>Date</label></br>
                                    <input  class="form-control col-md-4 col-xs-4" data-validate-length-range="6" data-validate-words="2" id="createddate" name="createddate" required type="datetime-local">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>Document Type</label></br>
                                    <select class="form-control" id="documenttype" name="documenttype" onchange="show_option(this.value);">
                                        <option value ="0">Select Document</option>
                                        <option value ="Shipping Documents">Shipping Documents</option>
                                        <option  value ="Commercial Invoice">Commercial Invoice</option>
                                        <option   value ="India Commercial Invoice">India Commercial Invoice</option>    
                                    </select>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-4 option_div hide">
                                    <label>Select Shipping Document Uploaded</label></br>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="Bill of Laden" name="bill_of_laden" id="bill_of_laden"> Bill of Laden
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="Packing List" name="packing_list" id="packing_list"> Packing List
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="Certificate Of Analysis" name="certificate_of_analysis" id="certificate_of_analysis"> Certificate Of Analysis
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="Certificate of Origin" name="certificate_of_origin" id="certificate_of_origin"> Certificate of Origin
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="Gsp" name="gsp" id="gsp"> Gsp
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="Haz Declaraition" name="haz_declaraition" id="haz_declaraition"> Haz Declaraition
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="MSDS" name="msds" id="msds"> MSDS
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="Heat Treatment Certification" name="heat_treatment_certification" id="heat_treatment_certification"> Heat Treatment Certification
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="Benificary Declaration" name="benificary_declaration" id="benificary_declaration"> Benificary Declaration
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="Certificate Quantity" name="certificate_quantity" id="certificate_quantity"> Certificate Quantity
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>Upload a file(Max Size 32MB)</label></br>
                                    <input  class="form-control" data-validate-length-range="6" data-validate-words="2" id="document" name="document" required type="file">
                                </div>
                            </div>
                            <div class="row">
                                <div class="item col-md-12 col-sm-12 col-xs-12 form-group pull-right">
                                    <input  data-validate-length-range="6" data-validate-words="2" class="btn btn-primary" name="ok" id="document_upload" value="OK"  type="button">
                                      <input  data-validate-length-range="6" data-validate-words="2" class="btn btn-primary" name="submit" id="submit" value="Cancel" required type="SUBMIT">
                                </div>
                            </div>
                        </form>     
                    </div>
                    <div class="col-md-5">
                        <div class="col-md-12 col-sm-8 col-xs-8" >
                            <label>Document Uploaded</label>
                            <div id="targetLayer">
                             
                            </div>
                        </div>
                    </div>   
               </div>
            </div>
        </div>
    </div>
</div>

<script>


$(document).ready(function (e) {    
    $("#document_upload").click(function(e){ 
        var consignmentid1=$("#consignmentid1").val();
        var serviceprovider=$("#serviceprovider").val();
        var createddate=$("#createddate").val();
        var documenttype=$("#documenttype").val();
        if($('#bill_of_laden').prop('checked'))
        {              
            var bill_of_laden=$("#bill_of_laden").val();
        }
        if($('#packing_list').prop('checked'))
        {                 
            var packing_list=$("#packing_list").val();
        }
        if($('#certificate_of_analysis').prop('checked'))
        {                
            var certificate_of_analysis=$("#certificate_of_analysis").val();
        }
        if($('#certificate_of_origin').prop('checked'))
        {               
            var certificate_of_origin=$("#certificate_of_origin").val();
        }
        if($('#gsp').prop('checked'))
        {               
            var gsp=$("#gsp").val();
        }
        if($('#haz_declaraition').prop('checked'))
        {                
            var haz_declaraition=$("#haz_declaraition").val();
        }
        if($('#non_hAZ_declaraition').prop('checked'))
        {                
            var non_hAZ_declaraition=$("#non_hAZ_declaraition").val();
        }
        if($('#msds').prop('checked'))
        {               
            var msds=$("#msds").val();
        }
        if($('#heat_treatment_certification').prop('checked'))
        {              
            var heat_treatment_certification=$("#heat_treatment_certification").val();
        }
        if($('#benificary_declaration').prop('checked'))
        {                
            var benificary_declaration=$("#benificary_declaration").val();
        }
        if($('#certificate_quantity').prop('checked'))
        {                
            var certificate_quantity=$("#certificate_quantity").val();
        }
        var form_data = new FormData(); 
        var file_data = $('#document').prop('files')[0]; 
        form_data.append('document', file_data); 
        form_data.append('consignmentid1', consignmentid1);
        form_data.append('serviceprovider', serviceprovider);      
        form_data.append('createddate', createddate);
        form_data.append('documenttype',documenttype);
        form_data.append('bill_of_laden',bill_of_laden)
        form_data.append('packing_list',packing_list);
        form_data.append('certificate_of_analysis',certificate_of_analysis);
        form_data.append('certificate_of_origin',certificate_of_origin);
        form_data.append('gsp',gsp);
        form_data.append('haz_declaraition',haz_declaraition);
        form_data.append('non_hAZ_declaraition',non_hAZ_declaraition);
        form_data.append('msds',msds);
        form_data.append('heat_treatment_certification',heat_treatment_certification);
        form_data.append('benificary_declaration',benificary_declaration);
        form_data.append('certificate_quantity',certificate_quantity);
        $.ajax({               
            url: "logistics/upload.php",
            type: "POST",
            data: form_data,
            contentType: false,
            cache: false,
            processData:false,
            success: function(data)
            { 
                console.log(data);
                if(data == "success")
                {
                    $("#pop").html('<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert"aria-label="Close"><span aria-hidden="true">×</span></button>You have successfully completed your Action </div>');
                    $("#pop").fadeOut(5000);
                    var expload= function()
                    {
                    };
                    setTimeout(expload,5001);
                }
                else
                {
                    alert("faield");
                }
            },
            error: function() 
            {
            }           
        });
    });  
});
</script>