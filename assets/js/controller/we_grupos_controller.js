// controller javascript do módulo grupos
function we_grupos_controller() {

    // cria uma variavel para referenciar a classe dentro de funções
	var self = this;

    // instancia a classe grupos_model
    var grupos_model = new we_grupos_model();

    // instancia a classe grupos_view
    var grupos_view = new we_grupos_view();

    // lista os grupos
    self.exibirLista = function(){

        var pagina = we_url_helper.getParameterByName('pagina');

        var por_pagina = we_url_helper.getParameterByName('por_pagina');

	    // solicita um JSON com um resumo dos grupos
	    var carregarResumo = grupos_model.carregarResumo(pagina, por_pagina);

        // se a resposta do servidor for de sucesso
        carregarResumo.done(function ( resumo, textStatus, request ) {

            var total = request.getResponseHeader('X-Total-Count');

            // lista os grupos na tela
            grupos_view.listar( resumo, total, pagina, por_pagina );

        });

        // se a resposta do servidor for de falha
        carregarResumo.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

    };

    // exibe o form de adição de grupo
    this.exibirFormAdicaoGrupo = function(){

        // se o form ja foi carregado
        if( $('#adicionarGrupoForm').length > 0 ){

            // limpa o formulario de adição de grupos
            grupos_view.limpaFormAdicaoGrupo();

            // exibe o form
            grupos_view.exibirFormAdicaoGrupo();

        // se ainda nao foi carregado
        } else {

            // solicita ao servidor o html do form de adição de grupo
            var carregarAdicionarGrupoForm = grupos_model.carregarAdicionarGrupoForm();

            // se a resposta do servidor for de sucesso
            carregarAdicionarGrupoForm.done(function ( form ) {

                // solicita ao servidor a lista de modulos do sistema
                var carregarResumoModulos = grupos_model.carregarResumoModulos();

                // se a resposta do servidor for de sucesso
                carregarResumoModulos.done(function ( modulos ) {

                    // insere o html no DOM
                    grupos_view.inserirFormAdicaoGrupo( form );

                    // adiciona os modulso no formulário
                    grupos_view.adicionarModulosNoFormAdicaoGrupo( modulos );

                    // exibe o form
                    grupos_view.exibirFormAdicaoGrupo();

                });

                // se a resposta do servidor for de falha
                carregarResumoModulos.fail(function ( res ){

                    // insere um alerta na tela com a resposta do servidor
                    we_alerta.warning( res.statusText );

                });

            });

            // se a resposta do servidor for de falha
            carregarAdicionarGrupoForm.fail(function ( res ){

                // insere um alerta na tela com a resposta do servidor
                we_alerta.warning( res.statusText );

            });

        }

    };

    // exibe o form de edição de grupo
    this.exibirFormEdicaoGrupo = function( id ){

        // solicita ao servidor todos os dados do grupo
        var carregaGrupo = grupos_model.carregarGrupo( id );

        // se a resposta do servidor for de sucesso
        carregaGrupo.done(function ( grupo ) {

            // se o form ja foi carregado
            if( $('#editarGrupoForm').length > 0 ){

                // preenche o formulario de edição com os dados
                grupos_view.preencherFormEdicaoGrupo( grupo );
            
                // exibe o form
                grupos_view.exibirFormEdicaoGrupo();

            // se ainda nao foi carregado
            } else {

                // solicita ao servidor o html do form de edição de grupo
                var carregarEditarGrupoForm = grupos_model.carregarEditarGrupoForm();

                // se a resposta do servidor for de sucesso
                carregarEditarGrupoForm.done(function ( form ) {

                    // solicita ao servidor a lista de modulos do sistema
                    var carregarResumoModulos = grupos_model.carregarResumoModulos();

                    // se a resposta do servidor for de sucesso
                    carregarResumoModulos.done(function ( modulos ) {

                        // insere o html no DOM
                        grupos_view.inserirFormEdicaoGrupo( form );

                        // adiciona os modulso no formulário
                        grupos_view.addModulosNoFormEdicaoGrupo( modulos );

                        // preenche o formulario de edição com os dados
                        grupos_view.preencherFormEdicaoGrupo( grupo );

                        // exibe o form
                        grupos_view.exibirFormEdicaoGrupo();

                    });

                    // se a resposta do servidor for de falha
                    carregarResumoModulos.fail(function ( res ){

                    // insere um alerta na tela com a resposta do servidor
                    we_alerta.warning( res.statusText );

                    });

                });

                // se a resposta do servidor for de falha
                carregarEditarGrupoForm.fail(function ( res ){

                    // insere um alerta na tela com a resposta do servidor
                    we_alerta.warning( res.statusText );

                });

            }

        });

        // se a resposta do servidor for de falha
        carregaGrupo.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

    };

    // exibe o form de adição de grupo
    this.fecharFormAdicaoGrupo = function(){

        // esconde o form
        grupos_view.fecharFormAdicaoGrupo();

    };

    // adiciona um novo grupo
    self.adicionarGrupo = function( grupo ){

        // bloqueia o botão de submmit do formulario de adição
        grupos_view.blockearBotaoAdicionarGrupo();

        // solicita a adição do grupo no servidor
        var adicionarGrupo = grupos_model.adicionarGrupo( grupo );

        // se a responsta do servidor for de sucesso
        adicionarGrupo.done(function ( grupo, statusText, jqXhr ) {

            // adiciona a linha da tabela
            grupos_view.adicionarGrupo( grupo );

            // fecha o modal
            grupos_view.fecharFormAdicaoGrupo();

            // informa que a mensagem de adição
            we_alerta.success( jqXhr.statusText );

        });

        // se a responsta do servidor for de falha
        adicionarGrupo.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

        // sempre que receber a resposta do servidor
        adicionarGrupo.always(function (){

            // libera o botão de submmit do formulario de adição
            grupos_view.liberarBotaoAdicionarGrupo();

        });

    };

    // edita um grupo
    self.editarGrupo = function( grupo ){

        // bloqueia o botão de submmit do formulario de edição
        grupos_view.blockearBotaoEditarGrupo();

        // solicita a edição do grupo no servidor
        var editarGrupo = grupos_model.editarGrupo( grupo );

        // se a resposta do servidor for de sucesso
        editarGrupo.done(function ( dados, statusText, jqXhr ){

            // editar a linha da tabela
            grupos_view.editarGrupo( grupo );

            // fecha o modal
            grupos_view.fecharFormEdicaoGrupo();

            // informa que a adição foi efetuada com sucesso
            we_alerta.success( jqXhr.statusText );

        });

        // se a resposta do servidor for de falha
        editarGrupo.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

        // sempre que receber a resposta do servidor
        editarGrupo.always(function (){

            // libera o botão de submmit do formulario de edição
            grupos_view.liberarBotaoEditarGrupo();

        });

    };

    // remove o grupo tendo como referencia o seu id
    self.deletarGrupo = function( id, nome ){

        we_dialog.confirm("Atenção!", "Deseja realmente excluir o grupo <strong>"+nome+"</strong>?", function( comfirmado ){

            // pergunta se realmente quer excluir
            if( comfirmado ){

                // verifica se existem usuarios no grupo
                var carregaUsuarios = grupos_model.carregaUsuarios( id );

                // quando a verificacao for concluida
                carregaUsuarios.done(function( usuarios ){

                    // cria funcao que deleta o grupo
                    var deletar = function( id, novo_grupo_id ){

                        // solicita a remoção grupo ao servidor
                        var deletarGrupo = grupos_model.deletarGrupo( id, novo_grupo_id );

                        // se a resposta do servidor for de sucesso
                        deletarGrupo.done(function ( dados, statusText, jqXhr ) {

                            // remove a linha da tabela
                            grupos_view.deletarGrupo( id );

                            // informa que a remoção foi efetuada com sucesso
                            we_alerta.success( jqXhr.statusText );

                        });

                        // se a resposta do servidor for de falha
                        deletarGrupo.fail(function ( res ){

                            // insere um alerta na tela com a resposta do servidor
                            we_alerta.warning( res.statusText );

                        });

                    }

                    if( usuarios.length > 0 ){

                        // cria a lista de opções de grupos
                        var options = [];

                        // solicita um JSON com um resumo dos grupos
                        var carregarResumo = grupos_model.carregarResumo();

                        // se a resposta do servidor for de sucesso
                        carregarResumo.done(function ( grupos ) {

                            // para cada grupo dos grupos retornados
                            $.each( grupos, function( index, grupo ){

                                // verifica se o id do grupo nao é o mesmo que o do grupo atual e insere o grupo nas opções
                                if( grupo.id != id )
                                    options.push( { id : grupo.id, name : grupo.nome } );

                                // quando a iteração sobre os grupos temrinar
                                if( index == (grupos.length - 1) ){

                                    // pergunta para qual grupo os ususarios devem ser movidos
                                    we_dialog.radio("O grupo possui usuarios. Defina um novo grupo para eles.", options, function( novo_grupo_id ){

                                        // solicita a remoção do grupo ao servidor
                                        deletar( id, novo_grupo_id );

                                    });

                                }

                            });

                        });

                    } else {

                        // solicita a remoção grupo ao servidor
                        deletar( id );

                    }

                });

            }

        });

    };

}