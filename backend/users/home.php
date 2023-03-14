<?php
header("Access-Control-Allow-Origin: *"); // This allows any domain to access your API
header("Content-Type: application/json; charset=UTF-8"); // This sets the response type to JSON

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  http_response_code(200);
  exit();
}
// 
$response = array(
  "message" => "Hello, world!"
);

http_response_code(200); // This sets the response code to 200 OK
echo json_encode($response); // This encodes the response as JSON and sends it back
