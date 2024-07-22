<?php
require('top.inc.php');
isAdmin();

// Pagination variables
$limit = 6; // Number of banners per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Handle status and delete actions
if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == 'status') {
        $operation = get_safe_value($con, $_GET['operation']);
        $id = get_safe_value($con, $_GET['id']);
        $status = ($operation == 'active') ? '1' : '0';
        $update_status_sql = "UPDATE banner SET status='$status' WHERE id='$id'";
        mysqli_query($con, $update_status_sql);
    }

    if ($type == 'delete') {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "DELETE FROM banner WHERE id='$id'";
        mysqli_query($con, $delete_sql);
    }
}

// Query for total number of banners
$total_banners_sql = "SELECT COUNT(*) as total FROM banner";
$total_banners_res = mysqli_query($con, $total_banners_sql);
$total_banners_row = mysqli_fetch_assoc($total_banners_res);
$total_banners = $total_banners_row['total'];

// Query for banners with pagination
$sql = "SELECT * FROM banner ORDER BY id ASC LIMIT $offset, $limit";
$res = mysqli_query($con, $sql);
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Banner</h4>
                        <h4 class="box-link"><a href="manage_banner.php">Add Banner</a></h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>Heading1</th>
                                        <th>Heading2</th>
                                        <th>Btn Txt</th>
                                        <th>Btn Link</th>
                                        <th>Image</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = $offset + 1; // Adjust serial number for the current page
                                    while ($row = mysqli_fetch_assoc($res)) { ?>
                                    <tr>
                                        <td class="serial"><?php echo $i; ?></td>
                                        <td><?php echo $row['heading1']; ?></td>
                                        <td><?php echo $row['heading2']; ?></td>
                                        <td><?php echo $row['btn_txt']; ?></td>
                                        <td><?php echo $row['btn_link']; ?></td>
                                        <td>
                                            <?php
                                            echo "<a target='_blank' href='" . BANNER_SITE_PATH . $row['image'] . "'><img width='150px' src='" . BANNER_SITE_PATH . $row['image'] . "'/></a>";
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($row['status'] == 1) {
                                                echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&id=" . $row['id'] . "'>Active</a></span>&nbsp;";
                                            } else {
                                                echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=" . $row['id'] . "'>Deactive</a></span>&nbsp;";
                                            }
                                            echo "<span class='badge badge-edit'><a href='manage_banner.php?id=" . $row['id'] . "'>Edit</a></span>&nbsp;";
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
            $total_pages = ceil($total_banners / $limit);

            // Previous Button
            if ($page > 1) {
                echo "<li class='page-item'><a class='page-link' href='banner.php?page=" . ($page - 1) . "'>&laquo; Previous</a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link'>&laquo; Previous</span></li>";
            }

            // Page Numbers
            for ($p = 1; $p <= $total_pages; $p++) {
                if ($p == $page) {
                    echo "<li class='page-item active'><span class='page-link'>$p</span></li>";
                } else {
                    echo "<li class='page-item'><a class='page-link' href='banner.php?page=$p'>$p</a></li>";
                }
            }

            // Next Button
            if ($page < $total_pages) {
                echo "<li class='page-item'><a class='page-link' href='banner.php?page=" . ($page + 1) . "'>Next &raquo;</a></li>";
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
