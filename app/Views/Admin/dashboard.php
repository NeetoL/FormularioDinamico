<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="app/views/admin/assets/css/dash.css">
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="card card-custom">
                <h5>Quantidade de Formulários</h5>
                <div class="value" id="formCount">10</div>
                <p>Formulários registrados no sistema.</p>
            </div>

            <div class="card card-custom">
                <h5>Quantidade de Usuários</h5>
                <div class="value" id="userCount">200</div>
                <p>Total de usuários cadastrados.</p>
            </div>

            <div class="card card-custom">
                <h5>Data e Hora Atual</h5>
                <div class="date-time" id="currentDateTime">
                    <div class="date">Loading...</div>
                    <div class="time">Loading...</div>
                </div>
                <p>Data e hora do sistema.</p>
            </div>
        </div>

        <div class="row">
            <div class="card card-custom">
                <h5>Novas Mensagens</h5>
                <div class="value" id="newMessages">5</div>
                <p>Mensagens não lidas no sistema.</p>
            </div>
        </div>
    </div>
    <script src="app/views/admin/assets/js/dash.js"></script>
</body>
</html>
