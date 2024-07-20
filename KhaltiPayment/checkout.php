<?php 
session_start();
include('../includes/config.php');
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khalti Payment Integration</title>

    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="m-4">
    <?php
    if (isset($_SESSION['transaction_msg'])) {
        echo $_SESSION['transaction_msg'];
        unset($_SESSION['transaction_msg']);
    }

    if (isset($_SESSION['validate_msg'])) {
        echo $_SESSION['validate_msg'];
        unset($_SESSION['validate_msg']);
    }
    
    // Get parameters from URL
    $bookingNo = $_GET['bookingNo'];
    $vehicleName = urldecode($_GET['vehicleName']);
    $amount = $_GET['amount'];
    $name = urldecode($_GET['name']);
    $email = urldecode($_GET['email']);
    $phone = $_GET['phone'];
    ?>
    <h1 class="text-center">Khalti Payment Integration</h1>
    <div class="d-flex justify-content-center mt-3">
        <form class="row g-3 w-50 mt-4" action="payment-request.php" method="POST">
            <label for="">Product Details:</label>
            <div class="col-md-6">
                <label for="inputAmount4" class="form-label">Amount</label>
                <input type="text" class="form-control" id="inputAmount4" name="inputAmount4" value="<?php echo $amount; ?>" readonly>
            </div>
            <div class="col-md-6">
                <label for="inputPurchasedOrderId4" class="form-label">Booking No</label>
                <input type="text" class="form-control" id="inputPurchasedOrderId4" name="inputPurchasedOrderId4" value="<?php echo $bookingNo; ?>" readonly>
            </div>
            <div class="col-12">
                <label for="inputPurchasedOrderName" class="form-label">Booking Vehicle Name</label>
                <input type="text" class="form-control" id="inputPurchasedOrderName" name="inputPurchasedOrderName" value="<?php echo $vehicleName; ?>" readonly>
            </div>
            <label for="">Customer Details:</label>
            <div class="col-12">
                <label for="inputName" class="form-label">Name</label>
                <input type="text" class="form-control" id="inputName" name="inputName" value="<?php echo $name; ?>" readonly>
            </div>
            <div class="col-md-6">
                <label for="inputEmail" class="form-label">Email</label>
                <input type="text" class="form-control" id="inputEmail" name="inputEmail" value="<?php echo $email; ?>" readonly>
            </div>
            <div class="col-md-6">
                <label for="inputPhone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="inputPhone" name="inputPhone" value="<?php echo $phone; ?>" readonly>
            </div>
            <div class="col-12">
                <button type="submit" name="submit" class="btn btn-primary">Pay with Khalti</button>
            </div>
        </form>
    </div>
</body>

</html>
