function we_clientes_model() {

    var self = this;

    // atualiza um cliente no banco de dados
    self.editarCliente = function( cliente ){

        // PUT solicitando a edição do cliente
        var put = $.ajax( base_url+"clientes", { type: "PUT", data: cliente, cache: false } ).promise();

        // retorna o resultado da operação de edição
        return put;

    };

}