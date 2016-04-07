<div class="modal fade bs-example-modal-lg2" id ="kk_pop" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg2" style="width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="popupclosecross" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Shipment Details</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form>
                            <input type="hidden" name="consignmentid" id="consignmentid">
                            <div class="row">
                                <div class="item form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>Consignee Address</label>
                                    <input class="form-control" data-validate-length-range="6" data-validate-words="2" id="consigneeaddress" name="consigneeaddress" required type="text">
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>Mode Of Shipment</label>
                                    <input class="form-control" data-validate-length-range="6" data-validate-words="2" id="modeofshipment" name="modeofshipment" required type="text">
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>Vessel Name</label>
                                    <input class="form-control col-md-3 col-xs-3" data-validate-length-range="6" data-validate-words="2" id="vesselname" name="vesselname" required type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>ETD</label>
                                    <input class="form-control col-md-4 col-xs-4" data-validate-length-range="6" data-validate-words="2"  id="etd" name="etd" required type="datetime-local">
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>Shipped on Board</label>
                                    <input class="form-control col-md-4 col-xs-4" data-validate-length-range="6" data-validate-words="2" id="shippedonboard" name="shippedonboard" required type="datetime-local">
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <label id="liknktraking"></label>
                                    <input class="form-control col-md-3 col-xs-3" data-validate-length-range="6" data-validate-words="2" id="containername" value="" name="containername" required type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>Transhipment Port</label>
                                    <input class="form-control col-md-3 col-xs-3" data-validate-length-range="6" data-validate-words="2" id="transhipmentport" name="transhipmentport" required type="text">
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>Transhipment vessel Name</label>
                                    <input class="form-control col-md-3 col-xs-3" data-validate-length-range="6" data-validate-words="2" id="transhipmentvesselname" name="transhipmentvesselname" required type="text">
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>ETA</label>
                                    <input  class="form-control col-md-4 col-xs-4" data-validate-length-range="6" data-validate-words="2" id="eta" name="eta" required type="datetime-local">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>Arrival Date</label>
                                    <input  class="form-control col-md-4 col-xs-4" data-validate-length-range="6" data-validate-words="2" id="arrivaldate" name="arrivaldate" required type="datetime-local">
                                </div>                                                         
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>Custom Clearance Date</label>
                                    <input  class="form-control col-md-4 col-xs-4" data-validate-length-range="6" data-validate-words="2" id="customclearancedate" name="customclearancedate" required type="datetime-local">
                                </div>
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <div class="checkbox" id="checkbox">
                                        <label>
                                            <input type="checkbox" value ="yes" name="customclearance" id="customclearance"> Custom Clearence
                                        </label>
                                    </div>
                                    <br />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                    <label>Delivered at customer Location</label></br>
                                    <input  class="form-control col-md-4 col-xs-4" data-validate-length-range="6" data-validate-words="2" id="custdelivered" name="custdelivered" required type="datetime-local">
                                </div>                                                         
                                <div class="form-group col-md-8 col-sm-8 col-xs-8">
                                    <label>Remark</label></br>
                                    <textarea class="form-control" name="remark" id="remark" rows="3"></textarea>
                                </div>
                            </div>  
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <input  data-validate-length-range="6" data-validate-words="2" class="btn btn-primary" onclick="return insertshipment();" name="submit" id="submit" value="OK" required type="button">
                                <input  data-validate-length-range="6" data-validate-words="2" class="btn btn-primary"  name="cancel" id="cancel" onclick="hide_pop();" value="Cancel" required type="button">
                            </div>                    
                        </form>
                    </div>              
                </div>        
            </div>
        </div>
    </div>
</div>
<!--Edit Url Container-->

<div class="modal fade bs-example-modal-lg6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg2" style="width:60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Edit Url</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form  class="form-vertical form-label-right" novalidate method="post" action="">
                            <input type="text" value="" name="edit_container_url" id="edit_container_url" class="col-md-8"/>
                            <span id="add_btn_url"></span>
                            <span id="add_default_url"></span>                                            
                        </form>
                    </div>              
                </div>        
            </div>
        </div>
    </div>
</div>
<!-- End Edit Url Container--> 