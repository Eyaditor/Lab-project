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

// read all todos
$result = $bookmark->readAll();

if( ! empty($result)){
    echo json_encode($result);
}
else {
    http_response_code(404);
    echo json_encode(array('message'=>'No bookmarks found'));
}