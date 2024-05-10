<?php

//Custom Functions Library

//validate email address
function checkEmail($clientEmail)
{
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

/*
Passwords must be at least 8 characters and contain at least 1 number, 1 capital, and 1 special character
Note: The regular expression below allows spaces to be treated as a "special character".
*/
function checkPassword($clientPassword)
{
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword);
}

//Create top navigation bar 
function navList($classifications)
{
    /*$navList = '<ul>';
    $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
    foreach ($classifications as $classification) {
        $navList .= "<li><a href='/phpmotors/index.php?action=" . $classification['classificationName'] . "' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    }*/
    $navList = '<ul>';
    $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors Home Page'>Home</a></li>";
    foreach ($classifications as $classification) {
        $navList .= "<li><a href='/phpmotors/vehicles?action=classification&classificationName=" . urlencode($classification['classificationName']) . "' title='View our $classification[classificationName] Lineup of Vehicles'>$classification[classificationName]</a></li>";
    }
    $navList .= '</ul>';
    return $navList;
}

//Create drop down select list of classifications
function selectList($classifications)
{
    $classifications = getClassifications();
    $classificationList = '<ul>';
    $classificationList .= "<li><select name='classificationId' id='classificationId'>";
    $classificationList .= "<option value=''>Select a Classification</option>";
    foreach ($classifications as $classification) {
        $classificationList .= "<option value='" . $classification['classificationID'] . "'>" . $classification['classificationName'] . "</option>";
    }
    $classificationList .= "</select></li>";
    $classificationList .= '</ul>';
    return $classificationList;
    //Using Brother Robertson's select list since it's cleaner: https://www.youtube.com/watch?v=kkNWOXF9RbY&ab_channel=BlaineRobertson
    /*$classificationList = '<select name="classificationId">';
    foreach ($classifications as $classification) {
        $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option";
    }
    $classificationList .= '</select>';*/
}

/*
Passwords must be at least 8 characters and contain at least 1 number, 1 capital, and 1 special character
Note: The regular expression below allows spaces to be treated as a "special character".
*/
function checkClassificationName($classificationName)
{
    $pattern = '^.{1,30}$';
    return preg_match($pattern, $classificationName);
}

// Build the classifications select list 
function buildClassificationList($classifications)
{
    $classificationList = '<select name="classificationId" id="classificationList">';
    $classificationList .= "<option>Choose a Classification</option>";
    foreach ($classifications as $classification) {
        $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
    }
    $classificationList .= '</select>';
    return $classificationList;
}

//Build each type of vehicles display page with vehicles in that category
function buildVehiclesDisplay($vehicles)
{
    $dv = '<ul id="inv-display">';
    foreach ($vehicles as $vehicle) {
        $dv .= '<li>';
        //wrap in a link like in the nav and give name value pairs
        $dv .= "<a href='/phpmotors/vehicles?action=vehicleDetails&invId=" . urlencode($vehicle['invId']) . "' title='View $vehicle[invMake] $vehicle[invModel]'><div class='dv-img'><img src='$vehicle[imgPath]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'></div>";
        //$dv .= '<hr>';
        $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
        $dv .= "<span>$" . number_format($vehicle['invPrice'], 2, '.', ',') . "</span>";
        $dv .= '</a></li>';
    }
    $dv .= '</ul>';
    return $dv;
}


//Build individual vehicle display page with large image and info as a table
function buildEachVehicleDisplay($invInfo, $allImages)
{
    $ev = '<div id="each-display">';

    $ev .= "<div id='ev-img'><img src='$invInfo[imgPath]' alt='Image of $invInfo[invMake] $invInfo[invModel] on phpmotors.com'></div>";

    //put invInfo in a table to display each vehicles information
    $ev .= "<div id='ev-info'><table class='each-display'><tr><th><b>Price:</b> $" . number_format(($invInfo['invPrice']), 2, '.', ',') . "</th></tr>
        <tr><td><b>Vehicle Description:</b> $invInfo[invDescription]</td></tr>
        <tr><td><b>Vehicles in Stock:</b> $invInfo[invStock]</td>
        <tr><td><b>Vehicle Color:</b> $invInfo[invColor]</td></tr>
        </table></div>";

    $ev .= '<h3 id="tn-each-display-heading">Vehicle Images</h3>';
    $ev .= '<div id="tn-each-display">';
    //$ev .= '<ul>';
    foreach ($allImages as $tn) {
        //$ev .= '<li>';
        //wrap in a link like in the nav and give name value pairs
        $ev .= "<img src='$tn[imgPath]' alt='Image of $invInfo[invMake] $invInfo[invModel] on phpmotors.com'>";
    }
    //'</ul>';
    $ev .= '</div></div>';
    return $ev;
}


/* * ********************************
*  Functions for working with images
* ********************************* */

// Adds "-tn" designation to file name
function makeThumbnailName($image)
{
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
}

// Build images display for image management view
function buildImageDisplay($imageArray)
{
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
        $id .= '<li>';
        $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
        $id .= "<p class='image-display-p'><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
        $id .= '</li>';
    }
    $id .= '</ul>';
    return $id;
}

// Build the vehicles select list
function buildVehiclesSelect($vehicles)
{
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Vehicle</option>";
    foreach ($vehicles as $vehicle) {
        $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
}

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name)
{
    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    if (isset($_FILES[$name])) {
        // Gets the actual file name
        $filename = $_FILES[$name]['name'];
        if (empty($filename)) {
            return;
        }
        // Get the file from the temp folder on the server
        $source = $_FILES[$name]['tmp_name'];
        // Sets the new path - images folder in this directory
        $target = $image_dir_path . '/' . $filename;
        // Moves the file to the target folder
        move_uploaded_file($source, $target);
        // Send file for further processing
        processImage($image_dir_path, $filename);
        // Sets the path for the image for Database storage
        $filepath = $image_dir . '/' . $filename;
        // Returns the path where the file is stored
        return $filepath;
    }
}

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename)
{
    // Set up the variables
    $dir = $dir . '/';

    // Set up the image path
    $image_path = $dir . $filename;

    // Set up the thumbnail image path
    $image_path_tn = $dir . makeThumbnailName($filename);

    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);

    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
}

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height)
{

    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];

    // Set up the function names
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $image_from_file = 'imagecreatefromjpeg';
            $image_to_file = 'imagejpeg';
            break;
        case IMAGETYPE_GIF:
            $image_from_file = 'imagecreatefromgif';
            $image_to_file = 'imagegif';
            break;
        case IMAGETYPE_PNG:
            $image_from_file = 'imagecreatefrompng';
            $image_to_file = 'imagepng';
            break;
        default:
            return;
    } // ends the swith

    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);

    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;

    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {

        // Calculate height and width for the new image
        $ratio = max($width_ratio, $height_ratio);
        $new_height = round($old_height / $ratio);
        $new_width = round($old_width / $ratio);

        // Create the new image
        $new_image = imagecreatetruecolor($new_width, $new_height);

        // Set transparency according to image type
        if ($image_type == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagecolortransparent($new_image, $alpha);
        }

        if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }

        // Copy old image to new image - this resizes the image
        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;
        imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

        // Write the new image to a new file
        $image_to_file($new_image, $new_image_path);
        // Free any memory associated with the new image
        imagedestroy($new_image);
    } else {
        // Write the old image to a new file
        $image_to_file($old_image, $new_image_path);
    }
    // Free any memory associated with the old image
    imagedestroy($old_image);
} // ends resizeImage function



/*function buildSearchDisplay($searchArray)
{
    $ev = '<div id="search-display">';
    foreach ($searchArray as $search) {
        $ev .= "<a href='/phpmotors/vehicles?action=vehicleDetails&invId=" . urlencode($search['invId']) . "' title='View $search[invMake] $search[invModel]'><div class='dv-img'><img src='$search[imgPath]' alt='Image of $search[invMake] $search[invModel] on phpmotors.com'></div></a>";

        //put search in a table to display each vehicles information
        $ev .= "<div id='ev-info'><table class='search-display'>
            <tr><th><b>$search[invMake] $search[invModel]</b></th></tr>
            <tr><td><b>Price:</b> $" . number_format(($search['invPrice']), 2, '.', ',') . "</td></tr>
            <tr><td><b>Vehicle Description:</b> $search[invDescription]</td></tr>
            <tr><td><b>Vehicles in Stock:</b> $search[invStock]</td>
            <tr><td><b>Vehicle Color:</b> $search[invColor]</td></tr>
            </table></div>";

        //$ev .= '$search[invThumbnail]';

    }
    $ev .= '</div></div>';
    return $ev;
}*/


//SEARCH DISPLAY AND PAGINATION FUNCTION
function buildSearchDisplay($searchOutcome, $searchWord)
{
    $numSearch = count($searchOutcome);
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $perPage = isset($_GET['perPage']) ? intval($_GET['perPage']) : 10;
    // Determine the starting limit for the current page
    $starting_limit = ($page - 1) * $perPage;

    // Slice the search results to display only the current page
    $currentPageResults = array_slice($searchOutcome, $starting_limit, $perPage);

    // Build the HTML for the current page's results
    $sd = "<h3> Returned $numSearch results for: $searchWord</h3><hr>";
    //$sd .= count($searchOutcome);
    $sd .= '<div id="search-display">';
    foreach ($currentPageResults as $search) {
        $sd .= "<a href='/phpmotors/vehicles?action=vehicleDetails&invId=" . urlencode($search['invId']) . "' title='View $search[invMake] $search[invModel]'><div class='search-img'><img src='$search[imgPath]' alt='Image of $search[invMake] $search[invModel] on phpmotors.com'></div></a>";

        // display searched vehicle's information
        $sd .= "<div class='search-info'>
        <a href='/phpmotors/vehicles?action=vehicleDetails&invId=" . urlencode($search['invId']) . "' title='View $search[invMake] $search[invModel]'>
            <h4>$search[invMake] $search[invModel]</h4></a>
            <p>Description: $search[invDescription]<p>
            </div>";
    }

    $sd .= '</div>';
    $sd .= '<br><br>';

    // ********  Pagination  ******** //
    // Calculate total number of pages
    $totalPages = ceil(count($searchOutcome) / $perPage);

    // Generate links for all pages greater than 1
    if ($totalPages > 1) {
        $sd .= '<div id="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $sd .= '<a href="/phpmotors/search?action=search&searchTerm=' . urlencode($searchWord) . '&perPage=' . $perPage . '&page=' . $i . '"' . ($i == $page ? ' class="active"' : '') . '>' . $i . '</a>';
        }
        $sd .= '</div>';
    }
    
    return $sd;
}
