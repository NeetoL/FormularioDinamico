<?php
session_start();
class AdminController {
    public function index() {
        if (!isset($_SESSION['usuario_logado'])) {
            require_once 'app/Views/Admin/login.php';
            exit;
        }
        // Se estiver logado, exibe o painel
        require_once 'app/Views/Admin/painel.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: login?success=Deslogado com sucesso!');
        exit;
    }

    public function logoutInatividade() {
        session_start();
        session_destroy();
        header('Location: login?erro=Você foi deslogado por inatividade.');
        exit;
    }

    public function getUsuarios() {
        require_once 'app/Models/gerenciarUsuariosModel.php';
        $gerenciarUsuariosModel = new GerenciarUsuariosModel();

        $usuarios = $gerenciarUsuariosModel->listarUsuarios();
        header('Content-Type: application/json');
        echo json_encode($usuarios);
    }

    public function SalvarUsuario() {
        require_once 'app/Models/SalvarUsuariosModel.php';
        $salvarUsuariosModel = new SalvarUsuariosModel();
    
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $tipo = $_POST['tipoUsuario'];

        $resultado = $salvarUsuariosModel->salvarUsuario($nome, $email, $senha, $tipo);
    
        if ($resultado === 2) {
            header('Content-Type: application/json');
            echo json_encode([
                'codigo' => 2, 
                'mensagem' => 'O e-mail já está em uso. Escolha outro e-mail.'
            ]);
        } elseif ($resultado) {
            header('Content-Type: application/json');
            echo json_encode([
                'codigo' => 0, 
                'mensagem' => 'Usuário cadastrado com sucesso!'
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'codigo' => 1, 
                'mensagem' => 'Erro ao cadastrar o usuário. Tente novamente.'
            ]);
        }
    }

    public function carregarRelatoriosPorId() {
        require_once 'app/Models/carregarRelatoriosPorId.php';
        $carregarRelatoriosPorIdModel = new carregarRelatoriosPorId();
    
        $resultado = $carregarRelatoriosPorIdModel->carregarRelatoriosPorId($_POST['id']);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }

    public function carregarRespostasFormularioId(){
        require_once 'app/Models/obterRespostasFormularioId.php';

        $obterRespostasFormularioIdModel = new obterRespostasFormularioId();

        $resultado = $obterRespostasFormularioIdModel->obterRespostasFormularioId($_POST['id']);
        header('Content-Type: application/json');
        echo json_encode($resultado);
    }
}
