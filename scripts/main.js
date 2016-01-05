/**
 * All Ajax code wll be here in this file for Order Management
 * version 1.0
 *
 */

 // Left Sidebar Click Events
$(document).ready(function () {
	$("#place_order_btn" ).on( "click", function() {
		$('.main_heading').html("Place Order");
		$('.main_body').load('dashboard.php');
    });
});
$(document).ready(function () {
	$("#reset_vertical_btn" ).on( "click", function() {
		$('.main_heading').html("Reset Your Favorite Verical");
		$('.main_body').load('reset_fav_vertical.php');
    });
});
$(document).ready(function () {
	$("#order_history_btn" ).on( "click", function() {
		$('.main_heading').html("Order History");
		$('.main_body').load('order_history.php');
    });
});



// On Page Click Events

$(document).ready(function () {
	$(".main_body" ).on( "click","#b-verticals", function(e) {
		$('.main_heading').html("Business Vericals");
		$('.main_body').load('verticals.php');
    });
});
$(document).ready(function () {
	$(".main_body" ).on( "click","#fav-vertical", function(e) {
		$('.main_heading').html("Favorite Verical Name");
		$('.main_body').load('product_list.php');
    });
});
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