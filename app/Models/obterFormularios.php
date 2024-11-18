<?php
require_once 'config/Database.php'; // Conexão com o banco de dados

class ObterFormularios {

    private $db;
    
    public function __construct() {
        $this->db = (new Database())->connect(); // Cria a instância de conexão
    }

    public function obterFormularios() {
        // Consulta SQL para listar todos os usuários (exceto o logado)
        $query = "SELECT 
                    f.*,
                    u.nome AS nome_usuario
                  FROM 
                    formularios f
                  INNER JOIN 
                    usuarios u 
                  ON 
                    f.id_usuario = u.id;";
        
        // Prepara a consulta
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        // Retorna os resultados como um array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
