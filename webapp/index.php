<?php
    if (session_status() == 2) {
        $_SESSION = array();
        session_destroy();
        session_abort();
    }
    else{
        include_once('partials/navbar.php');
    }
?>
            <!--
            Put login info here
            -->
            <div class="container-login" style="">
                <h2 class="header-my">Shop Now</h2>
                <form method="post" action="action/login.php">
                    <div class="form-group">
                        <input type="text" class="form-control login-input" name="username" id="username-login" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control login-input" name="cid" id="id-login" placeholder="ID" required>
                    </div>
                    <!--If this button is pressed, send inputs along with the form-->
                    <!--Check customer's wallet amount first. If available, execute the following process.-->
                    <!--The buy table should have a new row,
                        and product table's associated row should be inserted or deleted
                        and customer's wallet should be updated-->
                    <div id="error-id">Please check your credentials</div>
                    <button type='submit' name="log-in" class='btn btn-default btn-sm btn-primary' id='btn-login'>
                            Log in
                    </button>
                </form>
            </div>

<?php
    include_once('partials/footer.php');
?>