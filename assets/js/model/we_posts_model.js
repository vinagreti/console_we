function we_posts_model() {

    var self = this;

    // carrega um JSON com o resumo da lista de posts
    self.carregarResumo = function( params, pagina, por_pagina ){

        // GET solicitando o resumo dos posts
        var get = $.ajax( base_url+"posts?pagina="+pagina+"&por_pagina="+por_pagina, { type: "GET", cache: false, data: params } ).promise();

        // retorna o resumo dos posts
        return get;

    };

    // carrega um JSON com os dados de um post tendo como referencia o seu id
    self.carregarPost = function( id ){

        // GET solicitando dados de um post
        var get = $.ajax( base_url+"posts/?id="+id , { type: "GET", cache: false } ).promise();

        // retorna os dados do post
        return get;

    };

    // carrega HTML do formulário de moderação do post
    self.carregarModerarPostForm = function(){

        // GET solicitando o formulario de moderação do post
        var get = $.ajax( base_url+"posts/formulario_moderacao", { type: "GET", cache: false } ).promise();

        // retorna o formulario de inserção de grupo
        return get;

    };

    // salva a moderação do post no banco de dados
    self.moderarPost = function( post ){

        // PUT solicitando a moderação do post
        var put = $.ajax( base_url+"posts", { type: "PUT", data: post, cache: false } ).promise();

        // retorna o resultado da operação de moderação
        return put;

    };

    // remove um post do banco de dados tendo como referencia o seu id
    self.deletarPost = function( id ){

        // DELETE solicitando a remoção do post
        var del = $.ajax( base_url+"posts/?id="+id, { type: "DELETE", cache: false } ).promise();

        // retorna o resultado da operação de remoção
        return del;

    };

    // carrega HTML do modal de detalhes de post
    self.carregarDetalharPostModal = function(){

        // GET solicitando o modal de detalhes de post
        var get = $.ajax( base_url+"posts/modal_detalhes", { type: "GET", cache: false } ).promise();

        // retorna o modal de detalhes de post
        return get;

    };

    // carrega HTML do formulário de moderação do post
    self.carregarModalFiltro = function(){

        // GET solicitando o formulario de moderação do post
        var get = $.ajax( base_url+"posts/modal_filtro", { type: "GET", cache: false } ).promise();

        // retorna o formulario de inserção de grupo
        return get;

    };
};