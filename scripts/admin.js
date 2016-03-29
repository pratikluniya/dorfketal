/********  Left Sidebar Click Events  *****/ 
$(document).ready(function () {
    $(".admin_orders" ).on( "click", function() {
        $('#loading').addClass("showloading");
        $('.main_heading').html("Orders");
        $('.main_body').load('admin_orders.php', function(data){
            $('#loading').removeClass("showloading");
        });
    });
});
$(document).ready(function () {
    $(".admin_po" ).on( "click", function() {
        $('#loading').addClass("showloading");
        $('.main_heading').html("PO#");
        $('.main_body').load('admin_po.php', function(data){
            $('#loading').removeClass("showloading");
        });
    });
});
$(document).ready(function () {
    $(".admin_quote" ).on( "click", function() {
        $('#loading').addClass("showloading");
        $('.main_heading').html("Quotations");
        $('.main_body').load('admin_quote.php', function(data){
            $('#loading').removeClass("showloading");
        });
    });
});

/********  On Page Click Events  *****/
$(document).ready(function () {
    $(".main_body" ).on( "click","#datefilter_btn", function(e) {
        var err = 0;
        var startdate = $('#adminstartdate').val();
        var enddate = $('#adminenddate').val();
        if(startdate == "" || enddate == "")
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please select start and end date to filter data!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            err =1;
        }
        if(err == 0)
        {
            $.ajax({
                type: "POST",
                url: "admin_orders.php",
                data: 'startdate=' + startdate +'&enddate='+ enddate + '&action=datefilter',
                beforeSend: function(){
                    $('#loading').addClass("showloading");
                },
                success: function( returnedData ){
                    $('.main_body').html(returnedData);
                },
                complete: function(){
                    $('#loading').removeClass("showloading");
                }
            });
        }
    });
});
$(document).ready(function () {
    $(".main_body" ).on( "click","#complete_order", function(e) {
        $('#loading').addClass("showloading");
        $('.main_heading').html("Place Order");
        $('.main_body').load('categories.php', function(data){
            $('.hide-nav').removeClass('active');
            $('body').removeClass();
            $('#loading').removeClass("showloading");
        });
    });
});
$(document).ready(function () {
    $(".main_body" ).on( "click","#admin_upload_quote_doc_btn", function(e) {
        $("#admin_change_quote").trigger("click");  
    });
});
$(document).ready(function () {
    $(".main_body" ).on( "click","#admin_upload_po_doc_btn", function(e) {
        $("#admin_change_po").trigger("click");  
    });
});
$(document).ready(function () {
    $(".main_body" ).on( "click","#submit_admin_po", function(e) {
        var err = 0;
        var po_id = $('#po_id').val().trim();
        var po_no = $('#admin_po_number').val().trim();
        var sold_to = $("#admin_sold_to option:selected").text().trim();
        var sold_to_id = $("#admin_sold_to option:selected").val().trim();
        var ship_to = $("#admin_ship_to option:selected").text().trim();
        var ship_to_id =  $("#admin_ship_to option:selected").val().trim();
        var cont_per = $('#admin_con_per').val().trim();
        var del_date = $('#admin_del_date').val().trim();
        var f_term = $('#admin_fterm option:selected').text().trim();
        var f_chrges = $('#admin_fcharges').val().trim();
        var vessal = $('#admin_vessal').val().trim();
        var pay_term = $('#admin_payment_term option:selected').text().trim();
        var pay_term_id = $('#admin_payment_term option:selected').val().trim();
        var comments = $('#admin_client_comment').val().trim();
        var feedback = $('#admin_feeback').val().trim();
        var status = $('#admin_po_status option:selected').text().trim();
        var cust_no = $('#admin_cust_no').val().trim();
        var old_file_name = $('#old_file_name').val().trim();
        var file_data = $('#admin_change_po').prop('files')[0];
        if(sold_to == "Choose One")
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Select Sold_To Value!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            err =1;
        }
        else if(ship_to == "Choose One")
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Select Ship_To Value!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            err =1;
        }
        else if(cont_per == "" || cont_per == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter Contact Person Name!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            err =1;
        }
        else if(del_date == "" || del_date == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Select Delivery Date!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            err =1;
        }
        else if(f_term == "Choose One")
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Select Freight Term!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            err =1;
        }
        else if(f_term == "At Site" && f_chrges=="" || f_term == "At Site" && f_chrges == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter Freight Charges!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            err =1;
        }
        else if(!(allLetter(cont_per)))
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Contact Person must be Alpahbests only!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            err =1;
        }
        else if((isNaN(f_chrges)))
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Freight Charges must be Number!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            err =1;
        }
        if(err == 0)
        {
            var form_data = new FormData();                    
            form_data.append('file', file_data);
            form_data.append('action', 'updatePO');
            form_data.append('po_id', po_id);
            form_data.append('po_no', po_no);
            form_data.append('cust_no', cust_no);
            form_data.append('sold_to', sold_to);
            form_data.append('sold_to_id', sold_to_id);
            form_data.append('ship_to', ship_to);
            form_data.append('ship_to_id', ship_to_id);
            form_data.append('cont_per', cont_per);
            form_data.append('del_date', del_date);
            form_data.append('f_term', f_term);
            form_data.append('f_chrges', f_chrges);
            form_data.append('vessal', vessal);
            form_data.append('pay_term', pay_term);
            form_data.append('pay_term_id', pay_term_id);
            form_data.append('status', status);
            form_data.append('comments', comments);
            form_data.append('feedback', feedback);
            form_data.append('old_file_name', old_file_name);
            $.ajax({
                url: 'ajax.php',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                      
                type: 'post',
                beforeSend: function(){
                    $('#loading').addClass("showloading");
                },
                success: function(returnedData){
                    if(returnedData == "Success")
                    {
                        $('.notify').html("<span class='close-notify'>&times;</span><strong>#PO Updated Successfully!</strong> ");
                        $('.notify').removeClass('notify-failed');
                        $('.notify').addClass('notify-success');
                        $('.notify').show();
                        $('body').removeClass();
                        setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
                        //$('#uploaded_po').replaceWith($('#uploaded_po').val('').clone(true));
                        $('.main_body').load('admin_po.php');
                    }
                    else
                    {
                        $('.notify').html("<span class='close-notify'>&times;</span><strong>Something Went Wrong...PLease Try Later!</strong> ");
                        $('.notify').removeClass('notify-success');
                        $('.notify').addClass('notify-failed');
                        $('.notify').show();
                    }
                },
                complete: function(){
                    $('#loading').removeClass("showloading");
                }
            });
        }
    });
});
$(document).ready(function () {
    $(".main_body" ).on( "click","#submit_admin_quote", function(e) {
        var err = 0;
        var quote_id = $('#quote_id').val().trim();
        var prod_id = $('#admin_quote_prod').val().trim();
        var quote_qty = $('#admin_quote_qty').val().trim();
        var quote_pkgsz = $("#admin_quote_pkgsize option:selected").text().trim();
        var quote_avai_price = $('#admin_quote_avai_price').val().trim();
        var quote_req_price = $('#admin_quote_req_price').val().trim();
        var agree_price = $('#admin_quote_agree_price').val().trim();
        var admin_feeback = $('#admin_feeback').val().trim();
        var quote_status = $("#admin_quote_status option:selected").text().trim();
        var old_file_name = $('#old_file_name').val();
        var file_data = $('#admin_change_quote').prop('files')[0];
        var form_data = new FormData(); 
        if(quote_qty == "" || quote_qty == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Fill All Required Fields!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
        }
        else
        {
            if(isNaN(quote_qty))
            {
                $('.notify').html("<span class='close-notify'>&times;</span><strong>Quantity Must in Number!</strong> ");
                $('.notify').removeClass('notify-success');
                $('.notify').addClass('notify-failed');
                $('.notify').show();
            }
            else if(isNaN(agree_price))
            {
                $('.notify').html("<span class='close-notify'>&times;</span><strong>Agreed Price Must in Number!</strong> ");
                $('.notify').removeClass('notify-success');
                $('.notify').addClass('notify-failed');
                $('.notify').show();
            }
            else
            {                 
                form_data.append('file', file_data);
                form_data.append('action', 'updatequote');
                form_data.append('quote_id', quote_id);
                form_data.append('prod_id', prod_id);
                form_data.append('quote_pkgsz', quote_pkgsz);
                form_data.append('agree_price', agree_price);
                form_data.append('quote_qty', quote_qty);
                form_data.append('admin_feeback', admin_feeback);
                form_data.append('quote_status', quote_status);
                form_data.append('old_file_name', old_file_name);
                $.ajax({
                    url: 'ajax.php',
                    dataType: 'text',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,                      
                    type: 'post',
                    beforeSend: function(){
                        $('#loading').addClass("showloading");
                    },
                    success: function( returnedData ){
                        $('.notify').html("<span class='close-notify'>&times;</span><strong>Quotation Updated Successfully!</strong> ");
                        $('.notify').removeClass('notify-failed');
                        $('.notify').addClass('notify-success');
                        $('.notify').show();
                        // $('#uploaded_quote').replaceWith($('#uploaded_quote').val('').clone(true));
                        $('body').removeClass();
                        setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
                        $('.main_body').load('admin_quote.php');
                    },
                    complete: function(){
                        $('#loading').removeClass("showloading");
                    }
                });
            }
        }
    });
});