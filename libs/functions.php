<?php


function get_connection() {
    /* 
    * Connects to MySQL database
    *
    * @return object -> MySQL database configuration
    */

    $config = require 'connect.php';
    return new PDO(
        $config['database_dsn'],
        $config['database_user'],
        $config['database_pass']
    );
}


function change_category($pdo, $category) {
    /* 
    *Returns a list of given category images
    *
    *@param object $pdo -> MySQL database connection
    *@param string $category -> category name 
    *@return array -> list of images 
    */

    $sql = "SELECT * FROM wallpapers WHERE category = :category";
    $result = $pdo->prepare($sql);
    $result->bindParam(':category', $category, PDO::PARAM_STR);
    $result->execute(); 
    $rows = $result->fetchAll();
    
    return $rows;
}



function format_size($size) {
    /* 
    *Returns a formatted image size
    *
    *@param int $size -> size of an image in bytes
    *@return string -> formatted image size
    */

    $sizes = [" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB"];
    if ($size == 0) { return('n/a'); } else {
    return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]); }
}

function get_resolution ($img) {
    /* 
    *Returns given image resolution
    *
    *@param $img -> image
    *@return string -> formatted resolution
    */

    $imgsize_arr = getimagesize($img);
    $img_width = $imgsize_arr[0];
    $img_height = $imgsize_arr[1];
    return $img_width."x".$img_height;
}