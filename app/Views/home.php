<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Formulários</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            color: #333;
        }
        .navbar {
            background-color: #b43e3e;
            border-bottom: 2px solid #ccc;
        }
        .navbar-brand, .nav-link {
            color: #fff !important; /* Texto escuro */
        }
        .navbar-brand:hover, .nav-link:hover {
            color: black !important; /* Bordô elegante */
        }
        .search-bar {
            margin: 30px 0;
        }
        .search-bar input {
            border-radius: 25px;
            padding: 10px 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Sutil realce */
            border: 1px solid #ccc;
            background-color: #fff; /* Fundo claro */
            color: #333; /* Texto escuro */
        }
        .search-bar input::placeholder {
            color: #888; /* Placeholder neutro */
        }
        .cardbox {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .card {
            width: 22rem;
            border: none;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Sutil sombra */
            border-radius: 15px;
            transition: transform 0.3s ease-in-out;
            padding: 15px;
            background-color: #fff; /* Fundo claro */
            color: #333; /* Texto escuro */
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card-title {
            font-size: 1.4rem;
            font-weight: bold;
            text-align: center;
            color: #b43e3e; /* Bordô para títulos */
        }
        .card p {
            font-size: 0.9rem;
            margin: 5px 0;
        }
        .btn-custom {
            background-color: #b43e3e; /* Cor principal */
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #942f2f; /* Tom mais escuro ao passar o mouse */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">Meus Formulários</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login">Criar Formulário</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Barra de Pesquisa -->
    <div class="container">
        <div class="search-bar d-flex justify-content-center">
            <input type="text" class="form-control w-50" id="search" placeholder="Pesquise por um formulário...">
        </div>
    </div>

    <!-- Cardbox -->
    <div class="container">
        <div class="cardbox" id="cardbox">           
        </div>
    </div>

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Script de Busca -->
    <script>
        $(document).ready(function() {
            getFormularios();
        });
        const searchInput = document.getElementById('search');
        const cards = document.querySelectorAll('.card');

        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.toLowerCase();
            cards.forEach(card => {
                const title = card.querySelector('.card-title').textContent.toLowerCase();
                if (title.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        const formatarData = function(data) {
            const dataFormatada = data.split(" ")[0];
            return dataFormatada.split("-").reverse().join("/");
        };

        const getFormularios = function() {
            $.ajax({
                url: 'obterFormularios',
                type: 'GET',
                success: function(response) {
                    var html = '';                    
                    $.each(response, function(index, obj) {
                        html += `
                                <a href="/formulario?id=${obj.id}" class="text-decoration-none text-dark">
                                    <div class="card">
                                        <h5 class="card-title">${obj.descricao}</h5>
                                        <p><strong>Data de Criação:</strong> ${formatarData(obj.data_criacao)}</p>
                                        <p><strong>Criador:</strong> ${obj.nome_usuario}</p>
                                        <p><strong>Validade:</strong> ${formatarData(obj.data_criacao)}</p>
                                        <p><strong>Descrição:</strong> ${obj.descricao}.</p>
                                    </div>
                                </a>
                                `;                        
                    });

                    $('#cardbox').html(html);
                },
                error: function() {
                    console.log('Erro ao carregar os usuários.');
                }
            });
        };
    </script>
</body>
</html>
