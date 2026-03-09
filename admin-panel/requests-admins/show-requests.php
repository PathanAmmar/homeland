```php
<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php

if(!isset($_SESSION['adminname'])) {
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php'</script>";
}

/* APPROVE REQUEST */
if(isset($_GET['approve'])){

    $id = $_GET['approve'];

    $update = $conn->prepare("UPDATE requests SET status='approved' WHERE id=?");
    $update->execute([$id]);

    echo "<script>window.location.href='show-requests.php'</script>";
}

/* GET ALL REQUESTS */
$requests = $conn->query("SELECT * FROM requests ORDER BY id DESC");

$requests->execute();

$allRequests = $requests->fetchAll(PDO::FETCH_OBJ);

?>


<div class="row">
<div class="col">
<div class="card">
<div class="card-body">

<h5 class="card-title mb-4 d-inline">Requests</h5>

<table class="table mt-3">

<thead>
<tr>
<th>#</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Property</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php if(count($allRequests) > 0) : ?>

<?php foreach($allRequests as $request) : ?>

<tr>

<td><?php echo $request->id; ?></td>
<td><?php echo $request->name; ?></td>
<td><?php echo $request->email; ?></td>
<td><?php echo $request->phone; ?></td>

<td>
<a href="http://localhost/homeland/property-details.php?id=<?php echo $request->prop_id; ?>" 
class="btn btn-success">View</a>
</td>

<td><?php echo $request->status; ?></td>

<td>

<?php if($request->status == "pending") : ?>

<a href="show-requests.php?approve=<?php echo $request->id; ?>" 
class="btn btn-primary">Approve</a>

<?php else : ?>

<span class="badge bg-success">Approved</span>

<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

<?php else : ?>

<tr>
<td colspan="7">
<div class="alert alert-success">you don't have any requests just yet</div>
</td>
</tr>

<?php endif; ?>

</tbody>

</table> 

</div>
</div>
</div>
</div>

<?php require "../layouts/footer.php"; ?>
```
