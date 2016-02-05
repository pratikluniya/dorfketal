/**
 * All Ajax code wll be here in this file for Order Management
 * version 1.0
 *
 */

/********  Login JS  *****/
$(document).ready(function () {
	$("#login-button" ).on( "click", function() {
		var cust_id=$("#login_cust_id").val().trim();
		var pass = $("#login_cust_pass").val().trim();
		if(cust_id == "")
		{
			$('#login-error').html("Please Enter Customer ID");
		}
		else if(pass == "")
		{
			$('#login-error').html("Please Enter Password");	
		}
		else
		{
			$.ajax({
	            type: "POST",
	            url: "ajax.php",
	            data: 'cust_id='+cust_id + '&cust_pass='+pass + '&action=Login',
	            success: function( returnedData ){
		            if(returnedData == "Success")
		            {
		            	$.ajax({
        					type: "POST",
        					url: "ajax.php",
					        data: 'action=cartonload',
					        
					        success: function( returnedData ){
        						$('form').fadeOut(500);
								$('.wrapper').addClass('form-success');	
		            			window.location = 'home.php';	
       						}
    					});
		            }
		            else
		            {
		            	$('#login-error').html(returnedData);
		            }	
	        	}
	        });
	    }
	});
	$("#login_cust_id" ).on( "focus", function() {
		$('#login-error').html("");
	});
	$("#login_cust_pass" ).on( "focus", function() {
		$('#login-error').html("");
	});
});
$(document).on('keypress','#login_cust_pass',function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13')
    {
        $("#login-button").trigger("click");
    }
});


/********  Log Out JS  *****/
$(document).ready(function () {
	$("#logout-button" ).on( "click", function() {
		$.ajax({
            type: "POST",
            url: "ajax.php",
            data: 'action=Logout',
            success: function( returnedData ){
	            window.location = 'index.php';
			}
		});
	});
});


/********  GLobal  *****/
$(document).ready(function () {
    $(".notify" ).on( "click",".close-notify", function(e) {
        $('.notify').removeClass('notify-success');
        $('.notify').removeClass('notify-failed');
        $('.notify').hide();
    });
});
$(document).ready(function () {
    $(".hide-nav").on("click", function(event){
        $(".cat-tabs").hide();
    });
});

$(document).ready(function () {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; 
    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 
    var today = yyyy+'-'+mm+'-'+dd;
    $(".main_body" ).on( "click","#PO_delivery_date", function(e) {
        $('#PO_delivery_date').attr("min", '2016-02-04');
    });
});
/********  Left Sidebar Click Events  *****/ 
$(document).ready(function () {
	$("#place_order_btn" ).on( "click", function() {
		$('.main_heading').html("Place Order");
		$('.main_body').load('categories.php');
    });
});
$(document).ready(function () {
	$("#regular_prod_btn" ).on( "click", function() {
		$.ajax({
            type: "POST",
            url: "product_list.php",
            data: '&cat_prod=2',
            beforeSend: function(){
                $('#loading').addClass("showloading");
            },
            success: function( returnedData ){
                $('.cat-tabs').show();
        		$('.main_heading').html("Regular Products");
				$('.main_body').html(returnedData);        
        	},
            complete: function(){
                $('#loading').removeClass("showloading");
            }
    	});
    });
});
$(document).ready(function () {
	$("#reset_vertical_btn" ).on( "click", function() {
		$('.main_heading').html("Reset Your Favorite Verical");
		$('.main_body').load('reset_fav_vertical.php');
        var fval;
		$.ajax({
            type: "POST",
            url: "ajax.php",
            data: 'action=F-Vertical',
            beforeSend: function(){
                $('#loading').addClass("showloading");
            },
            success: function( returnedData ){
                fval = returnedData;
	            $('input[name="cat_name"]').each(function () {
    					if ($(this).val() == fval) $(this).closest('.hpanel').addClass('f-cat');
					});
			},
            complete: function(){
                $('#loading').removeClass("showloading");
            }
		});
	});
});
$(document).ready(function () {
	$("#order_history_btn" ).on( "click", function() {
		$('.main_heading').html("Order History");
		$('.main_body').load('order_history.php');
    });
});
$(document).ready(function () {
	var cat_name;
	$("#fav_vertical_btn" ).on( "click", function() {
		$.ajax({
            type: "POST",
            url: "ajax.php",
            data: 'action=F-Vertical',
            beforeSend: function(){
                $('#loading').addClass("showloading");
            },
            success: function( returnedData ){
            	cat_name = returnedData;
            	$.ajax({
            		type: "POST",
            		url: "product_list.php",
            		data: 'cat_name='+cat_name + '&cat_prod=1',
            
            		success: function( returnedData ){
                        $('.cat-tabs').show();
        				$('.main_heading').html(cat_name);
						$('.main_body').html(returnedData);        
        			},
                    complete: function(){
                        $('#loading').removeClass("showloading");
                    }
    			});
            }
        });
		
	});
});
$(document).ready(function () {
    $("#upload_po_btn" ).on( "click", function() {
        $('.main_heading').html("Upload PO#");
        $('.main_body').load('upload_po.php');
    });
});
$(document).ready(function () {
	$("#track_order_btn" ).on( "click", function() {
		$.ajax({
            type: "POST",
            url: "ajax.php",
            data: 'action=chkuser',
            beforeSend: function(){
                $('#loading').addClass("showloading");
            },
            success: function( returnedData ){
	    		if(returnedData == 2)
	    		{
	    			$('.main_heading').html("Customer Dashboard");
	    			$('.main_body').load('logistics/customer_dashboard.php');
	    		}
	    		return false;        
			},
            complete: function(){
                $('#loading').removeClass("showloading");
            }
		}); 
    });
});
$(document).ready(function () {
	$("#contactus_btn" ).on( "click", function() {
		$('.main_heading').html("Contact Us");
		$('.main_body').load('contactus.php');
    });
});
$(document).ready(function () {
	$("#req_quotation_btn" ).on( "click", function() {
		$('.main_heading').html("Request Quotation");
		$('.main_body').load('req_quotation.php');
    });
});


/********  On Page Click Events  *****/
$(document).ready(function () {
    $(".main_body" ).on( "click",".b-verticals", function(e) {
    	var frm = $(this).parents("form:first");
   		var cat_name = $(frm).find("#cat_name").val().trim();
   		
    	$.ajax({
            type: "POST",
            url: "product_list.php",
            data: 'cat_name='+cat_name + '&cat_prod=1',
            beforeSend: function(){
                $('#loading').addClass("showloading");
            },
            success: function( returnedData ){
                $('.cat-tabs').show();
        		$('.main_heading').html(cat_name);
				$('.main_body').html(returnedData);        
        	},
            complete: function(){
                $('#loading').removeClass("showloading");
            }
    	});
    });
});
$(document).ready(function () {
	$( ".main_body" ).on( "click","#order-history-btn", function(e) {
		$('.main_heading').html("Order History");
		$('.main_body').load('order_history.php');
    });
});
$(document).ready(function () {
	$(".main_body" ).on( "click",".f-verticals", function(e) {
		$('.rm-all').removeClass('f-cat');
		var favcat = $(this).parents("form:first");
		var cat_name = $(favcat).find('#cat_name').val().trim();
		$.ajax({
            type: "POST",
            url: "ajax.php",
            data: 'cat_name='+cat_name + '&action=updatefcat',
            beforeSend: function(){
                $('#loading').addClass("showloading");
            },
            success: function( returnedData ){
            	if(returnedData == "Success")
		        {
        			$(favcat).closest('.hpanel').addClass('f-cat');
        		}
        	},
            complete: function(){
                $('#loading').removeClass("showloading");
            }
        });
    });
});
$(document).ready(function () {
	$("#by_application" ).on( "click", function(e) {
		var cat_name = $('#cat_name').val().trim();
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: 'cat_name='+cat_name +'&action=getcatapplication',
            beforeSend: function(){
                $('#loading').addClass("showloading");
            },
            success: function( returnedData ){
            	var opt = JSON.parse(returnedData);
                $('#cat_applications').find('option').remove().end();
            	$.each(opt, function(key, value) {  
            		$('#cat_applications')
         			.append($("<option></option>")
         			.attr("value",value['ID'])
         			.text(value['APPLICATION'])); 
				});
        	},
            complete: function(){
                $('#loading').removeClass("showloading");
            }
    	});
    	$(this).removeClass('inactive-cat-tab');
		$('#by_product').addClass('inactive-cat-tab');
		$('#cat_applications').show();
	});
});
$(document).ready(function () {
	$("#by_product" ).on( "click", function(e) {
		$(this).removeClass('inactive-cat-tab');
		$('#by_application').addClass('inactive-cat-tab');
		$('#cat_applications').hide();
        var cat_name = $('#cat_name').val().trim();
        $.ajax({
            type: "POST",
            url: "product_list.php",
            data: 'cat_name='+cat_name + '&cat_prod=1',
            beforeSend: function(){
                $('#loading').addClass("showloading");
            },
            success: function( returnedData ){
                $('.cat-tabs').show();
                $('.main_heading').html(cat_name);
                $('.main_body').html(returnedData);        
            },
            complete: function(){
                $('#loading').removeClass("showloading");
            }
        });
	});
});
$(document).ready(function () {
	$("#cat_applications" ).on( "change", function(e) {
    	var cat_name = $('#cat_name').val();
    	var pgid = $("#cat_applications option:selected").val().trim();
    	var pgapp = $("#cat_applications option:selected").text().trim();
    	$.ajax({
            type: "POST",
            url: "product_list.php",
            data: 'cat_name='+ cat_name +'&pgid='+ pgid +'&cat_prod=3',
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
    });
});
$(document).ready(function () {
	$(".main_body" ).on( "change","#q_cat", function(e) {
    	var cat_name = $("#q_cat option:selected").text().trim();
    	$.ajax({
            type: "POST",
            url: "ajax.php",
            data: 'cat_name='+ cat_name +'&action=getquoteproduct',
            beforeSend: function(){
                $('#loading').addClass("showloading");
            },
            success: function( returnedData ){
            	var opt = JSON.parse(returnedData);
                $('#q_prod').find('option').remove().end();
                $('#q_prod').append('<option value="0" selected>Select Product</option>');
            	$.each(opt, function(key, value) {  
            		$('#q_prod')
            		.append($("<option></option>")
         			.attr("value",value['ITEM_CODE'])
         			.text(value['DESCRIPTION']));
				});
				$("#q_prod").removeAttr("disabled");
            },
            complete: function(){
                $('#loading').removeClass("showloading");
            }
        });
    });
});
$(document).ready(function () {
	$(".main_body" ).on( "change","#q_prod", function(e) {
		$("#q_packaging_size").removeAttr("disabled");
	});
});
$(document).ready(function () {
	$(".main_body" ).on( "change","#q_packaging_size", function(e) {
		var q_cat = $("#q_cat option:selected").text().trim();
		var q_prod_id = $("#q_prod option:selected").val().trim();
		var q_prod_desc = $("#q_prod option:selected").text().trim();
		var q_packaging_size = $("#q_packaging_size option:selected").text().trim();

		$.ajax({
            type: "POST",
            url: "ajax.php",
            data: 'cat_name='+ q_cat +'&prod_id='+q_prod_id +'&prod_desc='+ q_prod_desc +'&pkg_size='+ q_packaging_size +'&action=getquoteprice',
            beforeSend: function(){
                $('#loading').addClass("showloading");
            },
            success: function( returnedData ){
                $("#q_req_price").removeAttr("disabled");
                $("#q_quantity").removeAttr("disabled");
                var data = JSON.parse(returnedData);
                if((data['status']) == "Success")
                {
                    $("#q_price").val(data['price']);
                    $("#packaging_code").val(data['PACKAGING_CODE']);
                }
                else
                {
                    $("#q_price").val(data['status']);
                }
            },
            complete: function(){
                $('#loading').removeClass("showloading");
            }
        });
	});
});
$(document).ready(function () {
    $(".main_body" ).on( "click","#req_q_btn", function(e) {
        var q_cat = $("#q_cat option:selected").text().trim();
        var q_prod_id = $("#q_prod option:selected").val().trim();
        var q_packaging_size = $("#q_packaging_size option:selected").text().trim();
        var price = $("#q_price").val().trim();
        var req_price = $('#q_req_price').val().trim();
        var qty = $("#q_quantity").val().trim();
        var remark = $("#q_remark").val().trim();
        if(req_price == "" || price == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Fill All Required Fields!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
        }
        else if(qty == "" || qty == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Fill All Required Fields!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
        }
        else
        {
            var file_data = $('#uploaded_quote').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file', file_data);
            form_data.append('action', 'insertquote');
            form_data.append('cat_name', q_cat);
            form_data.append('prod_id', q_prod_id);
            form_data.append('price', price);
            form_data.append('req_price', req_price);
            form_data.append('pkg_size', q_packaging_size);
            form_data.append('qty', qty);
            form_data.append('remark', remark);
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
                    $("#q_cat").val("0");
                    $("#q_prod").val("0");
                    $("#q_packaging_size").val("0");
                    $("#q_price").val("");
                    $("#q_req_price").val("");
                    $("#q_quantity").val("");
                    $("#q_remark").val("");
                    $("#q_prod").attr("disabled", "disabled");
                    $("#q_packaging_size").attr("disabled", "disabled");
                    $("#q_price").attr("disabled", "disabled");
                    $("#q_req_price").attr("disabled", "disabled");
                    $("#q_quantity").attr("disabled", "disabled");
                    $('.notify').html("<span class='close-notify'>&times;</span><strong>Quotation Submitted!</strong> ");
                    $('.notify').removeClass('notify-failed');
                    $('.notify').addClass('notify-success');
                    $('.notify').show();
                    $('#uploaded_quote').replaceWith($('#uploaded_quote').val('').clone(true));
                    setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
                },
                complete: function(){
                    $('#loading').removeClass("showloading");
                }
            });
        }
    });
});
$(document).ready(function () {
    $(".main_body" ).on( "click","#upload_po_doc_btn", function(e) {
        $("#uploaded_po").trigger("click");  
    });
});
$(document).ready(function () {
    $(".main_body" ).on( "click","#upload_quote_doc_btn", function(e) {
        $("#uploaded_quote").trigger("click");  
    });
});
$(document).ready(function () { 
    $(".main_body" ).on( "click","#submit_po", function(e) {
        var err = 0;
        var po_no = $('#PO_number').val().trim();
        var sold_to = $("#PO_sold_to option:selected").text().trim();
        var ship_to = $("#PO_ship_to option:selected").text().trim();
        var cont_per = $('#PO_contact_person').val().trim();
        var del_date = $('#PO_delivery_date').val().trim();
        var f_term = $('#PO_freight_term option:selected').text().trim();
        var f_chrges = $('#PO_freight_charges').val().trim();
        var vessal = $('#PO_vessel_name').val().trim();
        var pay_term = $('#PO_payment_term option:selected').text().trim();
        var comments = $('#PO_comments').val().trim();
        var file_data = $('#uploaded_po').prop('files')[0];
        if(po_no == "" || po_no == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter #PO Number!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            err =1;  
        }
        else if(sold_to == "Choose One")
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
        else if(file_data == "" || file_data == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Attach #PO File!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            err =1;
        }
        if(err == 0)
        {
            var form_data = new FormData();                  
            form_data.append('file', file_data);
            form_data.append('action', 'uploadPO');
            form_data.append('po_no', po_no);
            form_data.append('sold_to', sold_to);
            form_data.append('ship_to', ship_to);
            form_data.append('cont_per', cont_per);
            form_data.append('del_date', del_date);
            form_data.append('f_term', f_term);
            form_data.append('f_chrges', f_chrges);
            form_data.append('vessal', vessal);
            form_data.append('pay_term', pay_term);
            form_data.append('comments', comments);
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
                        $('.notify').html("<span class='close-notify'>&times;</span><strong>#PO Uploaded Successfully!</strong> ");
                        $('.notify').removeClass('notify-failed');
                        $('.notify').addClass('notify-success');
                        $('.notify').show();
                        setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
                        $('#uploaded_po').replaceWith($('#uploaded_po').val('').clone(true));
                        $('.main_body').load('upload_po.php');
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


/********  Cart JS  *****/ 
$(document).ready(function () {
	$(".main_body" ).on( "click",".add_to_cart_btn", function(e) {
		var prod_code = $(this).parent().find("#prod_code").val().trim();
		var desc = $(this).parent().parent().parent().find("#prod_desc").html().trim();
		var remark = $(this).parent().find("#remark").val().trim();
		var pkgsize = $(this).parent().find("#pkg_size").val().trim();
		var qty = $(this).parent().find("#qty").val().trim();
        if(qty == "" || qty == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter Quantity!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
        }
        else
        {
    		$.ajax({
                type: "POST",
                url: "ajax.php",
                data: 'prod_code=' + prod_code +'&prod_desc='+desc +'&remark='+ remark +'&pkgsize=' + pkgsize +'&qty='+qty +'&action=insertcart',
                beforeSend: function(){
                    $('#loading').addClass("showloading");
                },
                success: function( returnedData ){
                		if($.isNumeric( returnedData )){ 
                			$('.notify').html("<span class='close-notify'>&times;</span><strong>Product Added to Cart!</strong> ");
                            $('.notify').removeClass('notify-failed');
                            $('.notify').addClass('notify-success');
                            $('.notify').show();
                            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
                            $("#cart_count").html(returnedData);
                		}
                		else
                		{
                			$('.notify').html("<span class='close-notify'>&times;</span><strong>"+returnedData+"!</strong> ");
                            $('.notify').removeClass('notify-success');
                            $('.notify').addClass('notify-failed');
                            $('.notify').show();
                            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
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
	$("#mycart" ).on( "click", function(e) {
		$.ajax({
            type: "POST",
            url: "cart.php",
            data: '&action=getcart',
            beforeSend: function(){
                $('#loading').addClass("showloading");
            },
            success: function( returnedData ){
        		$('.main_heading').html("Shopping Cart");
                $('.cat-tabs').hide();
				$('.main_body').html(returnedData);        
        	},
            complete: function(){
                $('#loading').removeClass("showloading");
            }
    	});
	});
});
$(document).ready(function () {
	$(".main_body" ).on( "click","#checkout_btn", function(e) {
        $('.main_heading').html("Checkout Order Form");
        $('.main_body').load('order_form.php');    
	});
});
$(document).ready(function () {
	$(".main_body" ).on( "click","#continue_shop_btn", function(e) {
		$('.main_heading').html("Place Order");
		$('.main_body').load('categories.php');
	});
});
$(document).ready(function () {
	$(".main_body" ).on( "click",".remove_product_btn", function(e) {
		var prod_code = $(this).parent().find('.prod_id').val().trim();
		$(this).parent().hide();
		$.ajax({
            type: "POST",
            url: "ajax.php",
            data: 'prod_code=' + prod_code +'&action=removecart',
            beforeSend: function(){
                $('#loading').addClass("showloading");
            },
            success: function( returnedData ){
                $('.notify').html("<span class='close-notify'>&times;</span><strong>Product Removed from Cart!</strong> ");
                $('.notify').removeClass('notify-success');
                $('.notify').addClass('notify-failed');
                $('.notify').show();
                setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
    			$("#cart_count").html(returnedData);
    		},
            complete: function(){
                $('#loading').removeClass("showloading");
            }
    	});
	});
});
$(document).ready(function () {
	$(".main_body" ).on( "focusin",".cart-input", function(e) {

		$(this).parent().parent().find('.remove_product_btn').hide();
		$(this).parent().parent().find('.save_product_btn').show();
	});
});
$(document).ready(function () {
	$(".main_body" ).on( "click",".save_product_btn", function(e) {
		var prod_code = $(this).parent().find('.prod_id').val().trim();
		var qty = $(this).parent().find('.cart-qty').val().trim();
		var pkgsize = $(this).parent().find('.cart-pck-size').val().trim();
		var remark = $(this).parent().find('.cart-remark').val().trim();
		$.ajax({
            type: "POST",
            url: "ajax.php",
            data: 'prod_code=' + prod_code +'&qty='+ qty +'&pkgsize=' + pkgsize +'&remark='+ remark +'&action=updatecart',
            beforeSend: function(){
                $('#loading').addClass("showloading");
            },
            success: function( returnedData ){
    			if(returnedData == "success")
    			{
                    $('.notify').html("<span class='close-notify'>&times;</span><strong>Product Information Updated!</strong> ");
                    $('.notify').removeClass('notify-failed');
                    $('.notify').addClass('notify-success');
                    $('.notify').show();
                    setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
				}
    		},
            complete: function(){
                $('#loading').removeClass("showloading");
            }
    	});
    	$(this).parent().parent().find('.remove_product_btn').show();
		$(this).parent().parent().find('.save_product_btn').hide();
	});
});


/********  Checkout JS  *****/

$(document).ready(function () {
    $(".main_body" ).on( "change", "#freight_term", function(e) {
        var fterm = $("#freight_term option:selected").text().trim();
        if(fterm == "At Site")
            $('.fc_div').show();
        else
            $('.fc_div').hide();
    });
});

$(document).ready(function () {
    $(".main_body" ).on( "click","#place_order", function(e) {
        var err = 0;
        var po_no = $('#PO_number').val().trim();
        var sold_to = $("#sold_to option:selected").text().trim();
        var sold_to_id = $("#sold_to option:selected").val().trim();
        var ship_to = $("#ship_to option:selected").text().trim();
        var ship_to_id = $("#ship_to option:selected").val().trim();
        var cont_per = $('#contact_person').val().trim();
        var del_date = $('#delivery_date').val().trim();
        var f_term = $('#freight_term option:selected').text().trim();
        var f_chrges = $('#freight_charges').val().trim();
        var vessal = $('#vessel_name').val().trim();
        var pay_term = $('#payment_term option:selected').text().trim();
        var pay_term_id = $('#payment_term option:selected').val().trim();
        var comments = $('#comments').val().trim();
        if(po_no == "" || po_no == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter #PO Number!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            err =1;  
        }
        else if(sold_to == "Choose One")
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
        if(err == 0)
        {
            $.ajax({
            type: "POST",
            url: "order_summary.php",
            data: 'po_no=' + po_no +'&sold_to='+ sold_to +'&sold_to_id='+ sold_to_id +'&ship_to=' + ship_to +'&ship_to_id='+ ship_to_id +'&cont_per='+ cont_per +'&del_date='+ del_date +'&f_term='+ f_term +'&f_chrges='+ f_chrges +'&vessal='+ vessal +'&pay_term='+ pay_term +'&pay_term_id='+ pay_term_id +'&comments='+ comments +'&action=place_order',
            beforeSend: function(){
                $('#loading').addClass("showloading");
            },
            success: function( returnedData ){
                $('.notify').html("<span class='close-notify'>&times;</span><strong>Order Placed Successfully!</strong> ");
                $('.notify').removeClass('notify-failed');
                $('.notify').addClass('notify-success');
                $('.notify').show();
                setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
                $('.main_heading').html("Order Summary");
                $('.main_body').html(returnedData);
            },
            complete: function(){
                $('#loading').removeClass("showloading");
                $.ajax({
                type: "POST",
                    url: "ajax.php",
                    data:'action=getcartcount',
                    success: function( returnedData1 ){
                        $("#cart_count").html(returnedData1);
                    }
                });
            }
        });
        }
    });
});
$(document).ready(function () {
    $(".main_body" ).on( "click","#submit_query", function(e) {
        var err = 0;
        var purpose = $("#purpose option:selected").text().trim();
        var region = $("#region option:selected").text().trim();
        var industry_app = $("#industry_app option:selected").text().trim();
        var fname = $('#fname').val().trim();
        var lname = $('#lname').val().trim();
        var email = $('#email').val().trim();
        var phone = $('#phone').val().trim();
        var title = $('#title').val().trim();
        var country = $('#country').val().trim();
        var message = $('#message').val().trim();
        if(purpose == "Purpose of My request" || purpose == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Select Purpose!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            err =1;  
        }
        else if(region == "Select Region" || region == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Select Region!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            err =1;  
        }
        else if(industry_app == "Select Industry or Application" || industry_app == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Select Industry or Application!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            err =1;  
        }
        else if(fname == "" || fname == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter First Name!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            err =1;  
        }
        else if(lname == "" || lname == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter Last Name!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            err =1;  
        }
        else if(email == "" || email == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter email</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            err =1;  
        }
        else if(phone == "" || phone == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter Phone Number!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            err =1;  
        }
        else if(country == "" || country == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter Country Name!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            err =1;  
        }
        else if(title == "" || title == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter Title!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            err =1;  
        }
        else if(message == "" || message == null)
        {
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter Message!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            err =1;  
        }
        if(err == 0)
        {
            $('.form-group').find('input').val('');
            $('.form-group').find('select').val('0');
            $('.form-group').find('textbox').val('');
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Thanks for your valuable Feedback!<br> We Will get back to you Soon!!</strong> ");
            $('.notify').removeClass('notify-failed');
            $('.notify').addClass('notify-success');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
        }
    });
});
