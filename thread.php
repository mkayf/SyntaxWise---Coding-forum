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

<!-- Thread part goes here -->
 <?php
//  Getting thread ID to display corresponding information
    if(isset($_GET['thread-ID'])){
        $thread_ID = $_GET['thread-ID'];
    }
    else{
        // To display random thread from db if user directly opens thread.php
        $SQL = "SELECT * FROM `threads`";
        $result = mysqli_query($connection, $SQL);
        $totalThreads = mysqli_num_rows($result);
        $thread_ID = rand(1, $totalThreads);
    }

        // Fetch and display thread
        $SQL = "SELECT * FROM `threads` WHERE thread_ID = $thread_ID";
        $result = mysqli_query($connection, $SQL);
        while($row = mysqli_fetch_assoc($result)){  
            $thread_title = $row['thread_title'];
            $thread_desc = $row['thread_desc'];
            $thread_user_ID = $row['thread_user_ID'];
            $thread_created = $row['thread_created'];
        }

        // Fetch username from users table
        $fetchUser = "SELECT username from users WHERE user_ID = $thread_user_ID";
        $queryResult = mysqli_query($connection, $fetchUser);

        while($row = mysqli_fetch_assoc($queryResult)){
            $username = $row['username'];
        }


 ?>
    <div class="container thread-part my-5">
        <div class="thread-top-part">
            <h4>Q. <?php echo $thread_title;?></h4>
            <h6 class="mt-3">Description:</h6>
            <p><?php echo $thread_desc;?></p>
            <div class="d-flex justify-content-between align-items-center">
                <p class="thread-poster">By @<?php echo $username; ?></p>
                <p class="thread-date"><?php echo $thread_created;?></p>
            </div>
        </div>
        <hr>
        <div class="thread-bottom-part">
            <h6>Reply to this thread</h6>
            <div class="thread-comment-div">
                <form method="POST" class="d-flex flex-column justify-content-center align-items-start gap-2">
                    <textarea name="thread-comment" id="thread-comment" rows="4" class="thread-textarea"></textarea>
                    <button type="submit" class="btn btn-primary btn-sm add-comment">Comment</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Discussions related to thread goes here -->
    <section class="thread-discussion-section container my-5">
        <h2>Discussions</h2>
    </section>



    <!-- Vanilla JS -->
    <script src="/syntaxwise/scripts/app.js"></script>
    <!-- Bootstrap script CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>