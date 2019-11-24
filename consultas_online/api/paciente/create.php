<?php 

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database_conn.php';
 
// instantiate paciente 
include_once '../beans/paciente.php';
 
$database = new Database();
$db = $database->getConnection();
 
$paciente = new Paciente($db);

		/*$api_url = "http://localhost/consultas_online/api/paciente/create.php";  //change this url as per your folder path for api folder
		$client = curl_init($api_url);
		curl_setopt($client, CURLOPT_POST, true);
		//curl_setopt($client, CURLOPT_POSTFIELDS, $paciente);
		curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($client);
		curl_close($client);
		$result = json_decode($response, true);*/
 
// get posted data
$data = json_decode(file_get_contents("http://localhost/consultas_online/api/paciente/create.php"));


// make sure data is not empty
if( !empty($data->apelido) &&  !empty($data->nome) && !empty($data->n_bi) && !empty($data->morada) &&  !empty($data->contacto)){
 
    // set paciente property values
 
	$paciente->apelido = $data->apelido;
    $paciente->nome = $data->nome;
    $paciente->n_bi = $data->n_bi;
    $paciente->morada = $data->morada;
    $paciente->contacto = $data->contacto;
    $paciente->data_nasc = date('Y-m-d');
    $paciente->data_registo = date('Y-m-d');
    $paciente->utilizador = "freelancer";

  /*  //$paciente->utilizador = ""$data->utilizador"";
	$paciente->apelido = $_POST["apelido"];//$data->apelido;
    $paciente->nome = $_POST["nome"];//$data->nome;
    $paciente->n_bi = $_POST["n_bi"];//$data->n_bi;
    $paciente->morada = $_POST["morada"];//$data->morada;
    $paciente->contacto = $_POST["contacto"];//$data->contacto;
    $paciente->data_nasc = date('Y-m-d');
    $paciente->data_registo = date('Y-m-d');
    $paciente->utilizador = "freelancer";*/

//echo $paciente->utilizador
    // create the paciente
    if($paciente->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Paciente criado com sucesso."));
    }
 
    // if unable to create the product, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Paciente nao registado."));
    }
 }
	// tell the user data is incomplete
	else{

    // set response code - 400 bad request
    http_response_code(400);

 
    // tell the user
    echo json_encode(array("message" => "Nao foi possivel criar o paciente. Todos campos sao obrigatorios."));

}

?>