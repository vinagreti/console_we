<h1><small>Suporte</small></h1>

<p><small>
    Na área de <strong>Suporte</strong> são disponibilizadas informações sobre o console e também formas de contato com a equipe de suporte.
</small></p>

<p>

    <a href="<?=base_url()?>suporte/manual" class="btn btn-default btn-primary">Ler manual</a>

    <a class="btn btn-default btn-info">Baixar manual</a>

    <?php if ($this->session->userdata("logged")) { ?>

    <a href="<?=base_url()?>suporte/chamados" class="btn btn-default btn-success">Abrir chamado</a>

    <?php } ?>

</p>