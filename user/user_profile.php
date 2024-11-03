<?php
include_once "../init.php";
include "../genral/config.php";
include "../genral/functions.php";

// Mendapatkan data pengguna dari sesi
$idp = $_SESSION['id'];
$select = "SELECT * FROM customers WHERE id = $idp";
$sr = mysqli_query($connectSQL, $select);
$row = mysqli_fetch_assoc($sr);

$nameR = $row['name'];
$phoneR = $row['phone'];
$addressR = $row['address'];
$image = $row['image_user'];

include "../shared/header.php";
include "../shared/nav.php";
?>

<div class="container col-md-4 cart pt-4 ">
  <div class="user_profile pt-4">
    <div class="card ">
      <div class="card-header text-center">
        <div class='profile-image'>
          <img src="./upload_user_image/<?php echo $image ?>" alt="image" class="image_profile_user">
          <form method="POST" enctype="multipart/form-data">
            <label for="image" class="icone-image"><i class="far fa-image"></i></label>
            <input type="file" name="image" id="image">
            <button name='add' class='add_image btn btn-success'>Add</button>
          </form>
        </div>
      </div>
      <div class="card-body">
        <h5 class="card-title">NAME : <?php echo htmlspecialchars($nameR); ?></h5>
        <p class="card-text">ADDRESS : <?php echo htmlspecialchars($addressR); ?></p>
        <p class="card-text">PHONE : <?php echo htmlspecialchars($phoneR); ?></p>
        <div class="text-center mt-5">
          <!-- Arahkan ke update_user.php dengan parameter id -->
          <a href="<?php echo $root_path ?>/user/update_user.php?id=<?php echo $idp; ?>" class="btn btn-primary">
            Update Data <i class="fas fa-user-edit"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include "../shared/footer.php"; ?>
