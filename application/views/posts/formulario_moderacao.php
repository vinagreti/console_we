<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Moderar post</h4>
            </div>
            <form class="form-horizontal" id="moderarPostForm" role="form">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id" placeholder="Qual o nome do novo usuario?">
                    <div class="form-group">
                        <label for="admin" class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10">
                            <div class="radio-inline">
                                <label>
                                    <input class="status" type="radio" name="status" id="PB" value="PB">
                                    Publicado
                                </label>
                            </div>
                            <div class="radio-inline">
                                <label>
                                    <input class="status" type="radio" name="status" id="NP" value="NP">
                                    Despublicado
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="admin" class="col-sm-2 control-label">API</label>
                        <div class="col-sm-10">
                            <div class="radio-inline">
                                <label>
                                    <input class="api" type="radio" name="api" id="SIM" value="SIM">
                                    Sim
                                </label>
                            </div>
                            <div class="radio-inline">
                                <label>
                                    <input class="api" type="radio" name="api" id="NAO" value="NAO">
                                    Não
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="submitModerarPost" type="submit" class="btn btn-primary" data-loading-text="Moderando...">Moderar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->