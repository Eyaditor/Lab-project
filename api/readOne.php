<?php

// check http request method
if($_SERVER['REQUEST_METHOD']!=='GET'){
    header('Allow: GET');
    http_response_code(405);
    echo json_encode(array('message'=>'HTTP method not allowed'));
    return;
}


// set http response headers
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET'); 

include_once '../db/Database.php';
include_once '../models/Bookmark.php';

// Instantiate DB & object and connect
$database = new Database();
$dbConnection = $database->connect();
// Instantiate a todo object
$bookmark = new Bookmark($dbConnection);

// Get the http get request query parameter
if(!isset($_GET['id'])){
    http_response_code(422);
    echo json_encode(
        array('message'=>'Error missing required parameter id'));
    return;
}

// read todo details
$bookmark->setId($_GET['id']);
if ($bookmark->readOne()){
    $result = array(
        'id'=>$bookmark->getId(),
        'URL'=>$bookmark->getlink(),
        'title'=>$bookmark->getTitle(),
        'dateAdded'=>$bookmark->getDateAdded()
    );

    echo json_encode($result);
}
else {
    http_response_code(404);
    echo json_encode(array('message'=>'Bookmark not found'));
}