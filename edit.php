<?php
require 'libs/functions.php';

$pdo = get_connection();
$categories = get_categories();

$list = $_GET['list'];
$id = $_GET['id'];
$sql = "SELECT * FROM $list WHERE id= :id";
$result = $pdo->prepare($sql);
$result->bindParam(':id', $id, PDO::PARAM_INT);
$result->execute();
$item = $result->fetch();

$item_name = $item['name'];

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
  if (!isset($_SESSION['zalogowany'])) {
    header("Location: index.php");
  }
  ?>

  <div class="admin-menu">
    <div>
      <a class='<?php if ($list == 'wallpapers') {
                  echo "active-class ";
                } ?>btn btn-sm filter-button' href="list.php?list=wallpapers">Tapety</a>
      <a class='<?php if ($list == 'categories') {
                  echo "active-class ";
                } ?>btn btn-sm filter-button' href="list.php?list=categories">Kategorie</a>
      <a class='<?php if ($list == 'users') {
                  echo "active-class ";
                } ?>btn btn-sm filter-button' href="list.php?list=users">Użytkownicy</a>
    </div>
  </div>

  <?php
  echo "<div class='admin-forms'>";
  if ($list === 'wallpapers') {
    $item_description = $item['description'];
    $item_category = $item['category'];

    echo <<< END
    <div class="upload-form">
      <form action="edit_submit.php?id=$id" 
      method="post"
      enctype="multipart/form-data">
        <h3>Edytuj tapetę</h3>
        <p>Nazwa:</p>
        <input type="text" name="wallpaper_name" value='$item_name' required><br>
        <p>Opis:</p>
        <input type="text" name="description" value='$item_description' required><br>
        <p>Kategoria:</p>
        <select  name="category" value='$item_category' required> 
    END;

      foreach ($categories as $category) {
        $category_name = $category['name'];
        echo "<option value=$category_name>$category_name</option>";
      }

    echo <<<END
        </select><br><br>
        <input class="btn btn-primary" type='submit' name='submit' value='Zaktualizuj Dane'>
      </form>
    </div>
    <a href='list.php?list=wallpapers'>Powrót do listy tapet</a> 
    END;
  } else if ($list === 'users') {

    $item_password = $item['password'];
    echo <<<END
    <div class="upload-form">
      <form action="edit_submit.php?id=$id" method="post">
        <h3>Edytuj użytkownika</h3>
        <p>Login:</p>
        <input type="text" name="login" value='$item_name' required><br>
        <p>Hasło:</p>
        <input type="text" name="password" $item_password required><br>
        <input class="btn btn-primary" type='submit' name='submitUser' value='Zaktualizuj Dane'>
      </form>
    </div>
    <a href='list.php?list=users'>Powrót do listy użytkowników</a>
    END;
  } else if ($list === 'categories') {
    echo <<<END
    <div class="upload-form">
      <form action="edit_submit.php?id=$id" method="post">
        <h3>Edytuj kategorię</h3>
        <p>Nazwa kategorii:</p>
        <input type="text" name="newCategory" value='$item_name' required><br>
        <input class="btn btn-primary" type='submit' name='submitCategory' value='Zaktualizuj Dane'>
      </form>
    </div>
    <a href='list.php?list=categories'>Powrót do listy kategorii</a>
END;
  } else {
    header("Location: index.php");
  }
  echo "</div>";

  require 'layout/footer.php';
