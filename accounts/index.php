<?php
//This is the accounts controller

// Create or access a Session
session_start();

// Get the database connection file
//require_once '../library/connections.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/connections.php';
// Get the PHP Motors model for use as needed
//require_once '../model/main-model.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/main-model.php';
// Get the accounts model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/accounts-model.php';
// Get the functions library
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/library/functions.php';


//Default page title
$pageTitle = 'Accounts';


// Get the array of classifications
$classifications = getClassifications();
// Build a navigation bar using the $classifications array
$navList = navList($classifications);
// Create drop down list
//$classificationList = selectList($classifications);


$action = trim(filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
if ($action == NULL) {
    $action = trim(filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
}

switch ($action) {
        //code to deliver the views
    case 'login-view':
        $pageTitle = 'Login';
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
        break;

    case 'registration-view':
        $pageTitle = 'Registration';
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/registration.php';
        break;

    case 'error':
        $pageTitle = 'Error';
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/500.php';
        break;

    case 'register-user':
        // Filter and store the data
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        //Check clients email and password
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        //Check for existing client email address
        $existingEmail = checkExistingEmail($clientEmail);
        //Handle existing email during registration, check before missing data because if email is already in use, we don't want to re-register
        if ($existingEmail) {
            $_SESSION['message'] = "<p class='error'>That email address already has an account. Would you like to login?</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
            exit;
        }
        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
            $_SESSION['message'] = "<p class='error'>Please provide information for all empty form fields.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/registration.php';
            exit;
        }
        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        // Send the data to the model to save
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        // Check and report the result
        if ($regOutcome === 1) {
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $_SESSION['message'] = "<p class='yay'>Thanks for registering, $clientFirstname. Please use your email and password to login.</p>";
            header('Location: /phpmotors/accounts/?action=login-view');
            exit;
        } else {
            $_SESSION['message'] = "<p class='error'>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/registration.php';
            exit;
        }
        break;

    case 'login-user':
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        //Check clients email and password
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);
        // Check for missing data
        if (empty($clientEmail) || empty($checkPassword)) {
            $_SESSION['message'] = "<p class='error'>Please provide information for all empty form fields.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
            exit;
        }
        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        // If the hashes don't match create an error
        // and return to the login view
        if (!$hashCheck) {
            $_SESSION['message'] = "<p class='error'>Please check your password and try again.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/login.php';
            exit;
        }
        // A valid user exists, log them in 
        //Use in admin view to check if logged in
        $_SESSION['loggedin'] = TRUE;
        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;
        //echo '<pre>' . print_r($_SESSION['clientData'], true) . '<pre>';
        // Send them to the admin view
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/admin.php';
        exit;
        break;

    case 'logout':
        $pageTitle = 'Logout';
        //https://www.php.net/manual/en/function.session-unset.php
        session_unset();
        session_destroy();
        header("location: /phpmotors/");
        break;

        // View for client-update.php
    case 'client-update-view':
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
        break;

    case 'updateClient':
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        //$clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        $clientId = $_SESSION['clientData']['clientId'];
        //Check if client email is same as session email, then check that's it's unique
        if ($clientEmail != $_SESSION['clientData']['clientEmail']) {
            $existingEmail = checkExistingEmail($clientEmail);
            //Handle existing email during registration, check before missing data because if email is already in use, we don't want to re-register
            if ($existingEmail) {
                $_SESSION['message-update'] = "<p class='error'>That email address already has an account. Would you like to login?</p>";
                include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
                exit;
            }
        }

        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)) {
            $_SESSION['message-update'] = "<p class='error'>Please provide information for all empty form fields.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
            exit;
        }

        $updateClient = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);

        // Check and report the result
        if ($updateClient === 1) {
            //modified getClient from using email to using ID
            $clientData = getClientByID($clientId);
            //pop password
            array_pop($clientData);
            $_SESSION['clientData'] = $clientData;
            $_SESSION['message'] = "<p class='yay'>Thanks for updating your information, $clientFirstname. </p>";
            header('location: /phpmotors/accounts/'); //To default admin page
            exit;
        } else {
            $_SESSION['message'] = "<p class='error'>Sorry, $clientFirstname, failed to update your information. Please try again.</p>";
            header('location: /phpmotors/accounts/');
            exit;
        }
        break;

    case 'updatePassword':
        $clientFirstname = $_SESSION['clientData']['clientFirstname'];
        //$clientId = filter_input(INPUT_GET, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        $clientId = $_SESSION['clientData']['clientId'];
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $checkPassword = checkPassword($clientPassword);

        // Check for missing data
        if (empty($checkPassword)) {
            $_SESSION['message-pass'] = "<p class='error'>Please provide a new password.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/client-update.php';
            exit;
        }
        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        echo "$clientPassword, $hashedPassword, $clientId, $clientFirstname";
        // Send the data to the model to save
        $updatePassword = updatePassword($hashedPassword, $clientId);

        // Check and report the result
        if ($updatePassword === 1) {
            $clientData = getClientByID($clientId);
            //pop password
            array_pop($clientData);
            $_SESSION['clientData'] = $clientData;
            $_SESSION['message'] = "<p class='yay'>Thanks for updating your password, $clientFirstname.</p>";
            header('location: /phpmotors/accounts/');
            exit;
        } else {
            $_SESSION['message'] = "<p class='error'>Sorry $clientFirstname, but the password was not updated. Please try again.</p>";
            header('location: /phpmotors/accounts/');
            exit;
        }
        break;

        //DEFAULT account controller view
    default:
        $pageTitle = 'Admin';
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/admin.php';
        break;
}


//unset($_SESSION['message']);
