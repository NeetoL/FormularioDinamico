<?php
require_once 'config/Database.php'; // Conexão com o banco de dados

class carregarRelatoriosPorId {

    private $db;
    
    public function __construct() {
        $this->db = (new Database())->connect(); // Cria a instância de conexão
    }

    public function carregarRelatoriosPorId($id) {
        $query = "SELECT 
                    f.*,
                    u.nome AS nome_usuario
                  FROM 
                    formularios f
                  INNER JOIN 
                    usuarios u 
                  ON 
                    f.id_usuario = u.id
                    WHERE id_usuario = :id";
        // Prepara a consulta
        $stmt = $this->db->prepare($query);

        // Bind do parâmetro
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Executa a consulta
        $stmt->execute();
        // Retorna os resultados como um array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
