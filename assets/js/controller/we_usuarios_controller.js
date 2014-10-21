// controller javascript do módulo usuarios
function we_usuarios_controller() {

    // cria uma variavel para referenciar a classe dentro de funções
    var self = this;

    // instancia a classe usuarios_model
    var usuarios_model = new we_usuarios_model();

    // instancia a classe usuarios_view
    var usuarios_view = new we_usuarios_view();

    // lista os usuarios
    self.exibirLista = function(){

        var pagina = we_url_helper.getParameterByName('pagina');

        var por_pagina = we_url_helper.getParameterByName('por_pagina');

        // solicita um JSON com um resumo dos usuarios
        var carregarResumo = usuarios_model.carregarResumo(pagina, por_pagina);

        // se a resposta do servidor for de sucesso
        carregarResumo.done(function ( resumo, textStatus, request ) {

            var total = request.getResponseHeader('X-Total-Count');

            // lista os usuarios na tela
            usuarios_view.listar( resumo, total, pagina, por_pagina );

        });

        // se a resposta do servidor for de falha
        carregarResumo.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

    };

    // exibe o form de adição de usuario
    this.exibirFormAdicaoUsuarios = function(){

        // se o form ja foi carregado
        if( $('#adicionarUsuarioForm').length > 0 ){

            // solicita ao servidor a lista de grupos do sistema
            var carregarResumoGrupos = usuarios_model.carregarResumoGrupos();

            // se a resposta do servidor for de sucesso
            carregarResumoGrupos.done(function ( grupos ) {

                // adiciona os modulso no formulário
                usuarios_view.adicionarGruposNoFormAdicaoUsuario( grupos );

                // exibe o form
                usuarios_view.exibirFormAdicaoUsuario();

            });

            // se a resposta do servidor for de falha
            carregarResumoGrupos.fail(function ( res ){

                // insere um alerta na tela com a resposta do servidor
                we_alerta.warning( res.statusText );

            });

        // se ainda nao foi carregado
        } else {

            // solicita ao servidor o html do form de adição de usuario
            var carregarAdicionarUsuarioForm = usuarios_model.carregarAdicionarUsuarioForm();

            // se a resposta do servidor for de sucesso
            carregarAdicionarUsuarioForm.done(function ( form ) {

                // solicita ao servidor a lista de grupos do sistema
                var carregarResumoGrupos = usuarios_model.carregarResumoGrupos();

                // se a resposta do servidor for de sucesso
                carregarResumoGrupos.done(function ( grupos ) {

                    // insere o html no DOM
                    usuarios_view.inserirFormAdicaoUsuario( form );

                    // adiciona os modulso no formulário
                    usuarios_view.adicionarGruposNoFormAdicaoUsuario( grupos );

                    // exibe o form
                    usuarios_view.exibirFormAdicaoUsuario();

                });

                // se a resposta do servidor for de falha
                carregarResumoGrupos.fail(function ( res ){

                    // insere um alerta na tela com a resposta do servidor
                    we_alerta.warning( res.statusText );

                });

            });

            // se a resposta do servidor for de falha
            carregarAdicionarUsuarioForm.fail(function ( res ){

                // insere um alerta na tela com a resposta do servidor
                we_alerta.warning( res.statusText );

            });

        }

    };

    // adiciona um novo usuario
    self.adicionarUsuario = function( usuario ){

        var maskRE = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;

        if( ! maskRE.test( usuario.email ) ){

            we_alerta.warning("Favor informar um email válido.");
            
        } else {

            // bloqueia o botão de submmit do formulario de adição
            usuarios_view.blockearBotaoAdicionarUsuario();

            // solicita a adição do usuario no servidor
            var adicionarUsuario = usuarios_model.adicionarUsuario( usuario );

            // se a responsta do servidor for de sucesso
            adicionarUsuario.done(function ( usuario, statusText, jqXhr ) {

                // adiciona a linha da tabela
                usuarios_view.adicionarUsuario( usuario );

                // fecha o modal
                usuarios_view.fecharFormAdicaoUsuario( );

                // informa que a mensagem de adição
                we_alerta.success( jqXhr.statusText );

            });

            // se a responsta do servidor for de falha
            adicionarUsuario.fail(function ( res ){

                // insere um alerta na tela com a resposta do servidor
                we_alerta.warning( res.statusText );

            });

            // sempre que receber a resposta do servidor
            adicionarUsuario.always(function (){

                // libera o botão de submmit do formulario de adição
                usuarios_view.liberarBotaoAdicionarUsuario();

            });

        }

    };

    // remove o usuario tendo como referencia o seu usuario_id
    self.deletarUsuario = function( usuario_id, nome ){

        we_dialog.confirm("Atenção!", "Deseja realmente excluir o usuario <strong>"+nome+"</strong>?", function( comfirmado ){

            // pergunta se realmente quer excluir
            if( comfirmado ){

                // solicita a remoção usuario ao servidor
                var deletarUsuario = usuarios_model.deletarUsuario( usuario_id );

                // se a resposta do servidor for de sucesso
                deletarUsuario.done(function ( dados, statusText, jqXhr ) {

                    // remove a linha da tabela
                    usuarios_view.deletarUsuario( usuario_id );

                    // informa que a remoção foi efetuada com sucesso
                    we_alerta.success( jqXhr.statusText );

                });

                // se a resposta do servidor for de falha
                deletarUsuario.fail(function ( res ){

                    // insere um alerta na tela com a resposta do servidor
                    we_alerta.warning( res.statusText );

                });

            }

        });

    };

    // exibe o form de edição de usuario
    this.exibirFormEdicaoUsuario = function( id ){

        // solicita ao servidor todos os dados do usuario
        var carregaUsuario = usuarios_model.carregarUsuario( id );

        // se a resposta do servidor for de sucesso
        carregaUsuario.done(function ( usuario ) {

            // se o form ja foi carregado
            if( $('#editarUsuarioForm').length > 0 ){

                // preenche o formulario de edição com os dados
                usuarios_view.preencherFormEdicaoUsuario( usuario );
            
                // exibe o form
                usuarios_view.exibirFormEdicaoUsuario();

            // se ainda nao foi carregado
            } else {

                // solicita ao servidor o html do form de edição de usuario
                var carregarEditarUsuarioForm = usuarios_model.carregarEditarUsuarioForm();

                // se a resposta do servidor for de sucesso
                carregarEditarUsuarioForm.done(function ( form ) {

                    // solicita ao servidor a lista de grupos do sistema
                    var carregarResumoGrupos = usuarios_model.carregarResumoGrupos();

                    // se a resposta do servidor for de sucesso
                    carregarResumoGrupos.done(function ( grupos ) {

                        // insere o html no DOM
                        usuarios_view.inserirFormEdicaoUsuario( form );

                        // adiciona os modulso no formulário
                        usuarios_view.adicionarGruposNoFormEdicaoUsuario( grupos );

                        // preenche o formulario de edição com os dados
                        usuarios_view.preencherFormEdicaoUsuario( usuario );

                        // exibe o form
                        usuarios_view.exibirFormEdicaoUsuario();

                    });

                    // se a resposta do servidor for de falha
                    carregarResumoGrupos.fail(function ( res ){

                    // insere um alerta na tela com a resposta do servidor
                    we_alerta.warning( res.statusText );

                    });

                });

                // se a resposta do servidor for de falha
                carregarEditarUsuarioForm.fail(function ( res ){

                    // insere um alerta na tela com a resposta do servidor
                    we_alerta.warning( res.statusText );

                });

            }

        });

        // se a resposta do servidor for de falha
        carregaUsuario.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

    };

    // edita um usuario
    self.editarUsuario = function( usuario ){

        var maskRE = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;

        if( ! maskRE.test( usuario.email ) ){

            we_alerta.warning("Favor informar um email válido.");
            
        } else {

            // bloqueia o botão de submmit do formulario de edição
            usuarios_view.blockearBotaoEditarUsuario();

            // solicita a edição do usuario no servidor
            var editarUsuario = usuarios_model.editarUsuario( usuario );

            // se a resposta do servidor for de sucesso
            editarUsuario.done(function ( usuario, statusText, jqXhr ){

                // editar a linha da tabela
                usuarios_view.editarUsuario( usuario );

                // fecha o modal
                usuarios_view.fecharFormEdicaoUsuario();

                // informa que a adição foi efetuada com sucesso
                we_alerta.success( jqXhr.statusText );

            });

            // se a resposta do servidor for de falha
            editarUsuario.fail(function ( res ){

                // insere um alerta na tela com a resposta do servidor
                we_alerta.warning( res.statusText );

            });

            // sempre que receber a resposta do servidor
            editarUsuario.always(function (){

                // libera o botão de submmit do formulario de edição
                usuarios_view.liberarBotaoEditarUsuario();

            });

        }

    };
}