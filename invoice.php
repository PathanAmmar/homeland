<?php
require "../config/config.php";

if(!isset($_GET['id'])){
    echo "Invoice not found";
    exit;
}

$id = $_GET['id'];

$getProp = $conn->prepare("SELECT * FROM props WHERE id=:id");
$getProp->execute([':id'=>$id]);
$prop = $getProp->fetch(PDO::FETCH_OBJ);

if(!$prop){
    echo "Property not found";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Invoice</title>

<style>
body{
font-family: Arial;
background:#f5f5f5;
}

.invoice-box{
width:700px;
margin:50px auto;
background:white;
padding:30px;
border:1px solid #ddd;
}

h2{
text-align:center;
}

.table{
width:100%;
border-collapse: collapse;
margin-top:20px;
}

.table th, .table td{
border:1px solid #ddd;
padding:10px;
text-align:left;
}
</style>

</head>

<body>

<div class="invoice-box">

<h2>Property Purchase Invoice</h2>

<p><strong>Invoice ID:</strong> INV-<?php echo $prop->id; ?></p>
<p><strong>Property:</strong> <?php echo $prop->name; ?></p>
<p><strong>Location:</strong> <?php echo $prop->location; ?></p>
<p><strong>Status:</strong> SOLD</p>

<table class="table">

<tr>
<th>Description</th>
<th>Amount</th>
</tr>

<tr>
<td><?php echo $prop->name; ?></td>
<td>$<?php echo $prop->price; ?></td>
</tr>

<tr>
<th>Total</th>
<th>$<?php echo $prop->price; ?></th>
</tr>

</table>

<br>

<button onclick="window.print()">Print Invoice</button>

</div>

</body>
</html>