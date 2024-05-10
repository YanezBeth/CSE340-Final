<?php
//check first if user is not logged in, then if their clientLevel is 1, if both are false go to vehicle-main.php, otherwise go home
if ($_SESSION['loggedin'] && $_SESSION['clientData']['clientLevel'] > 1) {
    //display page
} else {
    header('Location: /phpmotors/');
    exit;
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
   }
?><?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\navigation.php'; ?>

<article class="vehicle-list">
    <h1 class="vehicles">PHP Motors Vehicles</h1>
    <!-- Links to add classification and add vehicle -->
    <p class="add">
        <a href="/phpmotors/vehicles/?action=add-classification-view" title="Add a classification to PHP Motors" id="add-classification">Add
            Classification</a>
        <br><br>
        <a href="/phpmotors/vehicles/?action=add-vehicle-view" title="Add a vehicle to PHP Motors" id="add-vehicle">Add
            Vehicle</a>
    </p>

    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
    }
    if (isset($classificationList)) {
        echo '<h2>Vehicles By Classification</h2>';
        echo '<p>Choose a classification to see those vehicles</p>';
        echo $classificationList;
    }
    ?>
    <noscript>
        <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
    </noscript>
    <table id="inventoryDisplay"></table>



</article>

<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\footer.php'; ?>