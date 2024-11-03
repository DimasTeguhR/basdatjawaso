<?php
include_once  "./init.php";
include "./genral/config.php";
include "./genral/functions.php";

// Dimas Teguh Ramadhani
 $slecet = "SELECT * FROM product";
$s = mysqli_query($connectSQL ,$slecet );
 $slecetMen = "SELECT category.name AS categoryName , product.id , product.title , product.descriptions , product.price , product.image FROM category JOIN product ON categoryId = category.id AND product.categoryId = 1";
$sMen = mysqli_query($connectSQL ,$slecetMen );
 $slecetFmale = "SELECT category.name AS categoryName , product.id , product.title , product.descriptions , product.price , product.image FROM category JOIN product ON categoryId = category.id AND product.categoryId = 2";
$sFmale = mysqli_query($connectSQL ,$slecetFmale );
// get search
if(isset($_GET['search'])){
  $search = $_GET['search_term'];
  header("location: $root_path/search/search.php?search=$search");
}

// Check if add to cart is triggered
if (isset($_POST['add_to_cart'])) {
  if (isset($_SESSION['customer'])) {
      $quantity = $_POST['quantity'];
      $productId = $_POST['product_id'];
      $customerId = $_SESSION['id'];
      $insert = "INSERT INTO orders VALUES (NULL, $quantity, $customerId, $productId)";
      $i = mysqli_query($connectSQL, $insert);
      $message = testMessage($i, "insert order");
      header("location: $root_path/index.php#content_product");
      exit;
  } else {
      header("location: $root_path/user/login.php");
      exit;
  }
}

include "shared/header.php" ;
 include "shared/nav.php" ;
 ?>
 <section id="home">
<div class="home">
<div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <div class="overlay"></div>
      <img src="<?php echo $root_path ?>/image/1.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5 class='display-4'>Toko Dekorasi JAWASO</h5>
        <h2 class='display-2 pb-4 mb-3'>Kue Custom</h2>
        <a href="<?php echo $root_path ?>/collection/collection.php?category=1" class="btn btn-outline-info rounded-pill" >SHOP NOW</a>
      </div>
    </div>
    <div class="carousel-item">
    <div class="overlay"></div>
      <img src="<?php echo $root_path ?>/image/2.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
      <h5 class='display-4'>Toko Dekorasi JAWASO</h5>
        <h2 class='display-2 pb-4 mb-3'>Dekorasi Pernikahan</h2>
        <a href="<?php echo $root_path ?>/collection/collection.php?category=1" class="btn btn-outline-info rounded-pill" >SHOP NOW</a>
      </div>
    </div>
    <div class="carousel-item">
    <div class="overlay"></div>
      <img src="<?php echo $root_path ?>/image/3.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
      <h5 class='display-4'>Toko Dekorasi JAWASO</h5>
        <h2 class='display-2 pb-4 mb-3'>Dekorasi Ulang Tahun</h2>
        <a href="<?php echo $root_path ?>/collection/collection.php?category=1" class="btn btn-outline-info rounded-pill" >SHOP NOW</a>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
  <i class="fas fa-caret-left fa-4x" aria-hidden="true"></i>

  </button>
  <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
  <i class="fas fa-caret-right fa-4x" aria-hidden="true"></i>
  </button>
</div>
</div>
<div class="product">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        
        <a href="<?php echo $root_path ?>/collection/collection.php?category=1">
        <div class="card">
          <img src="<?php echo $root_path ?>/image/2.jpg" alt="">
          <div class="overlay"></div>
          <div class="card-body">
          <h5>Dekorasi Pernikahan</h5>
        </div>
        <h4>Shop Now</h4>
        </div>
      </a>
      </div>
      <div class="col-md-6">
      <a href="<?php echo $root_path ?>/collection/collection.php?category=2">
        <div class="card">
        <img src="<?php echo $root_path ?>/image/5.jpg" alt="">
        <div class="overlay"></div>
        <div class="card-body">
          <h5>Dekorasi Ulang Tahun</h5>
        </div>
        <h4>Shop Now</h4>
        </div>
        </a>
      </div>
    </div>
  </div>
</div>
<div class="product_overview">
    <div class="container">
      <div class="landing">
        <h2>PRODUCT </h2>
        <div class="row">
          <div class="col-6">

  </div>
  <!-- filter product -->

<div id="content_product" class="content_product mt-4">
  <div id="content-filter" class="row">
  <?php foreach($s as $data){ ?>
    <?php $price = number_format($data['price'], 0, ',', '.'); ?>
    <div class="col-lg-3 col-md-4 col-12 mb-3">
      <div class="card wow animate__bounceInUp" >
        <div class="card-head">
          <img src="./dashboard/product/upload/<?php echo $data['image'] ; ?>" class="card-img-top" alt="...">
          <a href="<?php echo $root_path ?>/product_profile/profile.php?pId=<?php echo $data['id'];?>" class="btn btn-light quick_view rounded-pill">Quick View</a>
        </div>
        <div class="card-body p-2" style="display: flex; justify-content: space-between; align-items: center;">
          <div>
              <h5 class='card-title mb-1'><?php echo $data['title']; ?></h5>
              <p class="mb-1"><?php echo 'Rp. ' . $price; ?></p>
          </div>
          <form method="POST" class="ml-auto">
              <input type="hidden" name="product_id" value="<?php echo $data['id']; ?>">
              <input type="hidden" name="quantity" value="1">
              <button type="submit" name="add_to_cart" class="btn btn-warning" style="margin-left: 15px;"><ion-icon name="cart-outline" style="font-size: 1.5rem; margin-top: 5px;"></ion-icon></button>
          </form>
        </div>
      </div>
    </div>
    <?php }?>
        </div>
      </div>
    </div>
  </div>
  </section>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <?php if(isset($_SESSION['customer'])): ?>
  <?php include "shared/contact.php" ?>
  <?php endif; ?>
  <?php include "shared/footer.php" ?>

