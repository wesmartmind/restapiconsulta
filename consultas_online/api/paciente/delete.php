<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database_conn.php';
include_once '../beans/paciente.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare paciente object
$paciente = new Paciente($db);
 
// get paciente id
$data = json_decode(file_get_contents("http://localhost/consultas_online/api/paciente/read_one.php?id=1"));
 
// set paciente id to be deleted
$paciente->id = $data->id;
 
// delete the paciente
if($paciente->delete()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Paciente removido."));
}
 
// if unable to delete the paciente
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Paciente nao foi removido."));
}
?>