function we_canais_model() {

    var self = this;

    // carrega um JSON com o resumo da lista de canais
    self.carregarResumo = function(pagina, por_pagina){

        // GET solicitando o resumo dos canais
        var get = $.ajax( base_url+"canais?pagina="+pagina+"&por_pagina="+por_pagina, { type: "GET", cache: false } ).promise();

        // retorna o resumo dos canais
        return get;

    };

    // carrega HTML do formulário de adição do canal
    self.carregarAdicionarCanalForm = function(){

        // GET solicitando o formulario
        var get = $.ajax( base_url+"canais/formulario_adicao", { type: "GET", cache: false } ).promise();

        // retorna o formulario
        return get;

    };

    // adiciona um canal no banco de dados
    self.adicionarCanal = function( canal ){

        // POST solicitando a adição do canal
        var post = $.ajax( base_url+"canais", { type: "POST", data: canal, cache: false } ).promise();

        // retorna o resultado da operação de adição
        return post;

    };

    // carrega um JSON com os dados de um canal tendo como referencia o seu id
    self.carregarCanal = function( id ){

        // GET solicitando dados de um canal
        var get = $.ajax( base_url+"canais/?id="+id , { type: "GET", cache: false } ).promise();

        // retorna os dados do canal
        return get;

    };

    // carrega o HTML do formulário de edição do canal
    self.carregarEditarCanalForm = function(){

        // GET solicitando o formulario de edição de canal
        var get = $.ajax( base_url+"canais/formulario_edicao", { type: "GET", cache: false } ).promise();

        // retorna o formulario de edição de canal
        return get;

    };

    // atualiza um canal no banco de dados
    self.editarCanal = function( canal ){

        // PUT solicitando a edição do canal
        var put = $.ajax( base_url+"canais", { type: "PUT", data: canal, cache: false } ).promise();

        // retorna o resultado da operação de edição
        return put;

    };

    // remove um canal do banco de dados tendo como referencia o seu id
    self.deletarCanal = function( id ){

        // DELETE solicitando a remoção do canal
        var del = $.ajax( base_url+"canais/?id="+id, { type: "DELETE", cache: false } ).promise();

        // retorna o resultado da operação de remoção
        return del;

    };
};