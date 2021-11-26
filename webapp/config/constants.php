<?php
    const host = "localhost";
    const username = "root";
    const password = "";
    const dbname = "database_name";
    $conn = mysqli_connect(host, username, password) or die(mysqli_error());
    $db = mysqli_select_db($conn, dbname) or die(mysqli_error());
?>
