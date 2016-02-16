<?php

include("header.php");
include("top_header.php");
include("side_navigation.php");
?>

<div id="wrapper">
    <div class="normalheader transition animated fadeIn">
        <div class="hpanel row">
            <div class="panel-body">
                <div class="col-lg-6">
                    <h2 class="font-light m-b-xs main_heading">
                        Welcome to Dorf Ketal
                    </h2>
                </div>
                <div class="col-lg-6">
                    <span id="mycart">
                        <img src="images/cart-icon.png" style="height:60px;">
                        <span class="" id="cart_count" style="<?php if($_SESSION['cart_count'] > 9) { echo'margin:16px 0px 0px -46px';  } else{  echo 'margin:16px 0px 0px -40px'; } ?>;">
                            <?php echo $_SESSION['cart_count'];?>
                        </span>
                    </span>
                    <span class="pull-right" id="logout-button"> Log Out </span>
                </div>
            </div>
        </div>
    </div>
    <!-- Hi This is Tushar -->
    <!-- End of post Header Box  -->
    <!-- Main body starts -->
    <div class="content animate-panel">
        <div class="row">
            <div class="col-lg-12">
                <div class="hpanel row">
                    <div class="notify animated fadeIn">
  
                    </div>
                    <div class="container cat-tabs">
                        <button type="button" class="by_product btn btn-primary" id="by_product">By Products</button>
                        <button type="button" class="by_application btn btn-primary inactive-cat-tab" id="by_application">By Application</button><br>
                        <select id="cat_applications">
                        </select>
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
