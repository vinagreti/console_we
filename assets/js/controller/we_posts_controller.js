// controller javascript do módulo posts
function we_posts_controller() {

    // cria uma variavel para referenciar a classe dentro de funções
    var self = this;

    // instancia a classe posts_model
    var posts_model = new we_posts_model();

    // instancia a classe posts_view
    var posts_view = new we_posts_view();

    // lista os posts
    self.exibirLista = function( params ){

        var pagina = we_url_helper.getParameterByName('pagina');

        var por_pagina = we_url_helper.getParameterByName('por_pagina');

        if( $('#filtroPosts').length > 0 )
            posts_view.blockearBotaoSubmitFiltro();

        // solicita um JSON com um resumo dos posts
        var carregarResumo = posts_model.carregarResumo( params, pagina, por_pagina );

        // se a resposta do servidor for de sucesso
        carregarResumo.done(function ( resumo, textStatus, request ) {

            if( $('#filtroPosts').length > 0 )
                posts_view.fecharModalFiltro();

            var total = request.getResponseHeader('X-Total-Count');

            // lista os posts na tela
            posts_view.listar( resumo, total, pagina, por_pagina );

        });

        // se a resposta do servidor for de falha
        carregarResumo.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

        carregarResumo.always(function( res ){

            if( $('#filtroPosts').length > 0 )
                posts_view.liberarBotaoSubmitFiltro();

        });

    };

    // exibe o form de edição de post
    this.exibirFormModerarPost = function( id ){

        // solicita ao servidor todos os dados do post
        var carregaPost = posts_model.carregarPost( id );

        // se a resposta do servidor for de sucesso
        carregaPost.done(function ( post ) {

            // se o form ja foi carregado
            if( $('#moderarPostForm').length > 0 ){

                // preenche o formulario de edição com os dados
                posts_view.preencherFormModerarPost( post );
            
                // exibe o form
                posts_view.exibirFormModerarPost();

            // se ainda nao foi carregado
            } else {

                // solicita ao servidor o html do form de edição de post
                var carregarModerarPostForm = posts_model.carregarModerarPostForm();

                // se a resposta do servidor for de sucesso
                carregarModerarPostForm.done(function ( form ) {

                    // insere o html no DOM
                    posts_view.inserirFormModerarPost( form );

                    // preenche o formulario de edição com os dados
                    posts_view.preencherFormModerarPost( post );

                    // exibe o form
                    posts_view.exibirFormModerarPost();

                });

                // se a resposta do servidor for de falha
                carregarModerarPostForm.fail(function ( res ){

                    // insere um alerta na tela com a resposta do servidor
                    we_alerta.warning( res.statusText );

                });

            }

        });

        // se a resposta do servidor for de falha
        carregaPost.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

    };

    // edita um post
    self.moderarPost = function( post ){

        // bloqueia o botão de submmit do formulario de edição
        posts_view.blockearBotaoModerarPost();

        // solicita a edição do post no servidor
        var moderarPost = posts_model.moderarPost( post );

        // se a resposta do servidor for de sucesso
        moderarPost.done(function ( post, statusText, jqXhr ){

            // editar a linha da tabela
            posts_view.editarPost( post );

            // fecha o modal
            posts_view.fecharFormModerarPost();

            // informa que a adição foi efetuada com sucesso
            we_alerta.success( jqXhr.statusText );

        });

        // se a resposta do servidor for de falha
        moderarPost.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

        // sempre que receber a resposta do servidor
        moderarPost.always(function (){

            // libera o botão de submmit do formulario de edição
            posts_view.liberarBotaoModerarPost();

        });

    };

    // remove o post tendo como referencia o seu id
    self.deletarPost = function( id, nome ){

        we_dialog.confirm("Atenção!", "Deseja realmente excluir o post <strong><small>"+nome+"</small></strong>?", function( comfirmado ){

            // pergunta se realmente quer excluir
            if( comfirmado ){

                // solicita a remoção post ao servidor
                var deletarPost = posts_model.deletarPost( id );

                // se a resposta do servidor for de sucesso
                deletarPost.done(function ( msg, statusText, jqXhr ) {

                    // remove a linha da tabela
                    posts_view.deletarPost( id );

                    // informa que a remoção foi efetuada com sucesso
                    we_alerta.success( jqXhr.statusText );

                });

                // se a resposta do servidor for de falha
                deletarPost.fail(function ( res ){

                    // insere um alerta na tela com a resposta do servidor
                    we_alerta.warning( res.statusText );

                });

            }

        });

    };

    // exibe o modal com detalhes do post
    this.detalhesPost = function( id ){

        // solicita ao servidor todos os dados do post
        var carregaPost = posts_model.carregarPost( id );

        // se a resposta do servidor for de sucesso
        carregaPost.done(function ( post ) {

            // se o modal ja foi carregado
            if( $('#detalharPostModal').length > 0 ){

                // preenche modal com os dados
                posts_view.preencherDetalharPostModal( post );
            
                // exibe o modal
                posts_view.exibirDetalharPostModal();

            // se ainda nao foi carregado
            } else {

                // solicita ao servidor o html do modal de detalhamento de post
                var carregarDetalharPostModal = posts_model.carregarDetalharPostModal();

                // se a resposta do servidor for de sucesso
                carregarDetalharPostModal.done(function ( form ) {

                    // insere o html no DOM
                    posts_view.inserirDetalharPostModal( form );

                    // preenche modal com os dados
                    posts_view.preencherDetalharPostModal( post );

                    // exibe o form
                    posts_view.exibirDetalharPostModal();

                });

                // se a resposta do servidor for de falha
                carregarDetalharPostModal.fail(function ( res ){

                    // insere um alerta na tela com a resposta do servidor
                    we_alerta.warning( res.statusText );

                });

            }

        });

        // se a resposta do servidor for de falha
        carregaPost.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

    };

    // publica um post
    self.publicarPost = function( id ){

        // bloqueia o botão de publicar
        posts_view.blockearBotaoPublicarPost();

        // solicita a edição do post no servidor
        var moderarPost = posts_model.moderarPost( {id:id, status:"PB"} );

        // se a resposta do servidor for de sucesso
        moderarPost.done(function ( post, statusText, jqXhr ){

            // editar a linha da tabela
            posts_view.editarPost( post );

            // exibe botao de remover publicacao e esconde botao de publicar
            posts_view.mostrarBotaoRemoverPublicacaoDetalharPostModal();

            // informa que a publicação foi efetuada com sucesso
            we_alerta.success( "Post publicado!" );

        });

        // se a resposta do servidor for de falha
        moderarPost.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

        // sempre que receber a resposta do servidor
        moderarPost.always(function (){

            // libera o botão de submmit do formulario de edição
            posts_view.liberarBotaoPublicarPost();

        });

    };

    // publica um post
    self.removerPublicacaoPost = function( id ){

        // bloqueia o botão de remover publicação
        posts_view.blockearBotaoRemoverPubliicacaoPost();

        // solicita a edição do post no servidor
        var moderarPost = posts_model.moderarPost( {id:id, status:"NP"} );

        // se a resposta do servidor for de sucesso
        moderarPost.done(function ( post, statusText, jqXhr ){

            // editar a linha da tabela
            posts_view.editarPost( post );

            // exibe botao de publicar e esconde botao de remover publicacao
            posts_view.mostrarBotaoPublicarDetalharPostModal();

            // informa que a publicação foi efetuada com sucesso
            we_alerta.success( "Removida publicação do post!" );

        });

        // se a resposta do servidor for de falha
        moderarPost.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

        // sempre que receber a resposta do servidor
        moderarPost.always(function (){

            // libera o botão de submmit do formulario de edição
            posts_view.liberarBotaoRemoverPubliicacaoPost();

        });

    };

    // exibe o modal de filtro de post
    this.exibirModalFiltro = function(){

        // se o modal ja foi carregado
        if( $('#filtroPosts').length > 0 ){

            // exibe o modal
            posts_view.exibirModalFiltro();

        // se ainda nao foi carregado
        } else {

            // solicita ao servidor o html do modal de filtro de post
            var carregarModalFiltro = posts_model.carregarModalFiltro();

            // se a resposta do servidor for de sucesso
            carregarModalFiltro.done(function ( modal ) {

                // insere o html no DOM
                posts_view.inserirModalFiltro( modal );

                // exibe o modal
                posts_view.exibirModalFiltro();

            });

            // se a resposta do servidor for de falha
            carregarModalFiltro.fail(function ( res ){

                // insere um alerta na tela com a resposta do servidor
                we_alerta.warning( res.statusText );

            });

        }

    };

    // publica um post
    self.publicarPostAPI = function( id ){

        // solicita a edição do post no servidor
        var moderarPost = posts_model.moderarPost( {id:id, api:"SIM"} );

        // se a resposta do servidor for de sucesso
        moderarPost.done(function ( post, statusText, jqXhr ){

            // editar a linha da tabela
            posts_view.editarPost( post );

            // informa que a publicação foi efetuada com sucesso
            we_alerta.success( "Publicado post na api!" );

        });

        // se a resposta do servidor for de falha
        moderarPost.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

    };

    // publica um post
    self.removerPostAPI = function( id ){

        // solicita a edição do post no servidor
        var moderarPost = posts_model.moderarPost( {id:id, api:"NAO"} );

        // se a resposta do servidor for de sucesso
        moderarPost.done(function ( post, statusText, jqXhr ){

            // editar a linha da tabela
            posts_view.editarPost( post );

            // informa que a publicação foi efetuada com sucesso
            we_alerta.success( "Removido post da api!" );

        });

        // se a resposta do servidor for de falha
        moderarPost.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

    };
};