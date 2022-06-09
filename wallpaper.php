<?php 
    require 'libs/functions.php';
    session_start();

    
    $itemID = $_GET['id'];
    
    $pdo = get_connection();

    $result = $pdo->query("SELECT * FROM wallpapers WHERE id=$itemID");
    $item = $result->fetch();

    $url= $item['url'];
    $name = $item['name'];
    $resolution = $item['resolution'];
    $description= $item['description'];


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Galeria Tapet</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="css/styles.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>

        
    </head>
    <body>
    <h1>Tapeta</h1>
    <section class="product-section">
        <div class="row">
            <div class="col-lg-5 col-md-12 col-12">
                <?php echo "<img style='width: 30%' src='$url' alt=''>" ?>
            </div>
            <div>
            <?php echo "<p>$resolution</p>";
                 echo "<p>$description</p>";
                 echo "<p>$name</p>"; 
                //  echo "<a href=download.php?file='$url'>Download</a>"; 
                 echo "<a type='button' class='btn btn-primary' href='$url' download>Pobierz</a>"; 
                 ?>
            </div>
        </div>
    </section>
<? require 'layout/footer.php';?>
</body>
</html>
