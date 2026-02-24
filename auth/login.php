<?php
require "../config/config.php";
require "../includes/header.php";


 if(isset($_POST['submit'])) {

        if(empty($_POST['email']) OR empty($_POST['password'])) {
            echo "<script>alert('All fields are required')</script>";
    }else{

    
        
        $email=$_POST['email']; 
        $password=$_POST['password'];


        $login =$conn->query("SELECT * FROM users WHERE email='$email'");
        $login->execute();
    
        $fetch = $login->fetch(PDO::FETCH_ASSOC);

        if($login->rowCount () >  0) {
          //echo $login->rowCount ();
          //echo "email is correct";

          if(password_verify($password, $fetch['mypassword'])) {
            
              $_SESSION['username'] = $fetch['username'];
              $_SESSION['email'] = $fetch['email'];
              $_SESSION['id'] = $fetch['id'];

      header("location: " . APP_URL."");
exit();
           
          } else {
            echo "<script>alert('email or Password is incorrect')</script>";
          }

    } else {
          echo "<script>alert('email or Password is incorrect')</script>";
    }
     }
 }

?>

<div class="site-loader"></div>

<div class="site-wrap">

  <div class="site-navbar mt-4">
    <div class="container py-1">
      <div class="row align-items-center">
        <div class="col-8 col-md-8 col-lg-4">
          <h1 class="mb-0">
            <a href="../index.php" class="text-white h2 mb-0">
              <strong>Homeland<span class="text-danger">.</span></strong>
            </a>
          </h1>
        </div>
      </div>
    </div>
  </div>

  <div class="site-blocks-cover inner-page-cover overlay"
       style="background-image: url(<?php echo APP_URL; ?>/images/hero_bg_2.jpg);">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center">
        <div class="col-md-10">
          <h1 class="mb-2">Log In</h1>
        </div>
      </div>
    </div>
  </div>

  <div class="site-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h3 class="h4 text-black widget-title mb-3">Login</h3>

          <form action="login.php" method="post">
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email"id="email" class="form-control" required>
            </div>

            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password"id="password" class="form-control" required>
            </div>

            <div class="form-group">
              <input type="submit" name="submit"id="submit" class="btn btn-primary" value="Login">
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

<?php require "../includes/footer.php"; ?>
