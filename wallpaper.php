<?php
require 'libs/functions.php';

$itemID = $_GET['id'];

$pdo = get_connection();
$sql = "SELECT * FROM wallpapers WHERE id=:itemID";
$result = $pdo->prepare($sql);
$result->bindParam(':itemID', $itemID, PDO::PARAM_INT);
$result->execute();
$item = $result->fetch();

$url = $item['url'];
$name = $item['name'];
$resolution = $item['resolution'];
$description = $item['description'];
$item_size = $item['weight'];
$item_category = $item['category'];

$all_categories = $pdo->query('SELECT * FROM categories');
$categories = $all_categories->fetchAll();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <title>Galeria Tapet - <?php echo "$name"; ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?php echo "$description"; ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="css/styles.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400&family=Pacifico&family=Roboto:wght@100;400&display=swap" rel="stylesheet">
</head>

<body>
  <?php require 'layout/header.php'; ?>

  <div class="categories container">
    <div class="row">
      <div class="gallery col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <img src="img/logo/logo.jpg" id="logo">
      </div>
      <div class="categories-container">
        <?php
        foreach ($categories as $category) {
          $categoryName = $category['name'];
          echo "<a class='btn btn-sm filter-button' href='category.php?category=$categoryName' type='button' >$categoryName</a>";
        }
        ?>
      </div>
    </div>
  </div>
      <br><br><hr><br> 
  <h2 class="mt-4 mb-4"><?php echo "$name" ?></h2>
  <section class="wallpaper-section">
      <div class="wallpaper-div">
        <img src=<?php echo "$url" ?> alt="Image" class="wallpaper-site-img">
      </div>
      <div class="picture-desc" >
        <div><h3>Opis:</h3><span ><?php echo "$description" ?></span></div>                        
        <div><h3>Kategoria: </h3><span><?php echo "$item_category" ?></span></div>            
        <div><h3>Rozdzielczość: </h3><span><?php echo "$resolution" ?></span></div>
        <div><h3>Waga pliku: </h3><span><?php echo "$item_size" ?></span></div>
      </div>
  </section>
  <br>
  <div>
  <?php
      echo "<a type='button' class='btn btn-dark btn-lg' style='font-size:2rem;margin-bottom: 100px;' href='$url' download>Pobierz</a>";
  ?>
  </div> 
  </br></br>
  <?php require 'layout/footer.php'; ?>
</body>

</html>