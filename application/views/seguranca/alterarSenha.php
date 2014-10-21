<div class="col-md-offset-4 col-md-4 well">
  <form id="alterarSenhaForm" role="form">
    <div class="form-group">
      <label for="exampleInputEmail1">Nova senha</label>
      <input type="password" class="form-control" id="senha1" name="senha1" placeholder="informe a nova senha">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Confirmação da nova senha</label>
      <input type="password" class="form-control" id="senha2" name="senha2" placeholder="repita a nova senha">
    </div>
    <div class="pull-right">
      <button id="alterarSenha" type="submit" class="btn btn-primary" data-loading-text="Alterando...">Alterar senha</button>
      <a href="<?=base_url()?>" class="btn btn-default">Cancelar</a>
    </div>
  </form>
</div>