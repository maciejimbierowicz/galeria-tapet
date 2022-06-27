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

  $pdo = get_connection();
  $all_categories = $pdo->query('SELECT * FROM categories');
  $categories = $all_categories->fetchAll();
  $wallpaper_category = $_GET['category'];
  $rows = change_category($pdo, $wallpaper_category);
  ?>

  <div class="category-button container">
    <div class="row">
      <div class="gallery col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <img src="img/logo/logo.jpg" id="logo">
      </div>
      <div class="categories-container">
        <?php
        foreach ($categories as $category) {
          $categoryName = $category['name'];
          if ($categoryName == $wallpaper_category) {
            echo "<a class='btn filter-button active-class' style='width: fit-content;' href='category.php?category=$categoryName' type='button' >$categoryName</a>";
          } else {
            echo "<a class='btn filter-button' style='width: fit-content; border-radius: 0;' href='category.php?category=$categoryName' type='button' >$categoryName</a>";
          }
        } ?>
      </div>
    </div>
  </div>

  <?php

  $results_per_page = 20;
  $number_of_results = count($rows);
  $number_of_pages = ceil($number_of_results / $results_per_page);

  if (!isset($_GET['page'])) {
    $page = 1;
  } else {
    $page = $_GET['page'];
  }

  $starting_limit_number = ($page - 1) * $results_per_page;

  $sql = "SELECT * FROM wallpapers WHERE category = :category LIMIT :starting_limit_number, :results_per_page";
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $result = $pdo->prepare($sql);
  $result->bindParam(':starting_limit_number', $starting_limit_number, PDO::PARAM_INT);
  $result->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
  $result->bindParam(':category', $wallpaper_category, PDO::PARAM_STR);
  $result->execute();

  $rows = $result->fetchAll();
  ?>

  <section class='gallery'>
    <div class='container-fluid'>
      <?php echo "<h2 class='text-lg-start mt-4 mb-4'>$wallpaper_category</h2>" ?>
      <div class='row text-center text-lg-start photo-container'>
        <?php
        foreach ($rows as $wallpaper) {
          $url = $wallpaper['url'];
          $name = $wallpaper['name'];
          $resolution = $wallpaper['resolution'];
          $idLink = 'wallpaper.php?id=' . $wallpaper['id'];

          echo "<div class='col-lg-3 col-md-4 col-12 mb-5'>";
          echo "<a class='d-block h-60' href='$idLink'><img src='$url' class='img-fluid gallery-image' alt='gallery'></a>";
          echo  "<div class='d-flex justify-content-between'><span class='wallpaper-name'>$name</span></div>";
          echo "</div>";
        }
        ?>
      </div>

      <div class='page-container'>
        <?php
        $active_page = $page;
        if ($page != 1) {
          echo '<a class="page-navigation btn btn-primary" href="category.php?category=' . $wallpaper_category . '&page=' . $active_page - 1 . '">' . 'Poprzednia Strona</a>';
        }
        for ($page = 1; $page <= $number_of_pages; $page++) {
          if ($active_page == $page) {
            echo '<a class="paging-link" id="active" href="category.php?category=' . $wallpaper_category . '&page=' . $page . '">' . $page . ' </a>';
          } else {
            echo '<a class="paging-link" href="category.php?category=' . $wallpaper_category . '&page=' . $page . '">' . $page . ' </a>';
          }
        }
        if ($active_page != $number_of_pages) {
          echo '<a class="page-navigation btn btn-primary" href="category.php?category=' . $wallpaper_category . '&page=' . $active_page + 1 . '">' . 'Następna Strona</a>';
        }
        ?>
      </div>
  </section>

  <?php
  require 'layout/footer.php';
  ?>