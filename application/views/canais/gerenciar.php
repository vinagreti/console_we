<h1><small>Canais</small></h1>

<p><small>
    Os <strong>Canais</strong> são utilizados para reunir notícias de uma mesma categoria.
</small></p>

<p><button type="button" class="btn btn-default btn-sm adicionarCanal"><i class="fa fa-plus"></i> Criar novo canal</button></p>

<table id="tabelaCanais" class="table table-hover table-condensed  table-striped">
    <thead>
        <tr>
            <th class="col-sm-1" ordenavel>ID</th>
            <th class="col-sm-2" ordenavel>Ordem</th>
            <th ordenavel>Nome</th>
            <th ordenavel>Status</th>
            <th class="col-sm-1">Ações</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="id"></td>
            <td><a class="diminuir_ordem btn btn-xs"><i class="fa fa-minus fa-1"></i></a> <span class="label label-default"><span class="ordem"></span>&#176;</span> <a class="aumentar_ordem btn btn-xs"><i class="fa fa-plus fa-1"></i></a></td>
            <td class="nome"></td>
            <td class="status"></td>
            <td><span class="menuLinhaTabela">
                <button type="button" class="btn btn-default btn-xs editarCanal" data-toggle="tooltip" title="Editar canal"><i class="fa fa-edit fa-1"></i></button>
                <button type="button" class="btn btn-default btn-xs deletarCanal" data-toggle="tooltip" title="Excluir canal"><i class="fa fa-trash-o fa-1"></i></button>
            </span></td>
        </tr>
    </tbody>
</table>