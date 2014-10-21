$(document).ready(function(){

    // instancia o controller posts
    var posts_controller = new we_posts_controller();

    // lista os posts na tela
    posts_controller.exibirLista();

    // exibe modal de filtro
    $(document).on('click', '.abrirFiltro', function() {

        // exibe o modal do filtro
        posts_controller.exibirModalFiltro();

    });

    // filtrar o post
    $(document).on('submit', '#filtroPosts', function( e ) {

        // impede o formulário de recarregar a página
        e.preventDefault();
        
        // pega os dados do formulário
        var filtroPost = $(this).serializeObject();

        // busca posts no banco de acordo com o filtro configurado
        posts_controller.exibirLista( filtroPost );

        // impede o formulário de recarregar a página
        return false;

    });

    // ao clicar na classe "moderarPost"
    $(document).on('click', '.moderarPost', function() {

        // salva o id do post a ser editado
        var id = $(this).parents("tr").attr("id");

        // exibe o formulario de ediação de post
        posts_controller.exibirFormModerarPost( id );

    });

    // moderar o post
    $(document).on('submit', '#moderarPostForm', function( e ) {

        // impede o formulário de recarregar a página
        e.preventDefault();
        
        // pega os dados do formulário
        var post = $(this).serializeObject();

        // solicita a moderação do pst no banco
        posts_controller.moderarPost( post );

        // impede o formulário de recarregar a página
        return false;

    });

    // ao clicar na classe "deletarPost"
    $(document).on('click', '.deletarPost', function() {

        // salva o id do post a ser removido
        var id = $(this).parents("tr").attr("id");

        // salva o nome do post a ser removido
        var nome = '"'+$(this).parents("tr").find(".texto").html()+'..."';

        // remove o post
        posts_controller.deletarPost( id, nome );

    });

    // ao clicar na classe "detalhesPost"
    $(document).on('click', '.detalhesPost', function() {

        // salva o id do post a ser detalhado
        var id = $(this).parents("tr").attr("id");

        // remove o post
        posts_controller.detalhesPost( id );

    });

    // ao clicar na classe "publicarPost"
    $(document).on('click', '.publicarPost', function() {

        // salva o id do post a ser publicado
        var id = $(this).attr("data-id");

        // solicita publicação
        posts_controller.publicarPost( id );

    });

    // ao clicar na classe "removerPublicacaoPost"
    $(document).on('click', '.removerPublicacaoPost', function() {

        // salva o id do post a ser publicado
        var id = $(this).attr("data-id");

        // solicita a remoção da publicação
        posts_controller.removerPublicacaoPost( id );

    });

    // ao alterar checkbox "publicarPostAPI"
    $(document).on('change', '#publicarPostAPI', function() {

        // salva o id do post a ser publicado
        var id = $(this).attr("data-id");

        if($(this).is(":checked"))
            posts_controller.publicarPostAPI( id );  // publica na API

        else
            posts_controller.removerPostAPI( id ); // remove da API

    });
});