<!DOCTYPE html>
<html lang="pl">

<head>
  <title>Galeria Tapet</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="css/styles.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400&family=Pacifico&family=Roboto:wght@100;400&display=swap" rel="stylesheet">
</head>

<body>

  <?php
  require 'layout/header.php';
  require 'libs/functions.php';

  if (!isset($_SESSION['zalogowany'])) {
    header("Location: index.php");
  }

  $pdo = get_connection();
  $all_categories = $pdo->query('SELECT * FROM categories');
  $categories = $all_categories->fetchAll();

  if (isset($_GET['list'])) {
    $list = $_GET['list'];
  }
  ?>

  <div class="admin-menu">
    <div>
      <a class='<?php if ($list == 'wallpapers') {echo "active-class ";} ?>btn btn-sm admin-filter-button' href="list.php?list=wallpapers">Tapety</a>
      <a class='<?php if ($list == 'categories') {echo "active-class ";} ?>btn btn-sm admin-filter-button' href="list.php?list=categories">Kategorie</a>
      <a class='<?php if ($list == 'users') {echo "active-class ";} ?>btn btn-sm admin-filter-button' href="list.php?list=users">Użytkownicy</a>
    </div>
  </div>

  <?php
  // Image Edit Form
  if (isset($_GET['list'])) {
    echo "<div class='admin-forms'>";
    if ($list === 'wallpapers') {
      echo <<< END
      <div class="upload-form">
        <form action="upload.php" 
        method="post"
        enctype="multipart/form-data">
          <h3>Dodaj nową tapetę</h3>
          <input type='file' name='my_image' required><br><br>
          <p>Nazwa:</p>
          <input type="text" name="wallpaper_name" required><br>
          <p>Opis:</p>
          <input type="text" name="description" required><br>
          <p>Kategoria:</p>
          <select  name="category" required>
      END;

      foreach ($categories as $category) {
        $category_name = $category['name'];
        echo "<option value=$category_name>$category_name</option>";
      }

      echo <<< END
          </select><br><br>
          <input class="btn btn-primary" type='submit' name='submit' value='Dodaj tapetę'>
        </form>
      </div>
      <a href='list.php?list=wallpapers'>Powrót do listy tapet</a>
    END;
    }

    // Category Edit Form
    else if ($list === 'categories') {
      echo <<<END
      <div class="upload-form">
        <form action="upload.php" method="post">
          <h3>Dodaj nową kategorię</h3>
          <p>Nazwa kategorii:</p>
          <input type="text" name="newCategory" required><br>
          <input class="btn btn-primary" type='submit' name='submitCategory' value='Dodaj kategorię'>
        </form>
      </div>
      <a href='list.php?list=categories'>Powrót do listy kategorii</a>
      END;
    }

    // Users Edit Form
    else if ($list === 'users') {
      echo <<<END
      <div class="upload-form">
        <form action="upload.php" method="post">
          <h3>Dodaj nowego użytkownika</h3>
          <p>Login:</p>
          <input type="text" name="login" required><br>
          <p>Hasło:</p>
          <input type="text" id="user-password" name="password" required><br>
          <input type="checkbox" onClick="showPassword()">Pokaż hasło <br><br>
          <input class="btn btn-primary" type='submit' name='submitUser' value='Dodaj użytkownika'>
        </form>
      </div>
      <a href='list.php?list=users'>Powrót do listy użytkowników</a>
      END;
    }
    echo "</div>";
  }

  require 'layout/footer.php';
  ?>