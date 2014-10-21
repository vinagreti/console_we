<h1><small>Posts</small></h1>

<p><small>
    Os <strong>Posts</strong> são notícias criadas pelos repórteres cidadãos <?=$this->session->userdata("nom_cliente")?>.
</small></p>

<p><button type="button" class="abrirFiltro btn btn-default btn-sm"><i class="fa fa-search"></i> Filtrar resultados</button> <button type="button" class="removerFiltro btn btn-danger btn-sm">Remover filtro</button></p>

<table id="tabelaPosts" class="table table-hover table-condensed table-striped">
    <thead>
        <tr>
            <th ordenavel><small>ID</small></th>
            <th ordenavel><small>Canal</small></th>
            <th ordenavel><small>Evento</small></th>
            <th class="col-sm-2 col-xs-2" ordenavel><small>Texto</small></th>
            <th ordenavel><small>Mídia</small></th>
            <th ordenavel><small>Status</small></th>
            <th ordenavel><small>API</small></th>
            <th ordenavel><small>Repórter</small></th>
            <th class="col-sm-1 col-xs-1" ordenavel><small>Localidade</small></th>
            <th class="col-sm-2 col-xs-2" ordenavel><small>Data</small></th>
            <th class="col-sm-1"><small>Ações</small></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><small class="id"></small></td>
            <td><small class="canal"></small></td>
            <td><small class="evento"></small></td>
            <td><small><span class="texto"></span>...</small></td>
            <td><small class="tipo_midia"></small></td>
            <td><small class="status"></small></td>
            <td><small class="api"></small></td>
            <td><small class="vinculado"></small></td>
            <td><small class="localidade"></small></td>
            <td><small class="data"></small></td>
            <td><span class="menuLinhaTabela">
                <button type="button" class="detalhesPost btn btn-default btn-xs" data-toggle="tooltip" title="Abrir post"><i class="fa fa-expand fa-1"></i></button>
                <button type="button" class="moderarPost btn btn-default btn-xs" data-toggle="tooltip" title="Moderar post"><i class="fa fa-legal fa-1"></i></button>
                <button type="button" class="deletarPost btn btn-default btn-xs" data-toggle="tooltip" title="Excluir post"><i class="fa fa-trash-o fa-1"></i></button>
            </span></td>
        </tr>
    </tbody>
</table>