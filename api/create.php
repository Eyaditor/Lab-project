<?php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    http_response_code(200);
    exit();
}

// Set HTTP response headers
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');


include_once '../db/Database.php';
include_once '../models/Bookmark.php';

// Instantiate DB & object and connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate a bookmark object
$bookmark = new Bookmark($dbConnection);

// get the http post request data
$data = json_decode(file_get_contents('php://input'), true);

// if no link or title is included in the json body, return an error
if (!$data || !isset($data['link']) || !isset($data['title'])){
    http_response_code(422);
    echo json_encode(
        array('message'=>'Error missing required parameters link or title in JSON body'));
    return;

}

$bookmark->setlink($data['link']);
$bookmark->setTitle($data['title']);
if ($bookmark->create()){
    echo json_encode(array('message'=>'bookmark created successfully'));
}
else {
    echo json_encode(array('message'=>'Unable to create bookmark'));
}