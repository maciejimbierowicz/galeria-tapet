<?php
require 'libs/functions.php';
require 'layout/header.php';



$itemID = $_GET['id'];

$pdo = get_connection();

$result = $pdo->query("SELECT * FROM wallpapers WHERE id=$itemID");
$item = $result->fetch();

$url = $item['url'];
$name = $item['name'];
$resolution = $item['resolution'];
$description = $item['description'];
$item_size = $item['weight'];

$categories = get_categories();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Galeria Tapet</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>


</head>

<body>
    <div class="category-button container-fluid">
        <h2 class="mt-4 mb-0 text-center" style="padding-top: 20px; padding-bottom: 20px;">Kategorie</h2>
        <div class='row'>
            <?php

            foreach ($categories as $category) {
                $categoryName = $category['name'];
                echo "<div class='col-lg-2 col-md-4 col-sm-6'>";
                echo "<a class='btn btn-sm filter-button cat-button btn-block' style='width: fit-content;' href='category.php?category=$categoryName' type='button' >$categoryName</a>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <br /><br /><br />
    <section class="product-section">

        <div class="container-fluid">
            <div class="row mb-4 text-lg-start" style="padding-left: 20px">
                <h2 class="mt-4 mb-0"><?php echo "$name" ?></h2>
            </div>
            <div class="row">
                <div class="col-xl-8 col-md-7 col-sm-12 ">
                    <img src=<?php echo "$url" ?> alt="Image" class="img-fluid">
                </div>
                <div class="col-xl-4 col-md-5 col-sm-12">
                    <div class="wallpaper-description">
                        <h3 class="pt-4">Opis:</h3><span><?php echo "$description" ?></span>
                        <div class="text-center mb-5">
                            <?php
                            echo "<a type='button' class='btn btn-primary' href='$url' download>Pobierz</a>";
                            ?>
                        </div>
                        <div class="mb-4">
                            <div class="mr-4 mb-2">
                                <h3>Rozdzielczość: </h3><span><?php echo "$resolution" ?></span>
                            </div>
                        </div>
                        <div class="mb-4 pb-3">
                            <h3>Waga pliku: </h3><span><?php echo "$item_size" ?></span>
                        </div>
    </section>
    </br></br>
    <?php require 'layout/footer.php'; ?>
</body>

</html>