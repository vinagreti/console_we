$(document).ready(function(){

    // instancia o controller de chamados
    var chamados_controller = new we_chamados_controller();

    // efetuar login
    $(document).on('submit', '#chamadoForm', function( e ) {

        // impede o formulário de recarregar a página
        e.preventDefault();

        // pega os dados do formulário
        var chamado = $(this).serializeObject();

        // solicita a autenticação do chamado
        chamados_controller.criarChamado( chamado );

        // impede o formulário de recarregar a página
        return false;

    });

});