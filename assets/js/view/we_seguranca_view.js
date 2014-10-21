function we_seguranca_view() {

    var self = this;

    self.informarSucessoRecuperacao = function( msg ){

        var link = $("<a></a>");
        link.attr("href", base_url+"entrar");
        link.addClass("btn btn-default pull-right");
        link.html("Entrar");

        $("#recuperarSenhaForm").html("<p>"+msg+"</p>");

        $("#recuperarSenhaForm").append(link);
        
    };

    // libera o botão
    self.liberarBotaoRecuperarSenha = function(){

        $( "#recuperarSenhaForm" ).find( '#recuperarSenha' ).button('reset');
        
    };

    // bloqueia o botão
    self.blockearBotaoRecuperarSenha = function(){

        $( "#recuperarSenhaForm" ).find( '#recuperarSenha' ).button('loading');

    };

    // libera o botão
    self.liberarBotaoEntrar = function(){

        $( "#entrarForm" ).find( '#entrar' ).button('reset');
        
    };

    // bloqueia o botão
    self.blockearBotaoEntrar = function(){

        $( "#entrarForm" ).find( '#entrar' ).button('loading');

    };

    // libera o botão
    self.liberarBotaoAlterarSenha = function(){

        $( "#alterarSenhaForm" ).find( '#alterarSenha' ).button('reset');
        
    };

    // bloqueia o botão
    self.blockearBotaoAlterarSenha = function(){

        $( "#alterarSenhaForm" ).find( '#alterarSenha' ).button('loading');

    };

    self.informarSucessoAlteracao = function( msg ){

        var link = $("<a></a>");
        link.attr("href", base_url+"entrar");
        link.addClass("btn btn-default pull-right");
        link.html("Entrar");

        $("#alterarSenhaForm").html("<p>"+msg+"</p>");

        $("#alterarSenhaForm").append(link);
        
    };
}