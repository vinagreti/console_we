$(document).ready(function(){

    // instancia o controller grupos
    var grupos_controller = new we_grupos_controller();

    // lista os grupos na tela
    grupos_controller.exibirLista();

    // ao clicar na classe "adicionarGrupo"
    $(document).on('click', '.adicionarGrupo', function() {

        // exibe o formulario de criação de novo grupo
        grupos_controller.exibirFormAdicaoGrupo();

    });

    // ao clicar na classe "editarGrupo"
    $(document).on('click', '.editarGrupo', function() {

        // salva o id do grupo a ser editado
        var id = $(this).parents("tr").attr("id");

        // exibe o formulario de ediação de grupo
        grupos_controller.exibirFormEdicaoGrupo( id );

    });
    
    // ao clicar na classe "deletarGrupo"
    $(document).on('click', '.deletarGrupo', function() {

        // salva o id do grupo a ser removido
        var id = $(this).parents("tr").attr("id");

        // salva o nome do grupo a ser removido
        var nome = $(this).parents("tr").find(".nome").html();

        // remove o grupo
        grupos_controller.deletarGrupo( id, nome );

    });

    // adicionar grupo
    $(document).on('submit', '#adicionarGrupoForm', function( e ) {

        // impede o formulário de recarregar a página
        e.preventDefault();

        // pega os dados do formulário
        var grupo = $(this).serializeObject();

        // solicita a adição do novo grupo no banco
        grupos_controller.adicionarGrupo( grupo );

        // impede o formulário de recarregar a página
        return false;
    });

    // editar grupo
    $(document).on('submit', '#editarGrupoForm', function( e ) {

        // impede o formulário de recarregar a página
        e.preventDefault();
        
        // pega os dados do formulário
        var grupo = $(this).serializeObject();

        // solicita a edição do grupo no banco
        grupos_controller.editarGrupo( grupo );

        // impede o formulário de recarregar a página
        return false;

    });

});