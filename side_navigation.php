<!-- Navigation -->
<?php 
    include('classes/functions.php');
    // session_start();
?>
<aside id="menu">
    <div id="navigation">
        <ul class="nav affix" id="side-menu">
            <li>
                <a href="#"><span class="nav-label">Order Management</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <?php if($_SESSION['cust_id'] == "1111") { ?>
                        <li class="hide-nav admin_orders"><a href="#">Orders</a></li>
                        <li class="hide-nav admin_po"><a href="#">PO#</a></li>
                        <li class="hide-nav admin_quote"><a href="#">Quotations</a></li>
                    <?php } else { ?>
                        <li class="hide-nav place_order_btn"><a href="#">Place Order</a></li>
                        <li class="hide-nav req_quotation_btn"><a href="#">Request Quotation</a></li>
                        <li class="hide-nav upload_po_btn"><a href="#">Upload P.O.</a></li>
                        <li class="hide-nav regular_prod_btn"><a href="#">Regular Products</a></li>
                        <li class="hide-nav fav_vertical_btn"><a href="#">Favorite Vertical</a></li>                    
                        <li class="hide-nav reset_vertical_btn"><a href="#">Reset Favorite Vertical</a></li>
                        <li class="hide-nav order_history_btn"><a href="#">View Order History</a></li>
                        <li class="hide-nav repeat_order_btn"><a href="#">Repeat Order</a></li>                    
                        <li class="hide-nav sales_order_btn"><a href="#">Sales Order Agreement</a></li>
                    <?php } ?>
                </ul>
            </li>
            <li>
                <a href="#"><span class="nav-label">Logistic Management</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <?php if($_SESSION['cust_id'] == "1111") { ?>
                        <li class="hide-nav admin_track_order_btn"><a href="#">Track Order</a></li>
                   <!--  <li class="hide-nav"><a href="#">Track URL</a></li> -->
                    <?php } else { ?>
                        <li class="hide-nav track_order_btn"><a href="#">Track Order</a></li>
                    <?php } ?>
                </ul>
            </li>
            <li>
                <a href="#"><span class="nav-label">Finance  Management</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li class="hide-nav"><a href="">Open Invoice</a></li>
                    <li class="hide-nav"><a href="">Closed Invoice</a></li>
                    <li class="hide-nav"><a href="">Payment Details</a></li>
                </ul>
            </li>
             <li>
                <a href="#"><span class="nav-label">Product</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li class="hide-nav"><a href="">Catalogue</a></li>
                    <li class="hide-nav"><a href="">Knowlege Based</a></li>
                    <li class="hide-nav"><a href="">SDS</a></li>
                    <li class="hide-nav"><a href="">Solution Box</a></li>                   
                </ul>
            </li>
            <li>
                <a href="#"><span class="nav-label">Support</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li class="hide-nav"><a href="">Live Chat</a></li>
                    <li class="hide-nav contactus_btn"><a href="#">Contact Us</a></li>  
                </ul>
            </li>
        </ul>
    </div>
</aside>
