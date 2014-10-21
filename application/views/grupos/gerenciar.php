<h1><small>Grupos de Usuários Administrativos</small></h1>

<p><small>
    Os <strong>Grupos de Usuários Administrativos</strong> fornecem permissões aos usuários para utilização de módulos do console.
</small></p>

<p><button type="button" class="btn btn-default btn-sm adicionarGrupo"><i class="fa fa-plus"></i> Criar novo grupo</button></p>

<table id="tabelaGrupos" class="table table-hover table-condensed table-striped">
    <thead>
        <tr>
            <th ordenavel>ID</th>
            <th ordenavel>Nome do grupo</th>
            <th class="col-sm-1">Ações</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="id">-</td>
            <td class="nome">Grupo Padrão</td>
            <td><span class="menuLinhaTabela">
                <button type="button" class="btn btn-default btn-xs editarGrupo" data-toggle="tooltip" title="Editar grupo"><i class="fa fa-edit fa-1"></i></button>
                <button type="button" class="btn btn-default btn-xs deletarGrupo" data-toggle="tooltip" title="Excluir grupo"><i class="fa fa-trash-o fa-1"></i></button>
            </span></td>
        </tr>
    </tbody>
</table>