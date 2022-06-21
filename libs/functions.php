<?php

function get_connection() {
    $config = require 'connect.php';
    return new PDO(
        $config['database_dsn'],
        $config['database_user'],
        $config['database_pass']
    );
}

function get_categories() {
    $pdo = get_connection();
    $categoriesResult = $pdo->query('SELECT * FROM categories');
    $categories = $categoriesResult->fetchAll();
    return $categories;
}

function change_category($category) {
    $pdo = get_connection();
    if ($category == "") {
        $sql = 'SELECT * FROM wallpapers';
    }
    else {
        $sql = "SELECT * FROM wallpapers WHERE category = '$category'";
    }
    $result = $pdo->query($sql);
    $rows = $result->fetchAll();
    return $rows;
}

function format_size($size) {
    $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    if ($size == 0) { return('n/a'); } else {
    return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]); }
}

function get_resolution ($img) {
    $imgsize_arr = getimagesize($img);
    $img_width = $imgsize_arr[0];
    $img_height = $imgsize_arr[1];
    return $img_width."x".$img_height;
}