<?php
require_once 'config/Database.php'; // Conexão com o banco de dados

class obterRespostasFormularioId {

    private $db;
    
    public function __construct() {
        $this->db = (new Database())->connect();
    }

    public function obterRespostasFormularioId($id) {
        // Consulta SQL para listar todos os usuários (exceto o logado)
        $query = "SELECT * FROM `respostas_formulario` WHERE id_formulario = :id";
        
        
        // Prepara a consulta
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Retorna os resultados como um array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
