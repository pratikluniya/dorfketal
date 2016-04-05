<script type="text/javascript">
  function insertshipment()
  {
      var consignmentid=$("#consignmentid").val();
      var consigneeaddress=$("#consigneeaddress").val();
      var modeofshipment=$("#modeofshipment").val();
      var vesselname=$("#vesselname").val();
      var etd=$("#etd").val();
      var shippedonboard=$("#shippedonboard").val();
      var containername=$("#containername").val();
      var transhipmentport=$("#transhipmentport").val();
      var transhipmentvesselname=$("#transhipmentvesselname").val();
      var eta=$("#eta").val();
      var arrivaldate=$("#arrivaldate").val();
      var customclearancedate=$("#customclearancedate").val();      
      var custdelivered=$("#custdelivered").val();
      var remark=$("#remark").val();      
      if($("#customclearance").prop("checked") == false)
      {
        var customclearance="NA";        
      }
      else
      {
        var customclearance=$("#customclearance").val();
      }
      if(arrivaldate == null || arrivaldate =="" || arrivaldate == '')
      {
         customclearance = $("#customclearance").prop("checked") == false;
         customclearance="NA";
         var customclearancedate=$("#customclearancedate").val(" ");      
         var custdelivered=$("#custdelivered").val(" ");
      }
      
     $.ajax({
        type: "POST",
        url:"logistics/ajax_service.php",
       // id, consigneement_addrss, mode_of_shipment, vessel_name, etd_date, shipped_on_board, transhipment_port, transhipment_vessel_name, eta_date, arrival_date, custom_clearance_date, custom_clearance, delivered_cutomer_loaction, remark, consignment_id
        data:"consignment_address="+consigneeaddress+"&mode_of_shipment="+modeofshipment+"&vessel_name="+vesselname+"&etd_date="+etd+"&shipped_on_board="+shippedonboard+"&container_name="+containername+"&transhipment_port="+transhipmentport+"&transhipment_vessel_name="+transhipmentvesselname+"&eta_date="+eta+"&arrival_date="+arrivaldate+"&custom_clearance_date="+customclearancedate+"&custom_clearance="+customclearance+"&delivered_cutomer_loaction="+custdelivered+"&remark="+remark+"&consignment_id="+consignmentid+"&action=insertupdateconsignment",
        success: function(data)
        {
          alert(data);
          console.log(data);
          $("#kk_pop").hide();
         //location.reload();
        }
      
    });
  }
  
</script>
<div class="modal fade bs-example-modal-lg2" id ="kk_pop" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg2" style="width:90%;">
   <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" id="popupclosecross" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Shipment Details</h4>
            <div class="x_content bs-example-popovers" id="pop">

           </div>
        </div>
        <div class="modal-body">
           <div class="row">
                <div class="col-md-12">
                      <form  class="form-vertical form-label-right" novalidate method="post" action="">

                         <input type="hidden" name="consignmentid" id="consignmentid" >
                           <div class="item form-group">                                  
                                  <div class="col-md-2 col-sm-4 col-xs-3">
                                       <label>Consignee Address</label></br>
                                       <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" 
                                      data-validate-words="2" id="consigneeaddress" name="consigneeaddress" required type="text">
                                  </div>
                                  <div class="col-md-2 col-sm-4 col-xs-3">
                                       <label>Mode Of Shipment</label></br>
                                         <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" 
                                      data-validate-words="2" id="modeofshipment" name="modeofshipment" required type="text">
                                  </div>
                                  <div class="col-md-2 col-sm-4 col-xs-3">
                                       <label>Vessel Name</label></br>
                                         <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" 
                                      data-validate-words="2" id="vesselname" name="vesselname" required type="text">
                                  </div>
                                  <div class="col-md-3 col-sm-4 col-xs-4">
                                       <label>ETD</label></br>
                                        <input  class="form-control col-md-4 col-xs-4" data-validate-length-range="6" 
                                      data-validate-words="2"  id="etd" name="etd" required type="datetime-local">
                                  </div>
                                   <div class="col-md-3 col-sm-4 col-xs-4">
                                       <label>Shipped on Board</label></br>
                                        <input  class="form-control col-md-4 col-xs-4" data-validate-length-range="6" 
                                      data-validate-words="2" id="shippedonboard" name="shippedonboard" required type="datetime-local">
                                  </div>
                                                                                          
                            </div>
                            <div class="row">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="item form-group">                                  
                                   <div class="col-md-2 col-sm-3 col-xs-3">
                                       <label id="liknktraking"></label></br>
                                         <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" 
                                      data-validate-words="2" id="containername" value="" name="containername" required type="text">
                                      

                                  </div>
                                  <div class="col-md-2 col-sm-3 col-xs-3">
                                       <label>Transhipment Port</label></br>
                                         <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" 
                                      data-validate-words="2" id="transhipmentport" name="transhipmentport" required type="text">
                                  </div>
                                  <div class="col-md-2 col-sm-3 col-xs-3">
                                       <label>Transhipment vessel Name</label></br>
                                         <input  class="form-control col-md-3 col-xs-3" data-validate-length-range="6" 
                                      data-validate-words="2" id="transhipmentvesselname" name="transhipmentvesselname" required type="text">
                                  </div>
                                  <div class="col-md-3 col-sm-4 col-xs-4">
                                       <label>ETA</label></br>
                                        <input  class="form-control col-md-4 col-xs-4" data-validate-length-range="6" 
                                      data-validate-words="2" id="eta" name="eta" required type="datetime-local">
                                  </div>
                                  <div class="col-md-3 col-sm-4 col-xs-4">
                                       <label>Arrival Date</label></br>
                                        <input  class="form-control col-md-4 col-xs-4" data-validate-length-range="6" 
                                      data-validate-words="2" id="arrivaldate" name="arrivaldate" required type="datetime-local">
                                  </div>                                                         
                            </div>

                              <div class="row">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>

                            <div class="item form-group">                                  
                                   <div class="col-md-3 col-sm-4 col-xs-4">
                                       <label>Custom Clearance Date</label></br>
                                        <input  class="form-control col-md-4 col-xs-4" data-validate-length-range="6" 
                                      data-validate-words="2" id="customclearancedate" name="customclearancedate" required type="datetime-local">
                                  </div> 
                                  <div class="col-md-2 col-sm-3 col-xs-3">
                                     <div class="checkbox" id="checkbox">
                                     <label>&nbsp;</label></br>
                                          <label class="">
                                              <div class="icheckbox_flat-green " style="position: relative;">
                                              <input type="checkbox" value ="yes"  name="customclearance"  id="customclearance" style="margin-left: 4px;" >
                                             
                                              </div> Custom Clearence
                                          </label>
                                     </div>
                                   </div> 
                                  
                                  <div class="col-md-3 col-sm-4 col-xs-4">
                                       <label>Delivered at customer Location</label></br>
                                        <input  class="form-control col-md-4 col-xs-4" data-validate-length-range="6" 
                                      data-validate-words="2" id="custdelivered" name="custdelivered" required type="datetime-local">
                                  </div>                                                         
                            </div>

                              <div class="row">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="item form-group"> 

                              <div class="col-md-9 col-sm-9 col-xs-12">
                                   <label>Remark</label></br>
                                   <textarea class="form-control" name="remark" id="remark" rows="3"></textarea>
                              </div>
                              <div class="col-md-3 col-sm-9 col-xs-12">
                                   <div class="pull-right">
                              <div class="item form-group">
                                 <label>&nbsp;</label></br>                                                        
                                  <div class="col-md-12 col-sm-5 col-xs-5">
                                      <input  data-validate-length-range="6" 
                                      data-validate-words="2" class="btn btn-primary" onclick="return insertshipment();" name="submit" id="submit" value="OK" required type="button">
                                      <input  data-validate-length-range="6" 
                                      data-validate-words="2" class="btn btn-primary"  name="cancel" id="cancel" onclick="hide_pop();" value="Cancel" required type="button">
                                  </div>
                                </div>                             
                              </div> 
                              </div>
                            </div>                    
                     </form>
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
            <div class="x_content bs-example-popovers" id="pop">

           </div>
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
</div>
<script type="text/javascript">
     function container_edit_url(delivery_details_id) {
      var tracking_url=$("#edit_container_url").val();
     // var delivery_details_id=$("#delivery_id").val();
      var r =confirm("Are you sure you want to update url");
      if(r == true)
      {
         // alert(tracking_url);
             $.ajax({
              url: "logistics/ajax_service.php",
              data : "tracking_url="+tracking_url+"&delivery_details_id="+delivery_details_id+"&action=container_url_edit",
              success:function(data){ 

                   alert(data);
                   location.reload();
              }
            });
      }
      else
      {

      }

    
     }
      function container_default_url(delivery_details_id) {
     // var tracking_url=$("#edit_container_url").val();
     // var delivery_details_id=$("#delivery_id").val();
      var r =confirm("Are you sure you want to update url");
      if(r == true)
      {
         // alert(tracking_url);
             $.ajax({
              url: "logistics/ajax_service.php",
              data : "delivery_details_id="+delivery_details_id+"&action=container_Default_url",
              success:function(data){ 

                   alert(data);
               
              }
            });
      }
      else
      {

      }

    
     }
     function hide_pop()
     {
         $("#kk_pop").hide();
     }

  </script> 