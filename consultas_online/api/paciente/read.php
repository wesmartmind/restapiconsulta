
<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database_conn.php';
include_once '../beans/paciente.php';
 
// instantiate database and paciente bean
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$paciente = new Paciente($db);
 
// query products
$stmt = $paciente->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // paciente array
    $paciente_arr=array();
    $paciente_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $paciente_item=array(

        	"id" =>$id,
        	"apelido" =>$apelido,
        	"nome" =>$nome,
        	"n_bi"=>$n_bi,
        	"morada"=>$morada,
        	"contacto"=>$contacto,
        	"data_nasc" =>$data_nasc
            //"description" => html_entity_decode($description),
            
        );
 
        array_push($paciente_arr["records"], $paciente_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($paciente_arr);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "Nao Exitem Pacientes.")
    );
}

?>