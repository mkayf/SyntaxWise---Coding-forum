<?php

    $logged_in = false;
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
      // echo $_SESSION['username'];
      $logged_in = true;
  }

?>


<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/Syntaxwise/index.php">Syntax<span style="color : #6EACDA">Wise</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categories
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">HTML</a></li>
            <li><a class="dropdown-item" href="#">CSS</a></li>
            <li><a class="dropdown-item" href="#">JavaScript</a></li>
            <li><a class="dropdown-item" href="#">Python</a></li>
            <li><a class="dropdown-item" href="#">PHP</a></li>
            <li><a class="dropdown-item" href="#">C</a></li>
            <li><a class="dropdown-item" href="#">C++</a></li>
            <li><a class="dropdown-item" href="#">C#</a></li>
            <li><a class="dropdown-item" href="#">Java</a></li>
            <li><a class="dropdown-item" href="#">React.js</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">More categories</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>m
      <form class="d-flex" role="search">
        <input class="form-control me-2 search-field" type="search" placeholder="Search" aria-label="Search">
        <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>
      <div class="auth-btns mx-3">
        <?php
          if($logged_in){
            echo '
              <a href="/Syntaxwise/auth/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            ';    
          }
          else{
            echo '<a href="/Syntaxwise/auth/login.php"><i class="fa-solid fa-right-from-bracket"></i> Login</a>';
          }
        ?>
        <a href="/Syntaxwise/auth/signup.php"><i class="fa-solid fa-user"></i> Signup</a>
      </div>
    </div>
  </div>
</nav>