<?php
require('top.inc.php');

// Pagination variables
$limit = 6; // Number of products per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Determine the total number of products
$condition = '';
$condition1 = '';
if($_SESSION['ADMIN_ROLE'] == 1) {
    $condition = " and product.added_by='" . $_SESSION['ADMIN_ID'] . "'";
    $condition1 = " and added_by='" . $_SESSION['ADMIN_ID'] . "'";
}

if(isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($con, $_GET['type']);
    if($type == 'status') {
        $operation = get_safe_value($con, $_GET['operation']);
        $id = get_safe_value($con, $_GET['id']);
        $status = ($operation == 'active') ? '1' : '0';
        $update_status_sql = "UPDATE product SET status='$status' $condition1 WHERE id='$id'";
        mysqli_query($con, $update_status_sql);
    }

    if($type == 'delete') {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "DELETE FROM product WHERE id='$id' $condition1";
        mysqli_query($con, $delete_sql);
    }
}

// Query for total number of products
$total_products_sql = "SELECT COUNT(*) as total FROM product WHERE 1 $condition";
$total_products_res = mysqli_query($con, $total_products_sql);
$total_products_row = mysqli_fetch_assoc($total_products_res);
$total_products = $total_products_row['total'];

// Query for products with pagination
$sql = "SELECT product.*, categories.categories FROM product, categories WHERE product.categories_id = categories.id $condition ORDER BY product.id DESC LIMIT $offset, $limit";
$res = mysqli_query($con, $sql);
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Products </h4>
                        <h4 class="box-link"><a href="manage_product.php">Add Product</a></h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th width="2%">ID</th>
                                        <th width="10%">Categories</th>
                                        <th width="30%">Name</th>
                                        <th width="10%">Image</th>
                                        <th width="10%">MRP</th>
                                        <th width="7%">Price</th>
                                        <th width="7%">Qty</th>
                                        <th width="26%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = $offset + 1; // Adjust the starting index for displaying products
                                    while($row = mysqli_fetch_assoc($res)) { ?>
                                    <tr>
                                        <td class="serial"><?php echo $i ?></td>
                                        <td><?php echo $row['id'] ?></td>
                                        <td><?php echo $row['categories'] ?></td>
                                        <td><?php echo $row['name'] ?></td>
                                        <td><img src="<?php echo PRODUCT_IMAGE_SITE_PATH . $row['image'] ?>" /></td>
                                        <td><?php echo $row['mrp'] ?></td>
                                        <td><?php echo $row['price'] ?></td>
                                        <td><?php echo $row['qty'] ?><br />
                                            <?php
                                            $productSoldQtyByProductId = productSoldQtyByProductId($con, $row['id']);
                                            $pending_qty = $row['qty'] - $productSoldQtyByProductId;
                                            ?>
                                            Pending Qty <?php echo $pending_qty ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($row['status'] == 1) {
                                                echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&id=" . $row['id'] . "'>Active</a></span>&nbsp;";
                                            } else {
                                                echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=" . $row['id'] . "'>Deactive</a></span>&nbsp;";
                                            }
                                            echo "<span class='badge badge-edit'><a href='manage_product.php?id=" . $row['id'] . "'>Edit</a></span>&nbsp;";
                                            echo "<span class='badge badge-delete'><a href='?type=delete&id=" . $row['id'] . "'>Delete</a></span>";
                                            ?>
                                        </td>
                                    </tr>
                                    <?php 
                                    $i++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pagination Controls -->
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <?php
            $total_pages = ceil($total_products / $limit);

            // Previous Button
            if ($page > 1) {
                echo "<li class='page-item'><a class='page-link' href='product.php?page=" . ($page - 1) . "'>&laquo; Previous</a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link'>&laquo; Previous</span></li>";
            }

            // Page Numbers
            for ($p = 1; $p <= $total_pages; $p++) {
                if ($p == $page) {
                    echo "<li class='page-item active'><span class='page-link'>$p</span></li>";
                } else {
                    echo "<li class='page-item'><a class='page-link' href='product.php?page=$p'>$p</a></li>";
                }
            }

            // Next Button
            if ($page < $total_pages) {
                echo "<li class='page-item'><a class='page-link' href='product.php?page=" . ($page + 1) . "'>Next &raquo;</a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link'>Next &raquo;</span></li>";
            }
            ?>
        </ul>
    </nav>
</div>
<?php
require('footer.inc.php');
?>
