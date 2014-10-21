<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Filtrar denúncias</h4>
            </div>
            <form id="filtroDenuncias" class="form-horizontal" role="form">
                <div class="modal-body">
                        <div class="form-group">
                            <label for="denuncia_id" class="col-sm-3 control-label">ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="denuncia_id" name="denuncia_id"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="post_id" class="col-sm-3 control-label">Post ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="post_id" name="post_id"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="texto" class="col-sm-3 control-label">Denúncia</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="texto" name="texto" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="data_inicial" class="col-sm-3 control-label">Data inicial</label>
                            <span class="col-sm-3">
                                <input type="text" class="date-picker form-control" id="data_inicial" name="data_inicial" data-date-format="dd-mm-yyyy" />
                            </span>

                            <label for="data_final" class="col-sm-3 control-label">Data final</label>
                            <span class="col-sm-3">
                                <input type="text" class="date-picker form-control" id="data_final" name="data_final" data-date-format="dd-mm-yyyy" />
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="evento" class="col-sm-3 control-label">Evento</label>
                            <div class="col-sm-9">
                                <input id="evento" name="evento" type="text" data-provide="typeahead" class="form-control" autocomplete="on" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="vinculado" class="col-sm-3 control-label">Repórter</label>
                            <div class="col-sm-9">
                                <input id="vinculado" name="vinculado" type="text" data-provide="typeahead" class="form-control" autocomplete="on" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="categoria" class="col-sm-3 control-label">Categoria</label>
                            <div class="col-sm-9">
                                <input id="categoria" name="categoria" type="text" data-provide="typeahead" class="form-control" autocomplete="on" />
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger removerFiltro">Remover filtro</button>
                    <button type="submit" class="btn btn-primary submitFiltro" data-loading-text="Filtrando...">Filtrar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->