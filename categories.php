<?php 
require('top.php');

if(!isset($_GET['id']) || $_GET['id']==''){
    ?>
    <script>
    window.location.href='index.php';
    </script>
    <?php
}

$cat_id = mysqli_real_escape_string($con, $_GET['id']);
$sub_categories = '';
if (isset($_GET['sub_categories'])) {
    $sub_categories = mysqli_real_escape_string($con, $_GET['sub_categories']);
}
$price_high_selected = "";
$price_low_selected = "";
$new_selected = "";
$old_selected = "";
$sort_order = "";

if (isset($_GET['sort'])) {
    $sort = mysqli_real_escape_string($con, $_GET['sort']);
    if ($sort == "price_high") {
        $sort_order = " ORDER BY product.price DESC ";
        $price_high_selected = "selected";
    }
    if ($sort == "price_low") {
        $sort_order = " ORDER BY product.price ASC ";
        $price_low_selected = "selected";
    }
    if ($sort == "new") {
        $sort_order = " ORDER BY product.id DESC ";
        $new_selected = "selected";
    }
    if ($sort == "old") {
        $sort_order = " ORDER BY product.id ASC ";
        $old_selected = "selected";
    }
}

// Pagination variables
$items_per_page = 6; // Number of items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Fetch the total number of products for pagination
$total_products_query = "SELECT COUNT(*) as total FROM product WHERE categories_id = '$cat_id'";
if ($sub_categories != '') {
    $total_products_query .= " AND sub_categories_id = '$sub_categories'";
}
$total_products_result = mysqli_query($con, $total_products_query);
$total_products_row = mysqli_fetch_assoc($total_products_result);
$total_products = $total_products_row['total'];
$total_pages = ceil($total_products / $items_per_page);

// Fetch products for the current page
$get_product_query = "SELECT * FROM product WHERE categories_id = '$cat_id'";
if ($sub_categories != '') {
    $get_product_query .= " AND sub_categories_id = '$sub_categories'";
}
$get_product_query .= $sort_order . " LIMIT $offset, $items_per_page";
$get_product_result = mysqli_query($con, $get_product_query);
$get_product = mysqli_fetch_all($get_product_result, MYSQLI_ASSOC);

?>
<div class="body__overlay"></div>
        
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/4.jpg) no-repeat scroll center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner">
                        <nav class="bradcaump-inner">
                          <a class="breadcrumb-item" href="index.php">Home</a>
                          <span class="brd-separetor"><i class="zmdi zmdi-chevron-right"></i></span>
                          <span class="breadcrumb-item active">Products</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->

<!-- Start Product Grid -->
<section class="htc__product__grid bg__white ptb--100">
    <div class="container">
        <div class="row">
            <?php if (count($get_product) > 0) { ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="htc__product__rightidebar">
                    <div class="htc__grid__top">
                        <div class="htc__select__option">
                            <select class="ht__select" onchange="sort_product_drop('<?php echo $cat_id?>','<?php echo SITE_PATH?>')" id="sort_product_id">
                                <option value="">Default sorting</option>
                                <option value="price_low" <?php echo $price_low_selected ?>>Sort by price low to high</option>
                                <option value="price_high" <?php echo $price_high_selected ?>>Sort by price high to low</option>
                                <option value="new" <?php echo $new_selected ?>>Sort by new first</option>
                                <option value="old" <?php echo $old_selected ?>>Sort by old first</option>
                            </select>
                        </div>
                    </div>
                    <!-- Start Product View -->
                    <div class="row">
                        <div class="shop__grid__view__wrap">
                            <div role="tabpanel" id="grid-view" class="single-grid-view tab-pane fade in active clearfix">
                                <?php foreach ($get_product as $list) { ?>
                                <!-- Start Single Category -->
                                <div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
                                    <div class="category">
                                        <div class="ht__cat__thumb">
                                            <a href="product.php?id=<?php echo $list['id']?>">
                                                <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image']?>" alt="product images">
                                            </a>
                                        </div>
                                        <div class="fr__hover__info">
                                            <ul class="product__action">
                                                <li><a href="javascript:void(0)" onclick="wishlist_manage('<?php echo $list['id']?>','add')"><i class="icon-heart icons"></i></a></li>
                                                <li><a href="javascript:void(0)" onclick="manage_cart('<?php echo $list['id']?>','add')"><i class="icon-handbag icons"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="fr__product__inner">
                                            <h4><a href="product-details.html"><?php echo $list['name']?></a></h4>
                                            <ul class="fr__pro__prize">
                                                <li class="old__prize"><?php echo $list['mrp']?></li>
                                                <li><?php echo $list['price']?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } else { 
                echo "Data not found";
            } ?>
            
            <!-- Pagination -->
            <div class="col-xs-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php if ($page > 1) { ?>
                            <li>
                                <a href="categories.php?id=<?php echo $cat_id ?>&page=<?php echo $page - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                            <li class="<?php echo ($page == $i) ? 'active' : '' ?>">
                                <a href="categories.php?id=<?php echo $cat_id ?>&page=<?php echo $i ?>"><?php echo $i ?></a>
                            </li>
                        <?php } ?>
                        <?php if ($page < $total_pages) { ?>
                            <li>
                                <a href="categories.php?id=<?php echo $cat_id ?>&page=<?php echo $page + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- End Product Grid -->

<!-- End Banner Area -->
<input type="hidden" id="qty" value="1"/>
<?php require('footer.php')?>
