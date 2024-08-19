<?php
    $connection = mysqli_connect('localhost', 'root', '', 'syntaxwise');
    if(!$connection){
        echo 'Failed to connect to DB';
    }

?>