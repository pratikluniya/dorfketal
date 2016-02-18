<!-- Header -->
<div id="row header">
    <div id="logo" class="container light-version">
        <div class="col-xs-12 col-sm-6 col-md-8 pull-left">
            <span >
                <a href="home.php">
                    <img src="images/dk-logo.png" style="height: 80px;width: 187px;">
                </a>
            </span> 
        </div>       
        <div class="col-xs-6 col-md-4 pull-right search-div">
            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn search-dropdown-btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="search_cat">Product Id <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="#" data-page="1">Product Id</a></li>
                        <li><a href="#" data-page="2">Product Name</a></li>
                        <li><a href="#" data-page="3">Application</a></li>
                        <li><a href="#" data-page="4">Category</a></li>
                        <li><a href="#" data-page="5">Order Id</a></li>
                        <li><a href="#" data-page="6">Order Web Id</a></li>
                        
                    </ul>
                </div><!-- /btn-group -->
                <input type="text" class="form-control" id="search_box" aria-label="..." placeholder="Enter Product Id">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="hidden" id="search_id" value="1">
                <input type="hidden" id="pagination_search_id" value="">
                <input type="hidden" id="pagination_search_value" value="">
            </div>
        </div>        
    </div>
</div>
    <nav role="navigation">
        <div class="mobile-menu">
            <button type="button" class="navbar-toggle mobile-menu-toggle" data-toggle="collapse" data-target="#mobile-collapse">
                <i class="fa fa-chevron-down"></i>
            </button>
            <div class="collapse mobile-navbar" id="mobile-collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="nav-label">Order Management</span></a>
                        <ul class="dropdown-menu">
                            <li class="hide-nav place_order_btn"><a href="#">Place Order</a></li>
                            <li class="hide-nav req_quotation_btn"><a href="#">Request Quotation</a></li>
                            <li class="hide-nav upload_po_btn"><a href="#">Upload P.O.</a></li>
                            <li class="hide-nav regular_prod_btn"><a href="#">Regular Products</a></li>
                            <li class="hide-nav fav_vertical_btn"><a href="#">Favorite Vertical</a></li>
                            <li class="hide-nav reset_vertical_btn"><a href="#">Reset Favorite Vertical</a></li>
                            <li class="hide-nav order_history_btn"><a href="#">View Order History</a></li>
                            <li class="hide-nav repeat_order_btn"><a href="#">Repeat Order</a></li>                    
                            <li class="hide-nav sales_order_btn"><a href="#">Sales Order Agreement</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="nav-label">Logistic Management</span></a>
                        <ul class="dropdown-menu">
                            <li class="hide-nav track_order_btn"><a href="#">Track Order</a></li>
                            <li class="hide-nav"><a href="#">Track URL</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="nav-label">Finance  Management</span></a>
                        <ul class="dropdown-menu">
                            <li class="hide-nav"><a href="">Open Invoice</a></li>
                            <li class="hide-nav"><a href="">Closed Invoice</a></li>
                            <li class="hide-nav"><a href="">Payment Details</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="nav-label">Product</span></a>
                        <ul class="dropdown-menu">
                            <li class="hide-nav"><a href="">Catalogue</a></li>
                            <li class="hide-nav"><a href="">Knowlege Based</a></li>
                            <li class="hide-nav"><a href="">SDS</a></li>
                            <li class="hide-nav"><a href="">Solution Box</a></li> 
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="nav-label">Support</span></a>
                        <ul class="dropdown-menu">
                            <li class="hide-nav"><a href="">Live Chat</a></li>
                            <li class="hide-nav contactus_btn"><a href="#">Contact Us</a></li>  
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar-right">
        </div>
    </nav>
</div>
