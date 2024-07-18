<?php
require('top.php');

if(isset($_GET['oid']) && isset($_GET['amt']) && isset($_GET['refId'])){
    $order_id = $_GET['oid'];
    $amt = $_GET['amt'];
    $refId = $_GET['refId'];

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
    $curl_error = curl_error($curl);
    curl_close($curl);

    if($response === false) {
        echo "cURL Error: $curl_error";
        exit;
    } else {
        echo "Response: $response";
    }

    if(strpos($response, '<response_code>Success</response_code>') !== false){
        mysqli_query($con, "UPDATE `order` SET payment_status='success', esewa_txnid='$refId', esewa_status='success' WHERE txnid='$order_id'");
        ?>
        <script>
            window.location.href='thank_you.php';
        </script>
        <?php
    } else {
        mysqli_query($con, "UPDATE `order` SET payment_status='failed', esewa_status='failed' WHERE txnid='$order_id'");
        ?>
        <script>
            window.location.href='payment_fail.php';
        </script>
        <?php
    }
}
?>
