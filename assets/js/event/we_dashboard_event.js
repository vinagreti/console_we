$(document).ready(function(){

    // instancia o controller canais
    var dashboard_controller = new we_dashboard_controller();

    // exibe o grafico de vinculados
    dashboard_controller.exibirGraficoDiario( 'vinculados' );

    // exibe o grafico de posts
    dashboard_controller.exibirGraficoDiario( 'posts' );

    // exibe o grafico de denuncias
    dashboard_controller.exibirGraficoDiario( 'denuncias' );

});