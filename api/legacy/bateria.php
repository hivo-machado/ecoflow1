<?php
class Bateria{
  
    // Conexao com o database e o nome da tabela
    private $conn;
    private $table_name = "lorawan_status";
  
    // Propriedades do objeto
    public $device_addr;
    public $tempo;
    public $hora;
    public $snr;
    public $rssi;
    public $nivel_bateria;

      
    // Construtor com $db e conexão com o database
    public function __construct($db){
        $this->conn = $db;
    }

    // Criar novo nivel da bateria
    function createBateria(){

    // Query para inserir a nova linha
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                device_addr=:device_addr, tempo=:tempo, hora=:hora, snr=:snr, rssi=:rssi, nivel_bateria=:nivel_bateria";
                
    // Preparar query
    $stmt = $this->conn->prepare($query);

    // Limpeza
    $this->device_addr=htmlspecialchars(strip_tags($this->device_addr));    
    $this->tempo=htmlspecialchars(strip_tags($this->tempo));
    $this->hora=htmlspecialchars(strip_tags($this->hora));
    $this->snr=htmlspecialchars(strip_tags($this->snr));
    $this->rssi=htmlspecialchars(strip_tags($this->rssi));
    $this->nivel_bateria=htmlspecialchars(strip_tags($this->nivel_bateria));

    // Vincular os valores
    $stmt->bindParam(":device_addr", $this->device_addr);    
    $stmt->bindParam(":tempo", $this->tempo);
    $stmt->bindParam(":hora", $this->hora);
    $stmt->bindParam(":snr", $this->snr);
    $stmt->bindParam(":rssi", $this->rssi);
    $stmt->bindParam(":nivel_bateria", $this->nivel_bateria);

        
    // Executar a query
    if($stmt->execute()){
        return true;
    }

    return false;
        
    }
}
?>