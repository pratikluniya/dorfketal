<?php
    include "classes/functions.php";
    $con =new functions();

    $qryMem = "SELECT cp.ID, cp.PO_NUMBER, cp.SHIP_TO, cp.SOLD_TO, cp.CONTACT_PERSON, cp.DELIVERY_DATE, cp.FREIGHT_TERM, cp.FREIGHT_CHARGES, cp.VESSAL_NAME, cp.PAYMENT_TERM, cp.FILE_NAME, cp.COMMENT, cp.STATUS, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2 , cm.ADDRESS3,cm.ADDRESS4,cm.CITY, cm.COUNTRY) AS SHIP_ADDRESS FROM customer_po as cp, xxdkapps_customer_master as cm WHERE cp.SHIP_TO = cm.SITE_USE_ID and cm.BUSINESS_CODE = 'SHIP_TO' ORDER BY cp.ID DESC";
    $memresult =  $con -> data_select($qryMem);
?>
<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="memberModalLabel">Edit Member Detail</h4>
                </div>
                <div class="ct">
              
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Members Details</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div id="member" class="col-lg-12">                            
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Job Title</th>
                    <th>Service Year</th>
                    <th>Education</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($memresult as $key => $value) {
                            # code...
                        
                            echo '<tr>';
                                echo '<td>'.$value['PO_NUMBER'].'</td>';
                                echo '<td>'.$value['SHIP_TO'].'</td>';
                                echo '<td>'.$value['FILE_NAME'].'</td>';
                                echo '<td>'.$value['STATUS'].'</td>';
                    ?>
                                <td>
                                    <a class="btn btn-small btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $value['ID']; ?>">Edit</a></td>
                        
                    <?php
                            echo '</tr>';
                    }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    <script>
    $('#exampleModal').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var recipient = button.data('whatever') // Extract info from data-* attributes
          var modal = $(this);
          var dataString = 'id=' + recipient;

            $.ajax({
                type: "POST",
                url: "editdata.php",
                data: dataString,
                cache: false,
                success: function (data) {
                    console.log(data);
                    modal.find('.ct').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });  
    })
    </script>
</body>
</html>