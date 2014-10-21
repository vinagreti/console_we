// controller javascript do módulo seguranca
function we_seguranca_controller() {

    // cria uma variavel para referenciar a classe dentro de funções
    var self = this;

    // instancia a classe seguranca_model
    var seguranca_model = new we_seguranca_model();

    // instancia a classe seguranca_view
    var seguranca_view = new we_seguranca_view();

    // autentica usuario
    self.autentica = function( usuario ){

        var maskRE = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;

        if( ! maskRE.test( usuario.email ) )
            we_alerta.warning("Informe um e-mail válido");

        else if( usuario.senha == "")
            we_alerta.warning("Informe a senha");

        else {

            // bloqueia o botão de submit
            seguranca_view.blockearBotaoEntrar();

            // solicita a autenticacao ao servidor
            var autentica = seguranca_model.autentica( usuario );

            // se a resposta do servidor for de sucesso
            autentica.done(function ( url ) {

                // redireciona para a pagina desejada
                window.location = url;

            });

            // se a resposta do servidor for de falha
            autentica.fail(function ( res ){

                // libera o botão de submit
                seguranca_view.liberarBotaoEntrar();

                // insere um alerta na tela com a resposta do servidor
                we_alerta.warning( res.statusText );

            });

        }

    };

    // recuperar senha do usuario
    self.recuperarSenha = function( usuario ){

        var maskRE = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;

        if( ! maskRE.test( usuario.email ) )
            we_alerta.warning("Informe um e-mail válido");

        else {

            // bloqueia o botão de submit
            seguranca_view.blockearBotaoRecuperarSenha();

            // solicita a recuperação de senha ao servidor
            var recuperarSenha = seguranca_model.recuperarSenha( usuario );

            // se a resposta do servidor for de sucesso
            recuperarSenha.done(function ( res ) {

                // informa que um email foi enviado para a recuperacao da senha
                seguranca_view.informarSucessoRecuperacao( res );

            });

            // se a resposta do servidor for de falha
            recuperarSenha.fail(function ( res ){

                // libera o botão
                seguranca_view.liberarBotaoRecuperarSenha();

                // insere um alerta na tela com a resposta do servidor
                we_alerta.warning( res.statusText );

            });

        }

    };

    // alterar senha do usuario
    self.alterarSenha = function( senhas ){

        if( senhas.senha1 == "" && senhas.senha2 == "")
            we_alerta.warning("Informe a nova senha");

        else if( senhas.senha1 != senhas.senha2 )
            we_alerta.warning("A confirmação da nova senha deve ser idêntica a nova senha.");

        else {

            // bloqueia o botão de submit
            seguranca_view.blockearBotaoAlterarSenha();

            // solicita a recuperação de senha ao servidor
            var alterarSenha = seguranca_model.alterarSenha( senhas );

            // se a resposta do servidor for de sucesso
            alterarSenha.done(function ( res ) {

                // informa que um email foi enviado para a recuperacao da senha
                seguranca_view.informarSucessoAlteracao( res );

            });

            // se a resposta do servidor for de falha
            alterarSenha.fail(function ( res ){

                // libera o botão
                seguranca_view.liberarBotaoAlterarSenha();

                // insere um alerta na tela com a resposta do servidor
                we_alerta.warning( res.statusText );

            });

        }

    };
}