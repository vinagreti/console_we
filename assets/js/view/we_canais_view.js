function we_canais_view() {

    var self = this;

    // instancia a classe tabela
    var tabela = new we_tabela_library( "#tabelaCanais" );

    // lista os canais em uma tabela
    self.listar = function( canais, total, pagina, por_pagina ){

        base_url_pag = base_url+'canais';

        tabela.atualizarPaginacao( total, pagina, por_pagina, base_url_pag );

        // para cada canal da lista de canais
        $.each( canais, function( index, canal ){

            // insere uma linha na tabela
            tabela.inserirLinha( canal, "append" );

        });

    };

    // inserir o formulariod e adição de canal no DOM
    self.inserirFormAdicaoCanal = function( form ){

        // insere o formulário no DOM
        $("body").append( $(form) );

    };

    // exibe o formulário de adição de canal
    self.exibirFormAdicaoCanal = function(){

        var adicionarCanalForm = $("#adicionarCanalForm");

        // limpa o formulario
        adicionarCanalForm.find("#nome").val("");

        // exibe o formulário num modal
        adicionarCanalForm.closest(".modal").modal("show");

    };

    self.limpaFormAdicaoCanal = function(){

        // deschecka o checkbox
        $("#adicionarCanalForm").find(".inputModulosCanal").prop('checked', false);

    }

    // bloqueia o botão submmit do formulario de adição de canal
    self.blockearBotaoAdicionarCanal = function(){

        $("#adicionarCanalForm").find("#submitAddCanal").button('loading');

    };

    // libera o botão submmit do formulario de adição de canal
    self.liberarBotaoAdicionarCanal = function(){

        $("#adicionarCanalForm").find("#submitAddCanal").button('reset');
        
    };

    // adiciona o novo canal no inicio da tabela
    self.adicionarCanal = function( canal ){

        // adiciona o novo canal na tabela
        tabela.inserirLinha( canal, "prepend", true );

        // retorna o resultado da operação de remoção
        return true;

    };

    // fecha o formulário de adição de canal
    self.fecharFormAdicaoCanal = function(){

        // fecha o modal do formulário
        $("#adicionarCanalForm").closest(".modal").modal("hide");

    };

    // inserir o formulariod e edição de canal no DOM
    self.inserirFormEdicaoCanal = function( form ){

        // insere o formulário no DOM
        $("body").append( $(form) );

    };

    // exibe o formulário de edição de canal
    self.exibirFormEdicaoCanal = function(){

        // exibe o formulário num modal
        $("#editarCanalForm").closest(".modal").modal("show");

    };

    // fecha o formulário de edição de canal
    self.fecharFormEdicaoCanal = function(){

        // fecha o modal do formulário
        $("#editarCanalForm").closest(".modal").modal("hide");

    };

    // preenche o formulário de edição de canal com os dados do canal
    self.preencherFormEdicaoCanal = function( canal ){

        var editarCanalForm = $("#editarCanalForm");

        // preenche o formulário
        editarCanalForm.find("#id").val( canal.id );
        editarCanalForm.find("#nome").val( canal.nome );

        // setar o status
        editarCanalForm.find("input[name=status][value="+canal.status+"]").prop('checked', true);
        
    };

    // bloqueia o botão submmit do formulario de edição de canal
    self.blockearBotaoEditarCanal = function(){

        $("#editarCanalForm").find("#submitEditarCanal").button('loading');

        $(".diminuir_ordem, .aumentar_ordem").addClass('disabled');

    };

    // libera o botão submmit do formulario de edição de canal
    self.liberarBotaoEditarCanal = function(){

        $("#editarCanalForm").find("#submitEditarCanal").button('reset');

        $(".diminuir_ordem, .aumentar_ordem").removeClass('disabled');
        
    };

    // atualiza uma linhda da tabela
    self.editarCanal = function( canal ){

        if( $.isArray( canal ) ){

            $.each( canal, function( index, cnl ){

                // solicita o update da linha para a classe tabela
                tabela.editarLinha( cnl );

            })

        } else {

            // solicita o update da linha para a classe tabela
            tabela.editarLinha( canal );

        }

    };

    // fecha o formulário de edição de canal
    self.fecharFormEdicaoCanal = function(){

        // fecha o modal do formulário
        $("#editarCanalForm").closest(".modal").modal("hide");

    };

    // remove um canal tendo como referencia o seu id
    self.deletarCanal = function( id ){

        // remove o canal da tabela
        tabela.removerLinha( id );

        // retorna o resultado da operação de remoção
        return true;

    };
};