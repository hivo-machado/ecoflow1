<?php
class Leituras{
  
    // Conexao com o database e o nome da tabela
    private $conn;
    private $table_name = "unidade";
  
    // Propriedades do objeto
    public $idecoflow;
    public $tempo;
    public $hora;
    public $id_planta_fk;
    public $nome;
    public $medidor;
    public $servico;
    public $leitura;
  
    // Construtor com $db e conexão com o database
    public function __construct($db){
        $this->conn = $db;
    }

    // Criar nova medição
    function createLeituras(){

    // Query para inserir a nova linha
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                idecoflow=:idecoflow, tempo=:tempo, hora=:hora, id_planta_fk=:id_planta_fk, nome=:nome, medidor=:medidor, servico=:servico, leitura=:leitura";

    // Preparar query
    $stmt = $this->conn->prepare($query);

    // Limpeza
    $this->idecoflow=htmlspecialchars(strip_tags($this->idecoflow));
    $this->tempo=htmlspecialchars(strip_tags($this->tempo));
    $this->hora=htmlspecialchars(strip_tags($this->hora));
    $this->id_planta_fk=htmlspecialchars(strip_tags($this->id_planta_fk));
    $this->nome=htmlspecialchars(strip_tags($this->nome));
    $this->medidor=htmlspecialchars(strip_tags($this->medidor));
    $this->servico=htmlspecialchars(strip_tags($this->servico));
    $this->leitura=htmlspecialchars(strip_tags($this->leitura));

    // Vincular os valores
    $stmt->bindParam(":idecoflow", $this->idecoflow);
    $stmt->bindParam(":tempo", $this->tempo);
    $stmt->bindParam(":hora", $this->hora);
    $stmt->bindParam(":id_planta_fk", $this->id_planta_fk);
    $stmt->bindParam(":nome", $this->nome);
    $stmt->bindParam(":medidor", $this->medidor);
    $stmt->bindParam(":servico", $this->servico);
    $stmt->bindParam(":leitura", $this->leitura);

    // Executar a query
    if($stmt->execute()){
        return true;
    }

    return false;
        
    }
}
?>