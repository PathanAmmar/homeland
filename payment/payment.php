<?php
require "../config/config.php";

if(!isset($_GET['id'])){
    echo "Property not found";
    exit;
}

$id = $_GET['id'];

$getProp = $conn->prepare("SELECT * FROM props WHERE id = :id");
$getProp->bindParam(":id", $id);
$getProp->execute();

$prop = $getProp->fetch(PDO::FETCH_OBJ);

if(!$prop){
    echo "Property not found in database";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Secure Property Payment</title>

<style>
body{
    font-family: Arial;
    background:#f5f5f5;
}

.payment-box{
    width:500px;
    margin:80px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 15px rgba(0,0,0,0.1);
}

h2{
    text-align:center;
}

.property-info{
    background:#f0f0f0;
    padding:10px;
    margin-bottom:20px;
}

.pay-option{
    margin:10px 0;
}

button{
    width:100%;
    padding:12px;
    background:#28a745;
    color:white;
    border:none;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#218838;
}
</style>

</head>

<body>

<div class="payment-box">

<h2>Secure Property Payment</h2>

<div class="property-info">
<strong>Property:</strong> <?php echo $prop->name; ?><br>
<strong>Price:</strong> $<?php echo $prop->price; ?>
</div>
<form action="process-payment.php" method="POST">
    
<input type="hidden" name="id" value="<?php echo $prop->id; ?>">

<h3>Select Payment Method</h3>

<div class="pay-option">
<input type="radio" name="method" value="credit" required> Credit Card
</div>

<div class="pay-option">
<input type="radio" name="method" value="upi"> UPI Payment
</div>

<div class="pay-option">
<input type="radio" name="method" value="bank"> Bank Transfer
</div>

<div class="pay-option">
<input type="radio" name="method" value="crypto"> Crypto Wallet
</div>

<div class="pay-option">
<input type="radio" name="method" value="cash"> Cash Payment
</div>

<br>

<button type="submit">Complete Payment</button>

</form>

</div>

</body>
</html>