<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Editar canal</h4>
            </div>
            <form class="form-horizontal" id="editarCanalForm" role="form">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="nome" class="col-sm-2 control-label">Nome</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control input-sm" id="nome" name="nome" placeholder="Qual o nome do canal?">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="admin" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                            <div class="radio-inline">
                                <label>
                                    <input class="status" type="radio" name="status" id="AT" value="AT" checked>
                                    Ativo
                                </label>
                            </div>
                            <div class="radio-inline">
                                <label>
                                    <input class="status" type="radio" name="status" id="IN" value="IN">
                                    Inativo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="submitEditarCanal" type="submit" class="btn btn-primary" data-loading-text="Editando...">Editar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->