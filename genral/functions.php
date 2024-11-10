<?php 
function testMessage($condation , $mess){
    if($condation){
        echo "<div class='alert alert-info text-center mx-auto w-50'>
        <h5> $mess Is True Proccess </h5>
        </div>";
    }else{
        echo "<div class='alert alert-danger text-center mx-auto w-50'>
        <h5> $mess Is flass Proccess </h5>
        </div>";
    }
}
// Fungsi untuk mengautentikasi admin agar hanya bisa mengakses halaman tertentu
function authAdmin(){
    $root_path = $GLOBALS['root_path'];
    if(!$_SESSION['admin']){
        header("location: $root_path/dashboard/admin/login.php");
        exit;
    }
}
// Fungsi untuk mengecek apakah admin sudah login, jika iya maka diarahkan ke dashboard
function checkLogin(){
    $root_path = $GLOBALS['root_path'];
    if(isset($_SESSION['admin'])){
        header("location: $root_path/dashboard/");
        exit;
    }
}
// Fungsi untuk mengatur izin akses berdasarkan peran admin
function permissionsAdmin($role){
    $root_path = $GLOBALS['root_path'];
    if($_SESSION['admin']){
    if($_SESSION['role'] == $role || $_SESSION['role'] == 0){

    }else{
        header("location: $root_path/dashboard/admin/login.php");
    }

    }else{
        header("location: $root_path/dashboard/admin/login.php");
    }

}
// Fungsi untuk memeriksa izin akses pengguna (customer)
function userPermissions(){
    $root_path = $GLOBALS['root_path'];
    if($_SESSION['customer']){

    }else{
        header("location: $root_path/user/login.php");
    }
}
// Fungsi untuk mencegah pengguna yang telah login mengakses halaman tertentu
function notUserPermissions(){
    $root_path = $GLOBALS['root_path'];
    if(isset($_SESSION['customer']) ){

        header("location: $root_path/index.php");
    }else{
    }
}