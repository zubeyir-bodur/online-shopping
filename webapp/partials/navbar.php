<?php
    include_once('config/constants.php');
    $displayNavbar = "";
    if (session_status() == PHP_SESSION_NONE) {
        $displayNavbar = "pointer-events:none; color:#212529;user-select:none";
    }
echo "
<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"utf-8\"/>
        <title></title>
    </head>
    <body>
        <nav class=\"navbar navbar-expand-lg navbar-dark bg-dark\">
            <div class=\"container-fluid\">
                <span class=\"text-light\">Online Shopping Web App</span>
                <button class=\"navbar-toggler\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
                    <span class=\"navbar-toggler-icon\"></span>
                </button>
                <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
                    <ul class=\"navbar-nav me-auto mb-2 mb-lg-0\" style='margin-left: 75%;'>
                        <!--Populate this area if the user is logged in
                            Products Link -> All users start here when they logged in
                            Profile Link
                            Log Out Link
                        -->
                        <li class=\"nav-item\">
                            <a id=\"Products\" style='$displayNavbar' class=\"nav-link active\" aria-current=\"page\" href='products.php'>Products</a>
                        </li>
                        <li class=\"nav-item\">
                            <a id=\"Profile\" style='$displayNavbar' class=\"nav-link active\" aria-current=\"page\" href='profile.php'>Profile</a>
                        </li>
                        <li class=\"nav-item\" >
                            <a id=\"Logout\" style='$displayNavbar' class=\"nav-link active\" aria-current=\"page\" href='action/logout.php'>Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class=\"container-fluid\" id=\"container-main\">";
?>

