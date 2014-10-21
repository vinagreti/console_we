function we_usuarios_view() {

    var self = this;

    // instancia a classe tabela
    var tabela = new we_tabela_library( "#tabelaUsuarios" );

    // lista os usuarios em uma tabela
    self.listar = function( usuarios, total, pagina, por_pagina ){

        base_url_pag = base_url+'usuarios';

        tabela.atualizarPaginacao( total, pagina, por_pagina, base_url_pag );

        // para cada usuario da lista de usuarios
        $.each( usuarios, function( index, usuario ){

            // insere uma linha na tabela
            tabela.inserirLinha( usuario, "append" );

        });

    };

    // inserir o formulario de adição de usuario no DOM
    self.inserirFormAdicaoUsuario = function( form ){

        // insere o formulário no DOM
        $("body").append( $(form) );

    };

    // exibe o formulário de adição de usuario
    self.exibirFormAdicaoUsuario = function(){

        var adicionarUsuarioForm = $("#adicionarUsuarioForm");

        // limpa o formulário
        adicionarUsuarioForm.find("#nome").val("");
        adicionarUsuarioForm.find("#email").val("");
        adicionarUsuarioForm.find("#telefone1").val("");
        adicionarUsuarioForm.find("#telefone2").val("");
        adicionarUsuarioForm.find("#cargo").val("");
        adicionarUsuarioForm.find("input[name=admin][value=N]").prop('checked', true);

        // exibe o formulário num modal
        adicionarUsuarioForm.closest(".modal").modal("show");

    };

    // fecha o formulário de adição de usuario
    self.fecharFormAdicaoUsuario = function(){

        // fecha o modal do formulário
        $("#adicionarUsuarioForm").closest(".modal").modal("hide");

    };

    // adiciona o novo usuario no inicio da tabela
    self.adicionarUsuario = function( usuario ){

        // adiciona o novo usuario na tabela
        tabela.inserirLinha( usuario, "prepend", true );

        // retorna o resultado da operação de remoção
        return true;

    };

    // insere os grupos do sistema no formulário de adição de grupos
    self.adicionarGruposNoFormAdicaoUsuario = function( grupos ){

        var adicionarUsuarioForm = $("#adicionarUsuarioForm");

        // clona o html do radio
        var radio = adicionarUsuarioForm.find(".inputGruposUsuarioColunaPar").find(".radio").first().clone();

        // remove os grupos anteriores
        adicionarUsuarioForm.find(".inputGruposUsuarioColunaPar").empty();
        adicionarUsuarioForm.find(".inputGruposUsuarioColunaImpar").empty();

        // itera sobre a lista de módulos para inserilos no formulario
        $.each( grupos, function( index, grupo ){

            // instancia um novo radio
            var radioGrupo = radio.clone();

            // define o id do radio
            radioGrupo.find("input").val( grupo.id );

            // define o texto do radio
            radioGrupo.find(".nomeGrupo").html( grupo.nome );

            if( grupo.padrao == "S" )
                radioGrupo.find("input").attr("checked", true);

            // define a coluna que será inserido o novo radio
            if (index % 2 == 0) {

                // insere o novo radio na coluna da esquerda
                adicionarUsuarioForm.find(".inputGruposUsuarioColunaPar").append( radioGrupo );

            } else {

                // insere o novo radio na coluna da direita
                adicionarUsuarioForm.find(".inputGruposUsuarioColunaImpar").append( radioGrupo );

            }

        });

    };

    // bloqueia o botão submmit do formulario de adição de usuario
    self.blockearBotaoAdicionarUsuario = function(){

        $("#adicionarUsuarioForm").find("#submitAddUsuario").button('loading');

    };

    // libera o botão submmit do formulario de adição de usuario
    self.liberarBotaoAdicionarUsuario = function(){

        $("#adicionarUsuarioForm").find("#submitAddUsuario").button('reset');
        
    };

    // inserir o formulario de edição de usuario no DOM
    self.inserirFormEdicaoUsuario = function( form ){

        // insere o formulário no DOM
        $("body").append( $(form) );

    };

    // exibe o formulário de edição de usuario
    self.exibirFormEdicaoUsuario = function(){

        // exibe o formulário num modal
        $("#editarUsuarioForm").closest(".modal").modal("show");

    };

    // insere os grupos do sistema no formulário de edição de grupos
    self.adicionarGruposNoFormEdicaoUsuario = function( grupos ){

        var editarUsuarioForm = $("#editarUsuarioForm");

        // clona o html do radio
        var radio = editarUsuarioForm.find(".inputGruposUsuarioColunaPar").find(".radio").first().clone();

        // remove os grupos anteriores
        editarUsuarioForm.find(".inputGruposUsuarioColunaPar").empty();
        editarUsuarioForm.find(".inputGruposUsuarioColunaImpar").empty();

        // itera sobre a lista de grupos para inserí-los no formulário
        $.each( grupos, function( index, grupo ){

            // instancia um novo radio
            var radioGrupo = radio.clone();

            // define o id do radio
            radioGrupo.find("input").val( grupo.id );

            // define o texto do radio
            radioGrupo.find(".nomeGrupo").html( grupo.nome );

            if( grupo.padrao == "S" )
                radioGrupo.find("input").attr("checked", true);

            // define a coluna que será inserido o novo radio
            if (index % 2 == 0) {

                // insere o novo radio na coluna da esquerda
                editarUsuarioForm.find(".inputGruposUsuarioColunaPar").append( radioGrupo );

            } else {

                // insere o novo radio na coluna da direita
                editarUsuarioForm.find(".inputGruposUsuarioColunaImpar").append( radioGrupo );

            }

        });

    };

    // preenche o formulário de edição de usuario com os dados do usuario
    self.preencherFormEdicaoUsuario = function( usuario ){

        var editarUsuarioForm = $("#editarUsuarioForm");

        // preenche o formulário
        editarUsuarioForm.find("#id").val( usuario.id );
        editarUsuarioForm.find("#nome").val( usuario.nome );
        editarUsuarioForm.find("#email").val( usuario.email );
        editarUsuarioForm.find("#telefone1").val( usuario.telefone1 );
        editarUsuarioForm.find("#telefone2").val( usuario.telefone2 );
        editarUsuarioForm.find("#cargo").val( usuario.cargo );

        // setar se é admin
        editarUsuarioForm.find("input[name=admin][value="+usuario.admin+"]").prop('checked', true);

        // setar o grupo
        editarUsuarioForm.find("input[name=grupo][value="+usuario.grupo_id+"]").prop('checked', true);
        
    };

    // bloqueia o botão submmit do formulario de adição de usuario
    self.blockearBotaoEditarUsuario = function(){

        $("#adicionarUsuarioForm").find("#submitEditarUsuario").button('loading');

    };

    // libera o botão submmit do formulario de adição de usuario
    self.liberarBotaoEditarUsuario = function(){

        $("#adicionarUsuarioForm").find("#submitEditarUsuario").button('reset');
        
    };

    // remove um usuario tendo como referencia o seu id
    self.deletarUsuario = function( id ){

        // remove o usuario da tabela
        tabela.removerLinha( id );

        // retorna o resultado da operação de remoção
        return true;

    };

    // atualiza uma linhda da tabela
    self.editarUsuario = function( usuario ){

        // solicita o update da linha para a classe tabela
        tabela.editarLinha( usuario );

    };

    // fecha o formulário de edição de usuario
    self.fecharFormEdicaoUsuario = function(){

        // fecha o modal do formulário
        $("#editarUsuarioForm").closest(".modal").modal("hide");

    };
}