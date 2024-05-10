<?php
//if logged in, get data. If not, send to phpmotors home
if ($_SESSION['loggedin']) {
    $clientId = $_SESSION['clientData']['clientId'];
    $clientFirstname = $_SESSION['clientData']['clientFirstname'];
    $clientLastname = $_SESSION['clientData']['clientLastname'];
    $clientEmail = $_SESSION['clientData']['clientEmail'];
    $clientLevel = $_SESSION['clientData']['clientLevel'];
    //$comment = $_SESSION['clientData']['comment'];
    //$clientPassword = $_SESSION['clientData']['clientPassword'];
} else {
    header('Location: /phpmotors/');
}
?><?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\navigation.php'; ?>
<article class="admin">
    <h1><?php echo $clientFirstname . ' ' . $clientLastname ?></h1>
    <hr>
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
    }
    ?>

    <?php
    echo "<h2>You are logged in as:</h2>
        <p><ul class='userData'>
            <li>First Name: $clientFirstname</li>
            <li>Last Name: $clientLastname</li>
            <li>Email: $clientEmail</li>
        </ul></p>";
    ?>

    <p class="v-man">
        <a href="/phpmotors/accounts/?action=client-update-view" title="Update user account information with PHP Motors" id="acc-up">Update Account Information</a>
    </p>
    
    <?php
    //If the client level is greater than 1, show vehicle-main.php inside a <p>
    if ($clientLevel > 1) {
        echo "<br><hr><h2>Administrative Priviledges</h2>
        <p class='admin-veh'>Click Vehicle Managment below to add car classifications, add vehicles, modify vehicles, or to delete vehicles from PHP Motors inventory database.</p>
        <p class='v-man'>
        <a href='/phpmotors/vehicles/'>Vehicle Management</a>
        </p>";
    }
    ?>



</article>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\footer.php'; ?>