<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// get database connection
include_once '../config/database_conn.php';
include_once '../beans/consulta.php';

$database = new Database();
$db = $database->getConnection();
 
$consulta = new Consulta($db);
 
// set ID property of record to read
$consulta->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of product to be edited
$consulta->readOne();
 
if($consulta->tipo_consulta!=null){
    // create array
    $consulta_arr = array(
        
        "id" =>$consulta->id,
        "tipo_consulta" =>$consulta->tipo_consulta,
        "paciente" =>$consulta->paciente,
        "sintomas"=>$consulta->sintomas,
        "prof_saude"=>$consulta->prof_saude,
        "proxima"=>$consulta->proxima
        
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($consulta_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user consulta does not exist
    echo json_encode(array("message" => "Consulta nao existe."));
}
?>