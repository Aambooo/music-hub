<?php
require('top.php');

if(isset($_GET['oid'])){
    $order_id = $_GET['oid'];
    $amt = $_GET['amt'];
    $refId = $_GET['refId'];

    // Validate the payment
    $url = "https://esewa.com.np/epay/transrec";
    $data = [
        'amt' => $amt,
        'rid' => $refId,
        'pid' => $order_id,
        'scd' => 'EPAYTEST',
    ];

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($curl);
    curl_close($curl);

    // Debugging information
    if($response === false) {
        $error = curl_error($curl);
        echo "cURL Error: $error";
        exit;
    } else {
        echo "Response: $response";
    }

    // Parse the response from eSewa
    if(strpos($response, '<response_code>Success</response_code>') !== false){
        // Payment was successful
        mysqli_query($con, "UPDATE `order` SET payment_status='success', esewa_txnid='$refId', esewa_status='success' WHERE txnid='$order_id'");
        ?>
        <script>
            window.location.href='thank_you.php';
        </script>
        <?php
    } else {
        // Payment failed
        mysqli_query($con, "UPDATE `order` SET payment_status='failed', esewa_status='failed' WHERE txnid='$order_id'");
        ?>
        <script>
            window.location.href='payment_fail.php';
        </script>
        <?php
    }
}
?>
