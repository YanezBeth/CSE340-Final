<?php
//check first if user is not logged in, then if their clientLevel is 1, if both are false go to vehicle-main.php, otherwise go home
if ($_SESSION['loggedin'] && $_SESSION['clientData']['clientLevel'] > 1) {
    //display page
} else {
    header('Location: /phpmotors/');
    exit;
}
?><?php
    $classificationList = '<select name="classificationId" id="classificationId">';
    foreach ($classifications as $classification) {
        $classificationList .= "<option value='$classification[classificationId]'";
        if (isset($classificationId)) {
            if ($classification['classificationId'] == $classificationId) {
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
<article class="add-vehicle">
    <h1 class="add-vehicle-h1">Add Vehicle</h1>
    <p class="add-vehicle-p">
        *All fields are required to add a vehicle to PHP Motors
    </p>
    <!--add error or success message if needed -->
    <?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
    }
    ?>

    <div class="form-contain">
        <form action="/phpmotors/vehicles/" method="post">
            <div class="form-row">
                <div class="form-col-25">
                    <label for="classificationId">Classification List:</label>
                </div>
                <div class="form-col-75">
                    <?php
                    if (!empty($classificationList)) {
                        echo $classificationList;
                    } ?>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col-25">
                    <label for="invMake">Make:</label>
                </div>
                <div class="form-col-75">
                    <input name="invMake" id="invMake" type="text" <?php if (isset($invMake)) {
                                                                        echo "value='$invMake'";
                                                                    } ?> required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col-25">
                    <label for="invModel">Model:</label>
                </div>
                <div class="form-col-75">
                    <input name="invModel" id="invModel" type="text" <?php if (isset($invModel)) {
                                                                            echo "value='$invModel'";
                                                                        } ?> required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col-25">
                    <label for="invDescription">Description:</label>
                </div>
                <div class="form-col-75">
                    <textarea name="invDescription" id="invDescription" placeholder="Description of vehicle" required><?php if (isset($invDescription)) {
                                                                                                                            echo $invDescription;
                                                                                                                        } ?></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col-25">
                    <label for="invImage">Image Path:</label>
                </div>
                <div class="form-col-75">
                    <input name="invImage" id="invImage" type="text" value="/phpmotors/images/no-image.png" <?php if (isset($invImage)) {
                                                                                                                echo "value='$invImage'";
                                                                                                            } ?> required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col-25">
                    <label for="invThumbnail">Thumbnail Path:</label>
                </div>
                <div class="form-col-75">
                    <input name="invThumbnail" id="invThumbnail" type="text" value="/phpmotors/images/no-image.png" <?php if (isset($invThumbnail)) {
                                                                                                                        echo "value='$invThumbnail'";
                                                                                                                    } ?> required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col-25">
                    <label for="invPrice">Price:</label>
                </div>
                <div class="form-col-75">
                    <input name="invPrice" id="invPrice" type="text" <?php if (isset($invPrice)) {
                                                                            echo "value='$invPrice'";
                                                                        } ?> required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col-25">
                    <label for="invStock">Amount in Stock:</label>
                </div>
                <div class="form-col-75">
                    <input name="invStock" id="invStock" type="text" <?php if (isset($invStock)) {
                                                                            echo "value='$invStock'";
                                                                        } ?> required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col-25">
                    <label for="invColor">Color:</label>
                </div>
                <div class="form-col-75">
                    <input name="invColor" id="invColor" type="text" <?php if (isset($invColor)) {
                                                                            echo "value='$invColor'";
                                                                        } ?> required>

                    <!--classification_Id and invId are DEFAULT-->

                </div>
            </div>
            <br>
            <div class="form-row">
                <input type="submit" name="submit" id="add-vehicles" value="Add Vehicle">
                <!-- Add the action name - value pair -->
                <input type="hidden" name="action" value="add-vehicle">
            </div>
        </form>
    </div>

</article>
<?php include $_SERVER['DOCUMENT_ROOT'] . '\phpmotors\common\footer.php'; ?>