<?php
require 'libs/functions.php';

if (!isset($_SESSION['zalogowany'])) {
    header("Location: index.php");
}

$pdo = get_connection();

$item_id = $_GET['id'];
$item_table = $_GET['list'];

$sql = "DELETE FROM $item_table WHERE id=$item_id";
$result = $pdo->query($sql);

echo "Succesfully deleted item";