$(document).ready(function() {
    const notyf = new Notyf();
    var urlParams = new URLSearchParams(window.location.search);
    var pagina = urlParams.get('pagina') || 'inicio';
    carregarConteudo(pagina);

    $('a[href^="?pagina="]').on('click', function(e) {
        e.preventDefault();

        var pagina = new URLSearchParams($(this).attr('href').substring(1)).get('pagina');

        carregarConteudo(pagina);

        window.history.pushState({}, '', $(this).attr('href'));
    });

    $("#saveUserBtn").on('click', function() {
        var nome =  $("#userName").val();
        var email = $("#userEmail").val(); 
        var senha = $("#userPassword").val(); 
        var tipoUsuario = $("#tipoUsuario option:selected").val();

        if (isNullOrEmpty(nome)) {
            notyf.error('Preencha o campo Nome');
            return;
        }

        if (isNullOrEmpty(email)) {
            notyf.error('Preencha o campo email');
            return;
        }

        if (isNullOrEmpty(senha)) {
            notyf.error('Preencha o campo senha');
            return;
        }

        if (isNullOrEmpty(tipoUsuario)) {
            notyf.error('Preencha o campo Tipo de usuario');
            return;
        }

        $.ajax({
            url: 'SalvarUsuario',
            type: 'POST',
            data:{
                nome : nome,
                email : email,
                senha : senha,
                tipoUsuario: tipoUsuario
            },
            success: function(response) {
                debugger;
                if(response.codigo==0){
                    notyf.success(response.mensagem)
                    window.location.reload();
                }else{ 
                    notyf.error(response.mensagem);
                }
            },
            error: function() {
                alert('Erro ao carregar os usuários.');
            }
        });

    
        


    });

    let ultimoMovimento = new Date().getTime();

    const inatividade = function() {
        const agora = new Date().getTime();
        const tempoInativo = agora - ultimoMovimento;
    
        if (tempoInativo >= 6*10000) { // 5000ms = 5 segundos
            window.location.href = 'logoutInatividade';
        }
    };
    
    const resetarInatividade = function() {
        ultimoMovimento = new Date().getTime();
    };
    
    document.addEventListener("mousemove", resetarInatividade);
    document.addEventListener("keypress", resetarInatividade);
    document.addEventListener("click", resetarInatividade);
    document.addEventListener("scroll", resetarInatividade);
    
    setInterval(inatividade, 5000);
});

const calendario = function() {
        var html = `
            <main>
                <div class="container">
                    <h2>Calendario</h2>
                </div>
            </main>`;
        $("#conteudo").html(html);
}

const dashboard = function() {
    debugger;
        var html = `
            <main>
                <div class="container">
                    <h2>dashboard</h2>
                </div>
            </main>`;
        $("#conteudo").html(html);
}

const criarUsuario = function() {
    debugger;
        var html = `
            <main>
                <div class="container">
                    <h2>criarUsuario</h2>
                </div>
            </main>`;
        $("#conteudo").html(html);
}

const isNullOrEmpty = function (value) {
    return value === null || value === undefined || value.trim() === '';
}

const carregarConteudo = function (pagina) {
    let conteudo = $('#conteudo');

    switch (pagina) {
        case 'inicio':
            conteudo.load('app/views/admin/inicio.php');
            $("nav ul li").removeClass("active");
            $(`nav ul li a[href="?pagina=${pagina}"]`).parent().addClass("active");
            break;
        case 'calendario':
            conteudo.load('app/views/admin/calendario.php');
            $("nav ul li").removeClass("active");
            $(`nav ul li a[href="?pagina=${pagina}"]`).parent().addClass("active");
            break;
        case 'usuario':
            conteudo.load('app/views/admin/gerenciarusuarios.php');
            $("nav ul li").removeClass("active");
            $(`nav ul li a[href="?pagina=${pagina}"]`).parent().addClass("active");
            break;
        case 'formularios':
            conteudo.load('app/views/admin/formularios.php');
            $("nav ul li").removeClass("active");
            $(`nav ul li a[href="?pagina=${pagina}"]`).parent().addClass("active");
            break;
        case 'adicionarFormulario':
            conteudo.load('app/views/admin/addformularios.php');
            $("nav ul li").removeClass("active");
            $(`nav ul li a[href="?pagina=${pagina}"]`).parent().addClass("active");
            break;
        case 'dashboard':
            conteudo.load('app/views/admin/dashboard.php');
            $("nav ul li").removeClass("active");
            $(`nav ul li a[href="?pagina=${pagina}"]`).parent().addClass("active");
            break;
        case 'config':
            conteudo.load('app/views/admin/inicio.php');
            $("nav ul li").removeClass("active");
            $(`nav ul li a[href="?pagina=${pagina}"]`).parent().addClass("active");
            break;
        case 'criarUsuario':
            conteudo.load('app/views/admin/criarUsuario.php');
            $("nav ul li").removeClass("active");
            $(`nav ul li a[href="?pagina=${pagina}"]`).parent().addClass("active");
            break;
        case 'criarFormulario':
            conteudo.load('app/views/admin/addformularios.php');
            $("nav ul li").removeClass("active");
            $(`nav ul li a[href="?pagina=${pagina}"]`).parent().addClass("active");
            break;
        default:
            conteudo.html('<h2>Erro</h2><p>Página não encontrada.</p>');
            $("nav ul li").removeClass("active");
            break;
    }
}

const carregarUsuarios = function() {
    $.ajax({
        url: 'usuarios',
        type: 'GET',
        success: function(response) {
            console.log(response);
            var html = '<table id="usuariosTable">';
            html += '<thead><tr><th>ID</th><th>Nome</th><th>Email</th><th>Ações</th></tr></thead><tbody>';
            
            $.each(response, function(index, obj) {
                html += '<tr>';
                html += `<td>${obj.id}</td>`;
                html += `<td>${obj.nome}</td>`;
                html += `<td>${obj.email}</td>`;
                html += '<td style="color:white">';
                
                html += `<button class="editar" onclick="editar(${obj.id})" data-id="${obj.id}">Editar</button>`;
                html += `<button class="excluir" onclick="excluir(${obj.id})" data-id="${obj.id}">Excluir</button>`;

                html += '</td>';
                html += '</tr>';
            });

            html += '</tbody></table></div>';
            html += '<div>';

            $('#conteudo').html(html);
            
            dataTable();
        },
        error: function() {
            notyf.error('Erro ao carregar os usuários.');
        }
    });
}

const dataTable = function() {
    // Inicializando o DataTable
    $('#usuariosTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "language": {
            "search": "",
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "info": "Mostrando _START_ até _END_ de _TOTAL_ registros",
            "infoEmpty": "Nenhum registro encontrado",
            "infoFiltered": "(filtrado de _MAX_ registros no total)",
            "paginate": {
                "next": "Próximo",
                "previous": "Anterior"
            }
        },
        "dom": '<"top"f>rt<"bottom"p><"clear">'
    });

    // Estilizando a tabela com CSS personalizado
    $('#usuariosTable')
        .css({
            'width': '100%',
            'border-collapse': 'collapse',
            'font-family': 'Arial, sans-serif',
            'border': '1px solid #ddd'
        });

    // Estilizando o cabeçalho da tabela
    $('#usuariosTable th')
        .css({
            'background-color': '#5e63ff',
            'border-bottom': '2px solid #ddd',
            'padding': '10px 15px',
            'font-weight': 'bold',
            'color' : 'white',
            'text-align': 'center',
            'margin': '20px 0'
        });

    // Estilizando as células da tabela
    $('#usuariosTable td')
        .css({
            'padding': '8px 12px',
            'border-bottom': '1px solid #ddd',
            'text-align': 'center',
            'margin': '20px 0'
        });

    // Estilo para o campo de busca
    $('#usuariosTable_filter input')
        .css({
            'width': '200px',
            'padding': '6px 12px',
            'border-radius': '4px',
            'border': '1px solid #ddd',
            'font-size': '14px',
            'margin-bottom': '10px',
            'margin-top': '20px' 
        })
        .attr('placeholder', 'Pesquisar');

    // Estilizando a paginação
    $('.dataTables_paginate .paginate_button')
        .css({
            'padding': '6px 12px',
            'border-radius': '4px',
            'border': '1px solid #ddd',
            'color': '#007bff',
            'font-weight': 'bold',
            'cursor': 'pointer',
            'transition': 'background-color 0.3s ease, border-color 0.3s ease'
        })
        .hover(
            function() {
                $(this).css({
                    'background-color': '#007bff',
                    'color': 'white',
                    'border-color': '#0056b3',
                });
            },
            function() {
                $(this).css({
                    'background-color': 'transparent',
                    'color': '#007bff',
                    'border-color': '#ddd',
                });
            }
        );

    $('.dataTables_paginate')
        .css({
            'margin-top': '20px' 
        });

        $(".editar")
        .css({
            'padding': '6px 12px',
            'background-color': '#ffcd39',
            'color': 'white',
            'border-radius': '4px',
            'border': '1px solid transparent',
            'font-weight': 'bold',
            'cursor': 'pointer',
            'transition': 'background-color 0.3s ease, border-color 0.3s ease',
        })
        .hover(
            function() {
                $(this).css({
                    'background-color': '#e0a800',
                    'color': 'white',
                });
            },
            function() {
                $(this).css({
                    'background-color': '#ffcd39',
                    'color': 'white',
                });
            }
        );

    $(".excluir")
        .css({
            'padding': '6px 12px',
            'background-color': '#dc3545',
            'color': 'white',
            'border-radius': '4px',
            'border': '1px solid transparent',
            'font-weight': 'bold',
            'cursor': 'pointer',
            'transition': 'background-color 0.3s ease, border-color 0.3s ease',
        })
        .hover(
            function() {
                $(this).css('background-color', '#c82333');
            },
            function() {
                $(this).css('background-color', '#dc3545');
            }
        );

    $("#usuariosTable button")
        .css({
            'padding': '6px 12px',
            'border-radius': '4px',
            'border': '1px solid transparent',
            'font-weight': 'bold',
            'cursor': 'pointer',
            'transition': 'background-color 0.3s ease, border-color 0.3s ease',
            'text-align': 'center',
        })
};

const excluir = function(id){
    $.confirm({
        title: 'Você tem certeza?',
        content: 'Esta ação não pode ser desfeita!',
        buttons: {
            confirm: {
                text: 'Sim, deletar!',
                btnClass: 'btn-danger',
                action: function () {
                    // Aqui você pode realizar a exclusão do item, por exemplo, via AJAX
                    // Para fins de exemplo, apenas mostramos a mensagem de sucesso
                    notyf.success('Deletado com sucesso!');
                    // Caso precise redirecionar ou recarregar a página após a exclusão, você pode fazer isso aqui
                    // window.location.reload(); ou qualquer outra ação após a exclusão.
                }
            },
            cancel: {
                text: 'Cancelar',
                btnClass: 'btn-primary'
            }
        }
    });
}

const editar = function(id){
    notyf.error('editar o id ' + id); 
}

const formatarData = function(data) {
    const dataFormatada = data.split(" ")[0];
    return dataFormatada.split("-").reverse().join("/");
}

const carregarRelatoriosPorId = function(id){
    $.ajax({
        url: 'carregarRelatoriosPorId',
        type: 'POST',
        data:{id:id},
        success: function(response) {
            console.log(response);  
            var html = '';
            $.each(response, function(index,obj){
                $("#cardbox").append(`
                        <a href="javascript:respostasRelatorio(${obj.id})" class="card-decoration">
                                    <div class="card">
                                        <h5 class="card-title">${obj.descricao}</h5>
                                        <p><strong>Data de Criação:</strong> ${formatarData(obj.data_criacao)}</p>
                                        <p><strong>Criador:</strong> ${obj.nome_usuario}</p>
                                        <p><strong>Validade:</strong> ${formatarData(obj.data_criacao)}</p>
                                        <p><strong>Descrição:</strong> ${obj.descricao}.</p>
                                    </div>
                                </a>
                        `);    
            })        
        },
        error: function() {
            notyf.error('Erro ao carregar os usuários.');
        }
    });
}

const respostasRelatorio = function (idFormulario) {
    $("#cardbox").empty();

    $.ajax({
        url: 'carregarRespostasFormularioId',
        type: 'POST',
        data: { id: idFormulario },
        success: function (response) {
            var html = '<table id="respostasTables" class="table table-striped table-hover">';
                html += '<thead class="table-dark">';
                html += '<tr>';
            var json = '';
            $.each(response, function (index, obj) {
                json = JSON.parse(obj.respostas_json);
                $.each(json, function (index, item) {
                    if (item.campo !== 'id') {
                        html += `<th>${item.campo}</th>`;
                    }
                });
            });
            html += `<th>AÇÕES</th>`;
            html += '</tr></thead><tbody>';

            $.each(response, function (index, obj) {
                html += `<tr>`;
                json = JSON.parse(obj.respostas_json);
                $.each(json, function (index, item) {
                    if (item.campo !== 'id') {
                        html += `<td>${item.value}</td>`;
                    }
                });

                $.each(json, function (index, item) {
                    if (item.campo == 'id') {
                        // Botões de ação
                        html+= '<td>';
                        html += `<a 
                                    class="btn btn-warning btn-sm editar" 
                                    href="javascript:editar(${item.value})">
                                    Editar
                                </a>`;
                        html += `<a 
                                    class="btn btn-danger btn-sm excluir" 
                                    href="javascript:excluir(${item.value})">
                                    Excluir
                                </a>`;            
                        html+= '</td>';
                    }
                });
                
                
                html += `</tr>`;
            });

            html += '</tbody></table>';
            $("#formulariosdispo").append(html);
            $("#formulariosdispo").removeClass("d-none");

                        // Ativar DataTable
                        $('#respostasTables').DataTable({
                            "paging": true,  // Ativa paginação
                            "searching": true,  // Ativa a busca
                            "ordering": true,  // Ativa a ordenação das colunas
                            "info": true,  // Mostra informações de quantos itens estão sendo mostrados
                            "language": {
                                "search": "",
                                "lengthMenu": "Mostrar _MENU_ registros por página",
                                "info": "Mostrando _START_ até _END_ de _TOTAL_ registros",
                                "infoEmpty": "Nenhum registro encontrado",
                                "infoFiltered": "(filtrado de _MAX_ registros no total)",
                                "paginate": {
                                    "next": "Próximo",
                                    "previous": "Anterior"
                                }
                            },
                            "dom": '<"top"f>rt<"bottom"p><"clear">'
                        });
            
            
            
                        $('#usuariosTable_filter input')
                        .addClass('form-control form-control')
                        .css('width', '200px')
                        .attr('placeholder', 'Pesquisar');
                        $('.dataTables_paginate .paginate_button').addClass('btn btn-outline-dark btn-sm');
                        $('.dataTables_paginate .paginate_button.previous').addClass('me-2');
                        $('.dataTables_paginate .paginate_button.next').addClass('ms-2');
                        $("#respostasTables_paginate").removeClass("dataTables_paginate").addClass("mt-3");

        },
        error: function () {
            notyf.error('Erro ao carregar os usuários.');
        },
    });
}