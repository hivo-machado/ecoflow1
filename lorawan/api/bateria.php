<?php
class Bateria{
  
    // database connection and table name
    private $conn;
    private $table_name = "bateria";
  
    // object properties
    public $idecoflow;
    public $bateria;
    public $tempo;
    public $hora;
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // create product
    function create(){

    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                idecoflow=:idecoflow, bateria=:bateria, tempo=:tempo, hora=:hora";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->idecoflow=htmlspecialchars(strip_tags($this->idecoflow));
    $this->bateria=htmlspecialchars(strip_tags($this->bateria));
    $this->tempo=htmlspecialchars(strip_tags($this->tempo));
    $this->hora=htmlspecialchars(strip_tags($this->hora));

    // bind values
    $stmt->bindParam(":idecoflow", $this->idecoflow);
    $stmt->bindParam(":bateria", $this->bateria);
    $stmt->bindParam(":tempo", $this->tempo);
    $stmt->bindParam(":hora", $this->hora);
    
    // execute query
    if($stmt->execute()){
        return true;
    }

    return false;
        
    }
}
?>