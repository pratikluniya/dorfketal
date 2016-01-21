/**
 * All Ajax code wll be here in this file for Order Management
 * version 1.0
 *
 */

// Login JS
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
// Log Out JS
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

//GLobal
$(document).ready(function () {
    $(".notify" ).on( "click",".close-notify", function(e) {
        $('.notify').removeClass('notify-success');
        $('.notify').removeClass('notify-failed');
        $('.notify').hide();
    });
});




 // Left Sidebar Click Events.
 
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
            
            success: function( returnedData ){
                $('.cat-tabs').show();
        		$('.main_heading').html("Regular Products");
				$('.main_body').html(returnedData);        
        	}
    	});
    });
});
$(document).ready(function () {
	$("#reset_vertical_btn" ).on( "click", function() {
		$('.main_heading').html("Reset Your Favorite Verical");
		$('.main_body').load('reset_fav_vertical.php');
		$.ajax({
            type: "POST",
            url: "ajax.php",
            data: 'action=F-Vertical',
            success: function( returnedData ){
	            var fval = returnedData;
	            $('input[name="cat_name"]').each(function () {
    					if ($(this).val() == fval) $(this).closest('.hpanel').addClass('f-cat');
					});
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
            success: function( returnedData ){
	    		if(returnedData == 2)
	    		{
	    			$('.main_heading').html("Customer Dashboard");
	    			$('.main_body').load('logistics/customer_dashboard.php');
	    		}
	    		return false;        
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


// On Page Click Events.

$(document).ready(function () {
    $(".main_body" ).on( "click",".b-verticals", function(e) {
    	var frm = $(this).parents("form:first");
   		var cat_name = $(frm).find("#cat_name").val().trim();
   		
    	$.ajax({
            type: "POST",
            url: "product_list.php",
            data: 'cat_name='+cat_name + '&cat_prod=1',
            
            success: function( returnedData ){
                $('.cat-tabs').show();
        		$('.main_heading').html(cat_name);
				$('.main_body').html(returnedData);        
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
            
            success: function( returnedData ){
            	if(returnedData == "Success")
		        {
        			$(favcat).closest('.hpanel').addClass('f-cat');
        		}
        	}
        });
    });
});
$(document).ready(function () {
    $(".hide-nav").on("click", function(event){
        $(".cat-tabs").hide();
    });
});

$(document).ready(function () {
	$("#by_application" ).on( "click", function(e) {
		var cat_name = $('#cat_name').val().trim();
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: 'cat_name='+cat_name +'&action=getcatapplication',
            
            success: function( returnedData ){
            	var opt = JSON.parse(returnedData);
                $('#cat_applications').find('option').remove().end();
            	$.each(opt, function(key, value) {  
            		$('#cat_applications')
         			.append($("<option></option>")
         			.attr("value",value['ID'])
         			.text(value['APPLICATION'])); 
				});
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
            
            success: function( returnedData ){
            	$('.main_body').html(returnedData);
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
            
            success: function( returnedData ){
                $("#q_price").removeAttr("disabled");
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
        var remark = $("#q_remark").val().trim();
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: 'cat_name='+ q_cat +'&prod_id='+q_prod_id +'&price='+ price +'&pkg_size='+ q_packaging_size +'&remark='+ remark +'&action=insertquote',
            
            success: function( returnedData ){
                $("#q_cat").val("0");
                $("#q_prod").val("0");
                $("#q_packaging_size").val("0");
                $("#q_price").val("");
                $("#q_remark").val("");
                $("#q_prod").attr("disabled", "disabled");
                $("#q_packaging_size").attr("disabled", "disabled");
                $("#q_price").attr("disabled", "disabled");
                $('.notify').html("<span class='close-notify'>&times;</span><strong>Quotation Submitted!</strong> ");
                $('.notify').removeClass('notify-failed');
                $('.notify').addClass('notify-success');
                $('.notify').show();
                setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            }
        });
    });
});
$(document).ready(function () {
    $(".main_body" ).on( "click","#upload_po_doc_btn", function(e) {
        $("#uploaded_po").trigger("click");  
    });
});
$(document).ready(function () { 
    $(".main_body" ).on( "click","#submit_po", function(e) {
    var err = 0;
    var fields = $(".form-group")
        .find("select, textarea, input").serializeArray();
  
    $.each(fields, function(i, field) {
    if (!field.value)
        err=1;
    });
    if(err == '0')
    {
        var file_data = $('#uploaded_po').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        form_data.append('action', 'uploadPO');
        $.ajax({
            url: 'ajax.php',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                      
            type: 'post',
            success: function(returnedData){
                $('.notify').html("<span class='close-notify'>&times;</span><strong>#PO Uploaded Successfully!</strong> ");
                $('.notify').removeClass('notify-failed');
                $('.notify').addClass('notify-success');
                $('.notify').show();
                setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
                }
            });
        }
    });
});




// Cart JS

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
            
            success: function( returnedData ){
        		$('.main_heading').html("Shopping Cart");
                $('.cat-tabs').hide();
				$('.main_body').html(returnedData);        
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
            
            success: function( returnedData ){
                $('.notify').html("<span class='close-notify'>&times;</span><strong>Product Removed from Cart!</strong> ");
                $('.notify').removeClass('notify-success');
                $('.notify').addClass('notify-failed');
                $('.notify').show();
                setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
    			$("#cart_count").html(returnedData);
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
            
            success: function( returnedData ){
    			if(returnedData == "success")
    			{
                    $('.notify').html("<span class='close-notify'>&times;</span><strong>Product Information Updated!</strong> ");
                    $('.notify').removeClass('notify-failed');
                    $('.notify').addClass('notify-success');
                    $('.notify').show();
                    setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
				}
    		}
    	});
    	$(this).parent().parent().find('.remove_product_btn').show();
		$(this).parent().parent().find('.save_product_btn').hide();
	});
});









// Checkout JS


