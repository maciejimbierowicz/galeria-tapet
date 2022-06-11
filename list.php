<?php 
require 'layout/header.php';
require 'libs/functions.php';

$pdo = get_connection();
$list = $_GET['list'];
$results_per_page = 10;
$sql = "SELECT * FROM $list";
$result = $pdo->query($sql);
$rows = $result->fetchAll();

$number_of_results = count($rows);

$number_of_pages = ceil($number_of_results / $results_per_page);
    
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

$starting_limit_number = ($page - 1)*$results_per_page;
$sql = "SELECT * FROM $list LIMIT " . $starting_limit_number . ',' . $results_per_page;

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
        <?php 
        if ($list === 'wallpapers') {
            echo "<a class='btn btn-primary' href='admin.php?list=$list'>Dodaj nową tapetę</a>";
            } 
        
        else if ($list === 'categories') {
            echo "<a class='btn btn-primary' href='admin.php?list=$list'>Dodaj nową kategorię</a>";    
            } 
            else if ($list === 'users') {
            echo "<a class='btn btn-primary' href='admin.php?list=$list'>Dodaj nowego użytkownika</a>";    
            }?>
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
<?php 

for ($page=1; $page<=$number_of_pages; $page++ ) {
    echo'<a href="list.php?list='. $list . '&page=' .$page .'">' . $page . ' </a>';
    
}
            ?>
</div>




