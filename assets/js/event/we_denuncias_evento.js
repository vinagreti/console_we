$(document).ready(function(){

    // instancia o controller denuncias
    var denuncias_controller = new we_denuncias_controller();

    // lista os denuncias na tela
    denuncias_controller.exibirLista();

    // exibe modal de filtro
    $(document).on('click', '.abrirFiltro', function() {

        // exibe o modal do filtro
        denuncias_controller.exibirModalFiltro();

    });

    // filtrar o denuncia
    $(document).on('submit', '#filtroDenuncias', function( e ) {

        // impede o formulário de recarregar a página
        e.preventDefault();

        // pega os dados do formulário
        var denuncia = $(this).serializeObject();

        // busca denuncias no banco de acordo com o filtro configurado
        denuncias_controller.exibirLista( denuncia );

        // impede o formulário de recarregar a página
        return false;

    });

    // exibe a denúncia
    $(document).on('click', '.detalhesDenuncia', function() {

        // salva o id do post a ser exibido
        var id = $(this).parents("tr").attr("id");

        // exibe o modal de detalhes
        denuncias_controller.exibirDetalhesDenuncia( id );

    });

    // ao clicar na classe "publicarPost"
    $(document).on('click', '.publicarPost', function() {

        // salva o id do post a ser publicado
        var id = $(this).attr("data-id");

        // solicita publicação
        denuncias_controller.publicarPost( id );

    });

    // ao clicar na classe "removerPublicacaoPost"
    $(document).on('click', '.removerPublicacaoPost', function() {

        // salva o id do post a ser publicado
        var id = $(this).attr("data-id");

        // solicita a remoção da publicação
        denuncias_controller.removerPublicacaoPost( id );

    });

    // ao alterar checkbox "publicarPostAPI"
    $(document).on('change', '#publicarPostAPI', function() {

        // salva o id do post a ser publicado
        var id = $(this).attr("data-id");

        if($(this).is(":checked"))
            denuncias_controller.publicarPostAPI( id );  // publica na API

        else
            denuncias_controller.removerPostAPI( id ); // remove da API

    });
});