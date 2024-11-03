<?php
ob_start();
include_once  "../init.php";
include "../genral/config.php";
include "../genral/functions.php";
include "../shared/header.php" ;
 include "../shared/nav.php" ;

 if(isset($_GET['category'])){
    $category = $_GET['category'];
    // select table category 1 row
    $slecetCategory = "SELECT * FROM category WHERE category.id = $category";
  $sCategory = mysqli_query($connectSQL ,$slecetCategory );
  $fetchCategory= mysqli_fetch_assoc($sCategory);
  // select table product join category
    $slecetProduct = "SELECT * FROM category JOIN product ON categoryId = category.id AND product.categoryId = $category";
  $sProduct = mysqli_query($connectSQL ,$slecetProduct );
  $numRowSearch = mysqli_num_rows($sProduct);
  }

if(isset($_GET['search'])){
    $search_term = mysqli_real_escape_string($connectSQL, $_GET['search_term'] );
    $slecet_search = "SELECT * FROM category JOIN product ON categoryId = category.id AND product.categoryId = $category WHERE title LIKE '%$search_term%'";
    $sMen = mysqli_query($connectSQL ,$slecet_search );
    $numRowSearch = mysqli_num_rows($sProduct);
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
      header("location: $root_path/index.php");
      exit;
  } else {
      header("location: $root_path/user/login.php");
      exit;
  }
}
ob_end_flush();
 ?>
<section id="home">
  
    <div class="product_carousel">
        <div class="container">
        <div class="Advertisement">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
    <div class="overlay"></div>
      <img src="<?php echo $root_path ?>/image/slide1.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
    <div class="overlay"></div>
      <img src="<?php echo $root_path ?>/image/slide2.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
    <div class="overlay"></div>
      <img src="<?php echo $root_path ?>/image/slide3.jpg" class="d-block w-100" alt="...">
    </div>
  </div>
</div>
    </div>

            <div class="landing pb-2 mt-5">
                <div class="row">
                    <div class="col-6">
                        <h2>Product Best Seller!!!</h2>
                        </div>
                          <!-- filter product -->
          <div class="col-6">
          </div>
        </div>
        <div id="content_product" class="content_product py-5">
            <!-- men product -->
            <?php if($numRowSearch > 0  ): ?>
                <div id="content-filter" class="row">
                        <?php foreach($sProduct as $data){ ?>
                          <?php $price = number_format($data['price'], 0, ',', '.'); ?>
                            <div class="col-lg-3 col-md-4 col-12 mb-3">
                                <div class="card wow animate__bounceInUp">
                                        <div class="card-head">
                                            <img src="../dashboard/product/upload/<?php echo $data['image'] ; ?>" class="card-img-top" alt="...">
                                            <a href="<?php echo $root_path ?>/product_profile/profile.php?pId=<?php echo $data['id'];?>" class="btn btn-light quick_view rounded-pill">Quick View</a>
                                        </div>        
                                    <div class="card-body p-2" style="display: flex; justify-content: space-between; align-items: center;">
                                      <div>
                                      <h5 class='card-title'><?php echo $data['title'] ; ?></h5>
                                      <p class=""><?php echo 'Rp. ' . $price ;?></p>
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
                <?php else : ?>
                    <div class="not_found">
                    </div>
                    <?php endif; ?>
            </div>
        </div>
        </div>
    </div>
</section>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<?php if(isset($_SESSION['customer'])): ?>
<?php include "../shared/contact.php" ?>
<?php endif; ?>
<?php include "../shared/footer.php" ?>