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
    //Display page
} else {
    header('Location: /phpmotors/');
}
?><?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\navigation.php'; ?>
<article class="up-client">
    <h1><?php if (isset($pageTitle)) {
            echo $pageTitle;
        } ?></h1>


    <h2>Account Update</h2>
    <p class="up-client-p">
        *All fields are required to update client information
    </p>
    <!--error or success message if needed -->
    <?php if (isset($_SESSION['message'])) {
        echo $_SESSION['message-update'];
    } ?>
    <div class="form-contain">
        <form action="/phpmotors/accounts/" method="post">
            <div class="form-row">
                <div class="form-col-25">
                    <label for="clientFirstname">First Name:</label>
                </div>
                <div class="form-col-75">
                    <input name="clientFirstname" id="clientFirstname" type="text" <?php if (isset($clientFirstname)) {
                                                                                        echo "value='$clientFirstname'";
                                                                                    } elseif (isset($clientData['clientFirstname'])) {
                                                                                        echo "value='$clientData[clientFirstname]'";
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
                                                                                    } elseif (isset($clientData['clientLastname'])) {
                                                                                        echo "value='$clientData[clientLastname]'";
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
                                                                            } elseif (isset($clientData['clientEmail'])) {
                                                                                echo "value='$clientData[clientEmail]'";
                                                                            } ?> required>
                </div>
            </div>
            <div class="form-row">
                <input type="submit" name="submit" id="upbtn" value="Update Information">
                <!-- Add the action name & value pair -->
                <input type="hidden" name="action" value="updateClient">
                <input type="hidden" name="clientId" value=" <?php if (isset($clientData['clientId'])) {
                                                                    echo $clientData['clientId'];
                                                                } elseif (isset($clientId)) {
                                                                    echo $clientId;
                                                                } ?> ">
            </div>
        </form>
    </div>
    

    <h2>Change Password</h2>
    <p class="up-client-p">*Entering a password will change the current password.</p>
    <!--error or success message if needed -->
    <?php if (isset($_SESSION['message-pass'])) {
        echo $_SESSION['message-pass'];
    } ?>

    <div class="form-contain">
        <form action="/phpmotors/accounts/" method="post">
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
                <input type="submit" name="submit" id="upPassbtn" value="Update Password">
                <!-- Add the action name & value pair -->
                <input type="hidden" name="action" value="updatePassword">
                <input type="hidden" name="clientId" value=" <?php if (isset($clientData['clientId'])) {
                                                                    echo $clientData['clientId'];
                                                                } elseif (isset($clientId)) {
                                                                    echo $clientId;
                                                                } ?> ">
            </div>
        </form>
    </div>
</article>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\footer.php'; ?>