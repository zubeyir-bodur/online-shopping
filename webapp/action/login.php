<?php
include_once('../config/constants.php');
session_start();
if (isset($_POST['log-in'])) {
    if ($conn != null)
        logIn($conn);
}
function logIn($mysqli) {
    $username = $_POST['username'];
    $cid = $_POST['cid'];
    $usernameLower = strtolower($username);
    $query = "SELECT cname, cid FROM customer WHERE cid = '". $cid . "';";
    $result = $mysqli->query($query);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $db_username = $row['cname'];
    $db_usernameLower = strtolower($db_username);
    if ($result->num_rows > 1) {
        // Prevent sql injection
        echo "<script>
                        window.alert('!!!!!!YOU HAVE COMMITTED AN SQL INJECTION!!!!!');
                        window.location.href='../index.php'
                    </script>";
    }
    else if ($result->num_rows == 1) {
        if ( $db_usernameLower == $usernameLower) {
            // Save username and customer id through the session
            $_SESSION['login_user'] = $row['cname'];
            $_SESSION['login_id'] = $row['cid'];
            // Open their welcome page, a.k.a. products.php
            echo "<script>
                        window.alert('Login success!');
                        window.location.href='../products.php'
                    </script>";
        }
        else {
            // Credentials were wrong, then go back to index.php
            echo "<script>
                        window.alert('Please check your credentials');
                        window.location.href='../index.php'
                    </script>";
        }
    }
    else if ($result->num_rows == 0) {
        // Credentials were wrong, then go back to index.php
        echo "<script>
                        window.alert('Please check your credentials');
                        window.location.href='../index.php'
                    </script>";
    }
}