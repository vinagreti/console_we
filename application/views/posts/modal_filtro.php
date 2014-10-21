<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Filtrar posts</h4>
            </div>
            <form id="filtroPosts" class="form-horizontal" role="form">
                <div class="modal-body">
                        <div class="form-group">
                            <label for="post_id" class="col-sm-3 control-label">ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="post_id" name="post_id"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="texto" class="col-sm-3 control-label">Texto</label>
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
                            <label for="localidade" class="col-sm-3 control-label">Localidade</label>
                            <div class="col-sm-9">
                                <input id="localidade" name="localidade" type="text" data-provide="typeahead" class="form-control" autocomplete="on" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="canal" class="col-sm-3 control-label">Canal</label>
                            <div class="col-sm-9">
                                <input id="canal" name="canal" type="text" data-provide="typeahead" class="form-control" autocomplete="on" />
                            </div>
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
                            <label class="col-sm-3 control-label">Mídias</label>
                            <div class="col-sm-9">
                                <label class="checkbox-inline">
                                    <input id="FT" value="FT" type="checkbox" name="midias" checked>
                                    Foto
                                </label>
                                <label class="checkbox-inline">
                                    <input id="AU" value="AU" type="checkbox" name="midias" checked>
                                    Audio
                                </label>
                                <label class="checkbox-inline">
                                    <input id="VD" value="VD" type="checkbox" name="midias" checked>
                                    Video
                                </label>
                                <label class="checkbox-inline">
                                    <input id="VD" value="TX" type="checkbox" name="midias" checked>
                                    Texto
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-9">
                                <label class="checkbox-inline">
                                    <input id="PB" value="PB" type="checkbox" name="status" checked>
                                    Publicado
                                </label>
                                <label class="checkbox-inline">
                                    <input id="NP" value="NP" type="checkbox" name="status" checked>
                                    Não publicado
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Denúnciado</label>
                            <div class="col-sm-9">
                                <label class="checkbox-inline">
                                    <input id="sim" value="sim" type="checkbox" name="denuncia" checked>
                                    Sim
                                </label>
                                <label class="checkbox-inline">
                                    <input id="nao" value="nao" type="checkbox" name="denuncia" checked>
                                    Não
                                </label>
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