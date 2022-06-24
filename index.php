<?php

require 'libs/functions.php';

$categories = get_categories();
$category = "";
$rows = change_category($category);
$pdo = get_connection();

$latestWallpapers = $pdo->query('SELECT * FROM wallpapers ORDER BY id DESC LIMIT 16');
$latestRows = $latestWallpapers->fetchAll();

$highestQuality = $pdo->query('SELECT * FROM wallpapers ORDER BY resolution DESC LIMIT 16');
$qualityRows = $highestQuality->fetchAll();


?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <title>Galeria Tapet</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="css/styles.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Italiana&family=Pacifico&family=Roboto:wght@100;400&display=swap" rel="stylesheet">


</head>

<body>

  <?php
  require 'layout/header.php';

  // Login
  if (isset($_POST['login'])) {
    $login = $_POST['login'];
    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE name= :login";
    $result = $pdo->prepare($sql);
    $result->bindParam(':login', $login, PDO::PARAM_STR);
    $result->execute();
    $user = $result->fetchAll();

    if (count($user) > 0) {
      $db_pass = $user[0]['password'];

      if (password_verify($password, $db_pass)) {
        $_SESSION['zalogowany'] = true;
        unset($_SESSION['login_error']);
        header("Location: index.php");
      } else {
        $_SESSION['login_error'] = '<span style="color:red">Nieprawidlowe hasło!</span>';
        echo '<script type="text/javascript"> $(".modal").modal("show");</script>';
        unset($_SESSION['zalogowany']);
        header("Location: index.php#staticBackdrop");
      }
    } else {
      $_SESSION['login_error'] = '<span style="color:red">Nie znaleziono użytkownika!</span>';
      echo '<script type="text/javascript"> $(".modal").modal("show");</script>';
      unset($_SESSION['zalogowany']);
      header("Location: index.php#staticBackdrop");
    }
  }


  ?>

  <div class="category-button container">
    <div class="row">
      <div class="gallery col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1 class="gallery-title">Galeria Tapet</h1>
      </div>

      <div class="categories-container">
        <?php
        foreach ($categories as $category) {
          $categoryName = $category['name'];
          echo "<a class='btn btn-sm filter-button' style='width: fit-content;' href='category.php?category=$categoryName' type='button' >$categoryName</a>";
        }
        ?>
      </div>
    </div>
  </div>


  <section class='gallery'>
    <div class='container-fluid mb-5 pb-5'>
      <h2 class="text-lg-start mt-4 mb-0">Najnowsze Tapety</h2>
      <hr class="mt-2 mb-3">
      <div class='row text-center text-lg-start photo-container'>
        <?php
        foreach ($latestRows as $item) {
          $id = $item['id'];
          $url = $item['url'];
          $name = $item['name'];
          $resolution = get_resolution($url);
          $idLink = 'wallpaper.php?id=' . $item['id'];
          $file_size = format_size(filesize($url));


          echo "<div class='col-lg-3 col-md-4 col-12 mb-5'>";
          echo "<a class='d-block mb-1 h-60' href='$idLink'><img src='$url' class='img-fluid gallery-image' alt='gallery'></a>";
          echo <<<END
          <div class="d-flex justify-content-between text-center">
            <span class="wallpaper-name">$name</span>
          </div>
          END;
          echo "</div>";
        }
        ?>
      </div>
    </div>


    <div class='container-fluid'>
      <h2 class="text-lg-start mt-4 mb-0">Tapety o największej rozdzielczości</h2>
      <hr class="mt-2 mb-3">
      <div class='row text-center text-lg-start photo-container'>
        <?php
        foreach ($qualityRows as $item) {
          $url = $item['url'];
          $name = $item['name'];
          $resolution = get_resolution($url);
          $idLink = 'wallpaper.php?id=' . $item['id'];

          echo "<div class='col-lg-3 col-md-4 col-12 mb-5'>";
          echo "<a class='d-block mb-1 h-60' href='$idLink'><img src='$url' class='img-fluid gallery-image' alt='gallery'></a>";
          echo <<<END
          <div class="d-flex justify-content-between">
            <span class="wallpaper-name">$name</span>                       
          </div>
          END;
          echo "</div>";
        }
        ?>
      </div>
  </section>

  <?php require 'layout/footer.php'; ?>

  <script>
    $(document).ready(function() {

      if (window.location.href.indexOf('#staticBackdrop') != -1) {
        $('#staticBackdrop').modal('show');
      }

    });
  </script>