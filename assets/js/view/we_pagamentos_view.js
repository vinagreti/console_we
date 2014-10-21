function we_pagamentos_view() {

    var self = this;

    // instancia a classe tabela
    var tabela = new we_tabela_library( "#tabelaPagamentos" );

    // lista os pagamentos em uma tabela
    self.listar = function( pagamentos ){

        // para cada pagamento da lista de pagamentos
        $.each( pagamentos, function( index, pagamento ){

            // insere uma linha na tabela
            tabela.inserirLinha( pagamento, "append" );

        });

    };

};