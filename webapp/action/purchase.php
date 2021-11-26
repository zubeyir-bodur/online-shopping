<?php
    include_once('../config/constants.php');
    include_once('session.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pid = $_POST['purchase'];
        $amount = $_POST['amt-purchased'];
        $query = "SELECT price, pname
        FROM product
        WHERE pid='" . $pid ."';";
        $prod = $conn->query($query)->fetch_array(MYSQLI_ASSOC);
        $price = $prod['price'];
        $pname = $prod['pname'];
        if ( $wallet_session >= $price * $amount) {
            $queryUpdateCustomer = "UPDATE customer
            SET wallet = wallet - '$price' * '$amount'
            WHERE cid='" . $id_session ."';";

            // amount input is valid by default, it is also forced to be an integer
            $queryUpdateProducts = "UPDATE product
            SET stock = stock -'$amount'
            WHERE pid='" . $pid ."';";

            //Check if the user owns any of the product
            $queryUpdateBuy = ";";
            $queryQuantity = "SELECT quantity FROM buy WHERE cid='". $id_session ."' and pid='". $pid ."';";
            $result = $conn->query($queryQuantity);
            if ($result->num_rows == 0 || $result->fetch_array(MYSQLI_ASSOC)['quantity'] == 0 ) {
                $queryUpdateBuy = "INSERT INTO buy(cid, pid, quantity) 
                            VALUES('" . $id_session . "', '" . $pid . "', '$amount');";
            } else {
                $queryUpdateBuy = "UPDATE buy
                SET quantity = quantity + '$amount'
                WHERE cid='". $id_session ."' and pid='". $pid ."';";
            }
            $conn->query($queryUpdateCustomer);
            $conn->query($queryUpdateProducts);
            $conn->query($queryUpdateBuy);
            $bill = $price * $amount;
            echo "<script>
                let amount = '$amount';
                let pname = '$pname';
                let bill = '$bill';
                let msg = 'You have successfully purchased ' + amount  + ' ' +  pname + '(s)' + ' for $' + bill;
                window.alert(msg);
                window.location.href = '../products.php';
            </script>";
        }
        else {
            echo "<script>
                window.alert('You have insufficient funds');
                window.location.href = '../products.php';
            </script>";
        }
    }
?>