<?php
require('top.inc.php');
isAdmin();

// Pagination variables
$limit = 6; // Number of orders per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Determine the total number of orders
$total_orders_sql = "SELECT COUNT(*) as total FROM `order`";
$total_orders_res = mysqli_query($con, $total_orders_sql);
$total_orders_row = mysqli_fetch_assoc($total_orders_res);
$total_orders = $total_orders_row['total'];

// Query for orders with pagination
$sql = "SELECT `order`.*, order_status.name as order_status_str 
        FROM `order`
        LEFT JOIN order_status ON order_status.id = `order`.order_status
        ORDER BY `order`.id DESC
        LIMIT $offset, $limit";
$res = mysqli_query($con, $sql);
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Order Master</h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Order ID</th>
                                        <th class="product-name"><span class="nobr">Order Date</span></th>
                                        <th class="product-price"><span class="nobr">Address</span></th>
                                        <th class="product-stock-stauts"><span class="nobr">Payment Type</span></th>
                                        <th class="product-stock-stauts"><span class="nobr">Payment Status</span></th>
                                        <th class="product-stock-stauts"><span class="nobr">Order Status</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                    <tr>
                                        <td class="product-add-to-cart">
                                            <a href="order_master_detail.php?id=<?php echo $row['id']?>"><?php echo $row['id']?></a><br/>
                                            <a href="../order_pdf.php?id=<?php echo $row['id']?>">PDF</a>
                                        </td>
                                        <td class="product-name"><?php echo $row['added_on']?></td>
                                        <td class="product-name">
                                            <?php echo $row['address']?><br/>
                                            <?php echo $row['city']?><br/>
                                            <?php echo $row['pincode']?>
                                        </td>
                                        <td class="product-name"><?php echo $row['payment_type']?></td>
                                        <td class="product-name"><?php echo $row['payment_status']?></td>
                                        <td class="product-name"><?php echo $row['order_status_str']?></td>
                                    </tr>
                                    <?php } ?>
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
            $total_pages = ceil($total_orders / $limit);

            // Previous Button
            if ($page > 1) {
                echo "<li class='page-item'><a class='page-link' href='order_master.php?page=" . ($page - 1) . "'>&laquo; Previous</a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link'>&laquo; Previous</span></li>";
            }

            // Page Numbers
            for ($p = 1; $p <= $total_pages; $p++) {
                if ($p == $page) {
                    echo "<li class='page-item active'><span class='page-link'>$p</span></li>";
                } else {
                    echo "<li class='page-item'><a class='page-link' href='order_master.php?page=$p'>$p</a></li>";
                }
            }

            // Next Button
            if ($page < $total_pages) {
                echo "<li class='page-item'><a class='page-link' href='order_master.php?page=" . ($page + 1) . "'>Next &raquo;</a></li>";
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
