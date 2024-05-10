<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\navigation.php'; ?>
<article class="search">
    <h1 class="searching">PHP Motors Search</h1>
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
    }
    ?>

    <div class="form-contain">
        <form action="/phpmotors/search/" method="get">
            <div class="form-row">
                <div class="form-col-25">
                </div>
                <div class="form-col-75">
                    <span class="instructions"></span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col-25">
                    <label for="searchWord">Search: </label>
                </div>
                <div class="form-col-75">
                    <input id="searchWord" name="searchWord" type="text" required autofocus>
                </div>
            </div>
            <div class="form-row">
                <input type="submit" name="submit" id="search" value="Search">
            </div>
            <input type="hidden" name="action" value="search">
        </form>
    </div>

</article>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\footer.php'; ?>