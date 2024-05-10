<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\navigation.php'; ?>
<article class="registration">
    <h1 class="reg-user">Register New User</h1>
    <p class="reg-p">
        *All fields are required to register an account with PHP Motors
    </p>
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
    }
    ?>
    <div class="form-contain">
        <form action="/phpmotors/accounts/" method="post">
            <div class="form-row">
                <div class="form-col-25">
                    <label for="clientFirstname">First Name:</label>
                </div>
                <div class="form-col-75">
                    <input name="clientFirstname" id="clientFirstname" type="text" <?php if (isset($clientFirstname)) {
                                                                                        echo "value='$clientFirstname'";
                                                                                    } ?> required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col-25">
                    <label for="clientLastname">Last Name:</label>
                </div>
                <div class="form-col-75">
                    <input name="clientLastname" id="clientLastname" type="text" <?php if (isset($clientLastname)) {
                                                                                        echo "value='$clientLastname'";
                                                                                    } ?> required>
                </div>
            </div>
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
                <input type="submit" name="submit" id="regbtn" value="Register">
                <!-- Add the action name & value pair -->
                <input type="hidden" name="action" value="register-user">
            </div>
        </form>
    </div>

</article>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\footer.php'; ?>