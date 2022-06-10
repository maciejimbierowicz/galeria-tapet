<?php 
require 'layout/header.php';
require 'libs/functions.php';

$pdo = get_connection();
$list = $_GET['list'];
$sql = "SELECT * FROM $list";
$result = $pdo->query($sql);
$rows = $result->fetchAll();
?>
<div class="admin-menu">
            <ul>
                <li><a href="list.php?list=wallpapers">Tapety</a></li>
                <li><a href="list.php?list=categories">Kategorie</a></li>
                <li><a href="list.php?list=users">Użytkownicy</a></li>
            </ul>
        </div>
        <div class='table'>
<table class="styled-table">
    <thead>
        <tr>
            <th>id</th>
            <th>Data dodania</th>
            <th>Nazwa</th>
            <th>Operacje</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach ($rows as $row) {
            $id = $row['id'];
            $name = $row['name'];
            $item_date = $row['date'];

            echo "<tr>";
            echo "<td>$id</td>";
            echo "<td>$item_date</td>";
            echo "<td>$name</td>";
            echo "<td>
                <div class='btn-group'>
                    <a class='btn btn-secondary action-button' href='edit.php?id=$id&list=$list'>Edytuj</a>
                    <a class='btn btn-danger action-button' href='delete.php?id=$id&list=$list'>Usuń</a>
                    </div>
                    </td>";
            echo "</tr>";
        }
        
        ?>
    </tbody>
</table>
</div>




