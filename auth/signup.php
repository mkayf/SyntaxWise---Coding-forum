<?php
  session_start();
  include '../partials/dbconnection.php';

  $user_exists = false;
  $pass_error = false;
  $data_inserted = false;
  $data_insertion_error = false;

  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Getting all the input fields value:
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Query to check if a user exists with similar username:
      $user_check_query = "SELECT `username` FROM  users WHERE `username` = '$username'";
      $user_result = mysqli_query($connection, $user_check_query);
      if(mysqli_num_rows($user_result) > 0){
        $user_exists = 'This account already exists! Please try with different username';
      }

      // Inserting data into tables if all things are clear.
      // user and password check: 
      if($user_exists == false){  // if the user doesn't exist then it will further proceed.
        if($password == $cpassword){
          
          $hashPass = password_hash($password, PASSWORD_DEFAULT);

          $SQL = "INSERT INTO users (`username`, `user_email`, `user_password`, `signupTime`) VALUES ('$username', '$email', '$hashPass', CURRENT_TIMESTAMP)";
          $insertResult = mysqli_query($connection, $SQL);

          if($insertResult){
            $data_inserted = 'Your account has been created successfully! <a href="./login.php">Login to continue.</a>';
          }
          else{
            $data_inserted = false;
            $data_insertion_error = true;
          }
        }
        else{
          $pass_error = 'Passwords do not match.';
        }
      }
  }

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup to SyntaxWise and be a part of cool developers</title>
    <!-- Favicon link -->
    <link rel="icon" type="image/x-icon" href="../assets/images/fav.ico">
    <!-- Boostrap link CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom link CDN -->
     <link rel="stylesheet" href="../styles/style.css">
     <!-- Fontawesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
  <body>
    <!-- navbar starts -->
    <?php require '../partials/navbar.php'   ?>
<!-- navbar ends -->

<!-- Alerts section goes here -->
 <?php
  if($user_exists){
    echo '  
      <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
  <strong>Error!</strong> '.$user_exists.'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    ';
  }

  if($pass_error){
    echo '
      <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
  <strong>Error! </strong> '.$pass_error.'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    ';
  }

  if($data_inserted){
    echo '
      <div class="alert alert-success alert-dismissible fade show border-0" role="alert">
  <strong>Success! </strong> '.$data_inserted.'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    ';
  }

  if($data_insertion_error){
    echo '
      <div class="alert alert-danger alert-dismissible fade show border-0" role="alert">
  <strong>Error! </strong>Some error occured while creating account. Please refresh the page and try again
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    ';
  }
 ?>
<!-- Alerts section ends here -->

<!-- signup form starts -->
 <div class="container my-5">
   <form class="form w-100 my-3 mx-auto" method="post">
    <h1 class="">Signup to Syntax<span style="color:#6EACDA;">Wise</span></h1>
    <div class="row">
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" id="username" name="username" required>
  </div>
  <div class="mb-3">
    <label for="emailAdd" class="form-label">Email address</label>
    <input type="email" class="form-control" id="emailAdd" aria-describedby="emailHelp" name="email" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" required autocomplete="">
  </div>
  <div class="mb-3">
    <label for="cpassword" class="form-label">Confirm Passowrd</label>
    <input type="password" class="form-control" id="cpassword" name="cpassword" required autocomplete="">
  </div>
  </div>
  <button type="submit" class="btn btn-primary">Signup</button>
  <button type="reset" class="btn btn-success">Reset form</button>
</form>
</div>
<!-- signup form ends -->

<!-- Vanilla JS  -->
<script src="/syntaxwise/scripts/app.js"></script>
<!-- Boostrap CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>