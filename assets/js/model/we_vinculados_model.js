function we_vinculados_model() {

    var self = this;

    // carrega um JSON com o resumo da lista de vinculados
    self.carregarResumo = function(pagina, por_pagina){

        // GET solicitando o resumo dos vinculados
        var get = $.ajax( base_url+"vinculados?pagina="+pagina+"&por_pagina="+por_pagina, { type: "GET", cache: false } ).promise();

        // retorna o resumo dos vinculados
        return get;

    };

    // remove um vinculado do banco de dados tendo como referencia o seu id
    self.deletarVinculado = function( id ){

        // DELETE solicitando a remoção do vinculado
        var del = $.ajax( base_url+"vinculados/?id="+id, { type: "DELETE", cache: false } ).promise();

        // retorna o resultado da operação de remoção
        return del;

    };
};