// Tabela
// Classe de criação e manipulação de tabelas
// Author: Bruno da Silva João
// https://github.com/vinagreti
function we_tabela_library( selector ) {

	// instancia a si mesmo para poder ser utilizado dentro de funções
	var self = this;

	// verifica o id da tabela
	if( ! selector )
		var selector = "table";

	// instancia o elemento tabela
	var tabela = $(  selector );

	// aplica a classe de ordenação na
	$(function(){ tabela.tablesorter(); });

	// copia a estrutura HTML da linha
	var elementoLinha = tabela.find("tbody").find("tr").clone();

	// remove a linha modelo
	tabela.find("tbody").find("tr").remove();

	// configura o cabeçalho da tabela
	$.each( tabela.find("th"), function( index, th ){

		// se tiverem a classe "ordenavel"
		if (typeof $(th).attr("ordenavel") !== 'undefined' && $(th).attr("ordenavel") !== false) {

			// torna o cabeçalho clicável 
			$(th).addClass("clicavel");

			// insere icones de sort no cabeçalho das colunas
			$(th).append(' <i class="fa fa-sort"></i>');

		}

	} );

	// atualiza a barra de paginação
	self.atualizarPaginacao = function( total, pagina, por_pagina, base_url_pag ){

		pagina = pagina ? parseInt(pagina) : 1;

		por_pagina = por_pagina ? parseInt(por_pagina) : 30;

		var totalPaginas = Math.ceil(total / por_pagina);

		if( totalPaginas > 1 ){

			var paginacao = '<div class="text-center"><ul class="pagination">';

			paginacao += '<li><a href="'+base_url_pag+'?pagina=1&por_pagina='+por_pagina+'">&laquo;</a></li>';

			paginacao += '<li><a href="'+base_url_pag+'?pagina='+(pagina > 2 ? pagina - 1 : 1)+'&por_pagina='+por_pagina+'">&lt;</a></li>';

			for (var i = 1; i <= totalPaginas; i++) {
				paginacao += '<li class="'+ (i == pagina ? 'active' : '') + '"><a href="'+base_url_pag+'?pagina='+i+'&por_pagina='+por_pagina+'">'+i+' <span class="sr-only">(current)</span></a></li>';
			};

			paginacao += '<li><a href="'+base_url_pag+'?pagina='+ ((pagina < totalPaginas) ? (pagina+1) : pagina) +'&por_pagina='+por_pagina+'">&gt;</a></li>';

			paginacao += '<li><a href="'+base_url_pag+'?pagina='+ totalPaginas +'&por_pagina='+por_pagina+'">&raquo;</a></li>';

			paginacao += '</ul></div>';

			if( ! tabela.find("tfoot").length )
				tabela.append($('<tfoot>'));

			tabela
				.find("tfoot")
					.html( $('<tr>')
								.html( $('<td>')
									.attr('colspan',elementoLinha.find('td').length)
									.html( $(paginacao) )
								)
							);

		} else {

			tabela.find("tfoot").empty();

		}

		if( ! tabela.find("caption").length )
			tabela.prepend($('<caption>'));

		var posicaoPrimeiroItem = total > 0 ? (pagina * por_pagina) + 1 - por_pagina : 0;

		var posicaoSegundoItem = (posicaoPrimeiroItem + por_pagina - 1) > total ? total : posicaoPrimeiroItem + por_pagina -1;

		tabela.find("caption").html("<small class='text-info'>Mostrando do " + posicaoPrimeiroItem + "&ordm até o " + posicaoSegundoItem + "&ordm de " + total + " registro(s) encontrado(s).</small>");

	}

	// insere uma linha na tabela tendo como base um objeto JSON
	self.inserirLinha = function( objeto, pos, highlight ){

		// define a posição da nova linha
		var pos = ( pos === "append" || pos === "prepend" ) ? pos : "append";

		// cria uma nova linha da tabela
		var linha = elementoLinha.clone();

		// define o identificador da nova linha
		linha.attr("id", objeto.id );

		// para cada atributo do objeto
		$.each( objeto, function( attribute, value ){

			var elemento = linha.find( "." + attribute );

			if( elemento.length > 0 ){

				// preenche a respectiva coluna da linha com seu valor
				elemento.html( value );

				if( elemento.get(0).tagName == "IMG" ){

					elemento.attr("src", value );

					elemento.wrap( "<a href='"+value+"' target='_blank'></a>" );

				}

			}

		});

		// se a opção highlight estiver setada como true
		if( highlight ){

			// cria um efeito visual na nova linha
			linha.addClass("success");

			// após 4 segundos
			setTimeout(function(){

				// remove o efeito visual da nova linha
				linha.removeClass("success");

			},2400);

		};

		// insere a nova linha na tabela
		linha.hide()[pos+"To"]( tabela.find("tbody") ).fadeIn( "slow" );

		// atualiza a classe de orednação
		self.atualizaOrdenacao();

	};

    // remove uma linha da tabela tendo como referência seu identificador (id)
    self.removerLinha = function( id ){

    	// instancia a linha da tabela
		var linha = tabela.find( "#" + id );

		// insere um efeito na linha
		linha.addClass("danger");

		// apaga a linha lentamente
		linha.fadeOut("slow", function(){

			// remove a linha da tabela
			linha.remove();

			// atualiza a classe de orednação
			self.atualizaOrdenacao();

		});

    };

    self.atualizaOrdenacao = function(){

		var resort = true, callback = function(table){};

		tabela.trigger("update", [resort, callback]);

    };

	// insere uma linha na tabela tendo como base um objeto JSON
	self.editarLinha = function( objeto ){

		// instancia a linha da tabela
		var linha = tabela.find("#"+objeto.id);

		// para cada atributo do objeto
		$.each( objeto, function( attribute, value ){

			var elemento = linha.find( "." + attribute );

			if( elemento.length > 0 ){

				// preenche a respectiva coluna da linha com seu valor
				elemento.html( value );
				
				if( elemento.get(0).tagName == "IMG" ){

					elemento.attr("src", value );

				}

			}

		});

		// cria um efeito visual na linha editada
		linha.addClass("success");

		// após 4 segundos
		setTimeout(function(){

			// remove o efeito visual da linha editada
			linha.removeClass("success");

		},2400);

		// atualiza a classe de orednação
		self.atualizaOrdenacao();

	};

	self.limpar = function(){

		tabela.find("tbody").empty();

		tabela.find("tfoot").remove();

		tabela.find("caption").remove();

	}
};