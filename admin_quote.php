<?php
include "classes/functions.php";
session_start();
$cust_id = $_SESSION['cust_id'];
$con =new functions();
//Fetch Quations History
$sql_quote = "SELECT cq.ID, cq.PRODUCT_CODE, cq.PACKAGING_SIZE, cq.QUANTITY, cq.FILE_NAME, cq.AVAILABLE_PRICE, cq.REQUESTED_PRICE, cq.REMARK, cq.FILE_NAME, cq.STATUS, up.DESCRIPTION FROM customer_quotations as cq, xxdkapps_unsegregated_products as up WHERE cq.PRODUCT_CODE = up.PRODUCT_CODE ORDER BY cq.ID DESC";
$result_quote_history = $con -> data_select($sql_quote);
if($result_quote_history != "no") 
{
	$html_data = "";
?>
	<div class="container table-responsive animated fadeIn quote-history-div">
	    <table id="cart_table" class="table table-bordered table-striped">
	    	<thead>
	      		<tr class="headings">
	        		<th>PRODUCT NAME</th>
	        		<th>AVAILABLE PRICE (PER KG)</th>
	        		<th>REQUESTED PRICE (PER KG)</th>
	        		<th>FILE_NAME</th>
	        		<th>STATUS</th>
	        		<th>Edit</th>
	      		</tr>
	    	</thead>
	    	<tbody id="quote_history_table">
				<?php
				foreach ($result_quote_history as $key => $value) 
				{
					$html_data .= '<tr class="item">        	
			        	<td>
			        		'.$value['DESCRIPTION'].'
			        	</td>
			            <td>
			            	'.$value['AVAILABLE_PRICE'].'
			            </td>
			            <td>
			            	'.$value['REQUESTED_PRICE'].'
			            </td>
			            <td>
			            	<a href="uploadedquotes/'.$value['FILE_NAME'].'" target="_blank">'.$value['FILE_NAME'].'</a>
			            </td>
			            <td>
			            	'.$value['STATUS'].'
			            </td>
			            <td>
			            	<a class="btn btn-small btn-primary" data-toggle="modal" data-target="#edit_quote_Modal" data-whatever="'.$value['ID'].'">Edit</a>
			            </td>
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
<div class="modal fade" id="edit_quote_Modal" tabindex="-1" role="dialog" aria-labelledby="editquoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="editpoModalLabel">Edit Quotation Detail</h4>
            </div>
            <div class="ct">
          
            </div>
        </div>
    </div>
</div>
<script>
    $('#edit_quote_Modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var recipient = button.data('whatever') // Extract info from data-* attributes
		var modal = $(this);
		var dataString = 'id=' + recipient;
        $.ajax({
            type: "POST",
            url: "admin_quote_popup.php",
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