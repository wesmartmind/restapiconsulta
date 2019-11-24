<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database_conn.php';
include_once '../beans/consulta.php';

$database = new Database();
$db = $database->getConnection();
 
$consulta = new Consulta($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("http://localhost/consultas_online/api/consulta/read_one.php?id=".$id.""));
 

// set ID property of product to be edited
$consulta->id = $data->id;
 
// set product property values
$consulta->tipo_consulta = $data->tipo_consulta;
$consulta->paciente = $data->paciente;
$consulta->sintomas = $data->sintomas;
$consulta->prof_saude = $data->prof_saude;
$consulta->proxima = $data->proxima;


// update consulta
if($consulta->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Consulta actualizada."));
}
 
// if unable to update consulta, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Consulta nao actualizada."));
}
?>