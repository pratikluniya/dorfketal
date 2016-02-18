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
                        <div class="container">
                            <div class="col-md-7">
                                <div class="pull-right">
                                    <button type="button" class="by_product btn btn-primary" id="by_product">By Products</button>
                                    <button type="button" class="by_application btn btn-primary inactive-cat-tab" id="by_application">By Application</button><br>
                                    <select id="cat_applications">
                                    </select>
                                </div>
                            </div>                        
                            <div class="col-md-4 pull-right local-search-div">
                                <div class="input-group">                                
                                    <input type="text" class="form-control local_search_box" aria-label="..." placeholder="Search...">
                                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                    <input type="hidden" id="local_search_cat" value="">
                                    <input type="hidden" id="local_pagination_search_cat" value="">
                                    <input type="hidden" id="local_pagination_search_value" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container po-tabs">
                        <button type="button" class="up_po btn btn-primary" id="up_po">Upload PO#</button>
                        <button type="button" class="po_history btn btn-primary inactive-cat-tab" id="po_history">PO# History</button><br>
                        </select>
                    </div>
                    <div class="container quote-tabs">
                        <button type="button" class="up_quote btn btn-primary" id="up_quote">Request Quotation</button>
                        <button type="button" class="quote_history btn btn-primary inactive-cat-tab" id="quote_history">Quotation History</button><br>
                        </select>
                    </div>
                    <div class="container search-tabs">
                        <div class="col-md-12">
                            <div class="col-xs-6 col-md-4 pull-right local-search-div">
                                <div class="input-group">                                
                                    <input type="text" class="form-control local_search_box" aria-label="..." placeholder="Search...">
                                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                    <input type="hidden" id="local_search_cat" value="">
                                    <input type="hidden" id="local_pagination_search_cat" value="">
                                    <input type="hidden" id="local_pagination_search_value" value="">
                                </div>
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
</div>   

<?php

include("footer.php");

?>
