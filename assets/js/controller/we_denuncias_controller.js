// controller javascript do módulo denuncias
function we_denuncias_controller() {

    // cria uma variavel para referenciar a classe dentro de funções
    var self = this;

    // instancia a classe denuncias_model
    var denuncias_model = new we_denuncias_model();

    // instancia a classe denuncias_view
    var denuncias_view = new we_denuncias_view();

    // lista os denuncias
    self.exibirLista = function( params ){

        var pagina = we_url_helper.getParameterByName('pagina');

        var por_pagina = we_url_helper.getParameterByName('por_pagina');

        if( $('#filtroDenuncias').length > 0 )
            denuncias_view.blockearBotaoSubmitFiltro();

        // solicita um JSON com um resumo dos denuncias
        var carregarResumo = denuncias_model.carregarResumo( params, pagina, por_pagina );

        // se a resdenunciaa do servidor for de sucesso
        carregarResumo.done(function ( resumo, textStatus, request ) {

            var total = request.getResponseHeader('X-Total-Count');

            if( $('#filtroDenuncias').length > 0 )
                denuncias_view.fecharModalFiltro();

            // lista os denuncias na tela
            denuncias_view.listar( resumo, total, pagina, por_pagina );

        });

        // se a resdenunciaa do servidor for de falha
        carregarResumo.fail(function ( res ){

            // insere um alerta na tela com a resdenunciaa do servidor
            we_alerta.warning( res.statusText );

        });

        carregarResumo.always(function( res ){

            if( $('#filtroDenuncias').length > 0 )
                denuncias_view.liberarBotaoSubmitFiltro();

        });

    };

    // exibe o modal de filtro de denuncia
    self.exibirModalFiltro = function(){

        // se o modal ja foi carregado
        if( $('#filtroDenuncias').length > 0 ){

            // exibe o modal
            denuncias_view.exibirModalFiltro();

        // se ainda nao foi carregado
        } else {

            // solicita ao servidor o html do modal de filtro de denuncia
            var carregarModalFiltro = denuncias_model.carregarModalFiltro();

            // se a post do servidor for de sucesso
            carregarModalFiltro.done(function ( modal ) {

                // insere o html no DOM
                denuncias_view.inserirModalFiltro( modal );

                // exibe o modal
                denuncias_view.exibirModalFiltro();

            });

            // se a post do servidor for de falha
            carregarModalFiltro.fail(function ( res ){

                // insere um alerta na tela com a post do servidor
                we_alerta.warning( res.statusText );

            });

        }

    };

    // exibir Detalhes de uma Denúncia
    self.exibirDetalhesDenuncia = function( id ){

        // solicita ao servidor os dados da denuncia
        var carregarDenuncia = denuncias_model.carregarDenuncia( id );

        // se a a denuncia for carregada com seucesso
        carregarDenuncia.done(function ( res ) {

            // se o modal ja foi carregado
            if( $('#detalharDenunciaModal').length > 0 ){

                // exibe o modal
                denuncias_view.exibirModalDetalhesDenuncia( res.denuncia, res.post );

            // se ainda nao foi carregado
            } else {

                // solicita ao servidor o html do modal de detalhes de denuncia
                var carregarModalDetalhesDenuncia = denuncias_model.carregarModalDetalhesDenuncia();

                // se a post do servidor for de sucesso
                carregarModalDetalhesDenuncia.done(function ( modal ) {

                    // insere o html no DOM
                    denuncias_view.inserirModalDetalhesDenuncia( modal );

                    // exibe o modal
                    denuncias_view.exibirModalDetalhesDenuncia( res.denuncia, res.post );

                });

                // se a post do servidor for de falha
                carregarModalDetalhesDenuncia.fail(function ( res ){

                    // insere um alerta na tela com a post do servidor
                    we_alerta.warning( res.statusText );

                });

            }

        });

        // se o carregamento da denpuncia falhar
        carregarDenuncia.fail(function ( res ){

            // insere um alerta na tela com a post do servidor
            we_alerta.warning( res.statusText );

        });


    }

    // publica um post
    self.publicarPost = function( id ){

        // bloqueia o botão de publicar
        denuncias_view.blockearBotaoPublicarPost();

        // solicita a edição do post no servidor
        var moderarPost = denuncias_model.moderarPost( {id:id, status:"PB"} );

        // se a resposta do servidor for de sucesso
        moderarPost.done(function ( post, statusText, jqXhr ){

            // exibe botao de remover publicacao e esconde botao de publicar
            denuncias_view.mostrarBotaoRemoverPublicacaoDetalharDenunciaModal();

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
            denuncias_view.liberarBotaoPublicarPost();

        });

    };

    // publica um post
    self.removerPublicacaoPost = function( id ){

        // bloqueia o botão de remover publicação
        denuncias_view.blockearBotaoRemoverPubliicacaoPost();

        // solicita a edição do post no servidor
        var moderarPost = denuncias_model.moderarPost( {id:id, status:"NP"} );

        // se a resposta do servidor for de sucesso
        moderarPost.done(function ( post, statusText, jqXhr ){

            // exibe botao de publicar e esconde botao de remover publicacao
            denuncias_view.mostrarBotaoPublicarDetalharDenunciaModal();

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
            denuncias_view.liberarBotaoRemoverPubliicacaoPost();

        });

    };

    // publica um post
    self.publicarPostAPI = function( id ){

        // solicita a edição do post no servidor
        var moderarPost = denuncias_model.moderarPost( {id:id, api:"SIM"} );

        // se a resposta do servidor for de sucesso
        moderarPost.done(function ( post, statusText, jqXhr ){

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
        var moderarPost = denuncias_model.moderarPost( {id:id, api:"NAO"} );

        // se a resposta do servidor for de sucesso
        moderarPost.done(function ( post, statusText, jqXhr ){

            // informa que a publicação foi efetuada com sucesso
            we_alerta.success( "Removido post da api!" );

        });

        // se a resposta do servidor for de falha
        moderarPost.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

    };
}