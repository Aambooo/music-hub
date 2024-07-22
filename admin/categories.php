<?php
require('top.inc.php');
isAdmin();

// Pagination variables
$limit = 6; // Number of categories per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Handle status update and delete actions
if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == 'status') {
        $operation = get_safe_value($con, $_GET['operation']);
        $id = get_safe_value($con, $_GET['id']);
        $status = $operation == 'active' ? '1' : '0';
        $update_status_sql = "UPDATE categories SET status='$status' WHERE id='$id'";
        mysqli_query($con, $update_status_sql);
    }

    if ($type == 'delete') {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "DELETE FROM categories WHERE id='$id'";
        mysqli_query($con, $delete_sql);
    }
}

// Query for total number of categories
$total_categories_sql = "SELECT COUNT(*) as total FROM categories";
$total_categories_res = mysqli_query($con, $total_categories_sql);
$total_categories_row = mysqli_fetch_assoc($total_categories_res);
$total_categories = $total_categories_row['total'];

// Query for categories with pagination
$sql = "SELECT * FROM categories ORDER BY categories ASC LIMIT $offset, $limit";
$res = mysqli_query($con, $sql);
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Categories</h4>
                        <h4 class="box-link"><a href="manage_categories.php">Add Categories</a></h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>ID</th>
                                        <th>Categories</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = $offset + 1; // Adjust serial number for the current page
                                    while ($row = mysqli_fetch_assoc($res)) { ?>
                                    <tr>
                                        <td class="serial"><?php echo $i; ?></td>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['categories']; ?></td>
                                        <td>
                                            <?php
                                            if ($row['status'] == 1) {
                                                echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&id=" . $row['id'] . "'>Active</a></span>&nbsp;";
                                            } else {
                                                echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=" . $row['id'] . "'>Deactive</a></span>&nbsp;";
                                            }
                                            echo "<span class='badge badge-edit'><a href='manage_categories.php?id=" . $row['id'] . "'>Edit</a></span>&nbsp;";
                                            echo "<span class='badge badge-delete'><a href='?type=delete&id=" . $row['id'] . "'>Delete</a></span>";
                                            ?>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
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
            $total_pages = ceil($total_categories / $limit);

            // Previous Button
            if ($page > 1) {
                echo "<li class='page-item'><a class='page-link' href='categories.php?page=" . ($page - 1) . "'>&laquo; Previous</a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link'>&laquo; Previous</span></li>";
            }

            // Page Numbers
            for ($p = 1; $p <= $total_pages; $p++) {
                if ($p == $page) {
                    echo "<li class='page-item active'><span class='page-link'>$p</span></li>";
                } else {
                    echo "<li class='page-item'><a class='page-link' href='categories.php?page=$p'>$p</a></li>";
                }
            }

            // Next Button
            if ($page < $total_pages) {
                echo "<li class='page-item'><a class='page-link' href='categories.php?page=" . ($page + 1) . "'>Next &raquo;</a></li>";
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
