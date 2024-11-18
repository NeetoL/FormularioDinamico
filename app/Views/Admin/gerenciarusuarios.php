<script>
    carregarUsuarios();
</script>
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<style>
    @media (max-width: 767px) {
        #usuariosTable {
            width: 200%;
            font-size: 14px;
            border-collapse: collapse;
        }

        #usuariosTable th {
            padding: 10px;
            text-align: left;
            font-size: 16px;
        }

        #usuariosTable td {
            padding: 8px;
            text-align: left;
        }

        #usuariosTable button {
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .editar {
            background-color: #ffcd39;
            color: white;
            border: 1px solid transparent;
            font-weight: bold;
        }

        .editar:hover {
            background-color: #e0a800;
        }

        .excluir {
            background-color: #dc3545;
            color: white;
            border: 1px solid transparent;
            font-weight: bold;
        }

        .excluir:hover {
            background-color: #c82333;
        }

        .dataTables_paginate .paginate_button {
            padding: 6px 12px;
            border-radius: 4px;
            border: 1px solid #ddd;
            color: #007bff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .dataTables_paginate .paginate_button:hover {
            background-color: #007bff;
            color: white;
            border-color: #0056b3;
        }

        /* Ajuste para os botões de próxima e anterior da paginação */
        .dataTables_paginate .paginate_button.previous,
        .dataTables_paginate .paginate_button.next {
            background-color: #5e63ff;
            color: white;
        }

        .dataTables_paginate .paginate_button.previous:hover,
        .dataTables_paginate .paginate_button.next:hover {
            background-color: #3b44d0;
        }

        .dataTables_wrapper {
            margin-top: 20px;
        }
    }

    /* Estilos gerais para desktop e dispositivos maiores */
    @media (min-width: 768px) {
        #usuariosTable {
            width: 5%;
        }

        /* Botão adicionar usuário */
        .adicionar {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
    }
</style>
