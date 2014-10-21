function we_dashboard_model() {

    var self = this;

    // carrega um JSON com o resumo da lista de usuarios
    self.carregarDadosDiarios = function(chart, startDate, endDate){

        var filtro = "";

        if(startDate) filtro += "&startDate="+startDate;

        if(endDate) filtro += "&endDate="+endDate;

        // GET solicitando o resumo dos usuarios
        var get = $.ajax( base_url+chart+"/dailyResume/?"+filtro, { type: "GET", cache: false } ).promise();

        // retorna o resumo dos usuarios
        return get;

    };

    // carrega um JSON com o resumo da lista de usuarios
    self.carregarDadosUltimoLogin = function(chart){

        // GET solicitando o resumo dos usuarios
        var get = $.ajax( base_url+chart+"/LastLoginResume/", { type: "GET", cache: false } ).promise();

        // retorna o resumo dos usuarios
        return get;

    };
}