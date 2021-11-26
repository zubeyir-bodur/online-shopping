<?php
    include_once('../config/constants.php');
    include_once('session.php');
    if (isset($_POST['refund']) ) {
        $refund_pid = $_POST['refund-pid'];
        $refund_amount = $_POST['refund-amt'];
        // Check if the user has enough amount of that product
        $queryCheck = "SELECT pid, pname, quantity
                        FROM (WITH productsPurchased as(
        SELECT cid, pid, pname, price, quantity
                                            FROM buy INNER JOIN product USING(pid) )
                                        SELECT pid, pname, quantity
                                        FROM productsPurchased NATURAL JOIN customer
                                        WHERE cname='" . $login_session . "') as owned
                        WHERE pid = '$refund_pid' and quantity >= $refund_amount;";
        if (isset($conn) ) {
            $resultCheck = $conn->query($queryCheck);
            if( $resultCheck->num_rows == 1) {

                $row = $resultCheck->fetch_array(MYSQLI_ASSOC);
                $newQuant = $row['quantity'] - $refund_amount;
                $productName = $row['pname'];

                // calculate the refund money
                $queryRefundMoney = "SELECT pid, (price * $refund_amount) as refundedMoney, (stock + $refund_amount) as newStock 
                                    FROM product
                                    WHERE pid = '$refund_pid';";
                $resultProducts = $conn->query($queryRefundMoney);
                $row_resultProducts = $resultProducts->fetch_array(MYSQLI_ASSOC);
                $refundedMoney = $row_resultProducts['refundedMoney'];
                $newStock = $row_resultProducts['newStock'];

                // update wallet first
                $queryUpdateWallet = "UPDATE customer
                SET wallet = wallet + $refundedMoney
                WHERE cname='$login_session';";
                $conn->query($queryUpdateWallet);

                // update products table
                $queryUpdateProducts = "UPDATE product
                SET stock = stock + $refund_amount
                WHERE pid = '$refund_pid';";
                $conn->query($queryUpdateProducts);

                // decide whether the row from buy should be deleted or updated
                if ($newQuant == 0) {
                    // delete some rows
                    $queryDeleteFromBuy = "DELETE FROM buy 
                WHERE cid = '$id_session' and pid = '$refund_pid' and quantity = " . $refund_amount . ";";
                    $conn->query($queryDeleteFromBuy);
                    echo "<script>
                        let pname = '$productName';
                        let amount = '$refund_amount';
                        let msg = 'Your ' + amount + ' ' + pname + '(s)' + ' was refunded successfuly!';
                        window.alert(msg);
                        window.location.href='../profile.php'
                    </script>";
                }
                else if ($newQuant > 0) {
                    // update some rows
                    $queryUpdateBuy = "UPDATE buy
                    SET quantity = $newQuant
                    WHERE cid = '$id_session' and pid = '$refund_pid' and quantity > " . $refund_amount . ";";
                    $conn->query($queryUpdateBuy);
                    echo "<script>
                        window.alert('Refund success!');
                        window.location.href='../profile.php'
                    </script>";
                }
                else {
                    // display error message
                    //that quantity of that product is not owned by user
                    echo "<script>
                        window.alert('You own the product, however you are trying to refund more than you own');
                        window.location.href='../profile.php'
                    </script>";
                }
            } else {
                echo "<script>
                        window.alert('You don\'t own that product, therefore you can\'t request a refund');
                        window.location.href='../profile.php'
                    </script>";
            }
        }
    }
?>