/************* Autocomplete Global Search *******************/
$(document).ready(function(){   
    $('#search_box').autocomplete({
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
                    response($.map(data, function (item) {
                        if(data.length > 5){
                            $('.ui-autocomplete').addClass('ul_scroll');
                        }
                        else{
                            $('.ui-autocomplete').removeClass('ul_scroll');
                        }

                        if(auto_search_cat == 1){
                            return { 
                                value: item.id,
                                label: item.id,
                                description: item.desc,
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
                },
                select: function (event, ui) {
                },
                messages: {
                  noResults: 'No Result Found',
                  results: ''
                }        
            });
        },
        autoFocus: true,
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


