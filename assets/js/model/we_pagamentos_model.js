function we_pagamentos_model() {

    var self = this;

    // carrega um JSON com o resumo da lista de pagamentos
    self.carregarResumo = function(){

        // GET solicitando o resumo dos pagamentos
        var get = $.ajax( base_url+"pagamentos", { type: "GET", cache: false } ).promise();

        // retorna o resumo dos pagamentos
        return get;

    };

};