$(document).ready(function(){

    // instancia o controller clientes
    var clientes_controller = new we_clientes_controller();

    // editar o cliente
    $(document).on('submit', '#editarClienteForm', function( e ) {

        // impede o formulário de recarregar a página
        e.preventDefault();

        // pega os dados do formulário
        var cliente = $(this).serializeObject();

        // busca clientes no banco de acordo com o filtro configurado
        clientes_controller.editarCliente( cliente );

        // impede o formulário de recarregar a página
        return false;

    });

});