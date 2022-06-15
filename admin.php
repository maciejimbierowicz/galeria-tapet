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
            <a class='btn btn-default filter-button' href="list.php?list=wallpapers">Tapety</a>
            <a class='btn btn-default filter-button' href="list.php?list=categories">Kategorie</a>
            <a class='btn btn-default filter-button' href="list.php?list=users">Użytkownicy</a>
        </div>
    </div>
    <?php
    if (isset($_GET['list'])) {
        if ($list === 'wallpapers') {
            echo <<< END
                <div class="image-upload-form">
                    <form action="upload.php" 
                    method="post"
                    enctype="multipart/form-data">
                        <h3>Dodaj nową tapetę</h3>
                        <input type='file' name='my_image' required><br><br>
                        Nazwa:
                        <input type="text" name="wallpaper_name" required><br>
                        Opis:
                        <input type="text" name="description" required><br>
                        Kategoria:
                        <select  name="category" required>
                END;

            foreach ($categories as $category) {
                $category_name = $category['name'];
                echo "<option value=$category_name>$category_name</option>";
            }

            echo <<< END
                        </select><br><br>
                        <input class="btn btn-primary" type='submit' name='submit' value='Upload'>
                    </form>
                </div>
                END;
        } else if ($list === 'categories') {
            echo <<<END
                    <div class="category-form">
                        <form action="upload.php" method="post">
                        <h3>Dodaj nową kategorię</h3>
                            Nazwa kategorii:
                            <input type="text" name="newCategory" required><br>
                            <input class="btn btn-primary" type='submit' name='submitCategory' value='Dodaj kategorię'>
                        </form>
                    </div>
            END;
        } else if ($list === 'users') {
            echo <<<END
                        <div class="user-form">
                        <form action="upload.php" method="post">
                        <h3>Dodaj nowego użytkownika</h3>
                            Login:
                            <input type="text" name="login" required><br>
                            Hasło:
                            <input type="text" name="password" required><br>
                            <input class="btn btn-primary" type='submit' name='submitUser' value='Dodaj nowego użytkownika'>
                        </form>
                        </div>
            END;
        }
    }

    ?>


    <?php
    require 'layout/footer.php';
    ?>

</body>

</html>