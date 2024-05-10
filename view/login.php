<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\navigation.php'; ?>
<article class="login">
    <h1 class="log-user">PHP Motors Login</h1>
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
    }
    ?>
    <div class="form-contain">
        <form action="/phpmotors/accounts/" method="post">
            <div class="form-row">
                <div class="form-col-25">
                    <label for="clientEmail">Email Address:</label>
                </div>
                <div class="form-col-75">
                    <input name="clientEmail" id="clientEmail" type="email" <?php if (isset($clientEmail)) {
                                                                                echo "value='$clientEmail'";
                                                                            } ?> required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col-25">
                </div>
                <div class="form-col-75">
                    <span class="instructions">Passwords must be at least 8 characters and contain at least 1 number, 1 capital, and 1 special character</span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col-25">
                    <label for="clientPassword">Password:</label>
                </div>
                <div class="form-col-75">
                    <input name="clientPassword" id="clientPassword" type="password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
                </div>
            </div>
            <div class="form-row">
                <input type="submit" name="submit" id="logbtn" value="Login">
                <!-- Add the action name & value pair -->
                <input type="hidden" name="action" value="login-user">
            </div>
        </form>
    </div>
    <p class="reg-now">
        Don't have an account with PHP Motors? <br><br>
        <a href="/phpmotors/accounts?action=registration-view" title="Register new account with PHP Motors" id="reg">Register
            Now
        </a>
    </p>
</article>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\footer.php'; ?>