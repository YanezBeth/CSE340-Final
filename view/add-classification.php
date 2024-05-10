<?php
//check first if user is not logged in, then if their clientLevel is 1, if both are false go to vehicle-main.php, otherwise go home
if ($_SESSION['loggedin'] && $_SESSION['clientData']['clientLevel'] > 1) {
    //display page
} else {
    header('Location: /phpmotors/');
    exit;
}
?><?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\navigation.php'; ?>

<article class="add-classification">
    <h1 class="add-classification-h1">Add Car Classification</h1>
    <p class="add-classification-p">
        *All fields are required
    </p>
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
    }
    ?>
    <div class="form-contain">
        <form action="/phpmotors/vehicles/" method="post">
            <div class="form-row">
                <div class="form-col-25">
                </div>
                <div class="form-col-75">
                    <span class="instructions">Classification names may not be longer than 30 characters</span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col-25">
                    <label for="classificationName">Classification Name: </label>
                </div>
                <div class="form-col-75">
                    <input id="classificationName" name="classificationName" type="text" pattern="^.{1,30}$" required autofocus>
                </div>
            </div>
            <div class="form-row">
                <input type="submit" name="submit" id="add-classification" value="Add Classification">
            </div>
            <input type="hidden" name="action" value="add-classification">
        </form>
    </div>

</article>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\footer.php'; ?>