<?php 
require 'libs/functions.php';
require 'layout/header.php';
$pdo = get_connection();
$categories = get_categories();
$list = $_GET['list'];
$id = $_GET['id'];
$sql = "SELECT * FROM $list WHERE id=$id";
$result = $pdo->query($sql);
$item = $result->fetch();

$item_name = $item['name'];




if ($list === 'wallpapers') {
    $item_description = $item['description'];
    $item_category = $item['category'];

    echo <<< END
    <div class="image-upload-form">
        <form action="edit_submit.php?id=$id" 
        method="post"
        enctype="multipart/form-data">
            <h3>Edytuj tapetę</h3>
            Nazwa:
            <input type="text" name="wallpaper_name" value='$item_name' required><br>
            Opis:
            <input type="text" name="description" value='$item_description' required><br>
            Kategoria:
            <select  name="category" value='$item_category' required> 
    END; 

    foreach ($categories as $category) {
        $category_name = $category['name'];
        echo "<option value=$category_name>$category_name</option>";
    }

    echo <<<END
            </select><br><br>
            <input class="btn btn-primary" type='submit' name='submit' value='Upload'>
            </form>
        </div> <hr> 
    END;}

else if ($list === 'users') {

    $item_password = $item['password'];
    echo <<<END
        <div class="user-form">
            <form action="edit_submit.php?id=$id" method="post">
                <h3>Edytuj użytkownika</h3>
                Login:
                <input type="text" name="login" value='$item_name' required><br>
                Hasło:
                <input type="text" name="password" $item_password required><br>
                <input class="btn btn-primary" type='submit' name='submitUser' value='Dodaj nowego użytkownika'>
            </form>
        </div> <hr>
    END;
    }

else if ($list === 'categories') {
    echo <<<END
        <div class="category-form">
            <form action="edit_submit.php?id=$id" method="post">
                <h3>Edytuj kategorię</h3>
                Nazwa kategorii:
                <input type="text" name="newCategory" value='$item_name' required><br>
                <input class="btn btn-primary" type='submit' name='submitCategory' value='Dodaj kategorię'>
            </form>
        </div> <hr>
    END;
    } 

else {
    header("Location: index.php");
}