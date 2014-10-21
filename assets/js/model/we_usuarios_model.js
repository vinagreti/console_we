function we_usuarios_model() {

    var self = this;

    // carrega um JSON com o resumo da lista de usuarios
    self.carregarResumo = function(pagina, por_pagina){

        // GET solicitando o resumo dos usuarios
        var get = $.ajax( base_url+"usuarios?pagina="+pagina+"&por_pagina="+por_pagina, { type: "GET", cache: false } ).promise();

        // retorna o resumo dos usuarios
        return get;

    };

    // carrega HTML do formulário de adição do usuario
    self.carregarAdicionarUsuarioForm = function(){

        // GET solicitando o formulario
        var get = $.ajax( base_url+"usuarios/formulario_adicao", { type: "GET", cache: false } ).promise();

        // retorna o formulario
        return get;

    };

    // carrega HTML do formulário de edição do usuario
    self.carregarEditarUsuarioForm = function(){

        // GET solicitando o formulario
        var get = $.ajax( base_url+"usuarios/formulario_edicao", { type: "GET", cache: false } ).promise();

        // retorna o formulario
        return get;

    };

    // carrega um JSON com o resumo dos grupos do cliente
    self.carregarResumoGrupos = function(){

        // GET solicitando o resumo dos grupos do cliente
        var get = $.ajax( base_url+"grupos", { type: "GET", cache: false } ).promise();

        // retorna o resumo dos grupos
        return get;

    };

    // adiciona um usuario no banco de dados
    self.adicionarUsuario = function( usuario ){

        // POST solicitando a adição do usuario
        var post = $.ajax( base_url+"usuarios", { type: "POST", data: usuario, cache: false } ).promise();

        // retorna o resultado da operação de adição
        return post;

    };

    // remove um usuario do banco de dados tendo como referencia o seu id
    self.deletarUsuario = function( id ){

        // DELETE solicitando a remoção do usuario
        var del = $.ajax( base_url+"usuarios/?id="+id, { type: "DELETE", cache: false } ).promise();

        // retorna o resultado da operação de remoção
        return del;

    };

    // carrega um JSON com os usuarios do usuario
    self.carregarUsuario = function( id ){

        // GET solicitando o usuario
        var get = $.ajax( base_url+"usuarios?id="+id, { type: "GET", cache: false } ).promise();

        // retorna o usuario
        return get;

    };

    // atualiza um usuario no banco de dados
    self.editarUsuario = function( usuario ){

        // PUT solicitando a edição do usuario
        var put = $.ajax( base_url+"usuarios", { type: "PUT", data: usuario, cache: false } ).promise();

        // retorna o resultado da operação de edição
        return put;

    };

}