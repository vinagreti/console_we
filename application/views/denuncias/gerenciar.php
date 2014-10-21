<h1><small>Denúncias</small></h1>

<p><small>
    As <strong>Denúncias</strong> são feitas pelos repórteres cidadãos <?=$this->session->userdata("nom_cliente")?> quando algum conteúdo possui material inadequado ou incorreto.
</small></p>

<p><button type="button" class="abrirFiltro btn btn-default btn-sm"><i class="fa fa-search"></i> Filtrar resultados</button> <button type="button" class="removerFiltro btn btn-danger btn-sm">Remover filtro</button></p>

<table id="tabelaDenuncias" class="table table-hover table-condensed table-striped">
    <thead>
        <tr>
            <th ordenavel><small>ID</small></th>
            <th ordenavel><small>Denúncia</small></th>
            <th ordenavel><small>Post</small></th>
            <th ordenavel><small>Evento</small></th>
            <th ordenavel><small>Repórter</small></th>
            <th ordenavel><small>Categoria</small></th>
            <th ordenavel><small>Data</small></th>
            <th class="col-sm-1"><small>Ações</small></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><small class="id"></small></td>
            <td><small><span class="texto"></span></small></td>
            <td><small class="post"></small></td>
            <td><small class="evento"></small></td>
            <td><small class="vinculado"></small></td>
            <td><small class="categoria"></small></td>
            <td><small class="data"></small></td>
            <td><span class="menuLinhaTabela">
                <button type="button" class="detalhesDenuncia btn btn-default btn-xs" data-toggle="tooltip" title="Exibir denúncia"><i class="fa fa-expand fa-1"></i></button>
            </span></td>
        </tr>
    </tbody>
</table>