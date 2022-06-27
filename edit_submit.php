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
    $login = filter_var($_POST['login'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);
    $join_date = date("Y-m-d H:i:s");
    
    $sql = "UPDATE users SET name= :login , password= :password WHERE id= :id ";
    $result = $pdo->prepare($sql);
    $result->bindParam(':login', $login , PDO::PARAM_STR);
    $result->bindParam(':password', $password, PDO::PARAM_STR);
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    
    $_SESSION['success'] = "<span style='color: green'>Zaktualizowano dane użytkownika!</span>";
    header("Location: list.php?list=users");
}

// Category Edit
else if (isset($_POST['submitCategory']) && isset($_POST['newCategory'])) {
    $category_name = filter_var($_POST['newCategory'], FILTER_SANITIZE_SPECIAL_CHARS);
    
    $sql = "UPDATE categories SET name= :category_name WHERE id= :id";
    $result = $pdo->prepare($sql);
    $result->bindParam(':category_name', $category_name, PDO::PARAM_STR);
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();

    $_SESSION['success'] = "<span style='color: green'>Zaktualizowano kategorię!</span>";
    header("Location: list.php?list=categories");
}

//  Wallpaper Edit
else if (isset($_POST['submit']) && isset($_POST['wallpaper_name'])) {
    $wallpaper_name = filter_var($_POST['wallpaper_name'], FILTER_SANITIZE_SPECIAL_CHARS); 
    $wallpaper_description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
    $wallpaper_category = $_POST['category'];
    
    $sql = "UPDATE wallpapers SET name= :wallpaper_name, description= :wallpaper_description , category= :wallpaper_category WHERE id= :id";
    $result = $pdo->prepare($sql);
    $result->bindParam(':wallpaper_name', $wallpaper_name, PDO::PARAM_STR);
    $result->bindParam(':wallpaper_category', $wallpaper_category, PDO::PARAM_STR);
    $result->bindParam(':wallpaper_description', $wallpaper_description, PDO::PARAM_STR);
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();

    $_SESSION['success'] = "<span style='color: green'>Zaktualizowano dane tapety!</span>";
    header("Location: list.php?list=wallpapers");
} else {
    $_SESSION['error'] = "<span style='color: red'>Błąd!</span>";
    header("Location: list.php?list=wallpapers");
}
