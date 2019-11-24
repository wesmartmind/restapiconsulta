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

 
// get posted data
$data = json_decode(file_get_contents("http://localhost/consultas_online/api/consulta/create.php"));


// make sure data is not empty
if( !empty($data->tipo_consulta) ){
 `tipo_consulta`, `paciente`,`sintomas`, `prof_saude`,  `proxima`
    // set consulta property values
 
	$consulta->tipo_consulta = $data->tipo_consulta;
    $consulta->paciente = $data->paciente;
    $consulta->sintomas = $data->sintomas;
    $consulta->prof_saude = $data->prof_saude;
    $consulta->proxima = $data->proxima;
    $consulta->data_registo = date('Y-m-d');
    $consulta->utilizador = "freelancer";

  
    // create the consulta
    if($consulta->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Consulta criada com sucesso."));
    }
 
    // if unable to create consulta, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Consulta nao registada."));
    }
 }
	// tell the user data is incomplete
	else{

    // set response code - 400 bad request
    http_response_code(400);

 
    // tell the user
    echo json_encode(array("message" => "Nao foi possivel criar a consulta. Todos campos sao obrigatorios."));

}

?>