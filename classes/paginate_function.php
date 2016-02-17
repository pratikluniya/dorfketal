<?php

################ pagination function #########################################
function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
{
    $pagination = '';
    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
        $pagination .= '<nav><ul class="pagination">';
        
        $right_links    = $current_page + 3; 
        $previous_link = $current_page - 3; //previous links 
        $previous       = $current_page - 1; //previous link 
        $next           = $current_page + 1; //next link
        $first_link     = true; //boolean var to decide our first link
        
        if($current_page > 0){
            
            //$pagination .= '<li class="first"><a href="#" data-page="1" title="First">&laquo;</a></li>'; //first link
            if($current_page == 1){
                $pagination .= '<li class="disabled"><a href="#" aria-label="Previous" title="First"><span aria-hidden="true">First</span></a></li>'; //first link
                $pagination .= '<li class="disabled"><a href="#" title="Previous">Previous</a></li>'; //previous link
            }else
            {
                $pagination .= '<li><a href="#" data-page="1" aria-label="Previous" title="First"><span aria-hidden="true">First</span></a></li>'; //first link
                $pagination .= '<li><a href="#" data-page="'.$previous.'" title="Previous">Previous</a></li>'; //previous link
            }            
            for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
                if($i > 0){
                    $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
                }
            }   
            $first_link = false; //set first link to false
        }
        
        if($first_link){ //if current active page is first link
            $pagination .= '<li class="active"><a href="#">'.$current_page.'<span class="sr-only">(current)</span></a></li>';
        }elseif($current_page == $total_pages){ //if it's the last active link
            $pagination .= '<li class="active"><a href="#">'.$current_page.'<span class="sr-only">(current)</span></a></li>';
        }else{ //regular current link
            $pagination .= '<li class="active"><a href="#">'.$current_page.'<span class="sr-only">(current)</span></a></li>';
        }
                
        for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
            if($i<=$total_pages){
                $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
            }
        }
        if($current_page == $total_pages){ 
                //$next_link = ($i > $total_pages) ? $total_pages : $i;
                $pagination .= '<li class="disabled"><a href="#" title="Next">Next</a></li>'; //next link
                $pagination .= '<li class="disabled"><a href="#" aria-label="Next" title="Last"><span aria-hidden="true">Last</span></a></li>'; //last link
        }
        else{ 
                //$next_link = ($i > $total_pages) ? $total_pages : $i;
                $pagination .= '<li><a href="#" data-page="'.$next.'" title="Next">Next</a></li>'; //next link
                $pagination .= '<li><a href="#" aria-label="Next" data-page="'.$total_pages.'" title="Last"><span aria-hidden="true">Last</span></a></li>'; //last link
        }

        
        $pagination .= '</ul></nav>'; 
    }
    return $pagination; //return pagination links
}

?>