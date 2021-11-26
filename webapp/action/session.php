<?php
if (file_exists('config/constants.php'))
    include_once('config/constants.php');
    session_start();
if (session_status() == PHP_SESSION_ACTIVE) {
    $user_check = $_SESSION["login_user"];
    $query = "SELECT cid, cname, wallet, bdate, address, city FROM customer WHERE cname = '$user_check'";
    $result = $conn->query($query);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $id_session = $row['cid'];
    $login_session = $row['cname'];
    $wallet_session = $row['wallet'];
    $bdate_session = $row['bdate'];
    $address_session = $row['address'];
    $city_session = $row['city'];
    if ( !isset($_SESSION['login_user'] ) )
        header("location: index.php");
}