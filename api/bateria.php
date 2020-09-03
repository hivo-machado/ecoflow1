<?php
class Bateria{
  
    // Conexao com o database e o nome da tabela
    private $conn;
    private $table_name = "bateria";
  
    // Propriedades do objeto
    public $deviceAddr;
    public $nivel;
    public $tempo;
    public $hora;
  
    // Construtor com $db e conexão com o database
    public function __construct($db){
        $this->conn = $db;
    }

    // Criar novo nivel da bateria
    function create(){

    // Query para inserir a nova linha
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                deviceAddr=:deviceAddr, nivel=:nivel, tempo=:tempo, hora=:hora";

    // Preparar query
    $stmt = $this->conn->prepare($query);

    // Limpeza
    $this->deviceAddr=htmlspecialchars(strip_tags($this->deviceAddr));
    $this->nivel=htmlspecialchars(strip_tags($this->nivel));
    $this->tempo=htmlspecialchars(strip_tags($this->tempo));
    $this->hora=htmlspecialchars(strip_tags($this->hora));

    // Vincular os valores
    $stmt->bindParam(":idecoflow", $this->deviceAddr);
    $stmt->bindParam(":bateria", $this->nivel);
    $stmt->bindParam(":tempo", $this->tempo);
    $stmt->bindParam(":hora", $this->hora);
    
    // Executar a query
    if($stmt->execute()){
        return true;
    }

    return false;
        
    }
}
?>