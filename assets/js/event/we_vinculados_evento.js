$(document).ready(function(){

    // instancia o controller vinculados
    var vinculados_controller = new we_vinculados_controller();

    // lista os vinculados na tela
    vinculados_controller.exibirLista();

    // ao clicar na classe "deletarVinculado"
    $(document).on('click', '.deletarVinculado', function() {

        // salva o id do vinculado a ser removido
        var id = $(this).parents("tr").attr("id");

        // salva o nome do vinculado a ser removido
        var nome = $(this).parents("tr").find(".nome").html();
        
        // remove o vinculado
        vinculados_controller.deletarVinculado( id, nome );

    });

    // ao clicar na classe "deletarVinculado"
    $(document).on('click', '.csvVinculados', function() {

        downloadURL( base_url + "vinculados/criaCSV")

    });

});