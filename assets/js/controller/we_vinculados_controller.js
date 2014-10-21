// controller javascript do módulo vinculados
function we_vinculados_controller() {

    // cria uma variavel para referenciar a classe dentro de funções
    var self = this;

    // instancia a classe vinculados_model
    var vinculados_model = new we_vinculados_model();

    // instancia a classe vinculados_view
    var vinculados_view = new we_vinculados_view();

    // lista os vinculados
    self.exibirLista = function(){

        var pagina = we_url_helper.getParameterByName('pagina');

        var por_pagina = we_url_helper.getParameterByName('por_pagina');

        // solicita um JSON com um resumo dos vinculados
        var carregarResumo = vinculados_model.carregarResumo(pagina, por_pagina);

        // se a resposta do servidor for de sucesso
        carregarResumo.done(function ( resumo, textStatus, request ) {

            var total = request.getResponseHeader('X-Total-Count');

            // lista os vinculados na tela
            vinculados_view.listar( resumo, total, pagina, por_pagina );

        });

        // se a resposta do servidor for de falha
        carregarResumo.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

    };

    // remove o vinculado tendo como referencia o seu vinculado_id
    self.deletarVinculado = function( vinculado_id, nome ){

        we_dialog.confirm("Atenção!", "Deseja realmente excluir o vinculado <strong>"+nome+"</strong>?", function( comfirmado ){

            // pergunta se realmente quer excluir
            if( comfirmado ){

                // solicita a remoção vinculado ao servidor
                var deletarVinculado = vinculados_model.deletarVinculado( vinculado_id );

                // se a resposta do servidor for de sucesso
                deletarVinculado.done(function ( vinculados_ordem_atualizada, statusText, jqXhr ) {

                    // remove a linha da tabela
                    vinculados_view.deletarVinculado( vinculado_id );

                    // informa que a remoção foi efetuada com sucesso
                    we_alerta.success( jqXhr.statusText );

                });

                // se a resposta do servidor for de falha
                deletarVinculado.fail(function ( res ){

                    // insere um alerta na tela com a resposta do servidor
                    we_alerta.warning( res.statusText );

                });

            }

        });

    };
};