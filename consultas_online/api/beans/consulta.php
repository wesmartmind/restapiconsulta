<?php 
class Consulta{

	// database connection and table name
    private $conn;
    private $table_name = "tb_consulta";

    public $id;
    public $tipo_consulta;
    public $paciente;
    public $sintomas;
    public $prof_saude;
    public $proxima;
    public $data_registo;
    public $utilizador;

     // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    //read all paciente
    function readAll($from_record_num, $records_per_page){
 
    $query = "SELECT
                tb_c.id as id, tb_c.tipo_consulta as tipo_consulta , tb_p.nome as paciente ,tb_c.sintomas as sintomas, tb_p_sau.nome as prof_saude,  tb_c.proxima as proxima
            FROM
                tb_consulta tb_c
            INNER JOIN tb_paciente tb_p ON tb_p.id = tb_c.paciente
            INNER JOIN tb_prof_saude tb_p_sau ON tb_p_sau.id = tb_c.prof_saude
            
            ORDER BY
                tipo_consulta ASC
            LIMIT
                {$from_record_num}, {$records_per_page}";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    return $stmt;
	}


	// read pacientes
	function read(){
 
    // select all query
    $query = "SELECT

                `id`, `tipo_consulta`, `paciente`,`sintomas`, `prof_saude`,  `proxima`

            FROM
                " . $this->table_name . " 

            ORDER BY
                nome DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}


// create product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                tipo_consulta=:tipo_consulta, paciente=:paciente, sintomas=:sintomas, prof_saude=:prof_saude, proxima=:proxima, data_registo=:data_registo, utilizador=:utilizador";

    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->tipo_consulta=htmlspecialchars(strip_tags($this->tipo_consulta));
    $this->paciente=htmlspecialchars(strip_tags($this->paciente));
    $this->sintomas=htmlspecialchars(strip_tags($this->sintomas));
    $this->prof_saude=htmlspecialchars(strip_tags($this->prof_saude));
    $this->proxima=htmlspecialchars(strip_tags($this->proxima));
    $this->data_registo=date("Y-m-d H:i:s");
    $this->utilizador='freelancer';
 
	//echo $this->contacto ;
	//&''& $this->apelido &''& $this->n_bi &''& $this->morada;

    // bind values
    $stmt->bindParam(":tipo_consulta", $this->tipo_consulta);
    $stmt->bindParam(":paciente", $this->paciente);
    $stmt->bindParam(":sintomas", $this->sintomas);
    $stmt->bindParam(":prof_saude", $this->prof_saude);
    $stmt->bindParam(":proxima", $this->proxima);
    $stmt->bindParam(":data_registo", $this->data_registo);
    $stmt->bindParam(":utilizador", $this->utilizador);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

// used when filling up the update product form
function readOne(){
 
    // query to read single record
    $query = "SELECT
                 `id`, `tipo_consulta`, `paciente`,`sintomas`, `prof_saude`,  `proxima`
            FROM
                " . $this->table_name . " 
                 
            WHERE
                id = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties

    $this->tipo_consulta=$row['tipo_consulta'];
    $this->paciente=$row['paciente'];
    $this->sintomas=$row['sintomas'];
    $this->prof_saude=$row['prof_saude'];
    $this->proxima=$row['proxima']; 
    
}


// update the product
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                tipo_consulta=:tipo_consulta, 
                paciente=:paciente, 
                sintomas=:sintomas, 
                prof_saude=:prof_saude, 
                proxima=:proxima

            WHERE
                id = :id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
   	// sanitize
    $this->tipo_consulta=htmlspecialchars(strip_tags($this->tipo_consulta));
    $this->paciente=htmlspecialchars(strip_tags($this->paciente));
    $this->sintomas=htmlspecialchars(strip_tags($this->sintomas));
    $this->prof_saude=htmlspecialchars(strip_tags($this->prof_saude));
    $this->proxima=htmlspecialchars(strip_tags($this->proxima));
    $this->id=htmlspecialchars(strip_tags($this->id));
 
 
    // bind values
    $stmt->bindParam(":tipo_consulta", $this->tipo_consulta);
    $stmt->bindParam(":paciente", $this->paciente);
    $stmt->bindParam(":sintomas", $this->sintomas);
    $stmt->bindParam(":prof_saude", $this->prof_saude);
    $stmt->bindParam(":proxima", $this->proxima);
  	$stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}


// delete the product
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

// used for paging products
public function countAll(){
 
    $query = "SELECT id FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    $num = $stmt->rowCount();
 
    return $num;
}

// read products by search term
public function search($search_term, $from_record_num, $records_per_page){
 
    // select query
    $query = "SELECT
                  `id`, `tipo_consulta`, `paciente`,`sintomas`, `prof_saude`,  `proxima`
            FROM
                " . $this->table_name . " 
                
            WHERE
                tipo_consulta LIKE ? OR sintomas LIKE ?
            ORDER BY
                tipo_consulta ASC
            LIMIT
                ?, ?";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $search_term = "%{$search_term}%";
    $stmt->bindParam(1, $search_term);
    $stmt->bindParam(2, $search_term);
    $stmt->bindParam(3, $from_record_num, PDO::PARAM_INT);
    $stmt->bindParam(4, $records_per_page, PDO::PARAM_INT);
 
    // execute query
    $stmt->execute();
 
    // return values from database
    return $stmt;
}

public function countAll_BySearch($search_term){
 
    // select query
    $query = "SELECT
                COUNT(*) as total_rows
            FROM
                " . $this->table_name . "  
            WHERE
                tipo_consulta LIKE ? OR sintomas LIKE ?";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind variable values
    $search_term = "%{$search_term}%";
    $stmt->bindParam(1, $search_term);
    $stmt->bindParam(2, $search_term);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}


}

?>