<?php
//This is the SEARCH controller

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
// Get search model
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/model/search-model.php';


//Default page title
$pageTitle = 'Search';

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
        //deliver the search view
    case 'search-view':
        $pageTitle = 'Search';
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/search.php';
        break;

        //search the database and get results
    case 'search':
        $pageTitle = 'Search PHP Motors';
        // Filter and store the data
        $searchWord = htmlspecialchars(strip_tags(trim(filter_input(INPUT_GET, 'searchWord', FILTER_SANITIZE_FULL_SPECIAL_CHARS))));
        //$searchWord = strip_tags($searchWord);
        //$searchWord = htmlspecialchars($searchWord);
        //echo $searchWord;
        //exit;

        // Check for missing data
        /*if (empty($searchWord)) {
            $_SESSION['message'] = "<p class='error'>Please provide a search word.</p>";
            include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/search.php';
            exit;
        }*/
        // Send the data to the model        
        $searchOutcome = searchPHPMotors($searchWord);

        //echo '<pre>' . print_r($searchOutcome) . '</pre>'; exit;
        
        if (count($searchOutcome)) {
            $searchInformation = buildSearchDisplay($searchOutcome, $searchWord);
            
        } else {
            $_SESSION['message'] = "<p class='error'>Sorry, no vehicle information could be found for $searchWord.</p>";
        }

        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/search-results.php';
   
        exit;
        break;

        //DEFAULT view
    default:
        $pageTitle = 'Search';
        include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/view/search.php';
        
        break;
}
