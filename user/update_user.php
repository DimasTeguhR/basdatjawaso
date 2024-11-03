<?php
include_once "../init.php";
include "../genral/config.php";
include "../genral/functions.php";

$id = $_GET['id'] ?? null;

if ($id) {
    $select = "SELECT * FROM customers WHERE id = ?";
    $stmt = mysqli_prepare($connectSQL, $select);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    $name = $user['name'];
    $password = $user['password'];
    $phone = $user['phone'];
    $address = $user['address'];
}

$errorName = $errorPassword = $errorPhone = $errorAddress = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if (empty($name)) {
        $errorName[] = "The name field is empty!";
    } elseif (strlen($name) > 25) {
        $errorName[] = "(25) max for this field!";
    }

    if (empty($password)) {
        $errorPassword[] = "The Password field is empty!";
    } elseif (strlen($password) > 12) {
        $errorPassword[] = "(12) max for this field!";
    } elseif (strlen($password) < 4) {
        $errorPassword[] = "(4) minimum for this field!";
    }

    if (empty($phone)) {
        $errorPhone[] = "The phone field is empty!";
    } elseif (strlen($phone) != 11) {
        $errorPhone[] = "Enter (11) numbers!";
    }

    if (empty($address)) {
        $errorAddress[] = "The address field is empty!";
    } elseif (strlen($address) > 25) {
        $errorAddress[] = "(25) max for this field!";
    }

    if (empty($errorName) && empty($errorPassword) && empty($errorPhone) && empty($errorAddress)) {
        $updateQ = "UPDATE customers SET name=?, password=?, phone=?, address=? WHERE id=?";
        $stmt = mysqli_prepare($connectSQL, $updateQ);
        mysqli_stmt_bind_param($stmt, 'ssssi', $name, $password, $phone, $address, $id);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['customer'] = $name;
            header("Location: $root_path/user/user_profile.php");
            exit;
        } else {
            echo "Error updating record: " . mysqli_error($connectSQL);
        }
    }
}

include "../shared/header.php";
include "../shared/nav.php";
?>

<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h3 class="text-center mb-4">Update User Profile</h3>
        <form method="POST">
            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input value="<?php echo htmlspecialchars($name); ?>" name="name" type="text" class="form-control" id="name" placeholder="Enter your name">
                <?php if (!empty($errorName)) { echo "<div class='alert alert-danger mt-2'>{$errorName[0]}</div>"; } ?>
            </div>
            <div class="form-group mb-3">
                <label for="password">Password</label>
                <input value="<?php echo htmlspecialchars($password); ?>" name="password" type="password" class="form-control" id="password" placeholder="Enter your password">
                <?php if (!empty($errorPassword)) { echo "<div class='alert alert-danger mt-2'>{$errorPassword[0]}</div>"; } ?>
            </div>
            <div class="form-group mb-3">
                <label for="phone">Phone</label>
                <input value="<?php echo htmlspecialchars($phone); ?>" name="phone" type="text" class="form-control" id="phone" placeholder="Enter your phone number">
                <?php if (!empty($errorPhone)) { echo "<div class='alert alert-danger mt-2'>{$errorPhone[0]}</div>"; } ?>
            </div>
            <div class="form-group mb-3">
                <label for="address">Address</label>
                <input value="<?php echo htmlspecialchars($address); ?>" name="address" type="text" class="form-control" id="address" placeholder="Enter your address">
                <?php if (!empty($errorAddress)) { echo "<div class='alert alert-danger mt-2'>{$errorAddress[0]}</div>"; } ?>
            </div>
            <div class="d-flex justify-content-center mt-4">
                <button name="update" class="btn btn-primary me-2">Update</button>
                <a href="<?php echo $root_path; ?>/user/user_profile.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include "../shared/footer.php"; ?>