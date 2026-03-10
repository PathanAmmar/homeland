<?php
require "config/config.php";
session_start();

if(isset($_POST['pay'])){

$prop_id = $_POST['prop_id'];
$amount = $_POST['amount'];
$user_id = $_SESSION['user_id'];

$insert = $conn->prepare("INSERT INTO payments(prop_id,user_id,amount,payment_status)
VALUES(:prop_id,:user_id,:amount,'completed')");

$insert->execute([
':prop_id'=>$prop_id,
':user_id'=>$user_id,
':amount'=>$amount
]);

$update = $conn->prepare("UPDATE props SET status='sold' WHERE id=:id");

$update->execute([
':id'=>$prop_id
]);

header("location: success.php");

}