<div class="col-md-offset-4 col-md-4 well">
  <form id="entrarForm" role="form">
    <div class="form-group">
      <label for="exampleInputEmail1">Email</label>
      <input type="text" class="form-control" id="email" name="email" placeholder="Qual seu email?">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Senha</label>
      <input type="password" class="form-control" id="senha" name="senha" placeholder="Qual sua senha?">
      <div class="text-right"><small><a href="<?=base_url()?>recuperarSenha">Recuperar senha</a></small></div>
    </div>
    <div class="pull-right">
      <button id="entrar" type="submit" class="btn btn-primary" data-loading-text="Autenticando...">Entrar</button>
      <a href="<?=base_url()?>" class="btn btn-default">Cancelar</a>
    </div>
  </form>
</div>