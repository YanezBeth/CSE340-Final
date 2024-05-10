<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\navigation.php'; ?>
<!--<h1>Content Title Here</h1>-->
<h1><?php if (isset($pageTitle)) {
        echo $pageTitle;
    } ?></h1>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\footer.php'; ?>