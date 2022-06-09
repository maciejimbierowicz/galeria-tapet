<?php
require 'libs/functions.php';

$pdo = get_connection();


if (isset($_POST['submit']) && isset($_FILES['my_image'])) {
    $img_name = $_FILES['my_image']['name'];
    $img_size = $_FILES['my_image']['size'];
    $tmp_name = $_FILES['my_image']['tmp_name'];

    $wallpaper_name = $_POST['wallpaper_name'];
    $wallpaper_description = $_POST['description'];
    $upload_date = date("Y-m-d H:i:s");
    $wallpaper_size = format_size($img_size);
    $wallpaper_category = $_POST['category'];

    $error = $_FILES['my_image']['error'];
    if($error === 0) {
        if($img_size > 125000) {
            $em = "Sorry, your file is too large";
            header("Location: index.php?error=$em");
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
			$img_ex_lc = strtolower($img_ex);

			$allowed_exs = array("jpg", "jpeg", "png"); 
            
            if (in_array($img_ex_lc, $allowed_exs)) {
				$new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
				$img_upload_path = 'img/'.$new_img_name;
				move_uploaded_file($tmp_name, $img_upload_path);
                $img_resolution = get_resolution($img_upload_path);

                $sql = "INSERT INTO wallpapers
                VALUES (null, '$wallpaper_name','$wallpaper_category','$wallpaper_description','$img_resolution','$wallpaper_size','$img_upload_path','$upload_date')";
                $rows = $pdo->query($sql);
				echo "Succesfully uploaded!";
			} 
            else {
				$em = "You can't upload files of this type";
		        header("Location: index.php?error=$em");
			}
        
        }
    } else {
        $em = "Unknown error occured!";
        header("Location: index.php?error=$em");
    }

} else {
    echo "cos nie dziala";
}


if (isset($_POST['submitCategory']) && isset($_POST['newCategory'])) {
    $category_name = $_POST['newCategory'];
    $sql = "INSERT INTO categories
                VALUES (null, '$category_name')";
                $rows = $pdo->query($sql);
				echo "Succesfully added new category!";
} else {
    echo "cos nie dziala";
}

if (isset($_POST['submitUser']) && isset($_POST['login'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $join_date = date("Y-m-d H:i:s");
    $sql = "INSERT INTO users VALUES (null, '$login', '$password', '$join_date')";
                $rows = $pdo->query($sql);
				echo "New user added!";
} else {
    echo "cos nie dziala";
}
