<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Editar grupo <span class="nomeGrupo"></span></h4>
            </div>
            <form class="form-horizontal" id="editarGrupoForm" role="form">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id" placeholder="Qual o nome do novo usuario?">
                    <div class="form-group">
                        <label for="nome" class="col-sm-2 control-label">Nome</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control input-sm" id="nome" name="nome" placeholder="Qual o nome do novo grupo?">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="inputModulosGrupo" class="col-sm-2 control-label">Módulos</label>
                        <div class="col-sm-5 inputModulosGrupoColunaPar">
                            <div class="checkbox">
                                <label>
                                    <input class="inputModulosGrupo" type="checkbox" name="modulos">
                                    <span class="nomeModulo"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-5 inputModulosGrupoColunaImpar"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="submitEditGrupo" type="submit" class="btn btn-primary" data-loading-text="Editando...">Editar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->