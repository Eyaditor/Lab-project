<?php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    http_response_code(200); // Return 200 for preflight
    exit();
}

// set http response headers
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: application/json');

include_once '../db/Database.php';
include_once '../models/Bookmark.php';

// Instantiate DB & object and connect
$database = new Database();
$dbConnection = $database->connect();
// Instantiate a todo object
$bookmark = new Bookmark($dbConnection);

//get the http put request body
$data = json_decode(file_get_contents('php://input'));

if (! $data ||  !$data->id || !$data->link){
    http_response_code(422);
    echo json_encode(array('message'=>'error messing require parameters id and link.'));
    return;
}

// update the bookmark
$bookmark->setId($data->id);
$bookmark->setLink($data->link);

if($bookmark->updateLink()){
    http_response_code(200);
    echo json_encode(array('message'=>'bookmark updated'));
}else{
    http_response_code(503);
    echo json_encode(array('message'=>'Unable to update bookmark'));
}