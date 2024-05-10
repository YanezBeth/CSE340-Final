<!DOCTYPE html>
<html lang="en-us">

<head>
    <title>
        <?php if (isset($pageTitle)) {
            echo $pageTitle . ' | ';
        } ?> PHP Motors
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/phpmotors/css/motorStyle.css" media="screen">
</head>

<body>
    <div id="content">
        <header>
            <div class="logo-img">
                <img src="/phpmotors/images/site/logo.png" alt="php motors logo">
            </div>
            <div class="my-account">
                <!--My Account-->
                <?php /*if (isset($cookieFirstname)) {
                    echo "<span class='cookieFname'>Welcome, $cookieFirstname</span>";
                } */
                if (isset($_SESSION['loggedin'])) {
                    echo '<a href="/phpmotors/accounts/">Welcome, ' . $_SESSION['clientData']['clientFirstname'] . '</a>';
                    echo '  |  ';
                    echo '<a href="/phpmotors/accounts/?action=logout" title="Logout from PHP Motors" id="logout">Logout</a>';
                } else {
                    echo '<a href="/phpmotors/accounts/?action=login-view" title="Login or Register with PHP Motors" id="acc">My Account</a>';
                }
                ?>

                <a href="/phpmotors/search/?action=search-view" title="Search PHP Motors"><img src="/phpmotors/images/site/icons8-magnifying-glass-64.png" alt="search icon"></a>


            </div>
        </header>