<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database_conn.php';
include_once '../beans/paciente.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$paciente = new Paciente($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("http://localhost/consultas_online/api/paciente/read_one.php?id=1"));
 

// set ID property of product to be edited
$paciente->id = $data->id;
 
// set product property values
$paciente->apelido = $data->apelido;
$paciente->nome = $data->nome;
$paciente->n_bi = $data->n_bi;
$paciente->morada = $data->morada;
$paciente->contacto = $data->contacto;

//echo  $paciente->apelido;
// update the product
if($paciente->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Paciente Actualizado."));
}
 
// if unable to update the product, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Paciente nao actualizado."));
}
?>