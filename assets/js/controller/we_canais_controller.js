// controller javascript do módulo canais
function we_canais_controller() {

    // cria uma variavel para referenciar a classe dentro de funções
    var self = this;

    // instancia a classe canais_model
    var canais_model = new we_canais_model();

    // instancia a classe canais_view
    var canais_view = new we_canais_view();

    // lista os canais
    self.exibirLista = function(){

        var pagina = we_url_helper.getParameterByName('pagina');

        var por_pagina = we_url_helper.getParameterByName('por_pagina');

        // solicita um JSON com um resumo dos canais
        var carregarResumo = canais_model.carregarResumo(pagina, por_pagina);

        // se a resposta do servidor for de sucesso
        carregarResumo.done(function ( resumo, textStatus, request ) {

            var total = request.getResponseHeader('X-Total-Count');

            // lista os canais na tela
            canais_view.listar( resumo, total, pagina, por_pagina );

        });

        // se a resposta do servidor for de falha
        carregarResumo.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

    };

    // exibe o form de adição de canal
    this.exibirFormAdicaoCanal = function(){

        // se o form ja foi carregado
        if( $('#adicionarCanalForm').length > 0 ){

            // limpa o formulario de adição de canais
            canais_view.limpaFormAdicaoCanal();

            // exibe o form
            canais_view.exibirFormAdicaoCanal();

        // se ainda nao foi carregado
        } else {

            // solicita ao servidor o html do form de adição de canal
            var carregarAdicionarCanalForm = canais_model.carregarAdicionarCanalForm();

            // se a resposta do servidor for de sucesso
            carregarAdicionarCanalForm.done(function ( form ) {

                // insere o html no DOM
                canais_view.inserirFormAdicaoCanal( form );

                // exibe o form
                canais_view.exibirFormAdicaoCanal();

            });

            // se a resposta do servidor for de falha
            carregarAdicionarCanalForm.fail(function ( res ){

                // insere um alerta na tela com a resposta do servidor
                we_alerta.warning( res.statusText );

            });

        }

    };

    // adiciona um novo canal
    self.adicionarCanal = function( canal ){

        // bloqueia o botão de submmit do formulario de adição
        canais_view.blockearBotaoAdicionarCanal();

        // solicita a adição do canal no servidor
        var adicionarCanal = canais_model.adicionarCanal( canal );

        // se a responsta do servidor for de sucesso
        adicionarCanal.done(function ( canal, statusText, jqXhr ) {

            // adiciona a linha da tabela
            canais_view.adicionarCanal( canal );

            // fecha o modal
            canais_view.fecharFormAdicaoCanal();

            // informa que a mensagem de adição
            we_alerta.success( jqXhr.statusText );

        });

        // se a responsta do servidor for de falha
        adicionarCanal.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

        // sempre que receber a resposta do servidor
        adicionarCanal.always(function (){

            // libera o botão de submmit do formulario de adição
            canais_view.liberarBotaoAdicionarCanal();

        });

    };

    // exibe o form de edição de canal
    this.exibirFormEdicaoCanal = function( id ){

        // solicita ao servidor todos os dados do canal
        var carregaCanal = canais_model.carregarCanal( id );

        // se a resposta do servidor for de sucesso
        carregaCanal.done(function ( canal ) {

            // se o form ja foi carregado
            if( $('#editarCanalForm').length > 0 ){

                // preenche o formulario de edição com os dados
                canais_view.preencherFormEdicaoCanal( canal );
            
                // exibe o form
                canais_view.exibirFormEdicaoCanal();

            // se ainda nao foi carregado
            } else {

                // solicita ao servidor o html do form de edição de canal
                var carregarEditarCanalForm = canais_model.carregarEditarCanalForm();

                // se a resposta do servidor for de sucesso
                carregarEditarCanalForm.done(function ( form ) {

                    // insere o html no DOM
                    canais_view.inserirFormEdicaoCanal( form );

                    // preenche o formulario de edição com os dados
                    canais_view.preencherFormEdicaoCanal( canal );

                    // exibe o form
                    canais_view.exibirFormEdicaoCanal();

                });

                // se a resposta do servidor for de falha
                carregarEditarCanalForm.fail(function ( res ){

                    // insere um alerta na tela com a resposta do servidor
                    we_alerta.warning( res.statusText );

                });

            }

        });

        // se a resposta do servidor for de falha
        carregaCanal.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

    };

    // edita um canal
    self.editarCanal = function( canal ){

        // bloqueia o botão de submmit do formulario de edição
        canais_view.blockearBotaoEditarCanal();

        // solicita a edição do canal no servidor
        var editarCanal = canais_model.editarCanal( canal );

        // se a resposta do servidor for de sucesso
        editarCanal.done(function ( canal, statusText, jqXhr ){

            // editar a linha da tabela
            canais_view.editarCanal( canal );

            // fecha o modal
            canais_view.fecharFormEdicaoCanal();

            // informa que a adição foi efetuada com sucesso
            we_alerta.success( jqXhr.statusText );

        });

        // se a resposta do servidor for de falha
        editarCanal.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

        // sempre que receber a resposta do servidor
        editarCanal.always(function (){

            // libera o botão de submmit do formulario de edição
            canais_view.liberarBotaoEditarCanal();

        });

    };

    // remove o canal tendo como referencia o seu canal_id
    self.deletarCanal = function( canal_id, nome ){

        we_dialog.confirm("Atenção!", "Deseja realmente excluir o canal <strong>"+nome+"</strong>?", function( comfirmado ){

            // pergunta se realmente quer excluir
            if( comfirmado ){

                // solicita a remoção canal ao servidor
                var deletarCanal = canais_model.deletarCanal( canal_id );

                // se a resposta do servidor for de sucesso
                deletarCanal.done(function ( canais_ordem_atualizada, statusText, jqXhr ) {

                    // editar a linha da tabela
                    canais_view.editarCanal( canais_ordem_atualizada );

                    // remove a linha da tabela
                    canais_view.deletarCanal( canal_id );

                    // informa que a remoção foi efetuada com sucesso
                    we_alerta.success( jqXhr.statusText );

                });

                // se a resposta do servidor for de falha
                deletarCanal.fail(function ( res ){

                    // insere um alerta na tela com a resposta do servidor
                    we_alerta.warning( res.statusText );

                });

            }

        });

    };
};