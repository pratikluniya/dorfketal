/********** Search ************/
$(document).on('keypress','#search_box',function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13')
    {
        $(".input-group-addon").trigger("click");
    }
});

$(document).ready(function(){  

    $('.search-div').on('click','.dropdown-menu a',function(e){
        var search_cat = $(this).attr("data-page");
        var cat;
        if(search_cat == 1){
            cat = "Product Id";
        }
        if(search_cat == 2){
            cat = "Product Name";
        }
        if(search_cat == 3){
            cat = "Application";
        }
        if(search_cat == 4){
            cat = "Category";
        }
        if(search_cat == 5){
            cat = "Order Id";
        }
        if(search_cat == 6){
            cat = "Order Web Id";
        }
        
        $('#search_id').val(search_cat);
        $('#search_cat').html(cat +" <span class='caret'></span>");        

        var search_value = $('#search_box').val();
        if(search_value == "")
        {
            $('#search_box').attr('placeholder','Enter '+cat);
        }
    });

    $('.search-div').on('click','.input-group-addon',function(e){
        var search_value = $('#search_box').val();
        var search_category = $('#search_id').val();

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

        if(search_value == ""){
            return false;
        }else{
            if(search_category == 1 || search_category == 2 || search_category == 3 || search_category == 4)
            {
                $.ajax({
                    type: "POST",
                    url: "product_list.php",
                    data: 'search_category='+search_category+'&search_value='+search_value,
                    beforeSend: function(){
                        $('#loading').addClass("showloading");
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
                        $('#search_box').val('');
                        $('.main_body').prepend("<div class='col-md-12 search-tabs' style='display: block;'>Search result for <strong>"+cat+"</strong> like <strong>"+search_value+"</strong>...</div>");
                    }
                });
            }
            else
            {
                $('#loading').addClass("showloading"); //show loading element
                $(".main_body").load("repeat_order.php",{"search_category":search_category,"search_value":search_value}, function(){ 
                    $('.main_heading').html("Search Results");
                    $('.main_body').prepend("<div class='col-md-12 search-tabs' style='display: block;'>Search result for <strong>"+cat+"</strong> is <strong>"+search_value+"</strong>...</div>");
                    $('#loading').removeClass("showloading"); //once done, hide loading element
                    $('#pagination_search_value').val(search_value);
                    $('#pagination_search_id').val(search_category);
                    $('#search_box').val('');
                });                
            }            
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