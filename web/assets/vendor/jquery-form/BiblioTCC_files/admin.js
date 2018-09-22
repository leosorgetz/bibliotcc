Admin = {
    Init: function () {
        Admin.Datatable();
        Admin.JqueryMask();
        Admin.Boards();
    },
    Datatable: function () {
        // Config default para o datatable
        $.extend(true, $.fn.dataTable.defaults, {
            "language": {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar:",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
            "pageLength": 10,
            "lengthChange": false
        });

        //Tabelas Padrões
        $(".datatable").DataTable({});

        $('.datatable-boards').DataTable({    //Criação da dataTable
            "columns": [
                null,
                null,
                {"type": "date-euro"},
                null
            ],
            "order": [
                [2, "asc"]
            ]
        });

        $('.datatable-dashboard').DataTable({    //Criação da dataTable
            "columns": [
                null,
                null,
                {"type": "date-euro"},
                null
            ],
            "order": [
                [2, "asc"]
            ]
        });

    },
    JqueryMask: function () {
        function setMaxMin(field) {
            field.change(function () {
                // var max = parseInt($(this).attr('max'));
                // var min = parseInt($(this).attr('min'));
                var max = 10;
                var min = 0;

                if ($(this).val() > max) {
                    $(this).val(max);
                } else if ($(this).val() < min) {
                    $(this).val(min);
                }
            });
        }

        var advisorGrade = $("#appbundle_board_advisorGrade");
        var evaluatorOneGrade = $("#appbundle_board_evaluatorOneGrade");
        var evaluatorTwoGrade = $("#appbundle_board_evaluatorTwoGrade");

        setMaxMin(advisorGrade);
        setMaxMin(evaluatorOneGrade);
        setMaxMin(evaluatorTwoGrade);

        if (typeof advisorGrade.val() !== 'undefined') {
            advisorGrade.mask('#0.0', {reverse: true});
        }

        if (typeof evaluatorOneGrade.val() !== 'undefined') {
            evaluatorOneGrade.mask('#0.0', {reverse: true});
        }

        if (typeof evaluatorTwoGrade.val() !== 'undefined') {
            evaluatorTwoGrade.mask('#0.0', {reverse: true});
        }
    },
    Boards: function () {
        $("#form_finalize").on("click", function (e) {
            e.preventDefault();
            alertify.confirm('Você está certo disto?', 'Deseja finalizar a banca?', function () {
                $("#form_finalize").submit();
            }, function () {
                // alertify.error('Cancel')
            });
        });

        $("#form_cancel").on("click", function (e) {
            e.preventDefault();
            alertify.confirm('Você está certo disto?', 'Deseja cancelar a banca?', function () {
                $("#form_cancel").submit();
            }, function () {
                // alertify.error('Cancel')
            });
        });

    }
};

$(document).ready(function () {
    Admin.Init();
});