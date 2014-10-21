// controller javascript do módulo chamados
function we_chamados_controller() {

    // cria uma variavel para referenciar a classe dentro de funções
    var self = this;

    // instancia a classe chamados_model
    var chamados_model = new we_chamados_model();

    // instancia a classe chamados_view
    var chamados_view = new we_chamados_view();

    // cria chamado
    self.criarChamado = function( chamado ){

        if( chamado.assunto.length < 6 || chamado.assunto.length > 100 )
            we_alerta.warning("O assunto deve possuir entre 6 e 100 caracteres.");

        else if( chamado.texto.length < 6 )
            we_alerta.warning("O texto deve possuir no mínimo 6 caracteres.");

        else {

            // bloqueia o botão de submit
            chamados_view.blockearBotaoCriar();

            // solicita a criaChamadocao ao servidor
            var criarChamado = chamados_model.criarChamado( chamado );

            // se a resposta do servidor for de sucesso
            criarChamado.done(function ( res ) {

                // insere um alerta na tela com a resposta do servidor
                we_alerta.success( res );

                // reseta o formulário de criação de chamado
                chamados_view.resetaFormulario();

            });

            // se a resposta do servidor for de falha
            criarChamado.fail(function ( res ){

                // insere um alerta na tela com a resposta do servidor
                we_alerta.warning( res.statusText );

            });

            // ao receber resposta do servidor
            criarChamado.always(function ( res ){

                // libera o botão de submit
                chamados_view.liberarBotaoCriar();

            });

        }

    };

}