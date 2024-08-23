<?php
    session_start();
    require './partials/dbconnection.php';    


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SyntaxWise - Tech forum</title>
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="./styles/style.css">
    <!-- Favicon link -->
    <link rel="icon" type="image/x-icon" href="./assets/images/fav.ico">
    <!-- Bootstrap link CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Fontawesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Navbar -->
    <?php include './partials/navbar.php' ?>
    <!-- Navbar -->

    <!-- Hero section -->
    <section class="hero-section">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col col-12 col-md-7 col-lg-7 hero-content-div">
                    <h1>Join the Ultimate Tech Community</h1>
                    <h5>Connect, Collaborate, and Code with Developers Worldwide.</h5>
                    <p>Our tech forum is a space where developers of all levels come together to share knowledge, solve
                        problems, and grow their skills. Whether you're a beginner or a pro, you'll find valuable
                        discussions, tutorials, and resources to help you on your coding journey.</p>
                    <div class="hero-btns">
                        <a href="#" class="btn btn-primary btn-sm">Post Thread</a>
                        <a href="#" class="btn btn-secondary btn-sm">About us</a>
                    </div>
                </div>
                <div class="col col-12 col-md-5 col-lg-5 hero-image-div">
                    <img src="./assets/images/hero-img.svg" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- Hero section -->

    <!-- Categories section -->
    <section class="categories-section my-5">
        <h1 class="text-center">Explore Categories</h1>
        <p class="text-center">Explore all the language and framework categories and learn about the upcoming tech
            future.</p>
        <div class="container my-5">
            <div class="row d-flex justify-content-center align-items-center">
                <!-- Fetch and iterate all the categories here -->
                <?php
                $SQL = 'SELECT * FROM `categories`';
                $result = mysqli_query($connection, $SQL);

                if($result){
                    while($row = mysqli_fetch_assoc($result)){
                         echo "
                        <div class='card col col-12 col-md-6 col-lg-4 px-1 py-2 border-0 category-card'>
                    <img src='". $row['category_img'] ."' class='card-img-top' alt='category-image'>
                    <div class='card-body'>
                        <h5 class='card-title'>". $row['cat_title'] ."</h5>
                        <p class='card-text'>". substr($row['cat_desc'], 0, 90) ."...</p>
                        <a href='/syntaxwise/threadlist.php?category-ID=". $row['cat_ID'] ."' class='btn btn-primary btn-sm'>Explore Category</a>
                    </div>
                </div>      
                        ";
                    }
                }
             ?>
                

            </div>
        </div>
    </section>
    <!-- Categories section -->




    <!-- Vanilla JS -->
    <script src="/syntaxwise/scripts/app.js"></script>
    <!-- Bootstrap script CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>