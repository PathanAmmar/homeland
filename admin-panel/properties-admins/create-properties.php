<?php require "../layouts/header.php"; ?>
<?php require "../../config/config.php"; ?>

<?php 
  // 1. Session Check
  if(!isset($_SESSION['adminname'])) {
    echo "<script>window.location.href='".ADMINURL."/admins/login-admins.php' </script>";
    exit;
  }

  // 2. Fetch categories for dropdown
  $categories = $conn->query("SELECT * FROM categories");
  $categories->execute();
  $allCategories = $categories->fetchAll(PDO::FETCH_OBJ);

  // 3. Form Processing
  if(isset($_POST['submit'])) {

    if(empty($_POST['name']) || empty($_POST['location']) || empty($_POST['price']) || empty($_FILES['thumbnail']['name'])) {
      echo "<script>alert('Please fill all required fields and select a thumbnail');</script>";
    } else {

      $name = $_POST['name'];
      $location = $_POST['location'];
      $price = $_POST['price'];
      $beds = $_POST['beds'];
      $baths = $_POST['baths'];
      $sq_ft = $_POST['sq_ft'];
      $home_type = $_POST['home_type'];
      $year_built = $_POST['year_built'];
      $type = $_POST['type'];
      $description = $_POST['description'];
      $price_sqft = $_POST['price_sqft'];
      $status = $_POST['status']; 
      $adminname = $_SESSION['adminname'];
      
      // Handle Thumbnail Upload
      $image = $_FILES['thumbnail']['name'];
      $new_thumbnail_name = time() . "_" . basename($image); 
      $dir = "thumbnails/" . $new_thumbnail_name; 

      $insert = $conn->prepare("INSERT INTO props(name, location, price, beds, baths,
      sq_ft, home_type, year_built, type, description, price_sqft, status, admin_name, image) 
      VALUES (:name, :location, :price, :beds, :baths, :sq_ft, :home_type, 
      :year_built, :type, :description, :price_sqft, :status, :adminname, :image)");

      $insert->execute([
        ':name' => $name,
        ':location' => $location,
        ':price' => $price,
        ':beds' => $beds,
        ':baths' => $baths,
        ':sq_ft' => $sq_ft,
        ':home_type' => $home_type,
        ':year_built' => $year_built,
        ':type' => $type,
        ':description' => $description,
        ':price_sqft' => $price_sqft,
        ':status' => $status,
        ':adminname' => $adminname,
        ':image' => $new_thumbnail_name,
      ]);

      // Move thumbnail to folder
      move_uploaded_file($_FILES['thumbnail']['tmp_name'], $dir);

      $id = $conn->lastInsertId();

      // Handle Multiple Gallery Images
      if(isset($_FILES['image'])) {
          foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
            $filename = $_FILES['image']['name'][$key];
            if(!empty($filename)) {
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                $newfilename = "gallery_" . time() . "_" . $key . "." . $ext;
                
                if(move_uploaded_file($tmp_name, 'images/' . $newfilename)) {
                    $insertqry = $conn->prepare("INSERT INTO related_images (image, prop_id) VALUES (:image, :prop_id)");
                    $insertqry->execute([
                        ':image' => $newfilename,
                        ':prop_id' => $id
                    ]);
                }
            }
          }
      }

      echo "<script>window.location.href='".ADMINURL."/properties-admins/show-properties.php' </script>";
    }
  }
?>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title mb-5 d-inline">Create Properties</h5>
        <form method="POST" action="create-properties.php" enctype="multipart/form-data">
          
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="name" class="form-control" placeholder="name" required />
          </div>    
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="location" class="form-control" placeholder="location" required />
          </div> 
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="price" class="form-control" placeholder="price" required />
          </div> 
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="beds" class="form-control" placeholder="beds" />
          </div>
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="baths" class="form-control" placeholder="baths" />
          </div>
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="sq_ft" class="form-control" placeholder="SQ/FT" />
          </div>   
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="year_built" class="form-control" placeholder="Year Build" />
          </div> 
          <div class="form-outline mb-4 mt-4">
            <input type="text" name="price_sqft" class="form-control" placeholder="Price Per SQ FT" />
          </div> 
          
          <select name="home_type" class="form-control form-select mb-4">
            <option selected disabled>Select Home Type</option>
            <?php foreach( $allCategories as $category) : ?>
              <option value="<?php echo $category->name; ?>"><?php echo $category->name; ?></option>
            <?php endforeach; ?>
          </select>   

          <select name="type" class="form-control mb-4 form-select">
            <option selected disabled>Select Type</option>
            <option value="Rent">Rent</option>
            <option value="Sale">Sale</option>
          </select>  

          <div class="form-outline mb-4 mt-4">
            <label>Property Status</label>
            <select name="status" class="form-control form-select">
              <option value="available">Available</option>
              <option value="reserved">Reserved</option>
              <option value="sold">Sold</option>
            </select>
          </div>

          <div class="form-group mb-4">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Property Thumbnail</label>
            <input name="thumbnail" class="form-control" type="file" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Gallery Images (Multiple)</label>
            <input name="image[]" class="form-control" type="file" multiple>
          </div>

          <button type="submit" name="submit" class="btn btn-primary mb-4 text-center">Create Property</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require "../layouts/footer.php"; ?>