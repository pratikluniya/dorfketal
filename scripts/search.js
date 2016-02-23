/********** Global Search ************/
$(document).on('keypress','#search_box',function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13')
    {
        $(".input-group-addon").trigger("click");
    }
});

$(document).ready(function(){  

    $('.search-div').on('click','.dropdown-menu a',function(e){

        var search_cat = $(this).attr("data-value");
        var search_cat_name = $(this).attr("data-category");
        var search_value = $('#search_box').val();

        $('#search_id').val(search_cat);
        $('#search_cat').html(search_cat_name +" <span class='caret'></span>");  
        if(search_value == ''){
            $("#search_box").attr("placeholder","Search By "+search_cat_name);
        }              
    });

    $('.search-div').on('click','.input-group-addon',function(e){
        var search_value = $('#search_box').val();
        var search_category = $('#search_id').val();

        if(search_category == 0){
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Select Search Category!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            return false;
        }
        if(search_value == ""){
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter Text In Search Box!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            return false;
        }

        var cat;
        if(search_category == 1){
            cat = "Product Id";
        }
        if(search_category == 2){
            cat = "Product Name";
        }
        if(search_category == 3){
            cat = "Application";
        }
        if(search_category == 4){
            cat = "Category";
        }
        if(search_category == 5){
            cat = "Order Id";
        }
        if(search_category == 6){
            cat = "Order Web Id";
        }
       
        if(search_category == 1 || search_category == 2 || search_category == 3 || search_category == 4)
        {
            $.ajax({
                type: "POST",
                url: "product_list.php",
                data: 'search_category='+search_category+'&search_value='+search_value,
                beforeSend: function(){
                    $('#loading').addClass("showloading");
                    $('.search-tabs').hide();
                },
                success: function( returnedData ){
                    $('.cat-tabs').hide();
                    $('.main_heading').html("Search Results");
                    $('.main_body').html(returnedData);
                },
                complete: function(){
                    $('#loading').removeClass("showloading");                        
                    $('#pagination_search_value').val(search_value);
                    $('#pagination_search_id').val(search_category);
                    $('#search_cat').html("Select <span class='caret'></span>");  
                    $('#search_box').val('');
                    $('#search_id').val('0');
                    $('.main_body').prepend("<div class='col-md-12 search-result-tabs' style='display: block;'>Search result for <strong>"+cat+"</strong> like <strong>"+search_value+"</strong>...</div>");
                }
            });
        }
        else
        {
            $('#loading').addClass("showloading"); //show loading element
            $('.search-tabs').hide();
            $(".main_body").load("repeat_order.php",{"search_category":search_category,"search_value":search_value}, function(){ 
                $('.main_heading').html("Search Results");
                $('.main_body').prepend("<div class='col-md-12 search-result-tabs' style='display: block;'>Search result for <strong>"+cat+"</strong> is <strong>"+search_value+"</strong>...</div>");
                $('#loading').removeClass("showloading"); //once done, hide loading element
                $('#pagination_search_value').val(search_value);
                $('#pagination_search_id').val(search_category);
                $('#search_cat').html("Select <span class='caret'></span>"); 
                $('#search_box').val('');
                $('#search_id').val('0');
            });                
        }            
       
    });

     //executes code below when user click on pagination links
    $(".main_body").on( "click", ".search_pagination1 .pagination a", function (e){
        e.preventDefault();
        var search_value = $('#pagination_search_value').val();
        var search_category = $('#pagination_search_id').val();
        var page = $(this).attr("data-page");
        $.ajax({
            type: "POST",
            url: "product_list.php",
            data: 'search_category='+search_category+'&search_value='+search_value+'&page='+page,
            beforeSend: function(){
                $('#loading').addClass("showloading");
                $('.search-tabs').hide();
            },
            success: function( returnedData ){
                $('.main_heading').html("Search Results");
                $('.main_body').html(returnedData);        
            },
            complete: function(){
                $('#loading').removeClass("showloading");
            }
        });            
    });
    

});

/************ Local search ***********/

//----------For Product List
$(document).on('keypress','#product_search_box',function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13')
    {
        $(".product_search .input-group-addon").trigger("click");
    }
});

$(document).ready(function () {
    $(".product_search" ).on( "click",".input-group-addon", function(e) {
        var cat_name = $("#local_search_cat").val();
        var search_value = $("#product_search_box").val();
        
        if(search_value == ""){
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter Text In Search Box!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            return false;
        }
        else
        {
            $.ajax({
                type: "POST",
                url: "product_list.php",
                data: 'l_cat_name='+cat_name + '&l_cat_prod=1&l_search_value='+search_value,
                beforeSend: function(){
                    $('#loading').addClass("showloading");
                    $('.main_body').remove('.pagination_div');
                },
                success: function( returnedData ){
                    $('.cat-tabs').show();
                    $('.main_heading').html(cat_name);                
                    $('.main_body').html(returnedData);        
                },
                complete: function(){
                    $('#loading').removeClass("showloading");
                    $('#local_pagination_search_cat').val(cat_name);
                    $('#local_pagination_search_value').val(search_value);
                    $('#product_search_box').val('');
                    $('.main_body').prepend("<div class='col-md-12 search-result-tabs' style='display: block;'>Search result for <strong>"+cat_name+"</strong> like <strong>"+search_value+"</strong>...</div>");
                }
            });
        }    
    });

    //executes code below when user click on pagination links
    $(".main_body").on( "click", ".local_search_pagination1 .pagination a", function (e){
        e.preventDefault();
        var cat_name = $('#local_pagination_search_cat').val();
        var search_value = $("#local_pagination_search_value").val();
        var page = $(this).attr("data-page");
        $.ajax({
            type: "POST",
            url: "product_list.php",
            data: 'l_cat_name='+cat_name + '&l_cat_prod=1&l_search_value='+search_value+'&page='+page,
            beforeSend: function(){
                $('#loading').addClass("showloading");
            },
            success: function( returnedData ){
                $('.main_body').html(returnedData);        
            },
            complete: function(){
                $('#loading').removeClass("showloading");
                $('.main_body').prepend("<div class='col-md-12 search-result-tabs' style='display: block;'>Search result for <strong>"+cat_name+"</strong> like <strong>"+search_value+"</strong>...</div>");
            }
        });            
    });
});

//-------------For Order History
$(document).on('keypress','#order_history_search_box',function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13')
    {
        $(".order_history_search .input-group-addon").trigger("click");
    }

});

$(document).ready(function () {
    $('.order_history_search').on('click','.dropdown-menu a',function(e){
        var search_cat = $(this).attr("data-category");
        var search_cat_value = $(this).attr("data-value");
        var search_value = $("#order_history_search_box").val();

        $('#local_src_ord_histry_cat').val(search_cat_value);
        $('#order_history_cat').html(search_cat +" <span class='caret'></span>");

        if(search_value == ''){
            $("#order_history_search_box").attr("placeholder","Search By "+search_cat);
        }              
    });

    $(".order_history_search" ).on( "click",".input-group-addon", function(e){        
        var search_value = $("#order_history_search_box").val();
        var search_cat = $('#local_src_ord_histry_cat').val();
        if(search_cat == 0){
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Select Search Category!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            return false;
        }
        if(search_value == ""){
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter Text In Search Box!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            return false;
        }
        else
        {            
            e.preventDefault();
            $('#loading').addClass("showloading"); //show loading element
            var order_type = $('#order_type_div').val();
            if(order_type == 'OH'){
                $(".main_body").load("order_history.php",{"search_cat":search_cat,"search_value":search_value}, function(){ //get content from PHP page
                    $('.search-tabs').show();
                    $('.main_body').prepend("<div class='col-md-12 search-result-tabs' style='display: block;'>Search result for <strong>"+search_value+"</strong>...</div>");
                    $('#loading').removeClass("showloading"); //once done, hide loading element
                    $('#local_pagtn_src_ord_histry').val(search_value);
                    $('#local_pagtn_src_ord_histry_cat').val(search_cat);
                    $('#order_history_search_box').val('');
                    $('#local_src_ord_histry_cat').val('0');
                    $('#order_history_cat').html("Select <span class='caret'></span>");
                });
            }
            else{
                $(".main_body").load("repeat_order.php",{"search_cat":search_cat,"search_value":search_value}, function(){ //get content from PHP page
                    $('.search-tabs').show();
                    $('.main_body').prepend("<div class='col-md-12 search-result-tabs' style='display: block;'>Search result for <strong>"+search_value+"</strong>...</div>");
                    $('#loading').removeClass("showloading"); //once done, hide loading element
                    $('#local_pagtn_src_ord_histry').val(search_value);
                    $('#local_pagtn_src_ord_histry_cat').val(search_cat);
                    $('#order_history_search_box').val('');
                    $('#local_src_ord_histry_cat').val('0');
                    $('#order_history_cat').html("Select <span class='caret'></span>");
                });
            }          
        }    
    });

    //executes code below when user click on pagination links
    $(".main_body").on( "click", ".order_history_loc_src_pagtn .pagination a", function (e){
        e.preventDefault();
        var search_value = $("#local_pagtn_src_ord_histry").val();
        var search_cat = $('#local_pagtn_src_ord_histry_cat').val();

        $('#loading').addClass("showloading"); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        var order_type = $('#order_type_div').val();
        if(order_type == 'OH'){
            $(".main_body").load("order_history.php",{"search_cat":search_cat,"search_value":search_value,"page":page}, function(){ //get content from PHP page
                $('.search-tabs').show();
                $('#loading').removeClass("showloading"); //once done, hide loading element
                $('#order_history_search_box').val('');
                $('#local_src_ord_histry_cat').val('0');
                $('#order_history_cat').html("Select <span class='caret'></span>");
                $('.main_body').prepend("<div class='col-md-12 search-result-tabs' style='display: block;'>Search result for <strong>"+search_value+"</strong>...</div>");
            }); 
        }
        else{
            $(".main_body").load("repeat_order.php",{"search_cat":search_cat,"search_value":search_value,"page":page}, function(){ //get content from PHP page
                $('.search-tabs').show();
                $('#loading').removeClass("showloading"); //once done, hide loading element
                $('#order_history_search_box').val('');
                $('#local_src_ord_histry_cat').val('0');
                $('#order_history_cat').html("Select <span class='caret'></span>");
                $('.main_body').prepend("<div class='col-md-12 search-result-tabs' style='display: block;'>Search result for <strong>"+search_value+"</strong>...</div>");
            });
        }             
    });
});

//----------For PO History
$(document).on('keypress','#po_search_box',function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13')
    {
        $(".po_search .input-group-addon").trigger("click");
    }
});

$(document).ready(function () {
    $(".po_search" ).on( "click",".input-group-addon", function(e) {
        var search_value = $("#po_search_box").val();
        
        if(search_value == ""){
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter Text In Search Box!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            return false;
        }
        else
        {
            $.ajax({
                url:'ajax.php',
                type: "POST",
                data:'search_value='+search_value+'&action=get_po_history',
                beforeSend:function(){
                    $('#loading').addClass("showloading"); //show loading element
                },
                success:function(data){
                    $('#po_history_table').html(data);
                },
                complete:function(){
                    $('#loading').removeClass("showloading"); //once done, hide loading element
                    $('#po_search_box').val('');
                    $('#local_pagination_po_value').val(search_value);
                    $('.search-result-tabs').remove();
                    $("<div class='col-md-12 search-result-tabs' style='display: block;'>Search result for <strong>"+search_value+"</strong>...</div>").insertBefore('.po-history-div');                
                }
            });            
        } 

        //executes code below when user click on pagination links
        $(".main_body").on( "click", ".po_history_loc_src_pagtn .pagination a", function (e){
            e.preventDefault();
            var search_value = $("#local_pagination_po_value").val();
            var page = $(this).attr("data-page"); //get page number from link

            $.ajax({
                url:'ajax.php',
                type: "POST",
                data:'search_value='+search_value+'&page='+page+'&action=get_po_history',
                beforeSend:function(){
                    $('#loading').addClass("showloading"); //show loading element
                },
                success:function(data){
                    $('#po_history_table').html(data);
                },
                complete:function(){
                    $('#loading').removeClass("showloading"); //once done, hide loading element
                    $('#po_search_box').val('');
                    $('.search-result-tabs').remove();
                    $("<div class='col-md-12 search-result-tabs' style='display: block;'>Search result for <strong>"+search_value+"</strong>...</div>").insertBefore('.po-history-div');                
                }
            });          
        });
    });   
});

//----------For Quotation History
$(document).on('keypress','#quote_search_box',function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13')
    {
        $(".quote_search .input-group-addon").trigger("click");
    }
});

$(document).ready(function () {
    $(".quote_search" ).on( "click",".input-group-addon", function(e) {
        var search_value = $("#quote_search_box").val();
        
        if(search_value == ""){
            $('.notify').html("<span class='close-notify'>&times;</span><strong>Please Enter Text In Search Box!</strong> ");
            $('.notify').removeClass('notify-success');
            $('.notify').addClass('notify-failed');
            $('.notify').show();
            setTimeout(function(){ $('.close-notify').trigger('click'); }, 5000);
            return false;
        }
        else
        {
            $.ajax({
                url:'ajax.php',
                type: "POST",
                data:'search_value='+search_value+'&action=get_quote_history',
                beforeSend:function(){
                    $('#loading').addClass("showloading"); //show loading element
                },
                success:function(data){
                    $('#quote_history_table').html(data);
                },
                complete:function(){
                    $('#loading').removeClass("showloading"); //once done, hide loading element
                    $('#quote_search_box').val('');
                    $('#local_pagination_quote_value').val(search_value);
                    $('.search-result-tabs').remove();
                    $("<div class='col-md-12 search-result-tabs' style='display: block;'>Search result for <strong>"+search_value+"</strong>...</div>").insertBefore('.quote-history-div');
                }
            });
        } 

        //executes code below when user click on pagination links
        $(".main_body").on( "click", ".quote_history_loc_src_pagtn .pagination a", function (e){
            e.preventDefault();
            var search_value = $("#local_pagination_quote_value").val();        
            var page = $(this).attr("data-page"); //get page number from link

            $.ajax({
                url:'ajax.php',
                type: "POST",
                data:'search_value='+search_value+'&page='+page+'&action=get_quote_history',
                beforeSend:function(){
                    $('#loading').addClass("showloading"); //show loading element
                },
                success:function(data){
                    $('#quote_history_table').html(data);
                },
                complete:function(){
                    $('#loading').removeClass("showloading"); //once done, hide loading element
                    $('#quote_search_box').val('');
                    $('.search-result-tabs').remove();
                    $("<div class='col-md-12 search-result-tabs' style='display: block;'>Search result for <strong>"+search_value+"</strong>...</div>").insertBefore('.quote-history-div');
                }
            });         
        });

    });   
   
});