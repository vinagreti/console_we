function we_chamados_model() {

    var self = this;

    // cria o chamado
    self.criarChamado = function( chamado ){

        // POST solicitando a criação do chamado
        var post = $.ajax( base_url+"suporte/chamados", { type: "POST", data: chamado, cache: false } ).promise();

        // retorna o resultado da operação de criação
        return post;

    };

}