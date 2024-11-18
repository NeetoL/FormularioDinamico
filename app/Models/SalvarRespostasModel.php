<?php
require_once 'config/Database.php';

class SalvarRespostasModel {
    
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect(); // Cria a instância de conexão
    }

    /**
     * Método para salvar as respostas de um formulário
     * 
     * @param int $formulario_id ID do formulário relacionado às respostas
     * @param array $respostas Respostas do formulário em formato de array
     * @return bool Retorna verdadeiro se as respostas forem inseridas com sucesso
     */
    public function salvarRespostas($formulario_id, $respostas) {
        // Converte as respostas para formato JSON
        $respostas_json = json_encode($respostas);

        $sql = "INSERT INTO respostas_formulario (respostas_json, id_formulario) VALUES (:respostas_json, :id_formulario)";

        $stmt = $this->conn->prepare($sql);

        // Usa a variável $respostas_json (que contém a string JSON) ao invés do array
        $stmt->bindParam(':respostas_json', $respostas_json);
        $stmt->bindParam(':id_formulario', $formulario_id);

        if ($stmt->execute()) {
            // Retorna sucesso em formato JSON
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Respostas salvas com sucesso!']);
            exit;
        }

        // Retorna falha em formato JSON
        return false;
    }
}
?>
