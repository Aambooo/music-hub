<?php
require('top.inc.php');

$condition = '';
$condition1 = '';
if($_SESSION['ADMIN_ROLE'] == 1) {
    $condition = " and product.added_by='" . $_SESSION['ADMIN_ID'] . "'";
    $condition1 = " and added_by='" . $_SESSION['ADMIN_ID'] . "'";
}

$categories_id = '';
$name = '';
$mrp = '';
$price = '';
$qty = '';
$image = '';
$short_desc = '';
$description = '';
$meta_title = '';
$meta_desc = '';
$meta_keyword = '';
$best_seller = '';
$sub_categories_id = '';
$multipleImageArr = [];
$msg = '';
$image_required = 'required';

if(isset($_GET['pi']) && $_GET['pi'] > 0){
    $pi = get_safe_value($con, $_GET['pi']);
    $delete_sql = "delete from product_images where id='$pi'";
    mysqli_query($con, $delete_sql);
}

if(isset($_GET['id']) && $_GET['id'] != '') {
    $image_required = '';
    $id = get_safe_value($con, $_GET['id']);
    $res = mysqli_query($con, "select * from product where id='$id' $condition1");
    $check = mysqli_num_rows($res);
    if($check > 0) {
        $row = mysqli_fetch_assoc($res);
        $categories_id = $row['categories_id'];
        $sub_categories_id = $row['sub_categories_id'];
        $name = $row['name'];
        $mrp = $row['mrp'];
        $price = $row['price'];
        $qty = $row['qty'];
        $short_desc = $row['short_desc'];
        $description = $row['description'];
        $meta_title = $row['meta_title'];
        $meta_desc = $row['meta_desc'];
        $meta_keyword = $row['meta_keyword'];
        $best_seller = $row['best_seller'];
        $image = $row['image'];
        
        $resMultipleImage = mysqli_query($con, "select id, product_images from product_images where product_id='$id'");
        if(mysqli_num_rows($resMultipleImage) > 0){
            $jj = 0;
            while($rowMultipleImage = mysqli_fetch_assoc($resMultipleImage)){
                $multipleImageArr[$jj]['product_images'] = $rowMultipleImage['product_images'];
                $multipleImageArr[$jj]['id'] = $rowMultipleImage['id'];
                $jj++;
            }
        }
        
    } else {
        header('location:product.php');
        die();
    }
}

if(isset($_POST['submit'])){
    $categories_id = get_safe_value($con, $_POST['categories_id']);
    $sub_categories_id = get_safe_value($con, $_POST['sub_categories_id']);
    $name = get_safe_value($con, $_POST['name']);
    $mrp = get_safe_value($con, $_POST['mrp']);
    $price = get_safe_value($con, $_POST['price']);
    $qty = get_safe_value($con, $_POST['qty']);
    $short_desc = get_safe_value($con, $_POST['short_desc']);
    $description = get_safe_value($con, $_POST['description']);
    $meta_title = get_safe_value($con, $_POST['meta_title']);
    $meta_desc = get_safe_value($con, $_POST['meta_desc']);
    $meta_keyword = get_safe_value($con, $_POST['meta_keyword']);
    $best_seller = get_safe_value($con, $_POST['best_seller']);
    
    $res = mysqli_query($con, "select product.* from product where product.name='$name' $condition1");
    $check = mysqli_num_rows($res);
    if($check > 0) {
        if(isset($_GET['id']) && $_GET['id'] != '') {
            $getData = mysqli_fetch_assoc($res);
            if($id != $getData['id']){
                $msg = "Product already exist";
            }
        } else {
            $msg = "Product already exist";
        }
    }
    
    if(isset($_GET['id']) && $_GET['id'] == 0) {
        if($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg'){
            $msg = "Please select only png, jpg and jpeg image format";
        }
    } else {
        if($_FILES['image']['type'] != ''){
            if($_FILES['image']['type'] != 'image/png' && $_FILES['image']['type'] != 'image/jpg' && $_FILES['image']['type'] != 'image/jpeg'){
                $msg = "Please select only png, jpg and jpeg image format";
            }
        }
    }
    
    if(isset($_FILES['product_images'])){
        if (isset($_FILES['product_images']['type']) && is_array($_FILES['product_images']['type'])) {
            foreach($_FILES['product_images']['type'] as $key=>$val){
                if (isset($_FILES['product_images']['type'][$key]) && $_FILES['product_images']['type'][$key] != '') {
                    if($_FILES['product_images']['type'][$key] != 'image/png' && $_FILES['product_images']['type'][$key] != 'image/jpg' && $_FILES['product_images']['type'][$key] != 'image/jpeg'){
                        $msg = "Please select only png, jpg and jpeg image format in multiple product images";
                    }
                }
            }
        }
    }
    
    if($msg == ''){
        if(isset($_GET['id']) && $_GET['id'] != ''){
            if($_FILES['image']['name'] != ''){
                $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image);
                $update_sql = "update product set categories_id='$categories_id', name='$name', mrp='$mrp', price='$price', qty='$qty', short_desc='$short_desc', description='$description', meta_title='$meta_title', meta_desc='$meta_desc', meta_keyword='$meta_keyword', image='$image', best_seller='$best_seller', sub_categories_id='$sub_categories_id' where id='$id'";
            } else {
                $update_sql = "update product set categories_id='$categories_id', name='$name', mrp='$mrp', price='$price', qty='$qty', short_desc='$short_desc', description='$description', meta_title='$meta_title', meta_desc='$meta_desc', meta_keyword='$meta_keyword', best_seller='$best_seller', sub_categories_id='$sub_categories_id' where id='$id'";
            }
            mysqli_query($con, $update_sql);
        } else {
            $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH . $image);
            mysqli_query($con, "insert into product(categories_id, name, mrp, price, qty, short_desc, description, meta_title, meta_desc, meta_keyword, status, image, best_seller, sub_categories_id, added_by) values('$categories_id', '$name', '$mrp', '$price', '$qty', '$short_desc', '$description', '$meta_title', '$meta_desc', '$meta_keyword', 1, '$image', '$best_seller', '$sub_categories_id', '".$_SESSION['ADMIN_ID']."')");
            $id = mysqli_insert_id($con);
        }
        
        if(isset($_GET['id']) && $_GET['id'] != ''){
            if (isset($_FILES['product_images']['name'])) {
                foreach($_FILES['product_images']['name'] as $key=>$val){
                    if($_FILES['product_images']['name'][$key] != ''){
                        if(isset($_POST['product_images_id'][$key])){
                            $image = rand(111111111, 999999999) . '_' . $_FILES['product_images']['name'][$key];
                            move_uploaded_file($_FILES['product_images']['tmp_name'][$key], PRODUCT_MULTIPLE_IMAGE_SERVER_PATH . $image);
                            mysqli_query($con, "update product_images set product_images='$image' where id='".$_POST['product_images_id'][$key]."'");
                        } else {
                            $image = rand(111111111, 999999999) . '_' . $_FILES['product_images']['name'][$key];
                            move_uploaded_file($_FILES['product_images']['tmp_name'][$key], PRODUCT_MULTIPLE_IMAGE_SERVER_PATH . $image);
                            mysqli_query($con, "insert into product_images(product_id, product_images) values('$id', '$image')");
                        }
                    }
                }
            }
        } else {
            if(isset($_FILES['product_images']['name'])){
                foreach($_FILES['product_images']['name'] as $key=>$val){
                    if($_FILES['product_images']['name'][$key] != ''){
                        $image = rand(111111111, 999999999) . '_' . $_FILES['product_images']['name'][$key];
                        move_uploaded_file($_FILES['product_images']['tmp_name'][$key], PRODUCT_MULTIPLE_IMAGE_SERVER_PATH . $image);
                        mysqli_query($con, "insert into product_images(product_id, product_images) values('$id', '$image')");
                    }
                }
            }
        }
        
        header('location:product.php');
        die();
    }
}
?>
<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Product</strong><small> Form</small></div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body card-block">
                            <div class="form-group">
                                <label for="categories" class="form-control-label">Categories</label>
                                <select class="form-control" name="categories_id" id="categories_id" onchange="get_sub_cat('')">
                                    <option>Select Category</option>
                                    <?php
                                    $res = mysqli_query($con, "select id, categories from categories order by categories asc");
                                    while($row = mysqli_fetch_assoc($res)){
                                        if($row['id'] == $categories_id){
                                            echo "<option selected value=".$row['id'].">".$row['categories']."</option>";
                                        } else {
                                            echo "<option value=".$row['id'].">".$row['categories']."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="categories" class="form-control-label">Sub Categories</label>
                                <select class="form-control" name="sub_categories_id" id="sub_categories_id">
                                    <option>Select Sub Category</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name" class="form-control-label">Product Name</label>
                                <input type="text" name="name" placeholder="Enter product name" class="form-control" required value="<?php echo $name ?>">
                            </div>
                            <div class="form-group">
                                <label for="mrp" class="form-control-label">MRP</label>
                                <input type="text" name="mrp" placeholder="Enter MRP" class="form-control" required value="<?php echo $mrp ?>">
                            </div>
                            <div class="form-group">
                                <label for="price" class="form-control-label">Price</label>
                                <input type="text" name="price" placeholder="Enter price" class="form-control" required value="<?php echo $price ?>">
                            </div>
                            <div class="form-group">
                                <label for="qty" class="form-control-label">Qty</label>
                                <input type="text" name="qty" placeholder="Enter qty" class="form-control" required value="<?php echo $qty ?>">
                            </div>
                            <div class="form-group">
                                <label for="image" class="form-control-label">Image</label>
                                <input type="file" name="image" class="form-control" <?php echo $image_required ?>>
                                <?php
                                if($image != ''){
                                    echo "<a target='_blank' href='".PRODUCT_IMAGE_SITE_PATH.$image."'><img width='150px' src='".PRODUCT_IMAGE_SITE_PATH.$image."'/></a>";
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="image" class="form-control-label">Multiple Images</label>
                                <input type="file" name="product_images[]" class="form-control" multiple>
                                <?php
                                if(isset($multipleImageArr[0])){
                                    foreach($multipleImageArr as $list){
                                        echo "<div class='product_images_box'><a target='_blank' href='".PRODUCT_MULTIPLE_IMAGE_SITE_PATH.$list['product_images']."'><img width='150px' src='".PRODUCT_MULTIPLE_IMAGE_SITE_PATH.$list['product_images']."'/></a><br/><a href='manage_product.php?id=".$id."&pi=".$list['id']."' style='color:red'>Delete</a></div>";
                                    }
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="short_desc" class="form-control-label">Short Description</label>
                                <textarea name="short_desc" placeholder="Enter short description" class="form-control" required><?php echo $short_desc ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-control-label">Description</label>
                                <textarea name="description" placeholder="Enter description" class="form-control" required><?php echo $description ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta_title" class="form-control-label">Meta Title</label>
                                <textarea name="meta_title" placeholder="Enter meta title" class="form-control"><?php echo $meta_title ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta_desc" class="form-control-label">Meta Description</label>
                                <textarea name="meta_desc" placeholder="Enter meta description" class="form-control"><?php echo $meta_desc ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta_keyword" class="form-control-label">Meta Keywords</label>
                                <textarea name="meta_keyword" placeholder="Enter meta keywords" class="form-control"><?php echo $meta_keyword ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="best_seller" class="form-control-label">Best Seller</label>
                                <select class="form-control" name="best_seller" required>
                                    <option value=''>Select</option>
                                    <?php
                                    if($best_seller == 1){
                                        echo '<option value="1" selected>Yes</option>
                                        <option value="0">No</option>';
                                    } else if($best_seller == 0){
                                        echo '<option value="1">Yes</option>
                                        <option value="0" selected>No</option>';
                                    } else {
                                        echo '<option value="1">Yes</option>
                                        <option value="0">No</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                                <span id="payment-button-amount">Submit</span>
                            </button>
                            <div class="field_error"><?php echo $msg ?></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function get_sub_cat(sub_cat_id){
    var categories_id = jQuery('#categories_id').val();
    jQuery.ajax({
        url: 'get_sub_cat.php',
        type: 'post',
        data: 'categories_id=' + categories_id + '&sub_cat_id=' + sub_cat_id,
        success: function(result){
            jQuery('#sub_categories_id').html(result);
        }
    });
}

<?php
if($sub_categories_id != '') {
    ?>
    get_sub_cat('<?php echo $sub_categories_id ?>');
    <?php
}
?>
</script>

<?php
require('footer.inc.php');
?>
