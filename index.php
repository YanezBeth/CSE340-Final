<?php
//This is the main controller for site

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

//Default page title
$pageTitle = 'Home';

// Get the array of classifications
$classifications = getClassifications();
//var_dump($classifications);

// Build a navigation bar using the $classifications array
$navList = navList($classifications);
// Create drop down list
//$classificationList = selectList($classifications);


/*// Build a navigation bar using the $classifications array
$navList = '<ul>';
$navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
foreach ($classifications as $classification) {
    $navList .= "<li><a href='/phpmotors/index.php?action=" . urlencode($classification['classificationName']) . "' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
}
$navList .= '</ul>';
//echo $navList;
//exit;
*/

// Check if the firstname cookie exists, get its value
if (isset($_COOKIE['firstname'])) {
    $cookieFirstname = trim(filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
}

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'error':
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/500.php';
        break;
    default:
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/home.php';
}


//unset($_SESSION['message']);