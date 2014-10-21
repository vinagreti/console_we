// controller javascript do módulo clientes
function we_clientes_controller() {

    // cria uma variavel para referenciar a classe dentro de funções
    var self = this;

    // instancia a classe clientes_model
    var clientes_model = new we_clientes_model();

    // instancia a classe clientes_view
    var clientes_view = new we_clientes_view();

    // edita um cliente
    self.editarCliente = function( cliente ){

        // bloqueia o botão de submmit do formulario de edição
        clientes_view.blockearBotaoEditarCliente();

        // solicita a edição do cliente no servidor
        var editarCliente = clientes_model.editarCliente( cliente );

        // se a resposta do servidor for de sucesso
        editarCliente.done(function ( res, statusText, jqXhr ){

            clientes_view.atualizaTela( res.cliente );

            // informa que a adição foi efetuada com sucesso
            we_alerta.success( jqXhr.statusText );

        });

        // se a resposta do servidor for de falha
        editarCliente.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

        // sempre que receber a resposta do servidor
        editarCliente.always(function (){

            // libera o botão de submmit do formulario de edição
            clientes_view.liberarBotaoEditarCliente();

        });

    };

}