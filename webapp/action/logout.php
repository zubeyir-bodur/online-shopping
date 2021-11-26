<?php
    if (session_status() != PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION = array();
    session_abort();
    echo "<script>
                        window.alert('Logout success!');
                        window.location.href='../index.php'
                    </script>";
?>