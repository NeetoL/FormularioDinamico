<?php
require_once 'config/Database.php'; // Conexão com o banco de dados

class obterCamposFormularios {

    private $db;
    
    public function __construct() {
        $this->db = (new Database())->connect(); // Cria a instância de conexão
    }

    public function obterCamposFormularios($id) {
        $query = "SELECT cf.nome_campo,f.id FROM campos_formulario cf INNER JOIN formularios f ON cf.id_formulario = f.id WHERE f.id = :id";
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
