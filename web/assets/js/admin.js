Admin = {
    Init: function () {
        Admin.Datatable();
        Admin.JqueryMask();
        Admin.Boards();
        Admin.ProgressBars();
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

        $("#form_rest").on("click", function (e) {
            e.preventDefault();
            alertify.confirm('Você está certo disto?', 'Deseja restabelecer a banca?', function () {
                $("#form_rest").submit();
            }, function () {
                // alertify.error('Cancel')
            });
        });
    },
    ProgressBars: function () {
        /*$("#form_first_post").submit(function () {
                    $("#form_first_post .spinner").show(400);
                    $("#form_first_post button[type='submit']").prop("disabled", true);
                })*/

        function getExtension(filename) {
            var parts = filename.split('.');
            return parts[parts.length - 1];
        }

        function validateCode(code) {
            var ext = getExtension(code);
            var mime = ['rar', 'zip', 'x-rar'];

            if (mime.indexOf(ext) === -1) {
                return false;
            }

            return true;
        }

        function validateArticle(article) {
            var ext = getExtension(article);
            var mime = ['pdf'];

            if (mime.indexOf(ext) === -1) {
                return false;
            }

            return true;
        }


        $("#form_first_post button[type='submit']").on('click', function (e) {
            var article = $("#appbundle_project_article");
            var code = $("#appbundle_project_code");
            var div_progress = $(".div-progress-bar");
            var progress_bar = $(".div-progress-bar .progress-bar");

            if (article.val() != '') {
                console.log('Valida article');
                if (!validateArticle(article.val())) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Insira o artigo no formato .pdf.');
                    return false;
                }
            }

            if (code.val() != '') {
                console.log('Valida code');
                if (!validateCode(code.val())) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Insira o codigo fonte no formato .rar ou .zip.');
                    return false;
                }
            }

            if (code.val() != '' || article.val() != null) {
                article.parent().hide(400, function () {
                    div_progress.show(400)
                });
                code.parent().hide(400);
            }

            /*
            * Usando ajaxForm
            * */
            $('#form_first_post').ajaxForm({
                beforeSend: function () {
                    $("#form_first_post .spinner").show(400);
                    $("#form_first_post button[type='submit']").prop("disabled", true);
                    var percentVal = '0%';
                    progress_bar.width(percentVal);
                    progress_bar.html(percentVal);
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    progress_bar.width(percentVal);
                    progress_bar.html(percentVal);
                },
                complete: function (xhr) {
                    var route = JSON.parse(xhr.responseText);
                    window.location.replace(route);
                }
            });
        });

        $("#form_last_post button[type='submit']").on('click', function (e) {
            var article = $("#appbundle_project_article");
            var code = $("#appbundle_project_code");
            var div_progress = $(".div-progress-bar");
            var progress_bar = $(".div-progress-bar .progress-bar");


            if (article.val() != '') {
                if (!validateArticle(article.val())) {
                    alertify.set('error', 'position', 'top-center');
                    alertify.error('Insira um codigo fonte no formato .pdf.');
                    return false;
                }
            }

            if (code.val() != '') {
                if (!validateCode(code.val())) {
                    alertify.set('error', 'position', 'top-center');
                    alertify.error('Insira um codigo fonte no formato .rar ou .zip.');
                    return false;
                }
            }


            if (code.val() != '' || article.val() != null) {
                article.parent().hide(400, function () {
                    div_progress.show(400)
                });
                code.parent().hide(400);
            }

            /*
            * Usando ajaxForm
            * */
            $('#form_last_post').ajaxForm({
                beforeSend: function () {
                    $("#form_last_post .spinner").show(400);
                    $("#form_last_post button[type='submit']").prop("disabled", true);
                    var percentVal = '0%';
                    progress_bar.width(percentVal);
                    progress_bar.html(percentVal);
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    progress_bar.width(percentVal);
                    progress_bar.html(percentVal);
                },
                complete: function (xhr) {
                    var route = JSON.parse(xhr.responseText);
                    window.location.replace(route);
                }
            });
        });

        $("#form_edit button[type='submit']").on('click', function (e) {
            // e.preventDefault();
            var article = $("#appbundle_project_article");
            var code = $("#appbundle_project_code");
            var div_progress = $(".div-progress-bar");
            var progress_bar = $(".div-progress-bar .progress-bar");


            if (article.val() != '') {
                if (!validateArticle(article.val())) {
                    alertify.set('error', 'position', 'top-center');
                    alertify.error('Insira um codigo fonte no formato .pdf.');
                    return false;
                }
            }

            if (code.val() != '') {
                if (!validateCode(code.val())) {
                    alertify.set('error', 'position', 'top-center');
                    alertify.error('Insira um codigo fonte no formato .rar ou .zip.');
                    return false;
                }
            }


            if (code.val() != '' || article.val() != null) {
                article.parent().hide(400, function () {
                    div_progress.show(400)
                });
                code.parent().hide(400);
            }

            /*
            * Usando ajaxForm
            * */
            $('#form_edit').ajaxForm({
                beforeSend: function () {
                    $("#form_edit .spinner").show(400);
                    $("#form_edit button[type='submit']").prop("disabled", true);
                    var percentVal = '0%';
                    progress_bar.width(percentVal);
                    progress_bar.html(percentVal);
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    progress_bar.width(percentVal);
                    progress_bar.html(percentVal);
                },
                complete: function (xhr) {
                    var route = JSON.parse(xhr.responseText);
                    window.location.replace(route);
                }
            });
        });

    }
};

$(document).ready(function () {
    Admin.Init();
});