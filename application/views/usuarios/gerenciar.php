<h1><small>Usuários Administrativos</small></h1>

<p><small>
    Os <strong>Usuários Administrativos</strong> são pessoas repsonsáveis pela administração do deste console.
</small></p>

<p><button type="button" class="btn btn-default btn-sm adicionarUsuarios"><i class="fa fa-plus"></i> Criar novo usuário</button></p>

<table id="tabelaUsuarios" class="table table-hover table-condensed table-striped">
    <thead>
        <tr>
            <th ordenavel>ID</th>
            <th ordenavel>Nome</th>
            <th ordenavel>Cargo</th>
            <th ordenavel>Email</th>
            <th ordenavel>Grupo</th>
            <th ordenavel>Telefone 1</th>
            <th ordenavel>Telefone 2</th>
            <th ordenavel>Admin</th>
            <th class="col-sm-1">Ações</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="id"></td>
            <td class="nome"></td>
            <td class="cargo"></td>
            <td class="email"></td>
            <td class="grupo"></td>
            <td class="telefone1"></td>
            <td class="telefone2"></td>
            <td class="admin"></td>
            <td><span class="menuLinhaTabela">
                <button type="button" class="btn btn-default btn-xs editarUsuario" data-toggle="tooltip" title="Editar usuário"><i class="fa fa-edit fa-1"></i></button>
                <button type="button" class="btn btn-default btn-xs deletarUsuario" data-toggle="tooltip" title="Excluir usuário"><i class="fa fa-trash-o fa-1"></i></button>
            </span></td>
        </tr>
    </tbody>
</table>