<?php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // CORS headers for preflight
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    http_response_code(200); // Return 200 OK for preflight
    exit();
}

// Set CORS and content headers for actual DELETE request
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


include_once '../db/Database.php';
include_once '../models/Bookmark.php';

// Instantiate a Database object & connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate Todo object
$bookmark = new Bookmark($dbConnection);

// Get the HTTP DELETE request JSON body
$data = json_decode(file_get_contents("php://input"));
if(!$data || !$data->id){
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error: missing required parameter id in the JSON body.')
    );
    return;
}

$bookmark->setId($data->id);


if ($bookmark->delete()) {
    echo json_encode(
        array('message' => 'A bookmark item was deleted.')
    );
} else {
    echo json_encode(
        array('message' => 'Error: a bookmark item was not deleted.')
    );
}