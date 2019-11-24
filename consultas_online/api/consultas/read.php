<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 

// get database connection
include_once '../config/database_conn.php';
include_once '../beans/consulta.php';

$database = new Database();
$db = $database->getConnection();
 
$consulta = new Consulta($db);

// query products
$stmt = $consulta->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // paciente array
    $consulta_arr=array();
    $consulta_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $consulta_item=array(

          
        	"id" =>$id,
        	"tipo_consulta" =>$tipo_consulta,
        	"paciente" =>$paciente,
        	"sintomas"=>$sintomas,
        	"prof_saude"=>$prof_saude,
        	"proxima"=>$proxima
        	
            
        );
 
        array_push($consulta_arr["records"], $consulta_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($consulta_arr);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "Nao Exitem Consultas.")
    );
}

?>