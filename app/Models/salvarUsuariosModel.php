<?php
require_once 'config/Database.php';

class SalvarUsuariosModel {
    
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect(); // Cria a instância de conexão
    }

    /**
     * Método para salvar um novo usuário
     * 
     * @param string $nome Nome do usuário
     * @param string $email E-mail do usuário
     * @param string $senha Senha do usuário
     * @param string $tipo Tipo de usuário (admin, editor, etc.)
     * @return bool|int Retorna verdadeiro se o usuário for inserido com sucesso, 
     *                  ou código 2 se o e-mail já estiver em uso
     */
    public function salvarUsuario($nome, $email, $senha, $tipo) {
        if ($this->emailExiste($email)) {
            return 2;
        }

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha, nivel) VALUES (:nome, :email, :senha, :tipo)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senhaHash);
        $stmt->bindParam(':tipo', $tipo);


        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    /**
     * Método para verificar se o e-mail já existe no banco de dados
     * 
     * @param string $email E-mail a ser verificado
     * @return bool Retorna true se o e-mail existir no banco de dados
     */
    private function emailExiste($email) {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = :email";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }
}
?>
