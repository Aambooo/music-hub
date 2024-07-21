<?php
require('top.inc.php');

// Fetch total number of users
$user_query = "SELECT COUNT(*) as total_users FROM users";
$user_result = mysqli_query($con, $user_query);
$user_data = mysqli_fetch_assoc($user_result);
$total_users = $user_data['total_users'];

// Fetch total number of products
$product_query = "SELECT COUNT(*) as total_products FROM product";
$product_result = mysqli_query($con, $product_query);
$product_data = mysqli_fetch_assoc($product_result);
$total_products = $product_data['total_products'];

// Fetch total sales
$sales_query = "SELECT SUM(total_price) as total_sales FROM `order`";
$sales_result = mysqli_query($con, $sales_query);
$sales_data = mysqli_fetch_assoc($sales_result);
$total_sales = $sales_data['total_sales'];

// Fetch total number of orders
$order_query = "SELECT COUNT(*) as total_orders FROM `order`";
$order_result = mysqli_query($con, $order_query);
$order_data = mysqli_fetch_assoc($order_result);
$total_orders = $order_data['total_orders'];

// Calculate total for percentage calculation
$total = $total_users + $total_products + $total_sales + $total_orders;

// Calculate percentages
$user_percentage = ($total_users / $total) * 100;
$product_percentage = ($total_products / $total) * 100;
$sales_percentage = ($total_sales / $total) * 100;
$order_percentage = ($total_orders / $total) * 100;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .dashboard-card {
            cursor: pointer;
            transition: transform 0.2s;
        }
        .dashboard-card:hover {
            transform: scale(1.05);
        }
        .dashboard-card h5 {
            margin-top: 10px;
        }
        .dashboard-card p {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .dashboard-card .icon {
            font-size: 3rem;
        }
        .card-header {
            background-color: #343a40;
            color: #fff;
        }
        .percentage {
            font-size: 1.2rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Dashboard</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="card dashboard-card text-center" onclick="location.href='users.php';">
                    <div class="card-body">
                        <div class="icon"><i class="fa fa-users"></i></div>
                        <h5>Total Users</h5>
                        <p><?php echo $total_users; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card text-center" onclick="location.href='product.php';">
                    <div class="card-body">
                        <div class="icon"><i class="fa fa-box"></i></div>
                        <h5>Total Products</h5>
                        <p><?php echo $total_products; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card text-center">
                    <div class="card-body">
                        <div class="icon"><i class="fa fa-dollar-sign"></i></div>
                        <h5>Total Sales</h5>
                        <p><?php echo $total_sales; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card text-center" onclick="location.href='order_master.php';">
                    <div class="card-body">
                        <div class="icon"><i class="fa fa-receipt"></i></div>
                        <h5>Total Orders</h5>
                        <p><?php echo $total_orders; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                Overview
            </div>
            <div class="card-body">
                <p class="text-center">Users: <?php echo round($user_percentage, 2); ?>%</p>
                <p class="text-center">Products: <?php echo round($product_percentage, 2); ?>%</p>
                <p class="text-center">Sales: <?php echo round($sales_percentage, 2); ?>%</p>
                <p class="text-center">Orders: <?php echo round($order_percentage, 2); ?>%</p>
            </div>
        </div>
    </div>
</body>
</html>
<?php
require('footer.inc.php');
?>
