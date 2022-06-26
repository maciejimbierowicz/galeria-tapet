<?php
session_start();

require 'libs/functions.php';

if (!isset($_SESSION['zalogowany'])) {
  header("Location: index.php");
}

$pdo = get_connection();

// WALLPAPER UPLOAD
if (isset($_POST['submit']) && isset($_FILES['my_image'])) {
  $img_name = $_FILES['my_image']['name'];
  $img_size = $_FILES['my_image']['size'];
  $tmp_name = $_FILES['my_image']['tmp_name'];

  $wallpaper_name = filter_var($_POST['wallpaper_name'], FILTER_SANITIZE_SPECIAL_CHARS);
  $wallpaper_description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
  $upload_date = date("Y-m-d H:i:s");
  $wallpaper_size = format_size($img_size);
  $wallpaper_category = $_POST['category'];
  $error = $_FILES['my_image']['error'];
  
  if ($error === 0) {
    if ($img_size > 10000000) {
      $_SESSION['error'] = "Plik jest za duży!";
      header("Location: index.php");
    } else {
      $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
      $img_ex_lc = strtolower($img_ex);

      $allowed_exs = ["jpg", "jpeg", "png"];

      if (in_array($img_ex_lc, $allowed_exs)) {
        $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
        $img_upload_path = 'img/' . $new_img_name;
        move_uploaded_file($tmp_name, $img_upload_path);
        $img_resolution = get_resolution($img_upload_path);

        $sql = "INSERT INTO wallpapers
                VALUES (null, :wallpaper_name, :wallpaper_category, :wallpaper_description, :img_resolution, :wallpaper_size, :img_upload_path, :upload_date)";
        $result = $pdo->prepare($sql);
        $result->bindParam(':wallpaper_name', $wallpaper_name, PDO::PARAM_STR);
        $result->bindParam(':wallpaper_category', $wallpaper_category, PDO::PARAM_STR);
        $result->bindParam(':wallpaper_description', $wallpaper_description, PDO::PARAM_STR);
        $result->bindParam(':img_resolution', $img_resolution, PDO::PARAM_STR);
        $result->bindParam(':wallpaper_size', $wallpaper_size, PDO::PARAM_STR);
        $result->bindParam(':img_upload_path', $img_upload_path, PDO::PARAM_STR);
        $result->bindParam(':upload_date', $upload_date, PDO::PARAM_STR);
        $result->execute();

        $_SESSION['success'] = "<span style='color: green'>Dodano Tapetę!</span>";
        header("Location: list.php?list=wallpapers");
      } else {
        $_SESSION['error'] = "<span style='color: red'>Nieprawidłowy typ pliku!</span>";
        header("Location: list.php?list=wallpapers");
      }
    }
  } else {
    $_SESSION['error'] = "<span style='color: red'>Błąd!</span>";
    header("Location: index.php");
  }
}

// ADD CATEGORY
else if (isset($_POST['submitCategory']) && isset($_POST['newCategory'])) {
  $category_name = filter_var($_POST['newCategory'], FILTER_SANITIZE_SPECIAL_CHARS);
  $date = date("Y-m-d H:i:s");

  $sql = "INSERT INTO categories VALUES (null, :category_name, :date)";
  $result = $pdo->prepare($sql);
  $result->bindParam(':category_name', $category_name, PDO::PARAM_STR);
  $result->bindParam(':date', $date, PDO::PARAM_STR);
  $result->execute();

  $_SESSION['success'] = "<span style='color: green'>Dodano kategorię!</span>";
  header("Location: list.php?list=categories");
}

// ADD USER
else if (isset($_POST['submitUser']) && isset($_POST['login'])) {
  $login = filter_var($_POST['login'], FILTER_SANITIZE_SPECIAL_CHARS);
  $password = $_POST['password'];
  $password = password_hash($password, PASSWORD_DEFAULT);
  $join_date = date("Y-m-d H:i:s");
  
  $sql = "INSERT INTO users VALUES (null, :login, :password, :join_date)";
  $result = $pdo->prepare($sql);
  $result->bindParam(':login', $login, PDO::PARAM_STR);
  $result->bindParam(':password', $password, PDO::PARAM_STR);
  $result->bindParam(':join_date', $join_date, PDO::PARAM_STR);
  $result->execute();


  $_SESSION['success'] = "<span style='color: green'>Dodano Użytkownika!</span>";
  header("Location: list.php?list=users");

} else {
  $_SESSION['error'] = "<span style='color: red'>Błąd!</span>";
  header("Location: list.php?list=users");
}
