
<?php


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    http_response_code(200);
    exit();
}




header('Access-Control-Allow-Origin: *'); 
header('Content-Type: application/json');

include_once '../db/Database.php';
include_once '../models/Bookmark.php';


$database = new Database();
$dbConnection = $database->connect();


$bookmark = new Bookmark($dbConnection);


$data = json_decode(file_get_contents('php://input'));

if (! $data ||  !$data->id || !$data->title){
    http_response_code(422);
    echo json_encode(array('message'=>'error missing require parameters id and title.'));
    return;
}
    
// update the bookmark
$bookmark->setId($data->id);
$bookmark->setTitle($data->title);

if($bookmark->updateTitle()){
    http_response_code(200);
    echo json_encode(array('message'=>'Bookmark updated'));
}
else {
    http_response_code(503);
    echo json_encode(array('message'=>'Failed to update bookmark'));
}