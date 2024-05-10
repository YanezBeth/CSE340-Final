<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
}
?><?php
    // Build the classifications option list
    $classificationList = '<select name="classificationId" id="classificationId">';
    $classificationList .= "<option>Choose a Car Classification</option>";
    foreach ($classifications as $classification) {
        $classificationList .= "<option value='$classification[classificationId]'";
        if (isset($classificationId)) {
            if ($classification['classificationId'] === $classificationId) {
                $classificationList .= ' selected ';
            }
        } elseif (isset($invInfo['classificationId'])) {
            if ($classification['classificationId'] === $invInfo['classificationId']) {
                $classificationList .= ' selected ';
            }
        }
        $classificationList .= ">$classification[classificationName]</option>";
    }
    $classificationList .= '</select>';
    ?><?php
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
<article class="del-vehicle">
    <h1><?php if (isset($pageTitle)) {
            echo $pageTitle;
        } ?></h1>
    <p class="del-vehicle-p">
        Confirm Vehicle Deletion. The delete is permanent.
    </p>
    <!--error or success message if needed -->
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
    }
    ?>

    <div class="form-contain">
        <form action="/phpmotors/vehicles/" method="post">
            <!-- <div class="form-row">
                <div class="form-col-25">
                    <label for="classificationId">Classification List:</label>
                </div>
                <div class="form-col-75">
                    <?php
                    if (!empty($classificationList)) {
                        echo $classificationList;
                    } ?>
                </div>
            </div> -->
            <div class="form-row">
                <div class="form-col-25">
                    <label for="invMake">Make:</label>
                </div>
                <div class="form-col-75">
                    <input name="invMake" id="invMake" type="text" readonly <?php if (isset($invInfo['invMake'])) {
                                                                                echo "value='$invInfo[invMake]'";
                                                                            } ?>>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col-25">
                    <label for="invModel">Model:</label>
                </div>
                <div class="form-col-75">
                    <input name="invModel" id="invModel" type="text" readonly <?php if (isset($invInfo['invModel'])) {
                                                                                    echo "value='$invInfo[invModel]'";
                                                                                } ?>>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col-25">
                    <label for="invDescription">Description:</label>
                </div>
                <div class="form-col-75">
                    <textarea name="invDescription" id="invDescription" readonly><?php if (isset($invInfo['invDescription'])) {
                                                                                        echo $invInfo['invDescription'];
                                                                                    } ?></textarea>
                </div>
            </div>

            <br>
            <div class="form-row">
                <input type="submit" name="submit" id="del-vehicles" value="Delete Vehicle">
                <!-- Add the action name - value pair -->
                <input type="hidden" name="action" value="deleteVehicle">
                <input type="hidden" name="invId" value="<?php if (isset($invInfo['invId'])) {
                                                                echo $invInfo['invId'];
                                                            } ?>">
            </div>
        </form>
    </div>

</article>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\footer.php'; ?>