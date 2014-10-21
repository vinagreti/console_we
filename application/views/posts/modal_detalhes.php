<!-- Modal -->
<div class="modal fade" id="detalharPostModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span id="evento"></span></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-2">
                        <img id="usuario_avatar" class="img-rounded" style="width:84px">
                    </div>
                    <div class="col-sm-10">
                        <div class="text-info"><strong id="usuario_nome"></strong> <strong id="usuario_sobrenome"></strong></div>
                        <div class="text-muted"><small class="text-warning"><span id="data"></span> - <span id="localidade"></span></small></div>
                        <div id="midia"></div>
                        <br>
                        <div id="texto"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <label class="checkbox-inline">
                    <input type="checkbox" id="publicarPostAPI"> API
                </label>
                &nbsp;
                <a class="baixarMidia btn btn-default" href="" download="" target="_blank"><icon class="fa fa-download"></icon> Baixar mídia</a>
                <button type="button" class="removerPublicacaoPost btn btn-danger" data-loading-text="Removendo publicação...">Despublicar</button>
                <button type="button" class="publicarPost btn btn-primary" data-loading-text="Publicando...">Publicar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->