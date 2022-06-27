<?php
require 'login.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="img/logo/logo2.jpg" style="height: 60px">
    </a>
    <button class="navbar-toggler collapsed logo-button" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      &#9776;
    </button>
    <div class="navbar-collapse collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Strona Główna</a>
        </li>

        <?php
        if (!isset($_SESSION['zalogowany'])) {
          echo "<li class='nav-item login-button'><a type='button' class='nav-link' data-toggle='modal' data-target='#staticBackdrop'>Zaloguj się</a></li>";
        } else {
          echo "<li class='nav-item'><a class='nav-link' href='list.php?list=wallpapers'>Menu Administratora</a></li>";
          echo "<li class='nav-item'><a class='nav-link' href='layout/logout.php'>Wyloguj się</a></li>";
        }
        ?>

      </ul>
    </div>
  </div>
</nav>