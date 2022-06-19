<?php
session_start();
require 'login.php';
?>


<!DOCTYPE html>
<html lang="en">

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

<?php if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    } 
    if (isset($_SESSION['success'])) {
      echo $_SESSION['success'];
      unset($_SESSION['success']);
  }
    ?>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <i class="fas fa-film mr-2"></i>
        Galeria Tapet
      </a>
      <button class="navbar-toggler collapsed logo-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
      <div class="navbar-collapse collapse" id="navbarSupportedContent" style="">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Strona Główna</a>
          </li>

          <?php
          if (!isset($_SESSION['zalogowany'])) {
            echo "<li class='nav-item'><a type='button' class='nav-link' data-toggle='modal' data-target='#staticBackdrop'>Zaloguj się</a></li>";
          } else {
            echo "<li class='nav-item'><a class='nav-link' href='list.php?list=wallpapers'>Menu Administratora</a></li>";
            echo "<li class='nav-item'><a class='nav-link' href='layout/logout.php'>Wyloguj się</a></li>";
          }
          ?>

        </ul>
      </div>
    </div>
  </nav>