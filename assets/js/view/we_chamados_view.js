function we_chamados_view() {

    var self = this;

    // libera o botão
    self.liberarBotaoCriar = function(){

        $( "#chamadoForm" ).find( '#criar' ).button('reset');

    };

    // bloqueia o botão
    self.blockearBotaoCriar = function(){

        $( "#chamadoForm" ).find( '#criar' ).button('loading');

    };

    // reseta o formulario
    self.resetaFormulario = function(){

        $( "#chamadoForm" )[0].reset();

    }

}