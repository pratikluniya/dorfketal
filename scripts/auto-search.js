/************* Autocomplete Global Search *******************/
$(document).ready(function(){
    $('#search_box').autocomplete({
        select:function(event,ui){
            $('#search_box').val(ui.item.value);
            if($('#search_box').val()==''){
                return false;
            }
            $(".search-div .input-group-addon").trigger("click");
        },
        source: function (request, response) {
            var auto_search_cat = $('#search_id').val();
            $.ajax({
                url : 'global_auto_search.php',
                dataType: 'json',
                data: { 
                    auto_search_value: request.term,
                    search_category: auto_search_cat
                },
                success: function (data) {
                    if(data[0] != 'No Data'){
                        response($.map(data, function (item) {
                            if(data.length > 5){
                                $('.ui-autocomplete').addClass('ul_scroll');
                            }
                            else{
                                $('.ui-autocomplete').removeClass('ul_scroll');
                            }

                            if(auto_search_cat == 1){
                                return { 
                                    value: item.PRODUCT_CODE,
                                    label: item.PRODUCT_CODE,
                                    description: item.DESCRIPTION,
                                };
                            }          
                            else{   
                                return { 
                                    value: item,
                                    label: item                                    
                                };                        
                            }                
                        }));
                    }
                    else{
                        $('.ui-autocomplete').removeClass('ul_scroll');
                        response($.map(data, function (item) {                            
                            return { 
                                label:'' 
                            };                            
                        }));                        
                    }
                }     
            });
        },               
        messages: {
          noResults: '',
          results: ''
        },   
        minLength: 0  
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        var auto_search_cat = $('#search_id').val();
        if(item.label == undefined || item.label == ''){        
            return $("<li></li>")
                .append("<a>No Records Found</a>")
                .appendTo(ul);       
        }
        else{
            if(auto_search_cat == 1){
                return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.label + " - <span class='autocomplete_desc'>[ "+ item.description +" ]</span></a>")
                    .appendTo(ul);
            }
            else{
                return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.label + "</a>")
                    .appendTo(ul);
            }
        }           
    }; 
});

/************* Autocomplete Local Search *******************/
//For Product
$(document).ready(function(){
    var cat_value = '';   
    $('#product_search_box').autocomplete({
        select:function(event,ui){
            $('#product_search_box').val(ui.item.value);
            if($('#product_search_box').val()==''){
                return false;
            }
            $(".product_search .input-group-addon").trigger("click");
        },
        source: function (request, response) {
            if(request.term == ''){
                return false;
            }
            var auto_search_cat = $('#local_search_cat').val();
            if (isNaN( request.term )) {
                // For Description Only
                cat_value = 0;
            } else {
                // For Product Code and Description Only
                cat_value = 1;
            }
           
            $.ajax({
                url : 'local_auto_search.php',
                dataType: 'json',
                data: { 
                    auto_search_value: request.term,
                    search_category: auto_search_cat,
                    action: 'product_search'
                },
                success: function (data) {
                    if(data[0] != 'No Data'){
                        response($.map(data, function (item) {                 
                            if(data.length > 5){
                                $('.ui-autocomplete').addClass('ul_scroll');
                            }
                            else{
                                $('.ui-autocomplete').removeClass('ul_scroll');
                            }

                            if(cat_value == 1){
                                return { 
                                    value: item.PRODUCT_CODE,
                                    label: item.PRODUCT_CODE,
                                    description: item.DESCRIPTION,
                                };
                            }          
                            else{                                
                                return { 
                                    value: item.DESCRIPTION,
                                    label: item.DESCRIPTION                                    
                                };                                                         
                            }                
                        }));
                    }
                    else{
                        $('.ui-autocomplete').removeClass('ul_scroll');
                        response($.map(data, function (item) {                            
                            return { 
                                label:'' 
                            };                            
                        }));                        
                    }                    
                }
            });
        },
        minLength: 0  
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        if(item.label == undefined || item.label == ''){        
            return $("<li></li>")
                .append("<a>No Records Found</a>")
                .appendTo(ul);       
        }
        else{
            if(cat_value == 1){
                return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.label + " - <span class='autocomplete_desc'>[ "+ item.description +" ]</span></a>")
                    .appendTo(ul);
            }
            else{
                return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.label + "</a>")
                    .appendTo(ul);
            }
        }           
    }; 
});

//For Quotation History
$(document).ready(function(){
    var cat_value = '';   
    $('#quote_search_box').autocomplete({
        select:function(event,ui){
            $('#quote_search_box').val(ui.item.value);
            if($('#quote_search_box').val()==''){
                return false;
            }
            $(".quote_search .input-group-addon").trigger("click");
        },
        source: function (request, response) {

            if(request.term == ''){
                return false;
            }
            if (isNaN( request.term )) {                
                // For Description Only
                cat_value = 0;
            } else {
                // For Product Code and Description Only
                cat_value = 1;
            }
           
            $.ajax({
                url : 'local_auto_search.php',
                dataType: 'json',
                data: { 
                    auto_search_value: request.term,
                    action: 'quote_search'
                },
                success: function (data) {
                    if(data[0] != 'No Data'){
                        response($.map(data, function (item) {                 
                            if(data.length > 5){
                                $('.ui-autocomplete').addClass('ul_scroll');
                            }
                            else{
                                $('.ui-autocomplete').removeClass('ul_scroll');
                            }

                            if(cat_value == 1){
                                return { 
                                    value: item.PRODUCT_CODE,
                                    label: item.PRODUCT_CODE,
                                    description: item.DESCRIPTION,
                                };
                            }          
                            else{                                
                                return { 
                                    value: item.DESCRIPTION,
                                    label: item.DESCRIPTION                                    
                                };                                                         
                            }                
                        }));
                    }
                    else{
                        $('.ui-autocomplete').removeClass('ul_scroll');
                        response($.map(data, function (item) {                            
                            return { 
                                label:'' 
                            };                            
                        }));                        
                    }                    
                }
            });
        },        
        minLength: 0  
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        if(item.label == undefined || item.label == ''){        
            return $("<li></li>")
                .append("<a>No Records Found</a>")
                .appendTo(ul);       
        }
        else{
            if(cat_value == 1){
                return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.label + " - <span class='autocomplete_desc'>[ "+ item.description +" ]</span></a>")
                    .appendTo(ul);
            }
            else{
                return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.label + "</a>")
                    .appendTo(ul);
            }
        }           
    }; 
});

//For PO History
$(document).ready(function(){
    $('#po_search_box').autocomplete({
        select:function(event,ui){
            $('#po_search_box').val(ui.item.value);
            if($('#po_search_box').val()==''){
                return false;
            }
            $(".po_search .input-group-addon").trigger("click");
        },
        source: function (request, response) {

            if(request.term == ''){
                return false;
            }                  
            $.ajax({
                url : 'local_auto_search.php',
                dataType: 'json',
                data: { 
                    auto_search_value: request.term,
                    action: 'po_search'
                },
                success: function (data) {
                    if(data[0] != 'No Data'){
                        response($.map(data, function (item) {                 
                            if(data.length > 5){
                                $('.ui-autocomplete').addClass('ul_scroll');
                            }
                            else{
                                $('.ui-autocomplete').removeClass('ul_scroll');
                            }                                
                            return { 
                                value: item.PO_NUMBER,
                                label: item.PO_NUMBER                                    
                            };                                          
                        }));
                    }
                    else{
                        $('.ui-autocomplete').removeClass('ul_scroll');
                        response($.map(data, function (item) {                            
                            return { 
                                label:'' 
                            };                            
                        }));                        
                    }                    
                }             
            });
        },        
        minLength: 0  
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        if(item.label == undefined || item.label == ''){        
            return $("<li></li>")
                .append("<a>No Records Found</a>")
                .appendTo(ul);       
        }
        else{           
            return $("<li></li>")
                .data("item.autocomplete", item)
                .append("<a>" + item.label + "</a>")
                .appendTo(ul);            
        }           
    }; 
});

//For Order History
$(document).ready(function(){
    $('#order_history_search_box').autocomplete({
        select:function(event,ui){
            $('#order_history_search_box').val(ui.item.value);
            if($('#order_history_search_box').val()==''){
                return false;
            }
            $(".order_history_search .input-group-addon").trigger("click");
        },
        source: function (request, response) {
            var auto_search_cat = $('#local_src_ord_histry_cat').val();
            $.ajax({
                url : 'local_auto_search.php',
                dataType: 'json',
                data: { 
                    auto_search_value: request.term,
                    search_category: auto_search_cat,
                    action: 'order_history_search'
                },
                success: function (data) {
                    response($.map(data, function (item) {
                        if(data.length > 5){
                            $('.ui-autocomplete').addClass('ul_scroll');
                        }
                        else{
                            $('.ui-autocomplete').removeClass('ul_scroll');
                        }

                        if(auto_search_cat == 1){
                            return { 
                                value: item.PRODUCT_CODE,
                                label: item.PRODUCT_CODE,
                                description: item.DESCRIPTION,
                            };
                        }          
                        else{
                            if(item == 'No Data'){
                                return { 
                                    label:''                                    
                                };
                            }
                            else{
                                return { 
                                    value: item,
                                    label: item                                    
                                };
                            }                         
                        }                
                    }));
                }     
            });
        },           
        minLength: 0  
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        var auto_search_cat = $('#local_src_ord_histry_cat').val();
        if(item.label == undefined || item.label == ''){        
            return $("<li></li>")
                .append("<a>No Records Found</a>")
                .appendTo(ul);       
        }
        else{
            if(auto_search_cat == 1){
                return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.label + " - <span class='autocomplete_desc'>[ "+ item.description +" ]</span></a>")
                    .appendTo(ul);
            }
            else{
                return $("<li></li>")
                    .data("item.autocomplete", item)
                    .append("<a>" + item.label + "</a>")
                    .appendTo(ul);
            }
        }           
    }; 
});
