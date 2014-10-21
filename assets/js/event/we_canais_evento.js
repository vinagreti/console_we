$(document).ready(function(){

    // instancia o controller canais
    var canais_controller = new we_canais_controller();

    // lista os canais na tela
    canais_controller.exibirLista();

    // ao clicar na classe "adicionarCanal"
    $(document).on('click', '.adicionarCanal', function() {

        // exibe o formulario de criação de novo canal
        canais_controller.exibirFormAdicaoCanal();

    });

    // adicionar canal
    $(document).on('submit', '#adicionarCanalForm', function( e ) {

        // impede o formulário de recarregar a página
        e.preventDefault();

        // pega os dados do formulário
        var canal = $(this).serializeObject();

        // solicita a adição do novo canal no banco
        canais_controller.adicionarCanal( canal );

        // impede o formulário de recarregar a página
        return false;
    });

    // ao clicar na classe "editarCanal"
    $(document).on('click', '.editarCanal', function() {

        // salva o id do canal a ser editado
        var id = $(this).parents("tr").attr("id");

        // exibe o formulario de ediação de canal
        canais_controller.exibirFormEdicaoCanal( id );

    });

    // editar canal
    $(document).on('submit', '#editarCanalForm', function( e ) {

        // impede o formulário de recarregar a página
        e.preventDefault();
        
        // pega os dados do formulário
        var canal = $(this).serializeObject();

        // solicita a edição do canal no banco
        canais_controller.editarCanal( canal );

        // impede o formulário de recarregar a página
        return false;

    });

    // ao clicar na classe "diminuir_ordem"
    $(document).on('click', '.diminuir_ordem', function() {

        // salva o id do canal a ser editado
        var canal = {
            id : $(this).parents("tr").attr("id")
            , ordem : parseInt($(this).parents("tr").find(".ordem").html()) - 1
        };

        // exibe o formulario de ediação de canal
        canais_controller.editarCanal( canal );

    });

    // ao clicar na classe "aumentar_ordem"
    $(document).on('click', '.aumentar_ordem', function() {

        // salva o id do canal a ser editado
        var canal = {
            id : $(this).parents("tr").attr("id")
            , ordem : parseInt($(this).parents("tr").find(".ordem").html()) + 1
        };

        // exibe o formulario de ediação de canal
        canais_controller.editarCanal( canal );

    });

    // ao clicar na classe "deletarCanal"
    $(document).on('click', '.deletarCanal', function() {

        // salva o id do canal a ser removido
        var id = $(this).parents("tr").attr("id");

        // salva o nome do canal a ser removido
        var nome = $(this).parents("tr").find(".nome").html();

        // remove o canal
        canais_controller.deletarCanal( id, nome );

    });
});