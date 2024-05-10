<?php

//Connection function to phpmotors database
function phpmotorsConnect(){
    $server = 'localhost';
    $dbname= 'phpmotors';
    $username = 'iClient';
    $password = '3h19i4XcWW6zNB*L'; 
    $dsn = "mysql:host=$server;dbname=$dbname;port=3307";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
   
    // Create the actual connection object and assign it to a variable
    try {
     $link = new PDO($dsn, $username, $password, $options);
     return $link;
    } catch(PDOException $e) {
     header('Location: /phpmotors/view/500.php');
     exit;
    }
   }

   //phpmotorsConnect();
