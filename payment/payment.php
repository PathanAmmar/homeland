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

<h1>Buy Product</h1>

<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

<input type="hidden" name="business" value="sb-b4a1i49461365@business.example.com">

<input type="hidden" name="cmd" value="_xclick">

<input type="hidden" name="item_name" value="<?php echo $prop->name; ?>">

<input type="hidden" name="amount" value="<?php echo str_replace(',', '', $prop->price); ?>">

<input type="hidden" name="currency_code" value="USD">

<input type="hidden" name="return" value="http://localhost/homeland/payment/success.php?id=<?php echo $prop->id; ?>">

<input type="hidden" name="cancel_return" value="http://localhost/homeland/payment/cancel.php">

<input type="submit" value="Pay with PayPal">

</form>