// Alerta
// Classe responsável pela exibição de alertas
// Author: Bruno da Silva João
// https://github.com/vinagreti
we_alerta = new function () {

    // cria um alerta de success
    this.success = function( message ) {

        // cria a div do alerta e adiciona a mensagem
        var alerta = $('<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Sucesso!</strong> '+ message +' </div>');
        
        // insere o alerta no corpo do documento
        this.alert( alerta );

    };

    // cria um alerta de info
    this.info = function( message ) {

        // cria a div do alerta e adiciona a mensagem
        var alerta = $('<div class="alert alert-block alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Info!</strong> '+ message +' </div>');
        
        // insere o alerta no corpo do documento
        this.alert( alerta );

    };

    // cria um alerta de warning
    this.warning = function( message ) {

        // cria a div do alerta e adiciona a mensagem
        var alerta = $('<div class="alert alert-block alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Aviso!</strong> '+ message +' </div>');
        
        // insere o alerta no corpo do documento
        this.alert( alerta );

    };

    // cria um alerta de danger
    this.danger = function( message ) {

        // cria a div do alerta e adiciona a mensagem
        var alerta = $('<div class="alert alert-block alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Perigo!</strong> '+ message +' </div>');
        
        // insere o alerta no corpo do documento
        this.alert( alerta );

    };

    // insere o alerta no corpo do documento
    this.alert = function( alerta ){

        // remove os alertas antigos
        $(".alert").remove();
        
        // copia a div para que seja possivel inserir um alerta também no modal
        var alerta_modal = alerta.clone();

        // insere o alerta no modal
        $('.modal-body').prepend( alerta_modal );

        // insere o alerta no corpo do documento
        $('body').prepend( alerta );

        // após 5 segundos
        setTimeout(function(){

            // remove o alerta do corpo do documento
            alerta.remove();

            // remove o alerta do modal
            alerta_modal.remove();

        }, 3000);
        
    };

}