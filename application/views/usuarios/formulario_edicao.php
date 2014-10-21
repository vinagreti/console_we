<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Editar usuario</h4>
            </div>
            <form class="form-horizontal" id="editarUsuarioForm" role="form">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id" placeholder="Qual o nome do novo usuario?">
                    <div class="form-group">
                        <label for="nome" class="col-sm-3 control-label">Nome</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-sm" id="nome" name="nome" placeholder="Qual o nome do novo usuario?">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">E-mail *</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-sm" id="email" name="email" placeholder="Qual o e-mail?" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefone1" class="col-sm-3 control-label">Telefone 1</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-sm" id="telefone1" name="telefone1" placeholder="Qual telefone principal?" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="telefone2" class="col-sm-3 control-label">Telefone 2</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-sm" id="telefone2" name="telefone2" placeholder="Qual o telefone secundario?" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cargo" class="col-sm-3 control-label">Cargo</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control input-sm" id="cargo" name="cargo" placeholder="Qual o cargo?" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="admin" class="col-sm-3 control-label">Administrador</label>
                        <div class="col-sm-9">
                            <div class="radio-inline">
                                <label>
                                    <input class="admin" type="radio" name="admin" id="S" value="S">
                                    Sim
                                </label>
                            </div>
                            <div class="radio-inline">
                                <label>
                                    <input class="admin" type="radio" name="admin" id="N" value="N" checked>
                                    Não
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="grupo" class="col-sm-2 control-label">Grupo</label>
                        <div class="col-sm-5 inputGruposUsuarioColunaPar">
                            <div class="radio">
                                <label>
                                    <input class="grupo" type="radio" name="grupo">
                                    <span class="nomeGrupo"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-5 inputGruposUsuarioColunaImpar"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="submitEditarUsuario" type="submit" class="btn btn-primary" data-loading-text="Editando...">Editar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->