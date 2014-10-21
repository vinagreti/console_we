$(document).ready(function(){

    // instancia o controller pagamentos
    var pagamentos_controller = new we_pagamentos_controller();

    // lista os pagamentos na tela
    pagamentos_controller.exibirLista();

});