<?php 

    require 'libs/functions.php';
    require 'layout/header.php';


    $categories = get_categories();
    $category = "";
    $rows = change_category($category);
    $pdo = get_connection();

    $najnowszeTapety = $pdo->query('SELECT * FROM wallpapers ORDER BY id DESC ');
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
    }
        else { 
            $_SESSION['blad'] = '<span color:"red">Nieprawidlowe Haslo!</span>';
            unset($_SESSION['zalogowany']);
        }}
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
            unset($_SESSION['blad']);} 
    ?>

    <ul>
        <?php
        foreach($categories as $category){
            $categoryName = $category['name'];
            echo "<li><a href='category.php?category=$categoryName' type='button' class='category-button'>$categoryName</a></li>";
        }
        ?>
    </ul>
        <br/>
    
    <section class='gallery min-vh-100'> 
        <h1>Najnowsze</h1>
        <div class='container-lg'>
        <div class='row gy-4 row-cols-1 row-cols-sm-3 row-cols-md-4'>
             <?php 
                foreach($najnowszeRows as $item) {
                    $id = $item['id'];
                    $url = $item['url'];
                    $name = $item['name'];
                    $resolution = get_resolution($url);
                    $idLink = 'wallpaper.php?id='.$item['id'];
                    $file_size = format_size(filesize($url));
                    // $pdo->query("UPDATE wallpapers SET resolution = '$resolution' WHERE id=$id");

                    echo "<div class='col'>";
                    echo "<a href='$idLink'><img src='$url' class='gallery-item' alt='gallery'></a>";
                    echo "<p>$name</p>";
                    echo "<p>$resolution</p>";
                    echo "<p>$file_size</p>";
                    echo "</div>";
                }
            ?> 
        </div>
        </div>
        <h1>Najwieksza rozdzielczosc</h1>
        <div class='container-lg'>
        <div class='row gy-4 row-cols-1 row-cols-sm-3 row-cols-md-4'>
             <?php 
                foreach($rozdzielczoscRows as $wallpaper) {
                    $url = $wallpaper['url'];
                    $name = $wallpaper['name'];
                    $resolution = get_resolution($url);
                    $idLink = 'wallpaper.php?id='.$wallpaper['id'];
                    // $pdo->query("UPDATE wallpapers SET resolution = '$resolution' WHERE id=$id");


                    echo "<div class='col'>";
                    echo "<a href='$idLink'><img src='$url' class='gallery-item' alt='gallery'></a>";
                    echo "<p>$name</p>";
                    echo "<p>$resolution</p>";
                    echo "</div>";
                }
            ?> 
        </div>

    </section>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

   