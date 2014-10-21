function we_clientes_view() {

    var self = this;

    // bloqueia o botão submmit do formulario de edição de grupo
    self.blockearBotaoEditarCliente = function(){

        $("#editarClienteForm").find(":submit").button('loading');

    };

    // libera o botão submmit do formulario de edição de grupo
    self.liberarBotaoEditarCliente = function(){

        $("#editarClienteForm").find(":submit").button('reset');
        
    };

    // atualiza os dados da tela com os novos
    self.atualizaTela = function( cliente ){

        $(".nomeClienteConsole").html( cliente.nome );

    }
}