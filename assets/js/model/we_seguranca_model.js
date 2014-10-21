function we_seguranca_model() {

    var self = this;

    // efetua o login do usuario
    self.autentica = function( usuario ){

        // POST solicitando a autenticacao do usuario
        var post = $.ajax( base_url+"entrar", { type: "POST", data: usuario, cache: false } ).promise();

        // retorna o resultado da operação de autenticação
        return post;

    };

    // recupera a senha do usuario
    self.recuperarSenha = function( usuario ){

        // POST solicitando a recuperação de senha do usuario
        var post = $.ajax( base_url+"recuperarSenha", { type: "POST", data: usuario, cache: false } ).promise();

        // retorna o resultado da operação de recuperação
        return post;

    };

    // altera a senha do usuario
    self.alterarSenha = function( senhas ){

        // POST solicitando a alteração de senha do usuario
        var post = $.ajax( document.URL, { type: "POST", data: senhas, cache: false } ).promise();

        // retorna o resultado da operação de alteração
        return post;

    };
}