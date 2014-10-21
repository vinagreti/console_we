function we_denuncias_model() {

    var self = this;

    // carrega um JSON com o resumo da lista de denuncias
    self.carregarResumo = function( params, pagina, por_pagina ){

        // GET solicitando o resumo dos denuncias
        var get = $.ajax( base_url+"denuncias?pagina="+pagina+"&por_pagina="+por_pagina, { type: "GET", cache: false, data: params } ).promise();

        // retorna o resumo dos denuncias
        return get;

    };

    // carrega um JSON com os dados de um denuncia tendo como referencia o seu id
    self.carregarDenuncia = function( id ){

        // GET solicitando dados de um denuncia
        var get = $.ajax( base_url+"denuncias/?id="+id , { type: "GET", cache: false } ).promise();

        // retorna os dados do denuncia
        return get;

    };

    // carrega HTML do formulário de moderação do denuncia
    self.carregarModalFiltro = function(){

        // GET solicitando o formulario de moderação do denuncia
        var get = $.ajax( base_url+"denuncias/modal_filtro", { type: "GET", cache: false } ).promise();

        // retorna o formulario de inserção de grupo
        return get;

    };

    // carrega HTML do formulário de detalhes do denuncia
    self.carregarModalDetalhesDenuncia = function(){

        // GET solicitando o formulario de detalhes do denuncia
        var get = $.ajax( base_url+"denuncias/modal_detalhes", { type: "GET", cache: false } ).promise();

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
}