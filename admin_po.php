<?php
include "classes/functions.php";
session_start();
$cust_id = $_SESSION['cust_id'];
$con =new functions();
$sql_PO = "SELECT cp.ID, cp.PO_NUMBER, cp.SHIP_TO, cp.SOLD_TO, cp.CONTACT_PERSON, cp.DELIVERY_DATE, cp.FREIGHT_TERM, cp.FREIGHT_CHARGES, cp.VESSAL_NAME, cp.PAYMENT_TERM, cp.FILE_NAME, cp.COMMENT, cp.STATUS, CONCAT_WS(',',cm.ADDRESS1,cm.ADDRESS2 , cm.ADDRESS3,cm.ADDRESS4,cm.CITY, cm.COUNTRY) AS SHIP_ADDRESS FROM customer_po as cp, xxdkapps_customer_master as cm WHERE cp.SHIP_TO = cm.SITE_USE_ID and cm.BUSINESS_CODE = 'SHIP_TO' ORDER BY cp.ID DESC";
$result_po_history = $con -> data_select($sql_PO);
if($result_po_history != "no") 
    {
	   	$html_data = "";
?>
	   	<div class="container table-responsive animated bounceInRight po-history-div">
	    	<table id="cart_table" class="table table-bordered table-striped">
		    	<thead>
		      		<tr class="headings">
		        		<th>PO# NUMBER</th>
		        		<th>SHIP ADDRESS</th>
		        		<th>FILE</th>
		        		<th>COMMENT</th>
		        		<th>STATUS</th>
		        		<th>ACTION</th>
		      		</tr>
		    	</thead>
		    	<tbody id="po_history_table">
			    	<?php
				   	foreach ($result_po_history as $key => $value) 
					{
				
			    		$html_data .= '<tr class="item">        	
						        	<td>'.$value['PO_NUMBER'].'</td>
						        	<td>'.$value['SHIP_ADDRESS'].'</td>
						            <td><a href="uploadedPO/'.$value['FILE_NAME'].'" target="_blank">'.$value['FILE_NAME'].'</a></td>
						            <td>'.$value['COMMENT'].'</td>
						            <td>'.$value['STATUS'].'</td>
									<td><a class="btn btn-small btn-primary" data-toggle="modal" data-target="#edit_po_Modal" data-whatever="'.$value['ID'].'">Edit</a></td>
						      	</tr>';	
					}
					echo $html_data;
					?>
				</tbody>
			</table>
		</div>
	<?php
	}
	else
	{
		echo '<tr class="item"><td colspan="8" align="center">No Records Found</td></tr>';
	}
?>
<div class="modal fade" id="edit_po_Modal" tabindex="-1" role="dialog" aria-labelledby="editpoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="editpoModalLabel">Edit PO# Detail</h4>
            </div>
            <div class="ct">
          
            </div>
        </div>
    </div>
</div>
<script>
    $('#edit_po_Modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var recipient = button.data('whatever') // Extract info from data-* attributes
		var modal = $(this);
		var dataString = 'id=' + recipient;
        $.ajax({
            type: "POST",
            url: "admin_po_popup.php",
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