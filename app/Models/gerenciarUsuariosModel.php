<?php
require_once 'config/Database.php'; // Conexão com o banco de dados

class GerenciarUsuariosModel {

    private $db;
    
    public function __construct() {
        $this->db = (new Database())->connect(); // Cria a instância de conexão
    }

    public function listarUsuarios() {
        // Consulta SQL para listar todos os usuários (exceto o logado)
        $query = "SELECT * FROM usuarios";
        
        // Prepara a consulta
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Retorna os resultados como um array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
