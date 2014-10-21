function we_vinculados_view() {

    var self = this;

    // instancia a classe tabela
    var tabela = new we_tabela_library( "#tabelaVinculados" );

    // lista os vinculados em uma tabela
    self.listar = function( vinculados, total, pagina, por_pagina ){

        base_url_pag = base_url+'vinculados';

        tabela.atualizarPaginacao( total, pagina, por_pagina, base_url_pag );

        // para cada vinculado da lista de vinculados
        $.each( vinculados, function( index, vinculado ){

            // insere uma linha na tabela
            tabela.inserirLinha( vinculado, "append" );

        });

    };

    // remove um vinculado tendo como referencia o seu id
    self.deletarVinculado = function( id ){

        // remove o vinculado da tabela
        tabela.removerLinha( id );

        // retorna o resultado da operação de remoção
        return true;

    };
};