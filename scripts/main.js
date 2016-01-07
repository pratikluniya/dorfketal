/**
 * All Ajax code wll be here in this file for Order Management
 * version 1.0
 *
 */

// Login JS
 
$(document).ready(function () {
	$("#login-button" ).on( "click", function() {
		var cust_id=$("#login_cust_id").val();
		var pass = $("#login_cust_pass").val();
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
		            	$('form').fadeOut(500);
						$('.wrapper').addClass('form-success');	
		            	window.location = 'home.php';
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

 // Left Sidebar Click Events.
 
$(document).ready(function () {
	$("#place_order_btn" ).on( "click", function() {
		$('.main_heading').html("Place Order");
		$('.main_body').load('categories.php');
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
        				$('.main_heading').html(cat_name);
						$('.main_body').html(returnedData);        
        			}
    			});
            }
        });
		
	});
});

// On Page Click Events.

$(document).ready(function () {
    $(".main_body" ).on( "click",".b-verticals", function(e) {
    	var frm = $(this).parents("form:first");
   		var cat_name = $(frm).find("#cat_name").val();
   		
    	$.ajax({
            type: "POST",
            url: "product_list.php",
            data: 'cat_name='+cat_name + '&cat_prod=1',
            
            success: function( returnedData ){
        		$('.main_heading').html(cat_name);
				$('.main_body').html(returnedData);        
        }
    });
    });
});
$(document).ready(function () {
	 $(".main_body" ).on( "click","#regular-products", function(e) {
		$('.main_heading').html("Regular Products");
		$('.main_body').load('product_list.php');
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
		var cat_name = $(favcat).find('#cat_name').val();
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