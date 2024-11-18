<link rel="stylesheet" href="app/views/admin/assets/css/addForm.css">
<div class="container">
    <h1 class="text-center">Adicionar Novo Formulário</h1>
    
    <div class="form-group">
        <label for="nomeFormulario">Nome do Formulário</label>
        <input type="text" id="nomeFormulario" class="form-control" placeholder="Digite o nome do formulário" required>
    </div>

    <div class="form-group">
        <label for="descricaoFormulario">Descrição</label>
        <textarea id="descricaoFormulario" class="form-control" placeholder="Descreva o objetivo do formulário" required></textarea>
    </div>

    <div class="form-group">
        <label for="validadeFormulario">Validade</label>
        <input type="date" id="validadeFormulario" class="form-control" required>
    </div>

    <h3>Campos do Formulário</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Campo</th>
                <th>Tipo</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody id="camposTableBody">
        </tbody>
    </table>

    <button type="button" class="btn btn-primary" onclick="adicionarCampo()">Adicionar Campo</button>

    <button type="button" class="btn btn-success mt-3" onclick="salvarFormulario()">Salvar Formulário</button>
    <script src="app/views/admin/assets/js/addForm.js"></script>
</div>
