<?php
session_start();
?>

<script>
    carregarRelatoriosPorId(<?php echo $_SESSION['usuario_logado_id'] ?? 'null'; ?>);
</script>

<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="app/views/admin/assets/css/formularios.css" rel="stylesheet">

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<h1 class="page-title">Formulários Disponíveis</h1>

<!-- Botão para abrir a modal -->
<div class="button-container">
    <a class="add-form-button" href="?pagina=adicionarFormulario">Adicionar Formulário</a>
</div>

<!-- Exibição dos cards -->
<div id="cardbox" class="card-container"></div>
<div class="d-none" id="formulariosdispo"></div>
