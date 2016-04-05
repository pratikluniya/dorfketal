<?php

ob_start();
include('admin_sidebar_header.php');
include('../classes/functions.php');
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
                                       <input type="text" value="<?php echo $result_tracking_url[0]['tracking_url'];?>" name="tracking_url" id="tracking_url" class="col-md-6"/>
                                       <input type="button" name="btn_tracking" id="btn_tracking" value="Edit Url" class="col-md-2" onclick="return change_url();"/>
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
  <script type="text/javascript">
     function change_url() {
      var tracking_url=$("#tracking_url").val();
     // alert(tracking_url);
             $.ajax({
              url: "logistics/ajax_service.php",
              data : "tracking_url="+tracking_url+"&action=change_url",
              success:function(data){ 

                   alert(data);
              }
            });
     }
      
  </script>           
<?php
 
  include('footer.php');
  ob_end_flush();
?>