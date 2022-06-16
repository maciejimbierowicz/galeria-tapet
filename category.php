<?php
require 'layout/header.php';
require 'libs/functions.php';

$categories = get_categories();
$wallpaperCategory = $_GET['category'];
$pdo = get_connection();

$rows = change_category($wallpaperCategory);


?>


<div class="category-button container">
        <div class="row">
        <div class="gallery col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1 class="gallery-title">Galeria Tapet</h1>
        </div>
        
        <div class="categories-container">
            <?php
            foreach ($categories as $category) {
                $categoryName = $category['name'];        
                echo "<a class='btn btn-sm filter-button' style='width: fit-content;' href='category.php?category=$categoryName' type='button' >$categoryName</a>";  
            }
            ?>
            </div>
        </div>
    </div>
<?php


$results_per_page = 5;
$number_of_results = count($rows);

$number_of_pages = ceil($number_of_results / $results_per_page);

if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

$starting_limit_number = ($page - 1) * $results_per_page;

$sql = "SELECT * FROM wallpapers WHERE category= '$wallpaperCategory' LIMIT " . $starting_limit_number . ',' . $results_per_page;


$pdo = get_connection();
$result = $pdo->query($sql);
$rows = $result->fetchAll();

?>

<section class='gallery'>
    <div class='container-fluid'>
        <?php echo "<h2 class='text-lg-start mt-4 mb-0'>$wallpaperCategory</h2>" ?>
        <hr class="mt-2 mb-5">
        <div class='row text-center text-lg-start photo-container'>
            <?php
            foreach ($rows as $wallpaper) {
                $url = $wallpaper['url'];
                $name = $wallpaper['name'];
                $resolution = $wallpaper['resolution'];
                $idLink = 'wallpaper.php?id=' . $wallpaper['id'];

                echo "<div class='col-lg-3 col-md-4 col-12 mb-5'>";
                echo "<a class='d-block h-60' href='$idLink'><img src='$url' class='img-fluid gallery-image' alt='gallery'></a>";
                echo <<<END
                    <div class="d-flex justify-content-between">
                    <span class="wallpaper-name">$name</span>
                        
                    </div>
                    END;
                echo "</div>";
            }
            ?>
        </div>
        <div class='page-container'>
            <?php
            $active_page = $page;
            if ($page != 1) {
                echo '<a class="page-navigation btn btn-primary" href="category.php?category=' . $wallpaperCategory . '&page=' . $active_page - 1 . '">' . 'Poprzednia Strona</a>';
            }
            for ($page = 1; $page <= $number_of_pages; $page++) {
                if ($active_page == $page) {
                    echo '<a class="paging-link" id="active" href="category.php?category=' . $wallpaperCategory . '&page=' . $page . '">' . $page . ' </a>';
                } else {
                    echo '<a class="paging-link" href="category.php?category=' . $wallpaperCategory . '&page=' . $page . '">' . $page . ' </a>';
                }
            }
            if ($active_page != $number_of_pages) {
                echo '<a class="page-navigation btn btn-primary" href="category.php?category=' . $wallpaperCategory . '&page=' . $active_page + 1 . '">' . 'Następna Strona</a>';
            }
            ?>
        </div>
</section>

<?php
require 'layout/footer.php';
?>