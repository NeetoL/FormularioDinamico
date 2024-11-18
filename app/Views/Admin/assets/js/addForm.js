function adicionarCampo() {
    var tabela = document.getElementById('camposTableBody');
    var novaLinha = document.createElement('tr');

    var tdCampo = document.createElement('td');
    var inputCampo = document.createElement('input');
    inputCampo.setAttribute('type', 'text');
    inputCampo.setAttribute('name', 'campo[]');
    inputCampo.setAttribute('class', 'form-control');
    tdCampo.appendChild(inputCampo);
    novaLinha.appendChild(tdCampo);

    var tdTipo = document.createElement('td');
    var selectTipo = document.createElement('select');
    selectTipo.setAttribute('name', 'tipo[]');
    selectTipo.setAttribute('class', 'form-control');
    
    var tipos = [
        { value: 'text', label: 'Texto' },
        { value: 'number', label: 'Número' },
        { value: 'email', label: 'Email' },
        { value: 'date', label: 'Data' },
        { value: 'tel', label: 'Telefone' },
        { value: 'password', label: 'Senha' },
        { value: 'url', label: 'URL' },
        { value: 'color', label: 'Cor' },
        { value: 'file', label: 'Arquivo' }
    ];

    tipos.forEach(function(tipo) {
        var option = document.createElement('option');
        option.value = tipo.value;
        option.textContent = tipo.label;
        selectTipo.appendChild(option);
    });

    tdTipo.appendChild(selectTipo);
    novaLinha.appendChild(tdTipo);

    var tdAcao = document.createElement('td');
    var btnRemover = document.createElement('button');
    btnRemover.textContent = 'Remover';
    btnRemover.setAttribute('type', 'button');
    btnRemover.setAttribute('class', 'btn btn-danger btn-sm');
    btnRemover.onclick = function() {
        tabela.removeChild(novaLinha);
    };
    tdAcao.appendChild(btnRemover);
    novaLinha.appendChild(tdAcao);

    tabela.appendChild(novaLinha);
}

function salvarFormulario() {
    var nome = document.getElementById('nomeFormulario').value;
    var descricao = document.getElementById('descricaoFormulario').value;
    var validade = document.getElementById('validadeFormulario').value;

    var campos = [];
    var camposInputs = document.querySelectorAll('input[name="campo[]"]');
    var tiposCampos = document.querySelectorAll('select[name="tipo[]"]');

    camposInputs.forEach(function(input, index) {
        campos.push({
            campo: input.value,
            tipo: tiposCampos[index].value
        });
    });

    var dadosFormulario = {
        nome: nome,
        descricao: descricao,
        validade: validade,
        campos: campos
    };
}