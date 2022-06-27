<?php
require 'libs/functions.php';

$pdo = get_connection();
$list = $_GET['list'];
$listArray = ['wallpapers', 'users', 'categories'];
$results_per_page = 10;

if (in_array($list, $listArray)) {
  $sql = "SELECT * FROM $list";
  $result = $pdo->query($sql);
  $rows = $result->fetchAll();
}

$number_of_results = count($rows);
$number_of_pages = ceil($number_of_results / $results_per_page);

if (!isset($_GET['page'])) {
  $page = 1;
} else {
  $page = $_GET['page'];
}

$starting_limit_number = ($page - 1) * $results_per_page;

if (in_array($list, $listArray)) {
  $sql = "SELECT * FROM $list LIMIT :starting_limit_number, :results_per_page";
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $result = $pdo->prepare($sql);
  $result->bindParam(':starting_limit_number', $starting_limit_number, PDO::PARAM_INT);
  $result->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
  $result->execute();
  $rows = $result->fetchAll();
}
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
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400&family=Pacifico&family=Roboto:wght@100;400&display=swap" rel="stylesheet">
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
      <a class='<?php if ($list == 'wallpapers') {echo "active-class ";} ?>btn btn-sm admin-filter-button' href="list.php?list=wallpapers">Tapety</a>
      <a class='<?php if ($list == 'categories') {echo "active-class ";} ?>btn btn-sm admin-filter-button' href="list.php?list=categories">Kategorie</a>
      <a class='<?php if ($list == 'users') {echo "active-class ";} ?>btn btn-sm admin-filter-button' href="list.php?list=users">Użytkownicy</a>
    </div>
  </div>

  <?php
  function success()
  {
    if (isset($_SESSION['error'])) {
      echo "<div>" . $_SESSION['error'] . "</div>";
      unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
      echo "<div style='padding-bottom: 40px;'>" . $_SESSION['success'] . "</div>";
      unset($_SESSION['success']);
    }
  }
  ?>

  <?php
  if ($list === 'wallpapers') {
    success();
    echo "<h1>Tapety</h1><br>";
    echo "<a class='btn btn-primary add-button' href='admin.php?list=$list'>Dodaj nową tapetę</a>";
  } else if ($list === 'categories') {
    success();
    echo "<h1>Kategorie</h1><br>";
    echo "<a class='btn btn-primary add-button' href='admin.php?list=$list'>Dodaj nową kategorię</a>";
  } else if ($list === 'users') {
    success();
    echo "<h1>Użytkownicy</h1><br>";
    echo "<a class='btn btn-primary add-button' href='admin.php?list=$list'>Dodaj nowego użytkownika</a>";
  } ?>
  
  <div class='container'>
    <div class="row cold-md-offset-2 custyle justify-content-center col-auto">
      <table class="table table-responsive styled-table">
        <thead>
          <tr>
            <th>id</th>
            <th>Data dodania</th>
            <th>Nazwa</th>
            <th class="text-center">Operacje</th>
          </tr>
        </thead>
        <tbody>
        <?php
        foreach ($rows as $row) {
          $id = $row['id'];
          $name = $row['name'];
          $item_date = $row['date'];

          if ($list == 'wallpapers') {
            $url = $row['url'];
          } else {
            $url = "";
          }

          echo "<tr>";
          echo "<td>$id</td>";
          echo "<td>$item_date</td>";
          if ($list == 'wallpapers') {
            echo "<td><a href='wallpaper.php?id=$id'>$name</a></td>";
          } else {
            echo "<td>$name</td>";
          }
          echo "<td>
            <div class='btn-group text-lg-start'>
              <a class='btn btn-sm btn-secondary action-button' href='edit.php?id=$id&list=$list'>Edytuj</a>
              <a class='btn btn-sm btn-danger action-button delete-button' data-confirm='Czy na pewno chcesz usunąć ten element?' style='width:fit-content' href='delete.php?id=$id&list=$list'>Usuń</a>
            </div>
            </td>";
          echo "</tr>";
        }
        ?>
        </tbody>
      </table>
    </div>

    <div class='page-container admin-paging'>
      <?php
      $active_page = $page;
      if ($page != 1) {
        echo '<a class="page-navigation btn btn-primary" href="list.php?list=' . $list . '&page=' . $active_page - 1 . '">' . 'Poprzednia Strona</a>';
      }
      for ($page = 1; $page <= $number_of_pages; $page++) {
        if ($active_page == $page) {
          echo '<a class="paging-link" id="active" href="list.php?list=' . $list . '&page=' . $page . '">' . $page . ' </a>';
        } else {
          echo '<a class="paging-link" href="list.php?list=' . $list . '&page=' . $page . '">' . $page . ' </a>';
        }
      }
      if ($active_page != $number_of_pages) {
        echo '<a class="page-navigation btn btn-primary" href="list.php?list=' . $list . '&page=' . $active_page + 1 . '">' . 'Następna Strona</a>';
      } 
      ?>
    </div>
  </div>

  <?php
  require 'layout/footer.php';
  ?>