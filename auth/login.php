<?php
  include '../partials/dbconnection.php';

  $loginFailed = false;
  $loginMsg = '';
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $SQL = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $SQL);
    $loginRecords = mysqli_num_rows($result);

    
    if($loginRecords == 1){

      while($row = mysqli_fetch_assoc($result)){
        if(password_verify($password, $row['user_password'])){
            session_start();
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $row['username'];
            $loginFailed = false;
            header('location:../index.php');
        }
        else{
          $loginFailed = true;
          $loginMsg = 'Invalid Credentials.';    
        }
      }     
    }
    else{
      $loginFailed = true;
      $loginMsg = 'Invalid Credentials.';
    }
  }

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login to Syntax<span style="color:#6EACDA">Wise</span></title>
    <!-- Favicon link -->
    <link rel="icon" type="image/x-icon" href="../assets/images/fav.ico">
    <!-- Bootstrap link CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/syntaxwise/styles/style.css">
    <!-- Fontawesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body>
    <!-- navbar -->
     <?php require '../partials/navbar.php';?>
    <!-- navbar -->

     <!-- alert -->
      <?php 
        if($loginFailed){
          echo '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong></strong> '.$loginMsg.'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
          ';
        }
      ?>
     <!-- alert -->

    <!-- login form starts here -->
  <div class="container my-5">
   <form class="form w-100 my-3 mx-auto" method="post">
    <h1 class="">Login to Syntax<span style="color:#6EACDA;">Wise</span></h1>
    <div class="row">
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" id="username" name="username" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" required autocomplete="">
  </div>
</div>
  <button type="submit" class="btn btn-primary">Login</button>
  <button type="reset" class="btn btn-success">Reset form</button>
</form>
</div>
<!-- login form ends here -->
 <!-- Boostrap script CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- Vanilla JS -->
 <script src="/syntaxwise/scripts/app.js"></script>
  </body>
</html>