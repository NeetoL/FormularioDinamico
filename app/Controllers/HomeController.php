<?php
class HomeController {
    public function index() {
        require_once 'app/Views/home.php';
    }
    
    public function formulario() {
        require_once 'app/Views/formulario.php';
    }

    public function obterFormularios() {
        require_once 'app/Models/ObterFormularios.php';
        $ObterFormulariosModel = new ObterFormularios();

        $formularios = $ObterFormulariosModel->obterFormularios();
        header('Content-Type: application/json');
        echo json_encode($formularios);
    }

    public function obterCamposFormularios() {
        require_once 'app/Models/obterCamposFormularios.php';        
        $obterCamposFormulariosModel = new obterCamposFormularios();

        $CamposFormularios = $obterCamposFormulariosModel->obterCamposFormularios($_POST['id'] ?? '');
        
        header('Content-Type: application/json');
        echo json_encode($CamposFormularios);
    }

    public function enviarRespostas() {
        require_once 'app/Models/SalvarRespostasModel.php';
        $return = [];
        
    
        // Recebe os dados JSON do corpo da requisição
        $inputData = file_get_contents('php://input');
    
        // Decodifica os dados JSON para um array PHP
        $respostas = json_decode($inputData, true);

        $id_formulario = null;
        foreach ($respostas as $resposta) {
            if ($resposta['campo'] === 'id') {
                $id_formulario = $resposta['value']; // Extrai o id do formulário
                break; // Encontrado, não precisa continuar
            }
        }

        if (!empty($respostas)) {
            // Cria uma instância do modelo de salvar respostas
            $salvarRespostasModel = new SalvarRespostasModel();
    
            // Salva as respostas no banco de dados
            if ($salvarRespostasModel->salvarRespostas($id_formulario, $respostas)) {
                $return = ['message' => 'Respostas salvas com sucesso!'];
            } else {
                $return = ['message' => 'Erro ao salvar as respostas.'];
            }
    
        } else {
            // Caso não haja dados
            $return = ['message' => 'Nenhum dado foi enviado.'];
        }
    
        // Define o tipo de conteúdo como JSON
        header('Content-Type: application/json');
        echo json_encode($return);
        exit;
    }
    
}
