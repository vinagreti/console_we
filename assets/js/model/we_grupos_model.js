function we_grupos_model() {

	var self = this;

	// carrega um JSON com o resumo da lista de grupos
	self.carregarResumo = function(pagina, por_pagina){

		// GET solicitando o resumo dos grupos
		var get = $.ajax( base_url+"grupos?pagina="+pagina+"&por_pagina="+por_pagina, { type: "GET", cache: false } ).promise();

		// retorna o resumo dos grupos
		return get;

	};

    // carrega um JSON com os usuarios do grupo
    self.carregaUsuarios = function( grupo_id ){

        // GET solicitando o resumo dos grupos
        var get = $.ajax( base_url+"usuarios?grupo_id="+grupo_id, { type: "GET", cache: false } ).promise();

        // retorna o resumo dos grupos
        return get;

    };

    // carrega um JSON com os dados de um grupo tendo como referencia o seu id
    self.carregarGrupo = function( id ){

        // GET solicitando dados de um grupo
        var get = $.ajax( base_url+"grupos/?id="+id , { type: "GET", cache: false } ).promise();

        // retorna os dados do grupo
        return get;

    };

    // carrega HTML do formulário de adição do grupo
	self.carregarAdicionarGrupoForm = function(){

		// GET solicitando o formulario de inserção de grupo
        var get = $.ajax( base_url+"grupos/formulario_adicao", { type: "GET", cache: false } ).promise();

        // retorna o formulario de inserção de grupo
        return get;

	};

    // carrega o HTML do formulário de edição do grupo
	self.carregarEditarGrupoForm = function(){

		// GET solicitando o formulario de edição de grupo
        var get = $.ajax( base_url+"grupos/formulario_edicao", { type: "GET", cache: false } ).promise();

        // retorna o formulario de edição de grupo
        return get;

	};

    // carrega um JSON com o resumo dos módulos do sistema
	self.carregarResumoModulos = function( grupo_id ){

        var url = base_url+"modulos";

        // verifica se foi passado o id do grupo
        if( grupo_id ){

            url += "?grupo_id=" + grupo_id;

        }

		// GET solicitando o resumo dos módulos
        var get = $.ajax( url, { type: "GET", cache: false } ).promise();

        // retorna o resumo dos modulos
        return get;

	};

    // adiciona um grupo no banco de dados
	self.adicionarGrupo = function( grupo ){

		// POST solicitando a adição do grupo
		var post = $.ajax( base_url+"grupos", { type: "POST", data: grupo, cache: false } ).promise();

		// retorna o resultado da operação de adição
		return post;

	};

    // atualiza um grupo no banco de dados
    self.editarGrupo = function( grupo ){

        // PUT solicitando a edição do grupo
        var put = $.ajax( base_url+"grupos", { type: "PUT", data: grupo, cache: false } ).promise();

        // retorna o resultado da operação de edição
        return put;

    };

	// remove um grupo do banco de dados tendo como referencia o seu id
	self.deletarGrupo = function( id, novo_grupo_id ){

        // define a url da chamada
        var url = base_url+"grupos/?id="+id;

        // define se os usuarios serao movidos
        if( novo_grupo_id )
            url += "&novo_grupo_id="+novo_grupo_id;


		// DELETE solicitando a remoção do grupo
		var del = $.ajax( url, { type: "DELETE", cache: false } ).promise();

		// retorna o resultado da operação de remoção
		return del;

	};

};