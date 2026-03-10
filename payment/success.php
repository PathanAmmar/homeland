<?php
// Example success page

echo "<h2>Payment Successful</h2>";
echo "Thank you for your payment!";

// You can get PayPal transaction data
if(isset($_GET['token'])){
    $token = $_GET['token'];
    echo "<br>Transaction Token: " . $token;
}

// Here you would normally verify payment using PayPal API
?>