<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database_conn.php';
include_once '../beans/paciente.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$paciente = new Paciente($db);
 
// set ID property of record to read
$paciente->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of product to be edited
$paciente->readOne();
 
if($paciente->nome!=null){
    // create array
    $paciente_arr = array(
        
        "id" =>$paciente->id,
        "apelido" =>$paciente->apelido,
        "nome" =>$paciente->nome,
        "n_bi"=>$paciente->n_bi,
        "morada"=>$paciente->morada,
        "contacto"=>$paciente->contacto,
        "data_nasc" =>$paciente->data_nasc
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($paciente_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user product does not exist
    echo json_encode(array("message" => "Paciente nao existe."));
}
?>