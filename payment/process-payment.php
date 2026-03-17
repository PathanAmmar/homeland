<?php
require "../config/config.php";

if(isset($_POST['id']) && isset($_POST['method'])){

    $id = $_POST['id'];
    $method = $_POST['method'];

    // check property
    $check = $conn->prepare("SELECT * FROM props WHERE id=:id");
    $check->execute([':id'=>$id]);
    $prop = $check->fetch(PDO::FETCH_OBJ);

    if(!$prop){
        echo "Property not found";
        exit;
    }

    // update property status
    $update = $conn->prepare("UPDATE props SET status='sold' WHERE id=:id");
    $update->execute([':id'=>$id]);

    // redirect to success page
    header("Location: success.php?id=".$id."&method=".$method);
    exit;

}else{
    echo "Invalid payment request";
}