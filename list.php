<?php 
require 'layout/header.php';
require 'libs/functions.php';

if (!isset($_SESSION['zalogowany'])) {
    header("Location: index.php");
}

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
            <div>
                <a class='btn btn-sm filter-button' href="list.php?list=wallpapers">Tapety</a>
                <a class='btn btn-sm filter-button' href="list.php?list=categories">Kategorie</a>
                <a class='btn btn-sm filter-button' href="list.php?list=users">Użytkownicy</a>
</div>
        </div>
        <?php 
        if ($list === 'wallpapers') {
            echo "<a class='btn btn-primary add-button' href='admin.php?list=$list'>Dodaj nową tapetę</a>";
            } 
        
        else if ($list === 'categories') {
            echo "<a class='btn btn-primary add-button' href='admin.php?list=$list'>Dodaj nową kategorię</a>";    
            } 
            else if ($list === 'users') {
            echo "<a class='btn btn-primary add-button' href='admin.php?list=$list'>Dodaj nowego użytkownika</a>";    
            }?>
        <div class='container'>
            <div class="row cold-md-offset-2 custyle justify-content-center col-auto">
<!-- <table class="styled-table"> -->
    <table class="table table-responsive custab styled-table">
    <thead>
        <tr>
            <th>id</th>
            <th>Data dodania</th>
            <th>Nazwa</th>
            <th class="text-center" >Operacje</th>
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
                <div class='btn-group text-lg-start'>
                    <a class='btn btn-sm btn-secondary action-button' style='width: fit-content' href='edit.php?id=$id&list=$list'>Edytuj</a>
                    <a class='btn btn-sm btn-danger action-button' style='width:fit-content' href='delete.php?id=$id&list=$list'>Usuń</a>
                    </div>
                    </td>";
            echo "</tr>";
        }
        
        ?>
    </tbody>
</table>

</div>
<div class='page-container'>
<?php
$active_page = $page;
if ($page != 1) {
    echo '<a class="page-navigation btn btn-primary" href="list.php?list=' . $list . '&page=' . $active_page - 1 . '">' . 'Poprzednia Strona</a>';
}
for ($page=1; $page<=$number_of_pages; $page++ ) {
    if ($active_page == $page) {
        echo'<a class="paging-link" id="active" href="list.php?list='. $list . '&page=' .$page .'">' . $page . ' </a>';
    } 
    else {
        echo'<a class="paging-link" href="list.php?list='. $list . '&page=' .$page .'">' . $page . ' </a>';
        }
}
if ($active_page != $number_of_pages) {
    echo '<a class="page-navigation btn btn-primary" href="list.php?list=' . $list . '&page=' . $active_page + 1 . '">' . 'Następna Strona</a>';
}
            ?>
</div>
</div>

<?php 
require 'layout/footer.php';
?>


