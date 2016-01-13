<?php

ob_start();
include('admin_sidebar_header.php');
include('class/functions.php');
$con=new functions();
date_default_timezone_set("Asia/Kolkata"); 
$date4=date('Y-m-d H:i:s');
$query_tracking_url="SELECT * FROM tracking_url WHERE id=1";
$result_tracking_url=$con->data_select($query_tracking_url);
/*echo "<pre>";
print_r($result_tracking_url[0]['tracking_url']);
exit;*/

?>
<!-- page content -->           
<div class="right_col" role="main">
    <div class="clearfix"></div>        
        <div class="row">           
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-md-12">              
                        <div class="x_panel">
                          <div class="x_title">
                              <h2>Tracking  Url</h2>
                               <div class="col-md-12">
                                <div class="x_panel">
                                  <div class="col-md-12">
                                    <form>                                   
                                       <input type="text" value="<?php echo $result_tracking_url[0]['tracking_url'];?>" name="tracking_url" id="tracking_url" class="col-md-6" readonly/>
                                       <input type="button" data-toggle="modal" data-target=".bs-example-modal-lg6" name="btn_tracking" id="btn_tracking" value="Edit Url" class="col-md-2" onclick=""/>
                                    </form>
                                  </div>
                               </div>
                             </div>
                          <div class="clearfix"></div>
                      </div>
                </div>
            </div>
        </div>  
    </div>
</div>
<!--Start Popup Box   -->
<div class="modal fade bs-example-modal-lg6" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg2" style="width:60%;">
   <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" id="popupclosecross" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Edit Url</h4>
            <div class="x_content bs-example-popovers" id="pop">

           </div>
        </div>
        <div class="modal-body">
           <div class="row">
                <div class="col-md-12">
                      <form  class="form-vertical form-label-right" novalidate method="post" action="">
                        <input type="hidden" name="delivery_id" id="delivery_id" value="<?php echo $_GET['delivery_details_id'];?>" />
                        <input type="text" value="<?php echo $result_tracking_url[0]['tracking_url'];?>" name="url" id="url" class="col-md-8"/>
                        <input type="button"  name="btn_edit" id="btn_edit" value="Edit Url" class="col-md-2" onclick="return container_edit_url();"/>                                            
                     </form>
                </div>              
             </div>        
        </div>
     </div>
  </div>
</div>

<!-- End Popup Box -->



  <script type="text/javascript">
     function container_edit_url() {
      var tracking_url=$("#url").val();
      var delivery_details_id=$("#delivery_id").val();
      var r =confirm("Are you sure you want to update url");
      if(r == true)
      {
         // alert(tracking_url);
             $.ajax({
              url: "ajax_service.php",
              data : "tracking_url="+tracking_url+"&delivery_details_id="+delivery_details_id+"&action=container_url_edit",
              success:function(data){ 

                   alert(data);
              }
            });
      }
      else
      {

      }

    
     }
      
  </script>           
<?php
 
  include('footer.php');
  ob_end_flush();
?>