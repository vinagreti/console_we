// controller javascript do módulo pagamentos
function we_pagamentos_controller() {

    // cria uma variavel para referenciar a classe dentro de funções
    var self = this;

    // instancia a classe pagamentos_model
    var pagamentos_model = new we_pagamentos_model();

    // instancia a classe pagamentos_view
    var pagamentos_view = new we_pagamentos_view();

    // lista os pagamentos
    self.exibirLista = function(){

        // solicita um JSON com um resumo dos pagamentos
        var carregarResumo = pagamentos_model.carregarResumo();

        // se a resposta do servidor for de sucesso
        carregarResumo.done(function ( resumo ) {

            // lista os pagamentos na tela
            pagamentos_view.listar( resumo );

        });

        // se a resposta do servidor for de falha
        carregarResumo.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

    };

}