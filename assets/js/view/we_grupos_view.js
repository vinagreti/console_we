function we_grupos_view() {

	var self = this;

	// instancia a classe tabela
	var tabela = new we_tabela_library( "#tabelaGrupos" );

	// lista os grupos em uma tabela
	self.listar = function( grupos, total, pagina, por_pagina ){

        base_url_pag = base_url+'grupos';

        tabela.atualizarPaginacao( total, pagina, por_pagina, base_url_pag );
		// para cada grupo da lista de grupos
		$.each( grupos, function( index, grupo ){

			// insere uma linha na tabela
			tabela.inserirLinha( grupo, "append" );

		});

	};

	// remove um grupo tendo como referencia o seu id
	self.deletarGrupo = function( id ){

		// remove o grupo da tabela
		tabela.removerLinha( id );

		// retorna o resultado da operação de remoção
		return true;

	};

	// inserir o formulariod e adição de grupo no DOM
	self.inserirFormAdicaoGrupo = function( form ){

		// insere o formulário no DOM
		$("body").append( $(form) );

	};

	// exibe o formulário de adição de grupo
	self.exibirFormAdicaoGrupo = function(){

		var adicionarGrupoForm = $("#adicionarGrupoForm");

		// limpa o formulario
		adicionarGrupoForm.find(".inputModulosGrupo").prop('checked', false);
		adicionarGrupoForm.find("#nome").val("");

		// exibe o formulário num modal
        adicionarGrupoForm.closest(".modal").modal("show");

	};

	// fecha o formulário de adição de grupo
	self.fecharFormAdicaoGrupo = function(){

		// fecha o modal do formulário
        $("#adicionarGrupoForm").closest(".modal").modal("hide");

	};

	// inserir o formulariod e edição de grupo no DOM
	self.inserirFormEdicaoGrupo = function( form ){

		// insere o formulário no DOM
		$("body").append( $(form) );

	};

	// exibe o formulário de edição de grupo
	self.exibirFormEdicaoGrupo = function(){

		// exibe o formulário num modal
        $("#editarGrupoForm").closest(".modal").modal("show");

	};

	// fecha o formulário de edição de grupo
	self.fecharFormEdicaoGrupo = function(){

		// fecha o modal do formulário
        $("#editarGrupoForm").closest(".modal").modal("hide");

	};

	// adiciona o novo grupo no inicio da tabela
	self.adicionarGrupo = function( grupo ){

		// adiciona o novo grupo na tabela
		tabela.inserirLinha( grupo, "prepend", true );

		// retorna o resultado da operação de remoção
		return true;

	};

	self.limpaFormAdicaoGrupo = function(){

		// deschecka o checkbox
		$("#adicionarGrupoForm").find(".inputModulosGrupo").prop('checked', false);

	}

	// insere os modulos do sistema no formulário de adição de grupos
	self.adicionarModulosNoFormAdicaoGrupo = function( modulos ){

		var adicionarGrupoForm = $("#adicionarGrupoForm");

		// clona o html do checkbox
		var checkbox = adicionarGrupoForm.find(".inputModulosGrupoColunaPar").find(".checkbox").first().clone();

		// remove o checkbox exemplo
        adicionarGrupoForm.find(".inputModulosGrupoColunaPar").empty();
        adicionarGrupoForm.find(".inputModulosGrupoColunaImpar").empty();

		// itera sobre a lista de módulos para inserilos no formulario
		$.each( modulos, function( index, modulo ){

			// instancia um novo checkbox
			var checkboxModulo = checkbox.clone();

			// define o id do checkbox
			checkboxModulo.find("input").val( modulo.id );

			// define o texto do checkbox
			checkboxModulo.find(".nomeModulo").html( modulo.nome );

			// define a coluna que será inserido o novo checkbox
			if (index % 2 == 0) {

				// insere o novo checkbox na coluna da esquerda
				adicionarGrupoForm.find(".inputModulosGrupoColunaPar").append( checkboxModulo );

			} else {

				// insere o novo checkbox na coluna da direita
				adicionarGrupoForm.find(".inputModulosGrupoColunaImpar").append( checkboxModulo );

			}

		});

	};

	// insere os modulos do sistema no formulário de edição de grupos
	self.addModulosNoFormEdicaoGrupo = function( modulos ){

		var editarGrupoForm = $("#editarGrupoForm");

		// clona o html do checkbox
		var checkbox = editarGrupoForm.find(".inputModulosGrupoColunaPar").find(".checkbox").first().clone();

		// remove o checkbox exemplo
        editarGrupoForm.find(".inputModulosGrupoColunaPar").empty();
        editarGrupoForm.find(".inputModulosGrupoColunaImpar").empty();

		// itera sobre a lista de módulos para inserilos no formulario
		$.each( modulos, function( index, modulo ){

			// instancia um novo checkbox
			var checkboxModulo = checkbox.clone();

			// define o id do checkbox
			checkboxModulo.find("input").val( modulo.id );

			// define o texto do checkbox
			checkboxModulo.find(".nomeModulo").html( modulo.nome );

			// define a coluna que será inserido o novo checkbox
			if (index % 2 == 0) {

				// insere o novo checkbox na coluna da esquerda
				editarGrupoForm.find(".inputModulosGrupoColunaPar").append( checkboxModulo );

			} else {

				// insere o novo checkbox na coluna da direita
				editarGrupoForm.find(".inputModulosGrupoColunaImpar").append( checkboxModulo );

			}

		});

	};

	// preenche o formulário de edição de grupo com os dados do grupo
	self.preencherFormEdicaoGrupo = function( grupo ){

		var editarGrupoForm = $("#editarGrupoForm");

		editarGrupoForm.find("#id").val( grupo.id );

		// insere o nome do grupo no campo nome
		editarGrupoForm.find("#nome").val( grupo.nome );

		// deschecka o checkbox
		editarGrupoForm.find(".inputModulosGrupo").prop('checked', false);
		
		// corre a lista de modulos do grupo
		$.each( grupo.modulos, function( index, modulo ){

			// marca os checkbox dos módulos utilizados
			editarGrupoForm.find('input[value="'+modulo+'"]').prop('checked', true);

		});

		// insere o id do grupo como valor do botao de submmit
		editarGrupoForm.attr("data-grupo", grupo.id); 
		
	};

	// atualiza uma linhda da tabela
	self.editarGrupo = function( grupo ){

		// solicita o update da linha para a classe tabela
		tabela.editarLinha( grupo );

	};

	// bloqueia o botão submmit do formulario de adição de grupo
	self.blockearBotaoAdicionarGrupo = function(){

		$("#adicionarGrupoForm").find("#submitAddGrupo").button('loading');

	};

	// libera o botão submmit do formulario de adição de grupo
	self.liberarBotaoAdicionarGrupo = function(){

		$("#adicionarGrupoForm").find("#submitAddGrupo").button('reset');
		
	};

	// bloqueia o botão submmit do formulario de edição de grupo
	self.blockearBotaoEditarGrupo = function(){

		$("#editarGrupoForm").find("#submitEditGrupo").button('loading');

	};

	// libera o botão submmit do formulario de edição de grupo
	self.liberarBotaoEditarGrupo = function(){

		$("#editarGrupoForm").find("#submitEditGrupo").button('reset');
		
	};

};