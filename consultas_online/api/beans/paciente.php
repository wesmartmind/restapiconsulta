<?php 

class Paciente{

	// database connection and table name
    private $conn;
    private $table_name = "tb_paciente";

    public $id;
    public $apelido; 
    public $nome; 
    public $n_bi;
    public $morada;
    public $contacto;
    public $data_nasc;
    public $data_registo;
    public $utilizador; 

     // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

//read all paciente
    function readAll($from_record_num, $records_per_page){
 
    $query = "SELECT
                `id`, `apelido`, `nome`, `n_bi`, `morada`, `contacto`, `data_nasc`
            FROM
                " . $this->table_name . "
            ORDER BY
                nome ASC
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

                `id`, `apelido`, `nome`, `n_bi`, `morada`, `contacto`, `data_nasc`

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
                apelido=:apelido, nome=:nome, n_bi=:n_bi, morada=:morada, contacto=:contacto, data_nasc=:data_nasc, data_registo=:data_registo, utilizador=:utilizador";

    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->apelido=htmlspecialchars(strip_tags($this->apelido));
    $this->nome=htmlspecialchars(strip_tags($this->nome));
    $this->n_bi=htmlspecialchars(strip_tags($this->n_bi));
    $this->morada=htmlspecialchars(strip_tags($this->morada));
    $this->contacto=htmlspecialchars(strip_tags($this->contacto));
    $this->data_nasc=htmlspecialchars(strip_tags($this->data_nasc));
    $this->data_registo=date("Y-m-d H:i:s");
    $this->utilizador='freelancer';
 
	//echo $this->contacto ;
	//&''& $this->apelido &''& $this->n_bi &''& $this->morada;

    // bind values
    $stmt->bindParam(":apelido", $this->apelido);
    $stmt->bindParam(":nome", $this->nome);
    $stmt->bindParam(":n_bi", $this->n_bi);
    $stmt->bindParam(":morada", $this->morada);
    $stmt->bindParam(":contacto", $this->contacto);
    $stmt->bindParam(":data_nasc", $this->data_nasc);
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
                 `id`, `apelido`, `nome`, `n_bi`, `morada`, `contacto`, `data_nasc`
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

    $this->apelido=$row['apelido'];
    $this->nome=$row['nome'];
    $this->n_bi=$row['n_bi'];
    $this->morada=$row['morada'];
    $this->contacto=$row['contacto'];
    $this->data_nasc=$row['data_nasc'];
    

    
}

// update the product
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                apelido=:apelido, 
                nome=:nome, 
                n_bi=:n_bi, 
                morada=:morada, 
                contacto=:contacto,
                data_nasc=:data_nasc
            WHERE
                id = :id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
   	// sanitize
    $this->apelido=htmlspecialchars(strip_tags($this->apelido));
    $this->nome=htmlspecialchars(strip_tags($this->nome));
    $this->n_bi=htmlspecialchars(strip_tags($this->n_bi));
    $this->morada=htmlspecialchars(strip_tags($this->morada));
    $this->contacto=htmlspecialchars(strip_tags($this->contacto));
    $this->data_nasc=htmlspecialchars(strip_tags($this->data_nasc));

    $this->id=htmlspecialchars(strip_tags($this->id));
 

    // bind values
    $stmt->bindParam(":apelido", $this->apelido);
    $stmt->bindParam(":nome", $this->nome);
    $stmt->bindParam(":n_bi", $this->n_bi);
    $stmt->bindParam(":morada", $this->morada);
    $stmt->bindParam(":contacto", $this->contacto);
    $stmt->bindParam(":data_nasc", $this->data_nasc);
  	
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
                 `id`, `apelido`, `nome`, `n_bi`, `morada`, `contacto`, `data_nasc`
            FROM
                " . $this->table_name . " 
                
            WHERE
                nome LIKE ? OR apelido LIKE ?
            ORDER BY
                nome ASC
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
                nome LIKE ? OR apelido LIKE ?";
 
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

/*
    function isAlreadyExist(){
        $query = "SELECT *
            FROM
                " . $this->table_name . " 
            WHERE
                email='".$this->email."'";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }*/



}





?>