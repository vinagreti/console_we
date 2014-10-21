function we_posts_view() {

    var self = this;

    // instancia a classe tabela
    var tabela = new we_tabela_library( "#tabelaPosts" );

    // lista os posts em uma tabela
    self.listar = function( posts, total, pagina, por_pagina ){

        // limpa a tabela
        tabela.limpar();

        base_url_pag = base_url+'posts';

        tabela.atualizarPaginacao( total, pagina, por_pagina, base_url_pag );

        // para cada post da lista de posts
        $.each( posts, function( index, post ){

            switch( post.tipo_midia ){
                case "FT":
                  post.tipo_midia = '<a href="'+post.url_midia+'" download="'+post.nome_midia+'"><icon class="fa fa-picture-o fa-2x"></icon></a>';
                  break;
                case "AU":
                  post.tipo_midia = '<a href="'+post.url_midia+'" download="'+post.nome_midia+'"><icon class="fa fa-music fa-2x"></icon></a>';
                  break;
                case "VD":
                  post.tipo_midia = '<a href="'+post.url_midia+'" download="'+post.nome_midia+'"><icon class="fa fa-video-camera fa-2x"></icon></a>';
                  break;
                default:
                  post.tipo_midia = "";
            }

            // insere uma linha na tabela
            tabela.inserirLinha( post, "append" );

        });

    };

    // inserir o formulario de moderação de post no DOM
    self.inserirFormModerarPost = function( form ){

        // insere o formulário no DOM
        $("body").append( $(form) );

    };

    // preenche o formulário de edição de post com os dados do post
    self.preencherFormModerarPost = function( post ){

        console.log(post);

        var moderarPostForm = $("#moderarPostForm");

        // preenche o formulário
        moderarPostForm.find("#id").val( post.id );

        // setar o status
        moderarPostForm.find("input[name=status][value="+post.status+"]").prop('checked', true);

        // setar api
        moderarPostForm.find("input[name=api][value="+post.api+"]").prop('checked', true);
        
    };

    // exibe o formulário de edição de post
    self.exibirFormModerarPost = function(){

        // exibe o formulário num modal
        $("#moderarPostForm").closest(".modal").modal("show");

    };

    // bloqueia o botão submmit do formulario de moderação de post
    self.blockearBotaoModerarPost = function(){

        $("#moderarPostForm").find("#submitModerarPost").button('loading');

    };

    // libera o botão submmit do formulario de moderação de post
    self.liberarBotaoModerarPost = function(){

        $("#moderarPostForm").find("#submitModerarPost").button('reset');
        
    };

    // atualiza uma linhda da tabela
    self.editarPost = function( post ){

        // solicita o update da linha para a classe tabela
        tabela.editarLinha( post );

    };

    // fecha o formulário de moderação de post
    self.fecharFormModerarPost = function(){

        // fecha o modal do formulário
        $("#moderarPostForm").closest(".modal").modal("hide");

    };

    // remove um post tendo como referencia o seu id
    self.deletarPost = function( id ){

        // remove o post da tabela
        tabela.removerLinha( id );

        // retorna o resultado da operação de remoção
        return true;

    };

    // inserir modal de detalhamento de post
    self.inserirDetalharPostModal = function( modal ){

        // insere o modal no DOM
        $("body").append( $(modal) );

    };

    // preenche modal de detalhamento de post
    self.preencherDetalharPostModal = function( post ){

        var detalharPostModal = $("#detalharPostModal");

        detalharPostModal.find("#data").html(post.data);
        detalharPostModal.find("#evento").html(post.evento);
        detalharPostModal.find("#localidade").html(post.localidade);
        detalharPostModal.find("#status").html(post.status);
        detalharPostModal.find("#texto").html(post.texto);
        detalharPostModal.find("#usuario_nome").html(post.usuario_nome);
        detalharPostModal.find("#usuario_sobrenome").html(post.usuario_sobrenome);
        detalharPostModal.find("#usuario_avatar").attr("src",post.usuario_avatar);

        if( post.tipo_midia != null ){

            switch( post.tipo_midia ){
                case "FT":
                    detalharPostModal.find("#midia").html( '<img class="img-responsive" src="'+post.url_midia+'">' );
                    detalharPostModal.find(".baixarMidia").attr("href", post.url_midia);
                    detalharPostModal.find(".baixarMidia").attr("download", post.nome_midia);
                    detalharPostModal.find(".baixarMidia").show();
                break;
                case "AU":
                    detalharPostModal.find("#midia").html( '<icon class="fa fa-music fa-2x"></icon>' );
                    detalharPostModal.find(".baixarMidia").attr("href", post.url_midia);
                    detalharPostModal.find(".baixarMidia").attr("download", post.nome_midia);
                    detalharPostModal.find(".baixarMidia").show();
                break;
                case "VD":
                    detalharPostModal.find("#midia").html( '<icon class="fa fa-video-camera fa-2x"></icon>' );
                    detalharPostModal.find(".baixarMidia").attr("href", post.url_midia);
                    detalharPostModal.find(".baixarMidia").attr("download", post.nome_midia);
                    detalharPostModal.find(".baixarMidia").show();
                break;
            }

        } else {

            post.tipo_midia = "";
            detalharPostModal.find("#midia").empty();
            detalharPostModal.find(".baixarMidia").hide();

        }

        detalharPostModal.find(".publicarPost").attr("data-id", post.id);
        detalharPostModal.find(".removerPublicacaoPost").attr("data-id", post.id);

        switch( post.status ){
            case "NP":
                detalharPostModal.find(".publicarPost").show();
                detalharPostModal.find(".removerPublicacaoPost").hide();
            break;
            case "PB":
                detalharPostModal.find(".removerPublicacaoPost").show();
                detalharPostModal.find(".publicarPost").hide();
            break;
        }

        detalharPostModal.find("#publicarPostAPI").attr("data-id", post.id);
        if( post.api == 'SIM' )
            detalharPostModal.find("#publicarPostAPI").attr("checked", true);

    };

    // exibe o modal de detalhamento de post
    self.exibirDetalharPostModal = function(){

        // exibe o modal de detalhamento de post
        $("#detalharPostModal").modal("show");

    };

    // bloqueia o botão publicar post
    self.blockearBotaoPublicarPost = function(){

        $("#detalharPostModal").find(".publicarPost").button('loading');

    };

    // libera o botão publicar post
    self.liberarBotaoPublicarPost = function(){

        $("#detalharPostModal").find(".publicarPost").button('reset');
        
    };

    // bloqueia o botão publicar post
    self.blockearBotaoRemoverPubliicacaoPost = function(){

        $("#detalharPostModal").find(".removerPublicacaoPost").button('loading');

    };

    // libera o botão publicar post
    self.liberarBotaoRemoverPubliicacaoPost = function(){

        $("#detalharPostModal").find(".removerPublicacaoPost").button('reset');
        
    };

    // mostrar botao de publicar post
    self.mostrarBotaoRemoverPublicacaoDetalharPostModal = function(){

        $("#detalharPostModal").find(".publicarPost").hide();
        $("#detalharPostModal").find(".removerPublicacaoPost").show();
    }

    // mostrar botao de publicar post
    self.mostrarBotaoPublicarDetalharPostModal = function(){

        $("#detalharPostModal").find(".removerPublicacaoPost").hide();
        $("#detalharPostModal").find(".publicarPost").show();
    }

    // inserir o modal de filtro de post no DOM
    self.inserirModalFiltro = function( modal ){

        // insere o modal no DOM
        $("body").append( $(modal) );

        // aplicando plugins nos elementos do filtro
        $('#localidade').typeahead({
            name: 'localidade'
            , valueKey : "nome"
            , remote : "localidades/?nome=%QUERY"
            , template: "<p>{{nome}}</p>"
            , engine: Hogan
        });

        $('#canal').typeahead({
            name: 'canal'
            , valueKey : "nome"
            , remote : "canais/?nome=%QUERY"
            , template: "<p>{{nome}}</p>"
            , engine: Hogan
        });

        $('#evento').typeahead({
            name: 'evento'
            , valueKey : "nome"
            , remote : "eventos/?nome=%QUERY"
            , template: "<p>{{nome}}</p>"
            , engine: Hogan
        });

        $('#vinculado').typeahead({
            name: 'vinculado'
            , valueKey : "nome"
            , remote : "vinculados/?nome=%QUERY"
            , template: "<p>{{nome}}</p>"
            , engine: Hogan
        });

        $(".date-picker").datepicker({
            autoclose: true
        });

        $('.removerFiltro').click(function(){
            $('#filtroPosts')[0].reset();
            $("#filtroPosts").find(":submit").click();
        });

        // fim - aplicando plugins nos elementos do filtro

    };

    // exibe o modal de filtro de post
    self.exibirModalFiltro = function(){

        // exibe o modal de filtro de post
        $("#filtroPosts").closest(".modal").modal("show");

    };

    // exibe o modal de filtro de post
    self.fecharModalFiltro = function(){

        // exibe o modal de filtro de post
        $("#filtroPosts").closest(".modal").modal("hide");

    };

    // bloqueia o botão publicar post
    self.blockearBotaoSubmitFiltro = function(){

        $("#filtroPosts").find(".submitFiltro").button('loading');

    };

    // libera o botão publicar post
    self.liberarBotaoSubmitFiltro = function(){

        $("#filtroPosts").find(".submitFiltro").button('reset');
        
    };
};