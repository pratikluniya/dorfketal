<?php

include("header.php");
include("top_header.php");
include("side_navigation.php");
?>

<div id="wrapper">
    <div class="normalheader transition animated fadeIn">
        <div class="hpanel row">
            <div class="panel-body">
                <div class="col-md-6 col-xs-6 col-lg-6 col-sm-6">
                    <h2 class="font-light m-b-xs main_heading">
                        Welcome to Dorf Ketal
                    </h2>
                </div>
                <div class="col-md-6 col-xs-6 col-lg-6 col-sm-6">
                    <span id="mycart">
                        <img src="images/cart-icon.png" style="height:60px;">
                        <span class="" id="cart_count" style="<?php if($_SESSION['cart_count'] > 9) { echo'margin:16px 0px 0px -46px';  } else{  echo 'margin:16px 0px 0px -40px'; } ?>;">
                            <?php echo $_SESSION['cart_count'];?>
                        </span>
                    </span>
                    <span class="pull-right" id="logout-button"> &nbsp;&nbsp;Log Out </span>
                    <span class="pull-right" id="cust_name">
                        <?php echo("Welcome, <b>".$_SESSION['cust_id']."</b>"); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- End of post Header Box  -->
    <!-- Main body starts -->
    <div class="content animate-panel">
        <div class="row">
            <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
                <div class="hpanel row">
                    <div class="notify animated fadeIn">
  
                    </div>
                    <div class="container cat-tabs">
                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 col-md-offset-4">
                            <div class="">
                                <button type="button" class="by_product btn btn-primary" id="by_product">By Products</button>
                                <button type="button" class="by_application btn btn-primary inactive-cat-tab" id="by_application">By Application</button><br>
                                <select id="cat_applications">
                                </select>
                            </div>
                        </div>                        
                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 local-search-div product_search">
                            <div class="input-group">                                
                                <input type="text" class="form-control " id="product_search_box" aria-label="..." placeholder="Search By Product Code or Name">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                <input type="hidden" id="local_search_cat" value="">
                                <input type="hidden" id="local_pagination_search_cat" value="">
                                <input type="hidden" id="local_pagination_search_value" value="">
                            </div>
                        </div>                        
                    </div>
                    <div class="container po-tabs">
                        <div class="col-xs-6 col-sm-8 col-md-6 col-lg-6 col-md-offset-2">
                            <div class="">
                                <button type="button" class="up_po btn btn-primary" id="up_po">Upload PO#</button>
                                <button type="button" class="po_history btn btn-primary inactive-cat-tab" id="po_history">PO# History</button><br>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 local-search-div po_search">
                            <div class="input-group">                                
                                <input type="text" class="form-control " id="po_search_box" aria-label="..." placeholder="Search By PO# Number">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                <input type="hidden" id="local_pagination_po_value" value="">
                            </div>
                        </div> 
                    </div>
                    <div class="container quote-tabs">
                        <div class="col-xs-6 col-sm-8 col-md-6 col-lg-6 col-md-offset-2">
                            <div class="">
                                <button type="button" class="up_quote btn btn-primary" id="up_quote">Request Quotation</button>
                                <button type="button" class="quote_history btn btn-primary inactive-cat-tab" id="quote_history">Quotation History</button><br>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4  local-search-div quote_search">
                            <div class="input-group">                                
                                <input type="text" class="form-control " id="quote_search_box" aria-label="..." placeholder="Search By Product Code or Name">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                <input type="hidden" id="local_pagination_quote_value" value="">
                            </div>
                        </div>
                    </div>
                    <div class="container search-tabs">                 
                        <div class="col-xs-12 col-sm-10 col-md-6 col-lg-5 pull-right local-search-div order_history_search">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button type="button" class="btn local-search-dropdown-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="order_history_cat">Select Search By <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a data-value="1" data-category="Product Code">Product Code</a></li>
                                        <li><a data-value="2" data-category="Product Name">Product Name</a></li>
                                        <li><a data-value="3" data-category="Order Number">Order Number</a></li>
                                        <li><a data-value="4" data-category="Order Web Id">Order Web Id</a></li>
                                        <li><a data-value="5" data-category="PO# Number">PO# Number</a></li>
                                        <li><a data-value="6" data-category="Order Status">Order Status</a></li>                                           
                                    </ul>
                                </div><!-- /btn-group -->                                
                                <input type="text" class="form-control" id="order_history_search_box" aria-label="..." placeholder="Search ">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                <input type="hidden" id="local_src_ord_histry_cat" value="0">
                                <input type="hidden" id="local_pagtn_src_ord_histry" value="">
                                <input type="hidden" id="local_pagtn_src_ord_histry_cat" value="">
                                <input type="hidden" id="order_type_div" value="">
                            </div>
                        </div>                    
                    </div>
                    <div class="panel-body main_body">
                        <p>
                            Lorem Ipsum is simply dummy text of the <strong>printing and typesetting</strong> industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                            <abbr title="" data-original-title="Sample abbreviation">scrambled it to make</abbr> a type specimen book. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the
                            scrambled it to make a type specimen book.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  

<?php

include("footer.php");

?>
