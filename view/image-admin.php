<?php if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
} ?><?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\navigation.php'; ?>
<!--<h1>Content Title Here</h1>-->
<h1><?php if (isset($pageTitle)) {
        echo $pageTitle;
    } ?></h1>

<h2>Add New Vehicle Image</h2>
<?php
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
} ?>

<form action="/phpmotors/uploads/" method="post" enctype="multipart/form-data">
    <label for="invItem">Vehicle</label>
    <?php echo $prodSelect; ?>
    <fieldset>
        <label>Is this the main image for the vehicle?</label><br>
        <label for="priYes" class="pImage">Yes</label>
        <input type="radio" name="imgPrimary" id="priYes" class="pImage" value="1"><br>
        <label for="priNo" class="pImage">No</label>
        <input type="radio" name="imgPrimary" id="priNo" class="pImage" checked value="0">
    </fieldset>
    <label>Upload Image:</label>
    <input type="file" name="file1">
    <input type="submit" class="regbtn" value="Upload">
    <input type="hidden" name="action" value="upload">
</form>

<hr>

<h2>Existing Images</h2>
<p class="error">If deleting an image, delete the thumbnail too and vice versa.</p>
<?php
if (isset($imageDisplay)) {
    echo $imageDisplay;
} ?>


<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\footer.php'; ?>