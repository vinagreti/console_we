<h1 class="text-center">Esqueceu sua senha?</h1>
<div class="col-md-offset-4 col-md-4 well">
    <form id="recuperarSenhaForm" role="form">
      <div class="form-group">
        <label for="exampleInputEmail1">Informe o e-mail cadastrado:</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="Qual seu e-mail?">
      </div>
      <div class="pull-right">
        <button id="recuperarSenha" type="submit" class="btn btn-primary" data-loading-text="Recuperando...">Recuperar senha</button>
        <a href="<?=base_url()?>entrar" class="btn btn-default">Cancelar</a>
      </div>
    </form>
</div>