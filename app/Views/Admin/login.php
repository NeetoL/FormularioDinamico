<?php
require_once 'config/Database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$database = new Database();
$pdo = $database->connect();

if (isset($_SESSION['usuario_logado'])) {
    require_once 'app/Views/Admin/painel.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $usuario);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['usuario_logado'] = $user['nome'];
            $_SESSION['usuario_logado_id'] = $user['id'];
            $_SESSION['nome'] = $user['nome'];
            $_SESSION['nivel'] = $user['nivel'];
            header('Location: login');
            exit;
        } else {
            $erro = 'Usuário ou senha inválidos!';
        }
    } else {
        $erro = 'Usuário não encontrado!';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        :root{
            --base-clr: #11121a;
            --line-clr: #42434a;
            --hover-clr: #222533;
            --text-clr: #e6e6ef;
            --accent-clr: #5e63ff;
            --secondary-text-clr: #b0b3c1;
        }

        html{
            font-family: Poppins, 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.5rem;
        }

        body {
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-card {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            width: 100%;
            max-width: 400px;
        }

        .logo {
            width: 50px;
            height: 50px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .login-card {
                padding: 15px;
            }

            .logo {
                width: 40px;
                height: 40px;
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 10px;
            }

            .logo {
                width: 35px;
                height: 35px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card login-card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="https://img.icons8.com/ios-filled/50/000000/lock.png" alt="Logo" class="logo">

                            <?php if (isset($erro)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $erro; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($_GET['erro'])): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $_GET['erro'] ?>
                                </div>
                            <?php endif; ?>

                            <?php if (isset($_GET['success'])): ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo $_GET['success'] ?>
                                </div>
                            <?php endif; ?>

                            <!-- Formulário de login -->
                            <form action="login" method="POST">
                                <div class="mb-3">
                                    <label for="usuario" class="form-label">Usuário</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                                </div>
                                <div class="mb-3">
                                    <label for="senha" class="form-label">Senha</label>
                                    <input type="password" class="form-control" id="senha" name="senha" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Entrar</button>
                            </form>
                            <div class="mt-3">
                                <a href="/" class="btn btn-secondary w-100">Voltar para o site</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
