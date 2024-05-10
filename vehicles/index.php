<?php
//This is the vehicles controller

// Create or access a Session
session_start();

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/connections.php';
// Get the PHP Motors model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/main-model.php';
// Get the vehicles model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/vehicles-model.php';
// Get nav and other functions
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/functions.php';
// Get uploads model
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/uploads-model.php';


//Default page title
$pageTitle = 'Vehicles';


// Get the array of classifications
$classifications = getClassifications();
// Build a navigation bar using the $classifications array
$navList = navList($classifications);
// Create drop down list
//$classificationList = selectList($classifications);


//Key value action pairs, trim and filter as well
$action = trim(filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
if ($action == NULL) {
    $action = trim(filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
}

switch ($action) {
    case 'login-view':
        $pageTitle = 'Login';
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
        break;
    case 'error':
        $pageTitle = 'Error';
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/500.php';
        break;

        //The view
    case 'add-classification-view':
        $pageTitle = 'Add Classification';
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
        break;

        //The form
    case 'add-classification':
        $pageTitle = 'Add Classification';
        // Filter and store the data
        $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        //Check with a REGEX that the classification name is between 1 and 30 characters
        //$classificationName = checkClassificationName($classificationName);
        // Check for missing data
        if (empty($classificationName)) {
            $_SESSION['message'] = "<p class='error'>Please provide information for all empty form fields.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
            exit;
        }
        // Send the data to the model        
        $classOutcome = addClassification($classificationName);
        // Check and report the result
        if ($classOutcome === 1) {
            //$message = "<p class='yay'>You have successfully added $classificationName. Thank you.</p>";
            //include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-main.php';
            header("location: /phpmotors/vehicles/");
            exit;
        } else {
            $_SESSION['message'] = "<p class='error'>Sorry failed to add classification to database. Please try again.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-classification.php';
            exit;
        }
        break;

        //The view
    case 'add-vehicle-view':
        $pageTitle = 'Add Vehicle';
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
        break;

        //The form
    case 'add-vehicle':
        $pageTitle = 'Add Vehicle';
        // Filter and store the 8/10 vehicle data tables
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT));

        // Check for missing data
        if (empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)) {
            $_SESSION['message'] = "<p class='error'>Please provide information for all empty form fields.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
            exit;
        }
        // Send the data to the model
        $invOutcome = addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);
        // Check and report the result
        if ($invOutcome === 1) {
            $_SESSION['message'] = "<p class='yay'>You have successfully added $invMake $invModel.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
            exit;
        } else {
            $_SESSION['message'] = "<p class='error'>Failed to add vehicle to database. Please try again.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/add-vehicle.php';
            exit;
        }
        break;

    /* *********************************** 
    * Get vehicles by classificationId 
    * Used for starting Update & Delete process 
    *********************************** */
    case 'getInventoryItems':
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId);
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray);
        break;

    case 'mod':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $_SESSION['message'] = "<p class='error'>Sorry, no vehicle information could be found.</p>";
        }
        //modify page title using Sister Woods example: https://www.youtube.com/watch?v=vi8cA2VD3aM&ab_channel=BonnyWoods
        if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
            $pageTitle = "Modify $invInfo[invMake] $invInfo[invModel]";
        } elseif (isset($invMake) && isset($invModel)) {
            $pageTitle = "Modify $invMake $invModel";
        }
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-update.php';
        exit;
        break;

    case 'updateVehicle':
        $pageTitle = 'Update Vehicle';
        // Filter and store vehicle information
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT));
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        // Check for missing data
        if (empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)) {
            $_SESSION['message'] = "<p class='error'>Please provide information for all empty form fields to update the vehicle.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-update.php';
            exit;
        }
        // Send the data to the model
        $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
        // Check and report the result
        if ($updateResult === 1) {
            $_SESSION['message'] = "<p class='yay'>Congratulations, the $invMake $invModel was successfully updated.</p>";
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $_SESSION['message'] = "<p class='error'>Failed to update vehicle in the PHP Motors database. Please try again.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-update.php';
            exit;
        }
        break;

    case 'del':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $_SESSION['message'] = "<p class='error'>Sorry, no vehicle information could be found.</p>";
        }
        //modify page title using Sister Woods example: https://www.youtube.com/watch?v=vi8cA2VD3aM&ab_channel=BonnyWoods
        if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
            $pageTitle = "Delete $invInfo[invMake] $invInfo[invModel]";
        } elseif (isset($invMake) && isset($invModel)) {
            $pageTitle = "Modify $invMake $invModel";
        }

        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-delete.php';
        exit;
        break;

    case 'deleteVehicle':
        $pageTitle = 'Delete Vehicle';
        // Filter and store vehicle information
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        // Send the data to the model
        $deleteResult = deleteVehicle($invId);
        // Check and report the result
        if ($deleteResult === 1) {
            $_SESSION['message'] = "<p class='yay'>Success! $invMake $invModel was deleted.</p>";
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $_SESSION['message'] = "<p class='error'>Error: $invMake $invModel was not deleted.</p>";
            header('location: /phpmotors/vehicles/');
            exit;
        }
        break;

        //updated nav list function with classifications    
    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vehicles = getVehiclesByClassification($classificationName);
        if (!count($vehicles)) {
            $_SESSION['message'] = "<p class='error'>Sorry, no $classificationName vehicles could be found.</p>";
        } else {
            $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }
        /*echo $vehicleDisplay;
        exit;*/
        $pageTitle = $classificationName;
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/classification.php';
        break;

        //create pages for vehicle inventory
    case 'vehicleDetails':
        //all of this function is the same as the 'mod' function except the ending page the user lands on. How to combine...
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        $allImages = likeImages($invId);
        if (!count($invInfo)) {
            $_SESSION['message'] = "<p class='error'>Sorry, no vehicle information could be found.</p>";
        } else {
            //only line different than 'mod'
            $vehInformation = buildEachVehicleDisplay($invInfo, $allImages);
        }
        if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
            $pageTitle = "$invInfo[invMake] $invInfo[invModel]";
        }
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-detail.php';
        exit;
        break;

        //DEFAULT vehicles controller view
    default:
        $classificationList = buildClassificationList($classifications);
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/vehicle-main.php';
        break;
}


//unset($_SESSION['message']);
