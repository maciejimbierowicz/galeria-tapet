<?php 
require 'libs/functions.php';

if (!isset($_SESSION['zalogowany'])) {
    header("Location: index.php");
}


$pdo = get_connection();
$id=$_GET['id'];

if (isset($_POST['submitUser']) && isset($_POST['login'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $join_date = date("Y-m-d H:i:s");
    $sql = "UPDATE users SET name='$login', password='$password' WHERE id='$id' ";
                $rows = $pdo->query($sql);
				echo "User edited succesfully!";
} else {
    echo "cos nie dziala";
}

if (isset($_POST['submitCategory']) && isset($_POST['newCategory'])) {
    $category_name = $_POST['newCategory'];
    $sql = "UPDATE categories
                SET name='$category_name'";
                $rows = $pdo->query($sql);
				echo "Succesfully added new category!";
} else {
    echo "cos nie dziala";
}

if (isset($_POST['submit']) && isset($_POST['wallpaper_name'])) {
    $wallpaper_name = $_POST['wallpaper_name'];
    $wallpaper_description = $_POST['description'];
    $wallpaper_category = $_POST['category'];
    echo $wallpaper_name;
    $sql = "UPDATE wallpapers SET name='$wallpaper_name', description='$wallpaper_description', category='$wallpaper_category' WHERE id=$id";
    $rows = $pdo->query($sql);
    echo "Succesfully updated wallpaper!";
} else {
echo "cos nie dziala";
}
