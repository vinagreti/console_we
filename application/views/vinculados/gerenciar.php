<h1><small>Repórteres cidadãos</small></h1>

<p><small>
    Os <strong>Repórteres cidadãos</strong> <?=$this->session->userdata("nom_cliente")?> são os leitores que colaboram na geração de conteúdo.
</small></p>

<p><button type="button" class="btn btn-default btn-sm csvVinculados"><i class="fa fa-download"></i> Baixar CSV</button></p>

<table id="tabelaVinculados" class="table table-hover table-condensed table-striped">
    <thead>
        <tr>
            <th class="col-sm-1" ordenavel>ID</th>
            <th class="col-sm-3" ordenavel>Nome</th>
            <th ordenavel>Email</th>
            <th ordenavel>Nascimento</th>
            <th ordenavel>Data vínculo</th>
            <th ordenavel>Última atividade</th>
            <th ordenavel>Status</th>
            <th class="col-sm-1">Ações</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><span class="id"></span><img class="pull-right avatar" style="height:25px; max-width:78px"></td>
            <td class="nome"></td>
            <td class="email"></td>
            <td class="nascimento"></td>
            <td class="vinculo"></td>
            <td class="ultima_atividade"></td>
            <td class="status"></td>
            <td><span class="menuLinhaTabela">
                <button type="button" class="btn btn-default btn-xs deletarVinculado" data-toggle="tooltip" title="Excluir vinculado"><i class="fa fa-trash-o fa-1"></i></button>
            </span></td>
        </tr>
    </tbody>
</table>