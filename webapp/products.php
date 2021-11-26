<?php
    include_once('partials/navbar.php');
?>
            <div class="container-products">
            <?php
                include_once('action/session.php');
                echo "<script>
                        var navbar_links = document.getElementsByClassName('nav-link');
                        for (i = 0; i < navbar_links.length; i++)
                            navbar_links.item(i).setAttribute('style', 'none');
                    </script>";
                // simply select all products
                $queryProducts = "SELECT * FROM product WHERE stock > 0;";
                if (isset($conn)) {
                    $resultProducts = $conn->query($queryProducts);
                    echo "
                    <h1><br>Welcome $login_session!<br></h1>
                    <h4><br>Wallet Balance: <b>$$wallet_session</b></h4>";
                    echo "<h4><br>Products</h4>
                                <table class=\"table\" id='prodTable'>
                                    <thead>
                                        <tr>
                                            <th>Product ID</th>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Stocks</th>
                                            <th>Buy</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                    if ($resultProducts->num_rows == 0) {
                        echo "</tbody></table>
                        <p id='text-center'>There are currently no products in the market.</p>";
                    }
                    else {
                        $i = 0;
                        while ($row = $resultProducts->fetch_array(MYSQLI_NUM) ) {
                            // For each row in the output of the query, print a bootstrap table row
                            echo "<tr>
                                        <td>" . $row[0] . "</td>
                                        <td>" . $row[1] . "</td>
                                        <td>" . $row[2] . "</td>
                                        <td>" . $row[3] . " required>
                                                </div>
                                                <button type='submit' name='purchase' class='btn btn-default btn-sm btn-success btn-purchase' value='$row[0]' id='btn-purchase-$i'>
                                                    Purchase
                                                </button>
                                            </form>
                                        </td>
                                  </tr>";
                            $i++;
                            }
                        }
                        echo "</tbody></table>";
                    }
            ?>
            </div>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script LANGUAGE="JavaScript">
    $(document).ready( () => {
        console.log("ready");
        var numRows = $("#prodTable tr").length - 1;
        console.log(numRows);
        var btn_id = [];
        var in_id= [];
        for (let i = 0; i < numRows; i++) {
            btn_id.push("#btn-purchase-" + i);
            in_id.push("#input_purchase_amnt-" + i);
            $(btn_id[i]).click( (e) => {
                let row = ($("#prodTable tr"))[i + 1];
                let pid = row.cells[0].innerHTML;
                let amount = $(in_id[i]).val();
                var data =  {
                    pid: pid,
                    amount: amount
                }
                $.ajax( {
                   url: "action/purchase.php",
                   type: "POST",
                   data : data,
                    success: function() {
                       console.log("success");
                    }
                });
            });
        }
    });
</script>-->
<?php
    include_once('partials/footer.php');
?>
