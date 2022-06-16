<?php

require 'libs/functions.php';
require 'layout/header.php';


$categories = get_categories();
$category = "";
$rows = change_category($category);
$pdo = get_connection();

$najnowszeTapety = $pdo->query('SELECT * FROM wallpapers ORDER BY id DESC LIMIT 16');
$najnowszeRows = $najnowszeTapety->fetchAll();

$najwiekszaRozdzielczosc = $pdo->query('SELECT * FROM wallpapers ORDER BY resolution DESC LIMIT 16');
$rozdzielczoscRows = $najwiekszaRozdzielczosc->fetchAll();


if (isset($_POST['login'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM users WHERE name='$login' AND password='$password'";
    $result = $pdo->query($sql);
    $wiersz = $result->fetchAll();

    if (count($wiersz) > 0) {
        $_SESSION['zalogowany'] = true;
        unset($_SESSION['blad']);
        header("Location: index.php");
    } else {
        $_SESSION['blad'] = '<span color:"red">Nieprawidlowe Haslo!</span>';
        unset($_SESSION['zalogowany']);
    }
}
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
    <?php
    if (isset($_SESSION['blad'])) {
        echo $_SESSION['blad'];
        unset($_SESSION['blad']);
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
                foreach ($najnowszeRows as $item) {
                    $id = $item['id'];
                    $url = $item['url'];
                    $name = $item['name'];
                    $resolution = get_resolution($url);
                    $idLink = 'wallpaper.php?id=' . $item['id'];
                    $file_size = format_size(filesize($url));

                    echo "<div class='col-lg-3 col-md-4 col-12 mb-5'>";
                    echo "<a class='d-block mb-1 h-60' href='$idLink'><img src='$url' class='img-fluid gallery-image' alt='gallery'></a>";
                    echo <<<END
                    <div class="d-flex justify-content-betweentext-center">
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
                foreach ($rozdzielczoscRows as $wallpaper) {
                    $url = $wallpaper['url'];
                    $name = $wallpaper['name'];
                    $resolution = get_resolution($url);
                    $idLink = 'wallpaper.php?id=' . $wallpaper['id'];



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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>