<form class="form-horizontal" id="editarClienteForm" role="form">

    <p class="col-sm-offset-2">
        <small><strong id="status" class="pull-right <?=$status_color?>"><?=$status?></strong></small>
        <small><strong>Código único:</strong> <span id="codigo_unico"><?=$codigo_unico?></span></small>
        <br>
        <small><strong>Data de cadastro:</strong> <span id="cadastro"><?=$cadastro?></span></small>
    </p>
    <span class="hide"><input type="hidden" id="id" name="id" value="<?=$id?>" /></span>
    <div class="form-group">
        <label for="nome" class="col-sm-2 control-label">Nome</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id="nome" name="nome" value="<?=$nome?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="cnpj" class="col-sm-2 control-label">CNPJ</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id="cnpj" name="cnpj" value="<?=$cnpj?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="razao_social" class="col-sm-2 control-label">Razão social</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id="razao_social" name="razao_social" value="<?=$razao_social?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="logradouro" class="col-sm-2 control-label">Logradouro</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id="logradouro" name="logradouro" value="<?=$logradouro?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="numero" class="col-sm-2 control-label">Número</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id="numero" name="numero" value="<?=$numero?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="complemento" class="col-sm-2 control-label">Complemento</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id="complemento" name="complemento" value="<?=$complemento?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="cep" class="col-sm-2 control-label">CEP</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id="cep" name="cep" value="<?=$cep?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="cidade" class="col-sm-2 control-label">Cidade</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id="cidade" name="cidade" value="<?=$cidade?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="uf" class="col-sm-2 control-label">UF</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id="uf" name="uf" value="<?=$uf?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="pais" class="col-sm-2 control-label">País</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id="pais" name="pais" value="<?=$pais?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="telefone" class="col-sm-2 control-label">Telefone</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id="telefone" name="telefone" value="<?=$telefone?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="permalink" class="col-sm-2 control-label">Permalink</label>
        <div class="col-sm-10">
            <input type="text" class="form-control input-sm" id="permalink" name="permalink" value="<?=$permalink?>" />
        </div>
    </div>

    <div class="form-group">
        <span class="pull-right">
            <button id="alterarSenha" type="submit" class="btn btn-primary" data-loading-text="Salvando...">Salvar alterações</button>
            <a href="<?=base_url()?>" class="btn btn-default">Cancelar</a>
        </span>
    </div>

</form>