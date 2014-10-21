// controller javascript do módulo dashboard
function we_dashboard_controller() {

    // cria uma variavel para referenciar a classe dentro de funções
    var self = this;

    // instancia a classe dashboard_model
    var dashboard_model = new we_dashboard_model();

    // instancia a classe dashboard_view
    var dashboard_view = new we_dashboard_view();

    // lista os dashboard
    self.exibirGraficoDiario = function( chart ){

        // solicita um JSON com um resumo dos dashboard
        var carregarDadosDiarios = dashboard_model.carregarDadosDiarios( chart );

        // se a resposta do servidor for de sucesso
        carregarDadosDiarios.done(function ( resumo, textStatus, request ) {

            var total = request.getResponseHeader('X-Total-Count');

            // lista os usuarios na tela
            dashboard_view.plotarGraficoDiario( chart, resumo );

        });

        // se a resposta do servidor for de falha
        carregarDadosDiarios.fail(function ( res ){

            // insere um alerta na tela com a resposta do servidor
            we_alerta.warning( res.statusText );

        });

    };

};