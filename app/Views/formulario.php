<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Formulários</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3.6.0/notyf.min.css">
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
        body {
            background-color: #f4f4f9;
            color: #333;
        }
        .navbar {
            background-color: #b43e3e;
            border-bottom: 2px solid #ccc;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .navbar-brand:hover, .nav-link:hover {
            color: var(--base-clr) !important;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 15px;
            background-color: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #b43e3e;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: rgba(178, 45, 0, 0.8); /* Cor com opacidade reduzida */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">Meus Formulários</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login">Criar Formulário</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div id="form-container" class="form-container">
            <h3 class="text-center" style="color:#b43e3e">Formulário Dinâmico</h3>
            <form id="dynamic-form">
            </form>
            <button type="submit" class="btn btn-custom w-100 mt-3" id="submit-form">Enviar</button>
        </div>
    </div>

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3.6.0/notyf.min.js"></script>
    <script>
        $(document).ready(function() {
            // Instância do Notyf
            const notyf = new Notyf();

            var id = <?php echo $_GET['id'] ?? 'null'; ?>;
            
            if (id) {
                getCamposFormularios(id);
            } else {
                alert('ID do formulário não informado.');
            }

            function getCamposFormularios(id) {
                $.ajax({
                    url: 'obterCamposFormularios',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        debugger;
                        if (response.length == 0) {
                            notyf.error('Nenhum campo encontrado para este formulário.');
                            return;
                        }

                        $('#dynamic-form').empty();

                        var html = '';
                        response.forEach(function(campo) {
                            html += `<div class="mb-3">
                                        <label for="${campo.nome_campo}" class="form-label">${campo.nome_campo}</label>
                                        <input type="text" class="form-control" id="${campo.nome_campo}" name="${campo.nome_campo}" placeholder="Digite ${campo.nome_campo}">
                                    </div>`;
                        });

                        $('#dynamic-form').append(html);

                        $('#dynamic-form').append(`<input type="text" class="form-control d-none" id="${response[0].id}" value="${response[0].id}" name="id" placeholder="Digite o ID${response[0].id}">`);
                    },
                    error: function() {
                        notyf.error('Erro ao carregar os campos do formulário.');
                    }
                });
            }

            $('#submit-form').on('click', function(e) {
                e.preventDefault();
                var formArray = [];

                var formData = $('#dynamic-form').serialize();
                var params = new URLSearchParams(formData);

                params.forEach(function(value, key) {
                    formArray.push({ campo: key, value: value });
                });

                console.log(JSON.stringify(formArray));
                debugger;
                // Envia os dados via AJAX no formato JSON
                $.ajax({
                    url: 'enviarRespostas',
                    type: 'POST',
                    contentType: 'application/json', // Indica que está enviando JSON
                    data: JSON.stringify(formArray), // Converte o array de objetos para JSON
                    success: function(response) {
                        debugger;
                        notyf.success('Dados enviados com sucesso!');
                        setTimeout(() => {
                            window.location.reload();
                        }, 3000);
                    },
                    error: function() {
                        notyf.error('Erro ao enviar o formulário.');
                    }
                });
            });

        });
    </script>
    
</body>
</html>
