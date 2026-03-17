<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "includes/header.php"; 
require "config/config.php"; 

if(isset($_GET['id'])) {

    $id = $_GET['id'];

    // Fetch Property
    $stmt = $conn->prepare("SELECT * FROM props WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $allDetails = $stmt->fetch(PDO::FETCH_OBJ);

    if(!$allDetails){
        echo "Property not found";
        exit;
    }

    // Fetch Gallery Images
    $images = $conn->prepare("SELECT * FROM related_images WHERE prop_id = :id");
    $images->execute([':id' => $id]);
    $allImages = $images->fetchAll(PDO::FETCH_OBJ);

    // Fetch Related Properties
    $related = $conn->prepare("SELECT * FROM props WHERE home_type = :home_type AND id != :id LIMIT 3");
    $related->execute([
        ':home_type' => $allDetails->home_type,
        ':id' => $id
    ]);
    $allRelatedProps = $related->fetchAll(PDO::FETCH_OBJ);

    // Check Requests
    if(isset($_SESSION['user_id'])){

        $check_request = $conn->prepare("SELECT * FROM requests WHERE prop_id = :prop_id AND user_id = :user_id");
        $check_request->execute([
            ':prop_id' => $id,
            ':user_id' => $_SESSION['user_id']
        ]);

    }

}else{
    echo "No ID provided";
    exit;
}
?>

<!-- HERO IMAGE -->
<div class="site-blocks-cover inner-page-cover overlay"
style="background-image: url('admin-panel/properties-admins/thumbnails/<?php echo $allDetails->image; ?>');"
data-aos="fade">

<div class="container">
<div class="row align-items-center justify-content-center text-center">
<div class="col-md-10">

<h1 class="mb-2"><?php echo $allDetails->name; ?></h1>

<p class="mb-5">
<strong class="h2 text-success font-weight-bold">
$<?php echo $allDetails->price; ?>
</strong>
</p>

</div>
</div>
</div>
</div>


<div class="site-section site-section-sm">
<div class="container">

<div class="row">

<!-- LEFT SIDE PROPERTY DETAILS -->

<div class="col-lg-8">

<!-- Gallery -->
<div class="slide-one-item home-slider owl-carousel">

<?php foreach($allImages as $img): ?>

<div>
<img src="admin-panel/properties-admins/images/<?php echo $img->image; ?>" class="img-fluid">
</div>

<?php endforeach; ?>

</div>


<div class="bg-white property-body border p-4 mt-4">

<h3 class="text-success">$<?php echo $allDetails->price; ?></h3>

<ul class="list-unstyled">

<li><strong>Beds:</strong> <?php echo $allDetails->beds; ?></li>

<li><strong>Baths:</strong> <?php echo $allDetails->baths; ?></li>

<li><strong>Sq Ft:</strong> <?php echo $allDetails->sq_ft; ?></li>

<li><strong>Home Type:</strong> <?php echo $allDetails->home_type; ?></li>

<li><strong>Year Built:</strong> <?php echo $allDetails->year_built; ?></li>

</ul>

<hr>

<h4>Description</h4>

<p><?php echo $allDetails->description; ?></p>

</div>

</div>



<!-- RIGHT SIDEBAR -->

<div class="col-lg-4">

<div class="bg-white widget border rounded p-4 mb-4">

<h3 class="h4 text-black widget-title mb-3">Contact Agent</h3>

<?php if(isset($_SESSION['user_id'])) : ?>

<?php if($check_request->rowCount() > 0) : ?>

<div class="alert alert-info">
You already sent a request for this property.
</div>

<?php else : ?>

<form action="requests/process-request.php" method="POST">

<input type="hidden" name="prop_id" value="<?php echo $id; ?>">
<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
<input type="hidden" name="admin_name" value="<?php echo $allDetails->admin_name; ?>">

<div class="form-group">
<label>Name</label>
<input type="text" name="name" class="form-control" placeholder="Your Name" required>
</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="email" class="form-control" placeholder="Your Email" required>
</div>

<div class="form-group">
<label>Phone</label>
<input type="text" name="phone" class="form-control" placeholder="Your Phone Number" required>
</div>

<div class="form-group">
<input type="submit" name="submit" class="btn btn-primary" value="Send Request">
</div>

</form>

<?php endif; ?>

<?php else : ?>

<p class="alert alert-warning">
Please <a href="<?php echo APPURL; ?>/auth/login.php">login</a> to contact the agent.
</p>

<?php endif; ?>

</div>

</div>

</div>


<!-- RELATED PROPERTIES -->

<div class="row mt-5">

<h3 class="mb-4">Related Properties</h3>

<?php foreach($allRelatedProps as $prop): ?>

<div class="col-md-4">

<div class="property-entry">

<a href="property-details.php?id=<?php echo $prop->id; ?>">

<img src="admin-panel/properties-admins/thumbnails/<?php echo $prop->image; ?>" class="img-fluid">

</a>

<h5 class="mt-2"><?php echo $prop->name; ?></h5>

<p class="text-success">$<?php echo $prop->price; ?></p>

</div>

</div>

<?php endforeach; ?>

</div>

</div>
</div>


<?php require "includes/footer.php"; ?>