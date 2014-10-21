<h1><small>Abertura de chamado</small></h1>

<form id="chamadoForm" role="form">
    <div class="form-group">
        <label for="assunto">Titulo</label>
        <input type="text" class="form-control" id="assunto" name="assunto" placeholder="Qual o assunto do chamado?">
    </div>
    <div class="form-group">
        <label for="texto">Texto</label>
        <textarea rows="7" class="form-control" id="texto" name="texto" placeholder="Quais os detalhes do chamado?"></textarea>
    </div>
    <div class="pull-right">
        <button id="criar" type="submit" class="btn btn-primary" data-loading-text="Abrindo chamado...">Abrir chamado</button>
        <a href="<?=base_url()?>" class="btn btn-default">Cancelar</a>
    </div>
</form>