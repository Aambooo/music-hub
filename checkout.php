<?php
// Start or resume the session
// session_start();

// Include necessary files
require('top.php');

// Check if user is logged in
if (!isset($_SESSION['USER_LOGIN'])) {
    ?>
    <script>
    window.location.href='login.php';
    </script>
    <?php
    exit; // Exit script if user is not logged in
}

// Initialize cart total
$cart_total = 0;

// Check if cart session variable is set and not empty
if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $val) {
        // Fetch product details from database based on $key
        $productArr = get_product($con, '', '', $key);
        if (!empty($productArr)) {
            $price = $productArr[0]['price'];
            $qty = $val['qty'];
            $cart_total += ($price * $qty);
        }
    }
} else {
    ?>
    <script>
    alert("Your cart is empty!");
    window.location.href='cart.php';
    </script>
    <?php
    exit; // Exit script if cart is empty
}

// Process form submission
if (isset($_POST['submit'])) {
    // Get and sanitize form data
    $address = get_safe_value($con, $_POST['address']);
    $city = get_safe_value($con, $_POST['city']);
    $pincode = get_safe_value($con, $_POST['pincode']);
    $payment_type = get_safe_value($con, $_POST['payment_type']);
    $user_id = $_SESSION['USER_ID'];
    $total_price = $cart_total;
    $payment_status = 'pending';
    $order_status = 1; // Default status for new orders
    $added_on = date('Y-m-d h:i:s');
    $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

    // Insert order into database
    $insert_order_query = "INSERT INTO `order` (user_id, address, city, pincode, payment_type, total_price, payment_status, order_status, txnid, esewa_txnid, esewa_status, added_on) VALUES ('$user_id', '$address', '$city', '$pincode', '$payment_type', '$total_price', '$payment_status', '$order_status', '$txnid', '', '', '$added_on')";
    mysqli_query($con, $insert_order_query);
    $order_id = mysqli_insert_id($con);

    // Insert order details into database
    foreach ($_SESSION['cart'] as $key => $val) {
        $productArr = get_product($con, '', '', $key);
        if (!empty($productArr)) {
            $price = $productArr[0]['price'];
            $qty = $val['qty'];
            $insert_order_detail_query = "INSERT INTO `order_detail` (order_id, product_id, qty, price) VALUES ('$order_id', '$key', '$qty', '$price')";
            mysqli_query($con, $insert_order_detail_query);
        }
    }

    // Clear cart after placing order
    unset($_SESSION['cart']);

    // Redirect based on payment type
    if ($payment_type == 'cod') {
        ?>
        <script>
        window.location.href='thank_you.php';
        </script>
        <?php
    } else if ($payment_type == 'esewa') {
        // Redirect to eSewa payment gateway
        $successUrl = "http://php/ecommerce/payment_complete.php?oid=".$txnid;
        $failureUrl = "http://yourwebsite.com/payment_fail.php";
        $esewa_url = "https://esewa.com.np/epay/main";
        ?>
        <form action="<?php echo $esewa_url; ?>" method="POST" id="esewa_payment_form">
            <input value="<?php echo $total_price; ?>" name="tAmt" type="hidden">
            <input value="<?php echo $total_price; ?>" name="amt" type="hidden">
            <input value="0" name="txAmt" type="hidden">
            <input value="0" name="psc" type="hidden">
            <input value="0" name="pdc" type="hidden">
            <input value="EPAYTEST" name="scd" type="hidden">
            <input value="<?php echo $txnid; ?>" name="pid" type="hidden">
            <input value="<?php echo $successUrl; ?>" type="hidden" name="su">
            <input value="<?php echo $failureUrl; ?>" type="hidden" name="fu">
        </form>
        <script type="text/javascript">
            document.getElementById('esewa_payment_form').submit();
        </script>
        <?php
    }
}
?>

<!-- HTML content starts here -->
<div class="checkout-wrap ptb--100">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="checkout__inner">
                    <div class="accordion-list">
                        <div class="accordion">
                            <form method="post">
                                <div class="accordion__title">
                                    Address Information
                                </div>
                                <div class="accordion__body">
                                    <div class="bilinfo">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="single-input">
                                                    <input type="text" name="address" placeholder="Street Address" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-input">
                                                    <input type="text" name="city" placeholder="City/State" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-input">
                                                    <input type="text" name="pincode" placeholder="Post code/ zip" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion__title">
                                    Payment Information
                                </div>
                                <div class="accordion__body">
                                    <div class="paymentinfo">
                                        <div class="single-method">
                                            <input type="radio" name="payment_type" value="cod" required> Cash on Delivery
                                            <input type="radio" name="payment_type" value="esewa" required> eSewa
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion__title">
                                    Order Summary
                                </div>
                                <div class="accordion__body">
                                    <div class="order-details">
                                        <div class="order-summary">
                                            <div class="order-summary__total">
                                                <h4>Total</h4>
                                                <span><?php echo $cart_total; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" name="submit" class="btn btn-primary btn-block" value="Place Order">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer
require('footer.php');
?>
