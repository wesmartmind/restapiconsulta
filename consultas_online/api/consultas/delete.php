<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 

// get database connection
include_once '../config/database_conn.php';
 
// instantiate consulta
include_once '../beans/consulta.php';

$database = new Database();
$db = $database->getConnection();
 
$consulta = new Consulta($db);
 
// get consulta id
$data = json_decode(file_get_contents("http://localhost/consultas_online/api/consulta/read_one.php?id=".$id.""));
 
// set consulta id to be deleted
$consulta->id = $data->id;
 
// delete consulta
if($consulta->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Consulta removida."));
}
 
// if unable to delete consulta
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Consulta nao foi removida."));
}
?>