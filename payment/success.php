<?php
require "../config/config.php";

if(isset($_GET['id'])){

$id = $_GET['id'];

$getProp = $conn->prepare("SELECT * FROM props WHERE id=:id");
$getProp->execute([':id'=>$id]);
$prop = $getProp->fetch(PDO::FETCH_OBJ);

?>

<h2 style="text-align:center;color:green;margin-top:100px;">
Payment Successful
</h2>

<p style="text-align:center;">
You successfully purchased <strong><?php echo $prop->name; ?></strong>
</p>

<div style="text-align:center;margin-top:20px;">
<a href="../property-details.php?id=<?php echo $prop->id; ?>">
Back to Property
</a>
</div>
<a href="invoice.php?id=<?php echo $prop->id; ?>" class="btn btn-primary">
Download Invoice
</a>
<?php
}else{
echo "Invalid page";
}