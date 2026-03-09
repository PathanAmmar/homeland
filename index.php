<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php 


  $select = $conn->query("SELECT * FROM props ORDER BY name DESC");
  $select->execute();

  $props = $select->fetchAll(PDO::FETCH_OBJ);


  

?>
  
 

    <div class="slide-one-item home-slider owl-carousel">
     <?php foreach($props as $prop) : ?>

        <div class="site-blocks-cover overlay" style="background-image: url(<?php echo THUMBNAILMURL; ?>/<?php echo $prop->image; ?>);" data-aos="fade" data-stellar-background-ratio="0.5">
          <div class="container">
            <div class="row align-items-center justify-content-center text-center">
                <div class="col-md-10">
                  <span class="d-inline-block bg-<?php if($prop->type == "rent") { echo "success"; } else { echo "danger"; }?> text-white px-3 mb-3 property-offer-type rounded"><?php echo $prop->type; ?></span>
                  <h1 class="mb-2"><?php echo $prop->name; ?></h1>
                  <p class="mb-5"><strong class="h2 text-success font-weight-bold">$<?php echo $prop->price; ?></strong></p>
                  <p><a href="property-details.php?id=<?php echo $prop->id; ?>" class="btn btn-white btn-outline-white py-3 px-5 rounded-0 btn-2">See Details</a></p>
                </div>
            </div>
          </div>
        </div>  
      <?php endforeach; ?>

   

    </div>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">

    <!-- Identify business -->
    <input type="hidden" name="business" value="YOUR_PAYPAL_EMAIL">

    <!-- Payment type -->
    <input type="hidden" name="cmd" value="_xclick">

    <!-- Product -->
    <input type="hidden" name="item_name" value="Test Product">
    <input type="hidden" name="amount" value="10.00">
    <input type="hidden" name="currency_code" value="USD">

    <!-- Redirect URLs -->
    <input type="hidden" name="return" value="https://yourwebsite.com/success.php">
    <input type="hidden" name="cancel_return" value="https://yourwebsite.com/cancel.php">

    <input type="submit" value="Pay Now">

</form>

    <div class="site-section site-section-sm pb-0">
      <div class="container">
        <div class="row">
          <form class="form-search col-md-12" method="POST" action="search.php" style="margin-top: -100px;">
            <div class="row  align-items-end">
              <div class="col-md-3">
                <label for="list-types">Listing Types</label>
                <div class="select-wrap">
                  <span class="icon icon-arrow_drop_down"></span>
                  <select name="types" id="list-types" class="form-control d-block rounded-0">
                    <?php foreach($allCategories as $category) : ?>
                      <option value="<?php echo $category->name; ?>"><?php echo str_replace('-', ' ', $category->name); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <label for="offer-types">Offer Type</label>
                <div class="select-wrap">
                  <span class="icon icon-arrow_drop_down"></span>
                  <select name="offers" id="offer-types" class="form-control d-block rounded-0">
                    <option value="sale">sale</option>
                    <option value="rent">rent</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <label for="select-city">Select City</label>
                <div class="select-wrap">
                  <span class="icon icon-arrow_drop_down"></span>
                  <select name="cities" id="select-city" class="form-control d-block rounded-0">
                    <option value="new york">New York</option>
                    <option value="brooklyn">Brooklyn</option>
                    <option value="london">London</option>
                    <option value="japan">Japan</option>
                    <option value="philippines">Philippines</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <input type="submit" name="submit" class="btn btn-success text-white btn-block rounded-0" value="Search">
              </div>
            </div>
          </form>
        </div>  

        <div class="row">
          <div class="col-md-12">
            <div class="view-options bg-white py-3 px-3 d-md-flex align-items-center">
              <div class="mr-auto">
                <a href="index.php" class="icon-view view-module active"><span class="icon-view_module"></span></a>
                
              </div>
              <div class="ml-auto d-flex align-items-center">
                <div>
                  <a href="<?php echo APPURL; ?>" class="view-list px-3 border-right active">All</a>
                  <a href="rent.php?type=rent" class="view-list px-3 border-right">Rent</a>
                  <a href="sale.php?type=sale" class="view-list px-3">Sale</a>
                
                </div>


               
              </div>
            </div>
          </div>
        </div>
       
      </div>
    </div>

    <div class="site-section site-section-sm bg-light">
      <div class="container">
      
        <div class="row mb-5">
          <?php foreach($props as $prop) : ?>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="property-entry h-100">
              <a href="property-details.php?id=<?php echo $prop->id; ?>" class="property-thumbnail">
                <div class="offer-type-wrap">
                  <span class="offer-type bg-<?php if($prop->type == "rent") { echo "success"; } else { echo "danger"; }?>"><?php echo $prop->type; ?></span>
                </div>
                <img src="<?php echo THUMBNAILMURL;?>/<?php echo $prop->image; ?>" alt="Image" class="img-fluid">
              </a>
              <div class="p-4 property-body">
<h2 class="property-title">
<a href="property-details.php?id=<?php echo $prop->id; ?>">
<?php echo $prop->name; ?>
</a>
</h2>

<span class="property-location d-block mb-3">
<span class="property-icon icon-room"></span>
<?php echo $prop->location; ?>
</span>

<strong class="property-price text-primary mb-3 d-block text-success">
$<?php echo $prop->price; ?>
</strong>

<?php if($prop->status == "available"){ ?>
<span style="color:green; font-weight:bold;">Available</span>

<?php } elseif($prop->status == "reserved"){ ?>
<span style="color:orange; font-weight:bold;">Reserved</span>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post">

<input type="hidden" name="business" value="YOUR_PAYPAL_EMAIL">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="item_name" value="<?php echo $prop->name; ?>">
<input type="hidden" name="amount" value="<?php echo $prop->price; ?>">
<input type="hidden" name="currency_code" value="USD">

<input type="hidden" name="return" value="http://localhost/homeland/payment/success.php?id=<?php echo $prop->id; ?>">
<input type="hidden" name="cancel_return" value="http://localhost/homeland/payment/cancel.php">

<input type="submit" value="Pay Now" class="btn btn-success mt-2">

</form>

<?php } elseif($prop->status == "sold"){ ?>
<span style="color:red; font-weight:bold;">Sold</span>
<?php } ?>
                  <li>
                    <span class="property-specs">Beds</span>
                    <span class="property-specs-number"><?php echo $prop->beds; ?></span>
                    
                  </li>
                  <li>
                    <span class="property-specs">Baths</span>
                    <span class="property-specs-number"><?php echo $prop->baths; ?></span>
                    
                  </li>
                  <li>
                    <span class="property-specs">SQ FT</span>
                    <span class="property-specs-number"><?php echo $prop->sq_ft; ?></span>
                    
                  </li>
                </ul>

              </div>
            </div>
          </div>
          <?php endforeach; ?>

        </div>
     
        
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 text-center">
            <div class="site-section-title">
              <h2>Why Choose Us?</h2>
            </div>
            <p>At Homeland Real Estate, we are committed to helping clients find the perfect property with ease and confidence. Our experienced team provides expert guidance, transparent communication, and reliable market insights to ensure every buying, selling, or renting experience is smooth and successful.</p>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 col-lg-4">
            <a href="#" class="service text-center">
              <span class="icon flaticon-house"></span>
              <h2 class="service-heading">Research Subburbs</h2>
              <p>We provide detailed information about neighborhoods, including nearby schools, transportation, safety, and lifestyle amenities. Our platform helps you explore the best areas to live based on your personal needs and preferences.

Read More</p>
              <p><span class="read-more">Read More</span></p>
            </a>
          </div>
          <div class="col-md-6 col-lg-4">
            <a href="#" class="service text-center">
              <span class="icon flaticon-sold"></span>
              <h2 class="service-heading">Sold Houses</h2>
              <p>Our strong network and market expertise allow us to successfully close property deals quickly and efficiently. We have helped many families find their dream homes and assisted sellers in getting the best value for their properties.

Read More</p>
              <p><span class="read-more">Read More</span></p>
            </a>
          </div>
          <div class="col-md-6 col-lg-4">
            <a href="#" class="service text-center">
              <span class="icon flaticon-camera"></span>
              <h2 class="service-heading">Security Priority</h2>
              <p>Your safety and privacy are our top priorities. We ensure secure transactions, verified listings, and professional support to give you peace of mind throughout your property journey.

Read More</p>
              <p><span class="read-more">Read More</span></p>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- <div class="site-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center">
            <div class="site-section-title">
              <h2>Recent Blog</h2>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis maiores quisquam saepe architecto error corporis aliquam. Cum ipsam a consectetur aut sunt sint animi, pariatur corporis, eaque, deleniti cupiditate officia.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="100">
            <a href="#"><img src="images/img_4.jpg" alt="Image" class="img-fluid"></a>
            <div class="p-4 bg-white">
              <span class="d-block text-secondary small text-uppercase">Jan 20th, 2019</span>
              <h2 class="h5 text-black mb-3"><a href="#">Art Gossip by Mike Charles</a></h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias enim, ipsa exercitationem veniam quae sunt.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="200">
            <a href="#"><img src="images/img_2.jpg" alt="Image" class="img-fluid"></a>
            <div class="p-4 bg-white">
              <span class="d-block text-secondary small text-uppercase">Jan 20th, 2019</span>
              <h2 class="h5 text-black mb-3"><a href="#">Art Gossip by Mike Charles</a></h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias enim, ipsa exercitationem veniam quae sunt.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="300">
            <a href="#"><img src="images/img_3.jpg" alt="Image" class="img-fluid"></a>
            <div class="p-4 bg-white">
              <span class="d-block text-secondary small text-uppercase">Jan 20th, 2019</span>
              <h2 class="h5 text-black mb-3"><a href="#">Art Gossip by Mike Charles</a></h2>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias enim, ipsa exercitationem veniam quae sunt.</p>
            </div>
          </div>

        </div>

      </div>
    </div> -->

    
    <div class="site-section bg-light">
    <div class="container">
      <div class="row mb-5 justify-content-center">
        <div class="col-md-7">
          <div class="site-section-title text-center">
            <h2>Our Agents</h2>
            <p>Our team of experienced real estate professionals is dedicated to helping you find the perfect property. With deep knowledge of the market and a commitment to excellent customer service, our agents guide clients through every step of buying, selling, or renting a home.</p>
          </div>
        </div>
      </div>
      <div class="row">
          <div class="col-md-6 col-lg-4 mb-5 mb-lg-5">
            <div class="team-member">

              <img src="images/person_1.jpg" alt="Image" class="img-fluid rounded mb-4">

              <div class="text">

                <h2 class="mb-2 font-weight-light text-black h4">Megan Smith</h2>
                <span class="d-block mb-3 text-white-opacity-05">Real Estate Agent</span>
                <p>Megan Smith is a dedicated real estate professional with years of experience in helping clients find homes that match their lifestyle and budget. She believes in building long-term relationships and delivering exceptional service to every client.</p>
                <p>
                  <a href="#" class="text-black p-2"><span class="icon-facebook"></span></a>
                  <a href="#" class="text-black p-2"><span class="icon-twitter"></span></a>
                  <a href="#" class="text-black p-2"><span class="icon-linkedin"></span></a>
                </p>
              </div>

            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-5 mb-lg-5">
            <div class="team-member">

              <img src="images/person_2.jpg" alt="Image" class="img-fluid rounded mb-4">

              <div class="text">

                <h2 class="mb-2 font-weight-light text-black h4">Brooke Cagle</h2>
                <span class="d-block mb-3 text-white-opacity-05">Real Estate Agent</span>
                <p>Brooke specializes in residential properties and works closely with buyers and sellers to ensure smooth and successful transactions. Her strong communication skills and deep knowledge of the market make her a trusted advisor.</p>
                <p>
                  <a href="#" class="text-black p-2"><span class="icon-facebook"></span></a>
                  <a href="#" class="text-black p-2"><span class="icon-twitter"></span></a>
                  <a href="#" class="text-black p-2"><span class="icon-linkedin"></span></a>
                </p>
              </div>

            </div>
          </div>

          <div class="col-md-6 col-lg-4 mb-5 mb-lg-5">
            <div class="team-member">

              <img src="images/person_3.jpg" alt="Image" class="img-fluid rounded mb-4">

              <div class="text">

                <h2 class="mb-2 font-weight-light text-black h4">Philip Martin</h2>
                <span class="d-block mb-3 text-white-opacity-05">Real Estate Agent</span>
                <p>Philip Martin is known for his professionalism and commitment to client satisfaction. With a strong understanding of the property market, he helps clients make informed decisions and achieve their real estate goals.</p>
                <p>
                  <a href="#" class="text-black p-2"><span class="icon-facebook"></span></a>
                  <a href="#" class="text-black p-2"><span class="icon-twitter"></span></a>
                  <a href="#" class="text-black p-2"><span class="icon-linkedin"></span></a>
                </p>
              </div>

            </div>
          </div>

          

        </div>
    </div>
<?php require "includes/footer.php"; ?>
