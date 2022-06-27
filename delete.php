<?php
session_start();
require 'libs/functions.php';

if (!isset($_SESSION['zalogowany'])) {
    header("Location: index.php");
}

$pdo = get_connection();

$item_id = $_GET['id'];
$item_table = $_GET['list'];
$table_list = ['categories', 'users', 'wallpapers'];

if (in_array($item_table, $table_list)) {
    $sql = "DELETE FROM $item_table WHERE id= :item_id";
    $result = $pdo->prepare($sql);
    $result->bindParam(':item_id', $item_id, PDO::PARAM_INT);
    $result->execute();
}

if ($item_table === 'wallpapers') {
    $_SESSION['success'] = "<span style='color: red'>Usunięto tapetę!</span>";
    header("Location: list.php?list=wallpapers");
} 
else if ($item_table === 'users') {
    $_SESSION['success'] = "<span style='color: red'>Usunięto użytkownika!</span>";
    header("Location: list.php?list=users");
} 
else if ($item_table === 'categories') {
    $_SESSION['success'] = "<span style='color: red'>Usunięto kategorię!</span>";
    header("Location: list.php?list=categories");
}