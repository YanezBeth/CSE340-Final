<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\navigation.php'; ?>
<article class="searching">
    <!--<h1>Content Title Here</h1>-->
    <h1><?php if (isset($pageTitle)) {
            echo $pageTitle;
        }
        //echo $invMake, $invModel; 
        ?></h1>

    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
    ?>

    <?php if (isset($searchInformation)) {
        echo $searchInformation;
    } ?>

</article>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\footer.php'; ?>