<?php
    session_start();
    require './partials/dbconnection.php';    


 // Getting ID of the category to display corresponding category data.
 if(isset($_GET['category-ID'])){
    $category_ID = $_GET['category-ID'];
}
else{
    // To display first category from db if user directly opens threadlist.php
    $category_ID = 1;
}


$SQL = "SELECT * FROM `categories` WHERE cat_ID = $category_ID";
$result = mysqli_query($connection, $SQL);

while($row = mysqli_fetch_assoc($result)){
    $category_title = $row['cat_title'];
    $category_desc = $row['cat_desc'];
}


 // Getting user ID of the logged in user:
 $thread_posted = false;
 $thread_empty = false;
if(isset($_SESSION['logged_in']) && !empty($_SESSION['username'])){
    $username = $_SESSION['username'];
    $SQL = "SELECT user_ID from `users` WHERE username = '$username'";
    $result = mysqli_query($connection, $SQL);
    while($row = mysqli_fetch_assoc($result)){
        $user_ID = $row['user_ID'];
    }

    // Post thread to threads table:
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $thread_title = $_POST['thread-title'];
        $thread_desc = $_POST['thread-desc'];
      if(!empty($thread_title) && !empty($thread_desc)){
        $SQL = "INSERT INTO threads (thread_title, thread_desc, thread_user_ID, thread_cat_ID) VALUES ('$thread_title', '$thread_desc', $user_ID, $category_ID)";
        $result = mysqli_query($connection, $SQL);
        
        if($result){
            $thread_posted = true;
        }
      }  
      else{
        $thread_empty = true;
      }
        
    }
}
    

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

 <?php
    // Show alert message if thread successfully posted to database
    if($thread_posted){
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
         <strong>Thread Posted!</strong> Your thread posted successfully! Please wait for the community to respond.
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>  
        ';
    }

    if($thread_empty){
        echo '
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
         <strong>Thread Empty! </strong> Thread title and description cannot be empty.
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>  
        ';
    }
?>



    <!-- hero for category -->
    <div class="container jumbotron-category">
        <h1>Welcome to <?php echo $category_title; ?> forums</h1>
        <p><?php echo $category_desc; ?></p>
        <hr>
        <h5>Forum Rules:</h5>
        <ul>
            <li>
                <p>Never post personal information about another forum participant.</p>
            </li>
            <li>
                <p>Don't post anything that threatens or harms the reputation of any person or organization.</p>
            </li>
            <li>
                <p>Don't post or link to inappropriate, offensive or illegal material.</p>
            </li>
        </ul>
        <a href="https://lni.us.engagementhq.com/forum-etiquette-moderation" class="btn btn-primary"
            target="_blank">Learn more</a>
    </div>

    <?php
    // show post thread container only if user is logged in
    if(isset($_SESSION['logged_in']) && !empty($_SESSION['username'])){
        echo '
            <div class="container post-thread-container" id="post-thread">
        <div class="row">
            <div class="col col-12 col-md-12 col-lg-6">
            <h2>Post a thread</h2>
        <form method="POST" action="'. $_SERVER['REQUEST_URI'] . '">
            <div class="d-flex flex-column align-items-start">
                <label for="thread-title">Thread title</label>
                <input type="text" name="thread-title" id="thread-title" maxlength="200" required>
            </div>
            <div class="d-flex flex-column align-items-start">
                <label for="thread-desc">Thread Description</label>
                <textarea name="thread-desc" id="thread-desc" rows="4" class="thread-textarea" required></textarea>
            </div>
            <button class="btn btn-sm btn-primary post-thread-btn" type="submit">Post thread</button>
        </form>
            </div>
            <div class="col col-12 col-md-12 col-lg-6 d-flex justify-content-center align-items-center ">
                <img src="./assets/images/post-thread-img.svg" alt="" width="300px">
            </div>
        </div>
    </div>    
        ';
    }
    else{
        echo '
        <div class="container">
        <p>Please login to post thread. Click the button below to login.</p>
        <a href="/syntaxwise/auth/login.php?category-path='. $_SERVER['REQUEST_URI'] .'#post-thread" class="btn btn-primary btn-sm">Login</a>
        </div>
        ';
    }
 ?>

    

    <div class="container my-5">
            <h2>Browse threads</h2>
            <div class="all-thread-div my-4">
                <!-- Threads -->

    <!-- Display all the threads related to the same category -->
     <?php
            $SQL = "SELECT * FROM threads WHERE thread_cat_ID = $category_ID ORDER BY thread_ID DESC";
            $result = mysqli_query($connection, $SQL);

            if(mysqli_num_rows($result) == 0){
                echo '
                <div class="my-3">
                <p>No threads yet, Be the first one to post thread on this category :)</p>
                </div>';
            }

            else{
                while($row = mysqli_fetch_assoc($result)){
                    echo '
                        <div class="d-flex thread my-3">
                        <div class="flex-shrink-0">
                            <img src="./assets/images/userdefault.png" alt="user image" width="34px">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <a href="/syntaxwise/thread.php?thread-ID='. $row['thread_ID'] .'" class="text-dark text-decoration-none"><h6>'. htmlspecialchars($row['thread_title']) .'</h6></a>
                            <p>'. htmlspecialchars(substr($row['thread_desc'], 0, 150)) .'... </p>
                            <div style="margin-top: -12px;">
                             <a href="/syntaxwise/thread.php?thread-ID='. $row['thread_ID'] .'" style="display: block; font-size: 0.8rem; margin-bottom: 0;">Read more</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    ';
                }
            }
    ?>

            </div>
    </div>


    <!-- Vanilla JS -->
    <script src="/syntaxwise/scripts/app.js"></script>
    <!-- Bootstrap script CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>