<?php
require('top.inc.php');
isAdmin();

// Pagination variables
$limit = 6; // Number of messages per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Handle delete action
if (isset($_GET['type']) && $_GET['type'] != '') {
    $type = get_safe_value($con, $_GET['type']);
    if ($type == 'delete') {
        $id = get_safe_value($con, $_GET['id']);
        $delete_sql = "DELETE FROM contact_us WHERE id='$id'";
        mysqli_query($con, $delete_sql);
    }
}

// Query for total number of messages
$total_messages_sql = "SELECT COUNT(*) as total FROM contact_us";
$total_messages_res = mysqli_query($con, $total_messages_sql);
$total_messages_row = mysqli_fetch_assoc($total_messages_res);
$total_messages = $total_messages_row['total'];

// Query for messages with pagination
$sql = "SELECT * FROM contact_us ORDER BY id DESC LIMIT $offset, $limit";
$res = mysqli_query($con, $sql);
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Contact Us</h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Query</th>
                                        <th>Date</th>
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
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['mobile']; ?></td>
                                        <td><?php echo $row['comment']; ?></td>
                                        <td><?php echo $row['added_on']; ?></td>
                                        <td>
                                            <?php
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
            $total_pages = ceil($total_messages / $limit);

            // Previous Button
            if ($page > 1) {
                echo "<li class='page-item'><a class='page-link' href='contact_us.php?page=" . ($page - 1) . "'>&laquo; Previous</a></li>";
            } else {
                echo "<li class='page-item disabled'><span class='page-link'>&laquo; Previous</span></li>";
            }

            // Page Numbers
            for ($p = 1; $p <= $total_pages; $p++) {
                if ($p == $page) {
                    echo "<li class='page-item active'><span class='page-link'>$p</span></li>";
                } else {
                    echo "<li class='page-item'><a class='page-link' href='contact_us.php?page=$p'>$p</a></li>";
                }
            }

            // Next Button
            if ($page < $total_pages) {
                echo "<li class='page-item'><a class='page-link' href='contact_us.php?page=" . ($page + 1) . "'>Next &raquo;</a></li>";
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
