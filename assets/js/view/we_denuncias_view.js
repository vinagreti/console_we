function we_denuncias_view() {

    var self = this;

    // instancia a classe tabela
    var tabela = new we_tabela_library( "#tabelaDenuncias" );

    // lista os denuncias em uma tabela
    self.listar = function( denuncias, total, pagina, por_pagina ){

        base_url_pag = base_url+'denuncias';

        tabela.atualizarPaginacao( total, pagina, por_pagina, base_url_pag );

        // para cada denuncia da lista de denuncias
        $.each( denuncias, function( index, denuncia ){

            // insere uma linha na tabela
            tabela.inserirLinha( denuncia, "append" );

        });

    };

    // inserir o modal de filtro de denuncia no DOM
    self.inserirModalFiltro = function( modal ){

        // insere o modal no DOM
        $("body").append( $(modal) );

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

        $('#categoria').typeahead({
            name: 'categoria'
            , valueKey : "nome"
            , remote : "categorias/?nome=%QUERY"
            , template: "<p>{{nome}}</p>"
            , engine: Hogan
        });

        $(".date-picker").datepicker({
            autoclose: true
        });

        $('.removerFiltro').click(function(){
            $('#filtroDenuncias')[0].reset();
            $("#filtroDenuncias").find(":submit").click();
        });

        // fim - aplicando plugins nos elementos do filtro

    };

    // exibe o modal de filtro de denuncia
    self.exibirModalFiltro = function(){

        // exibe o modal de filtro de denuncia
        $("#filtroDenuncias").closest(".modal").modal("show");

    };

    // exibe o modal de filtro de denuncia
    self.fecharModalFiltro = function(){

        // exibe o modal de filtro de denuncia
        $("#filtroDenuncias").closest(".modal").modal("hide");

    };

    // bloqueia o botão publicar denuncia
    self.blockearBotaoSubmitFiltro = function(){

        $("#filtroDenuncias").find(".submitFiltro").button('loading');

    };

    // libera o botão publicar denuncia
    self.liberarBotaoSubmitFiltro = function(){

        $("#filtroDenuncias").find(".submitFiltro").button('reset');

    };

    // inserir o modal de detalhe de denuncia no DOM
    self.inserirModalDetalhesDenuncia = function( modal ){

        // insere o modal no DOM
        $("body").append( $(modal) );

    }

    // exibe o modal de detalhe de denuncia
    self.exibirModalDetalhesDenuncia = function( denuncia, post ){

        var modal = $("#detalharDenunciaModal").closest(".modal");

        // adiciona os detalhes da denuncia no modal
        modal.find(".denuncia").find("#texto").html(denuncia.texto);
        modal.find(".denuncia").find("#categoria").html(denuncia.categoria);
        modal.find(".denuncia").find("#data").html(denuncia.data);
        modal.find(".denuncia").find("#vinculado").html(denuncia.vinculado);
        modal.find(".denuncia").find("#usuario_avatar").attr("src",denuncia.usuario_avatar);

        // adiciona detalhes do post no modal
        modal.find(".post").find("#data").html(post.data);
        modal.find(".post").find("#evento").html(post.evento);
        modal.find(".post").find("#localidade").html(post.localidade);
        modal.find(".post").find("#status").html(post.status);
        modal.find(".post").find("#texto").html(post.texto);
        modal.find(".post").find("#vinculado").html(post.vinculado);
        modal.find(".post").find("#usuario_avatar").attr("src",post.usuario_avatar);

        if( post.tipo_midia != null ){

            switch( post.tipo_midia ){
                case "FT":
                    modal.find(".post").find("#midia").html( '<img class="img-responsive" src="'+post.url_midia+'">' );
                    modal.find(".post").find(".baixarMidia").attr("href", post.url_midia);
                    modal.find(".post").find(".baixarMidia").attr("download", post.nome_midia);
                    modal.find(".post").find(".baixarMidia").show();
                break;
                case "AU":
                    modal.find(".post").find("#midia").html( '<icon class="fa fa-music fa-2x"></icon>' );
                    modal.find(".post").find(".baixarMidia").attr("href", post.url_midia);
                    modal.find(".post").find(".baixarMidia").attr("download", post.nome_midia);
                    modal.find(".post").find(".baixarMidia").show();
                break;
                case "VD":
                    modal.find(".post").find("#midia").html( '<icon class="fa fa-video-camera fa-2x"></icon>' );
                    modal.find(".post").find(".baixarMidia").attr("href", post.url_midia);
                    modal.find(".post").find(".baixarMidia").attr("download", post.nome_midia);
                    modal.find(".post").find(".baixarMidia").show();
                break;
            }

        } else {

            post.tipo_midia = "";
            modal.find(".post").find("#midia").empty();
            modal.find(".post").find(".baixarMidia").hide();

        }

        modal.find(".publicarPost").attr("data-id", post.id);
        modal.find(".removerPublicacaoPost").attr("data-id", post.id);

        switch( post.status ){
            case "NP":
                modal.find(".publicarPost").show();
                modal.find(".removerPublicacaoPost").hide();
            break;
            case "PB":
                modal.find(".removerPublicacaoPost").show();
                modal.find(".publicarPost").hide();
            break;
        }

        modal.find("#publicarPostAPI").attr("data-id", post.id);
        if( post.api == 'SIM' )
            modal.find("#publicarPostAPI").attr("checked", true);


        // exibe o modal de detalhe de denuncia
        modal.modal("show");

    };

    // bloqueia o botão publicar post
    self.blockearBotaoPublicarPost = function(){

        $("#detalharDenunciaModal").find(".publicarPost").button('loading');

    };

    // libera o botão publicar post
    self.liberarBotaoPublicarPost = function(){

        $("#detalharDenunciaModal").find(".publicarPost").button('reset');

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
    self.mostrarBotaoRemoverPublicacaoDetalharDenunciaModal = function(){

        $("#detalharDenunciaModal").find(".publicarPost").hide();
        $("#detalharDenunciaModal").find(".removerPublicacaoPost").show();
    }

    // mostrar botao de publicar post
    self.mostrarBotaoPublicarDetalharDenunciaModal = function(){

        $("#detalharDenunciaModal").find(".removerPublicacaoPost").hide();
        $("#detalharDenunciaModal").find(".publicarPost").show();
    }
  }