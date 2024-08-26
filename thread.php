<?php
session_start();
require './partials/dbconnection.php';

    //  Getting thread ID to display corresponding information
    if (isset($_GET['thread-ID'])) {
        $thread_ID = $_GET['thread-ID'];
    } else {
        // To display first thread from db if user directly opens thread.php
        $thread_ID = 1;
    }

    // Fetch and display thread
    $SQL = "SELECT * FROM `threads` WHERE thread_ID = $thread_ID";
    $result = mysqli_query($connection, $SQL);
    while ($row = mysqli_fetch_assoc($result)) {
        $thread_title = htmlspecialchars($row['thread_title']);
        $thread_desc = htmlspecialchars($row['thread_desc']);
        $thread_user_ID = $row['thread_user_ID'];
        $thread_created = $row['thread_created'];
    }

    // Fetch username from users table
    $fetchUser = "SELECT username from users WHERE user_ID = $thread_user_ID";
    $queryResult = mysqli_query($connection, $fetchUser);

    while ($row = mysqli_fetch_assoc($queryResult)) {
        $username = $row['username'];
    }

    // Getting user ID of the logged in user:
    $comment_posted = false;
    $comment_empty = false;
    if (isset($_SESSION['logged_in']) && !empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $SQL = "SELECT user_ID from `users` WHERE username = '$username'";
        $result = mysqli_query($connection, $SQL);
        while ($row = mysqli_fetch_assoc($result)) {
            $user_ID = $row['user_ID'];
        }

        // Post comment to thread_comments table:
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $comment_content = $_POST['comment-content'];
         if(!empty($comment_content)){
            $SQL = "INSERT INTO thread_comments (comment_content, comment_thread_ID, comment_user_ID) VALUES ('$comment_content', $thread_ID, $user_ID)";
            $result = mysqli_query($connection, $SQL);

            if ($result) {
                $comment_posted = true;
            }
         }
         else{
            $comment_empty = true;
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
    // Show alert message if comment successfully added to database
    if($comment_posted){
        echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
         <strong>Comment Added </strong> Your comment has been added! Check below.
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>  
        ';
    }

    if($comment_empty){
        echo '
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
         <strong>Comment Empty! </strong> Please fill up the comment box.
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>  
        ';
    }
?>

    <!-- Thread part goes here -->
    
    <div class="container thread-part my-5">
        <div class="thread-top-part">
            <h4>Q. <?php echo $thread_title; ?></h4>
            <h6 class="mt-3">Description:</h6>
            <p><?php echo $thread_desc; ?></p>
            <div class="d-flex justify-content-between align-items-center">
                <p class="thread-poster">By @<?php echo $username; ?></p>
                <p class="thread-date"><?php echo $thread_created; ?></p>
            </div>
        </div>
        <hr>

        <?php
        // Show comment section only if user is logged in
        if (isset($_SESSION['logged_in']) && !empty($_SESSION['username'])) {
            echo '
                <div class="thread-bottom-part">
            <h6>Reply to this thread</h6>
            <div class="thread-comment-div">
                <form action="' . $_SERVER['REQUEST_URI'] . '" method="POST" class="d-flex flex-column justify-content-center align-items-start gap-2">
                    <textarea name="comment-content" id="comment-content" rows="4" class="thread-textarea" required></textarea>
                    <button type="submit" class="btn btn-primary btn-sm add-comment">Comment</button>
                </form>
            </div>
        </div>   
            ';
        } else {
            echo '
        <div class="container">
        <p>Please login to reply to this thread</p>
        <a href="/syntaxwise/auth/login.php?thread-path=' . $_SERVER['REQUEST_URI'] . '" class="btn btn-primary btn-sm">Login</a>
        </div>
        ';
        }
        ?>

    </div>

    <!-- Discussions related to thread goes here -->
    <section class="thread-discussion-section container my-5">
        <h2>Discussions</h2>
        <div class="all-comments-div my-4">
            <!-- Comments -->
            <!-- Display all the comments related to the same thread -->
            <?php
            $SQL = "SELECT * FROM thread_comments, users WHERE thread_comments.comment_thread_ID = $thread_ID AND thread_comments.comment_user_ID = users.user_ID ORDER BY comment_ID DESC";
            $result = mysqli_query($connection, $SQL);

            if (mysqli_num_rows($result) == 0) {
                echo '
                <div class="my-3">
                <p>No comments yet, Be the first one to comment on this thread :)</p>
                </div>';
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <div class="d-flex thread my-3">
                        <div class="flex-shrink-0">
                            <img src="./assets/images/userdefault.png" alt="user image" width="34px">
                        </div   >
                        <div class="flex-grow-1 ms-3">
                        <div class="comment-top-part">
                            <h6 style="font-size: 0.95rem;">' . $row['username'] . '</h6>
                            <p style="font-size: 0.8rem;">' . $row['comment_date'] . '</p>
                        </div>
                            <p>' . htmlspecialchars($row['comment_content']) . '</p>
                        </div>
                    </div>
                    ';
                }
            }
            ?>
        </div>
    </section>



    <!-- Vanilla JS -->
    <script src="/syntaxwise/scripts/app.js"></script>
    <!-- Bootstrap script CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>