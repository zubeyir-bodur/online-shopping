<?php
    include('partials/navbar.php');
?>
            <div class="container-profile" style="width: 50%;margin: 0 auto;">
                <?php
                    include_once('action/session.php');
                    echo "<script>
                            var navbar_links = document.getElementsByClassName('nav-link');
                            for (i = 0; i < navbar_links.length; i++)
                                navbar_links.item(i).setAttribute('style', 'none');
                        </script>";
                    // Select-cname=login_user(CUSTOMER NIJ BUY NIJ PRODUCT)
                    // -> output table is the products which was purchased by logged in customer
                    $queryAssets = "WITH productsPurchased as( 
                                            SELECT cid, pid, pname, price, quantity
                                            FROM buy INNER JOIN product USING(pid) )
                                        SELECT pid, pname, price, quantity
                                        FROM productsPurchased NATURAL JOIN customer
                                        WHERE cname='" . $login_session . "';";
                    if (isset($conn)) {
                        $resultProducts = $conn->query($queryAssets);
                        echo "
                        <h1><br>Welcome $login_session!<br></h1>
                        <h4><br>Wallet Balance: <b>$$wallet_session</b></h4>
                        <div>
                            <form method='POST' action='action/deposit.php' class='align-center'>
                                <div class=\"form-group\">
                                    <input type=\"number\" name='deposit-amt' step='0.01' class=\"form-control\" id=\"input_deposit_amnt\" pattern=\"^\d*(\.\d{0,2})?$\" title='Two significant figures maximum' placeholder=\"Enter amount\" required>
                                </div>
                                <button type=\"submit\" name='deposit' class=\"btn btn-primary\" id=\"btn-deposit\">
                                    Deposit
                                </button>
                            </form>
                        </div>
                        <h4><br>Owned Products</h4>
                        <table class=\"table\">
                            <thead>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>";
                        if ($resultProducts->num_rows == 0) {
                            echo "<tbody><tr></tr></tbody></table>
                        <p id='text-center'>You don't have any products</p>";
                        }
                        else {
                            echo "
                            <tbody>";
                            while ($row = $resultProducts->fetch_array(MYSQLI_NUM) ) {
                                // For each row in the output of the query, print a bootstrap table row
                                echo "<tr>
                                    <td>" . $row[0] . "</td>
                                    <td>" . $row[1] . "</td>
                                    <td>" . $row[2] . "</td>
                                    <td>" . $row[3] . "</td>
                                  </tr>";
                            }
                            echo "</tbody></table>
                        <div>
                            <h5><br>Request a Refund</h5>
                            <form method='POST' action='action/refund.php'>
                                <div class=\"form-row row\">
                                    <div class=\"form-group col-md-2\">  
                                        <label for=\"input_refund_pid\">Product ID</label>
                                        <input type=\"text\" class=\"form-control\" name='refund-pid' id=\"input_refund_pid\" placeholder=\"P10X\" required>
                                    </div>
                                    <div class=\"form-group col-md-2\">
                                        <label for=\"input_refund_quantity\">Quantity</label>
                                        <input type=\"number\" name='refund-amt' step='1' min='1' class=\"form-control\" id=\"input_refund_quantity\" pattern=\"^[0-9]*$\" placeholder=\"0\" required>
                                    </div>
                                    <!--If this button is pressed, send it along with the form-->
                                    <!--Check the product id and quantity first. If quantity is available in customer, execute the follwowing process.-->
                                    <!--The buy table and product table's stocks/quantities should be updated 
                                        if buy's quantity is zero, delete row from buy 
                                        and customer's wallet should be updated (increase)-->
                                    <div class=\"form-group col-md-2\">
                                        <label style='color:white;user-select: none; pointer-events: none'>Refund</label>
                                        <button type=\"submit\" name='refund' class=\"btn btn-warning\" id=\"btn-refund\">
                                            Refund
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>";
                        }
                    }
                ?>
            </div>
<?php
    include_once('partials/footer.php');
?>

