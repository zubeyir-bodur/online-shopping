<?php
    include_once('../config/constants.php');
    include_once('session.php');
    if (isset($_POST['deposit']) ) {
        $deposit_amt = $_POST['deposit-amt'];
        $query = "UPDATE customer
        SET wallet = wallet + $deposit_amt
        WHERE cid = '" . $id_session . "';";
        $conn->query($query);
        echo "<script>
                        window.alert('You have successfuly deposited $$deposit_amt');
                        window.location.href='../profile.php'
                    </script>";
    }
?>