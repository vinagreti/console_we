$(document).ready(function(){

    // instancia o controller de seguranca
    var seguranca_controller = new we_seguranca_controller();

    // efetuar login
    $(document).on('submit', '#entrarForm', function( e ) {

        // impede o formulário de recarregar a página
        e.preventDefault();

        // pega os dados do formulário
        var usuario = $(this).serializeObject();

        // solicita a autenticação do usuario
        seguranca_controller.autentica( usuario );

        // impede o formulário de recarregar a página
        return false;

    });

    // recuperar senha de usuario
    $(document).on('submit', '#recuperarSenhaForm', function( e ) {

        // impede o formulário de recarregar a página
        e.preventDefault();

        // pega os dados do formulário
        var usuario = $(this).serializeObject();

        // solicita a recuperação de senha do usuario
        seguranca_controller.recuperarSenha( usuario );

        // impede o formulário de recarregar a página
        return false;

    });

    // alterar senha de usuario
    $(document).on('submit', '#alterarSenhaForm', function( e ) {

        // impede o formulário de recarregar a página
        e.preventDefault();
        
        // pega os dados do formulário
        var senhas = $(this).serializeObject();

        // solicita a alteração de senha do usuario
        seguranca_controller.alterarSenha( senhas );

        // impede o formulário de recarregar a página
        return false;

    });

});