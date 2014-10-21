$(document).ready(function(){

    // instancia o controller usuarios
    var usuarios_controller = new we_usuarios_controller();

    // lista os usuarios na tela
    usuarios_controller.exibirLista();

    // ao clicar na classe "adicionarUsuarios"
    $(document).on('click', '.adicionarUsuarios', function() {

        // exibe o formulario de criação de novo usuario
        usuarios_controller.exibirFormAdicaoUsuarios();

    });

    // ao clicar na classe "editarUsuarios"
    $(document).on('click', '.editarUsuarios', function() {

        // salva o id do usuario a ser editado
        var id = $(this).parents("tr").attr("id");

        // exibe o formulario de ediação de usuario
        usuarios_controller.exibirFormEdicaoUsuarios( id );

    });
    
    // ao clicar na classe "deletarUsuarios"
    $(document).on('click', '.deletarUsuarios', function() {

        // salva o id do usuario a ser removido
        var id = $(this).parents("tr").attr("id");

        // salva o id do usuario a ser removido
        var nome = $(this).parents("tr").find(".nome").html();

        // remove o usuario
        usuarios_controller.deletarUsuarios( id, nome );

    });

    // adicionar usuario
    $(document).on('submit', '#adicionarUsuarioForm', function( e ) {

        // impede o formulário de recarregar a página
        e.preventDefault();

        // pega os dados do formulário
        var usuario = $(this).serializeObject();

        // solicita a adição do novo usuario no banco
        usuarios_controller.adicionarUsuario( usuario );

        // impede o formulário de recarregar a página
        return false;

    });

    // ao clicar na classe "deletarUsuario"
    $(document).on('click', '.deletarUsuario', function() {

        // salva o id do usuario a ser removido
        var usuario_id = $(this).parents("tr").attr("id");

        // salva o nome do usuario a ser removido
        var nome = $(this).parents("tr").find(".nome").html();

        // remove o usuario
        usuarios_controller.deletarUsuario( usuario_id, nome );

    });

    // ao clicar na classe "editarUsuario"
    $(document).on('click', '.editarUsuario', function() {

        // salva o id do usuario a ser editado
        var id = $(this).parents("tr").attr("id");

        // exibe o formulario de ediação de usuario
        usuarios_controller.exibirFormEdicaoUsuario( id );

    });

    // editar usuario
    $(document).on('submit', '#editarUsuarioForm', function( e ) {

        // impede o formulário de recarregar a página
        e.preventDefault();
        
        // pega os dados do formulário
        var usuario = $(this).serializeObject();

        // solicita a edição do usuario no banco
        usuarios_controller.editarUsuario( usuario );

        // impede o formulário de recarregar a página
        return false;
    });

});