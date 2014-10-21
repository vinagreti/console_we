<h1><small>Dashboard <span class="text-info"><?=$this->session->userdata("nom_cliente")?></span></small></h1>

<p><small>
    Através do <strong>Dashboard</strong> é possível visualisar de forma clara os os ultimas atividades da aplicação.
</small></p>

<div class="row">

    <div class="col-md-6">

        <div class="bs-callout bs-callout-info">

            <fieldset>

                <legend>Resumo</legend>

                <p><?=$totalCanais?> <a href="<?=base_url()?>canais">Canais</a></p>

                <p><?=$totalDenuncias?> <a href="<?=base_url()?>denuncias">Denúncias</a></p>

                <p><?=$totalGrupos?> <a href="<?=base_url()?>grupos">Grupos de usuários</a></p>

                <p><?=$totalPosts?> <a href="<?=base_url()?>posts">Posts</a></p>

                <p><?=$totalVinculados?> <a href="<?=base_url()?>vinculados">Repórteres cidadãos</a></p>

                <p><?=$totalUsuarios?> <a href="<?=base_url()?>usuarios">Usuários</a></p>

            </fieldset>

        </div>

    </div>

    <div class="col-md-6">

        <div class="bs-callout bs-callout-info">

            <fieldset>

                <legend>Resumo desde o último login em <?=$this->session->userdata("ultimo_login_br")?></legend>

                <p><?=$totalDenunciasUltimoLogin?> <a href="<?=base_url()?>denuncias">Denúncias</a></p>

                <p><?=$totalPostsUltimoLogin?> <a href="<?=base_url()?>posts">Posts</a></p>

                <p><?=$totalVinculadosUltimoLogin?> <a href="<?=base_url()?>vinculados">Repórteres cidadãos</a></p>

            </fieldset>

        </div>

    </div>

    <div class="col-md-12">

        <div class="bs-callout bs-callout-info">

            <fieldset>

                <legend><span id="daily-vinculados-total"></span><a href="<?=base_url()?>vinculados"> Repórteres cidadãos</a> no último mês</legend>

                <div id="daily-vinculados" class="span5">
                    <canvas id="daily-vinculados-chart"></canvas>
                </div>

            </fieldset>

        </div>

    </div>

</div>

<div class="row">

    <div class="col-md-6">

        <div class="bs-callout bs-callout-info">

            <fieldset>

                <legend><span id="daily-posts-total"></span><a href="<?=base_url()?>posts"> Posts</a> no último mês</legend>

                <div id="daily-posts" class="span5">
                    <canvas id="daily-posts-chart"></canvas>
                </div>

            </fieldset>

        </div>

    </div>

    <div class="col-md-6">

        <div class="bs-callout bs-callout-info">

            <fieldset>

                <legend><span id="daily-denuncias-total"></span><a href="<?=base_url()?>denuncias"> Denúncias</a> no último mês</legend>

                <div id="daily-denuncias" class="span5">
                    <canvas id="daily-denuncias-chart"></canvas>
                </div>

            </fieldset>

        </div>

    </div>

</div>