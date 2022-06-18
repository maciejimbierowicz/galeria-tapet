<?php
require 'layout/header.php';
require 'libs/functions.php';

if (!isset($_SESSION['zalogowany'])) {
    header("Location: index.php");
}

$categories = get_categories();
if (isset($_GET['list'])) {
    $list = $_GET['list'];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>
    <div class="admin-menu">
        <div>
                <a class= '<?php if ($list == 'wallpapers') {echo "active-class ";} ?>btn btn-sm filter-button' href="list.php?list=wallpapers">Tapety</a>
                <a class='<?php if ($list == 'categories') {echo "active-class ";} ?>btn btn-sm filter-button' href="list.php?list=categories">Kategorie</a>
                <a class='<?php if ($list == 'users') {echo "active-class ";} ?>btn btn-sm filter-button' href="list.php?list=users">Użytkownicy</a>
        </div>
    </div>
    <?php
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
        } else if ($list === 'categories') {
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
        } else if ($list === 'users') {
            echo <<<END
                        <div class="upload-form">
                        <form action="upload.php" method="post">
                        <h3>Dodaj nowego użytkownika</h3>
                            <p>Login:</p>
                            <input type="text" name="login" required><br>
                            <p>Hasło:</p>
                            <input type="text" name="password" required><br>
                            <input class="btn btn-primary" type='submit' name='submitUser' value='Dodaj użytkownika'>
                        </form>
                        </div>
                        <a href='list.php?list=users'>Powrót do listy użytkowników</a>
            END;
        }
    echo "</div>";
    }

    ?>



    <?php
    require 'layout/footer.php';
    ?>

</body>

</html>