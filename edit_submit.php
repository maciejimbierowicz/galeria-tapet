<?php
session_start();
require 'libs/functions.php';

if (!isset($_SESSION['zalogowany'])) {
    header("Location: index.php");
}


$pdo = get_connection();
$id = $_GET['id'];

// User Edit
if (isset($_POST['submitUser']) && isset($_POST['login'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $join_date = date("Y-m-d H:i:s");
    $sql = "UPDATE users SET name='$login', password='$password' WHERE id='$id' ";
    $rows = $pdo->query($sql);
    $_SESSION['success'] = "<span style='color: green'>Zaktualizowano dane użytkownika!</span>";
    header("Location: list.php?list=users");
}


// Category Edit
if (isset($_POST['submitCategory']) && isset($_POST['newCategory'])) {
    $category_name = $_POST['newCategory'];
    $sql = "UPDATE categories
                SET name='$category_name' WHERE id=$id";
    $rows = $pdo->query($sql);
    $_SESSION['success'] = "<span style='color: green'>Zaktualizowano kategorię!</span>";
    header("Location: list.php?list=categories");
}

//  Wallpaper Edit
if (isset($_POST['submit']) && isset($_POST['wallpaper_name'])) {
    $wallpaper_name = $_POST['wallpaper_name'];
    $wallpaper_description = $_POST['description'];
    $wallpaper_category = $_POST['category'];
    $sql = "UPDATE wallpapers SET name='$wallpaper_name', description='$wallpaper_description', category='$wallpaper_category' WHERE id=$id";
    $rows = $pdo->query($sql);
    $_SESSION['success'] = "<span style='color: green'>Zaktualizowano dane tapety!</span>";
    header("Location: list.php?list=wallpapers");
} else {
    $_SESSION['error'] = "<span style='color: red'>Błąd!</span>";
    header("Location: list.php?list=wallpapers");
}
