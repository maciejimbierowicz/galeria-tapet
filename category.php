<?php 
    require 'layout/header.php';
    require 'libs/functions.php';

    $categories = get_categories();
    $wallpaperCategory = $_GET['category'];
    $pdo = get_connection();

    $rows = change_category($wallpaperCategory);

    
?>


    <ul>
        <?php
        foreach($categories as $category){
            $categoryName = $category['name'];
            echo "<li><a href='category.php?category=$categoryName' type='button' class='category-button'>$categoryName</a></li>";
        }
        ?>
    </ul>

    <?php 

    
    $results_per_page = 5;
    $number_of_results = count($rows);

    $number_of_pages = ceil($number_of_results / $results_per_page);
    
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $starting_limit_number = ($page - 1)*$results_per_page;
    
    $sql = "SELECT * FROM wallpapers WHERE category= '$wallpaperCategory' LIMIT " . $starting_limit_number . ',' . $results_per_page;
   
    
    $pdo = get_connection();
    $result = $pdo->query($sql);
    $rows = $result->fetchAll();

    ?>

    <section class='gallery min-vh-100'> 
        <?php echo "<h1 style='text-align:center'>$wallpaperCategory</h1>"?>
        <div class='container-lg'>
        <div class='row gy-4 row-cols-1 row-cols-sm-3 row-cols-md-4'>
             <?php 
                foreach($rows as $wallpaper) {
                    $url = $wallpaper['url'];
                    $name = $wallpaper['name'];
                    $resolution = $wallpaper['resolution'];
                    $idLink = 'wallpaper.php?id='.$wallpaper['id'];

                    echo "<div class='col'>";
                    echo "<a href='$idLink'><img src='$url' class='gallery-item' alt='gallery'></a>";
                    echo "<p>$name</p>";
                    echo "<p>$resolution</p>";
                    echo "</div>";
                }
            ?> 
        </div>
        <?php 
        for ($page=1; $page<=$number_of_pages; $page++ ) {
            echo'<a href="category.php?category='. $wallpaperCategory . '&page=' .$page .'">' . $page . ' </a>';
        }?>

    </section>

<?php 
    require 'layout/footer.php';
?>
