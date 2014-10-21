<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Console We Crowdcasting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Evita modo de compatibilidade do IE -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Bootstrap -->
    <link href="<?=base_url()?>assets/third-party/twitter-bootstrap3/css/bootstrap.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/css/we.global.css" rel="stylesheet">
    <!-- Carrega css dinamicamente -->
    <?php if( isset($arquivos_css) ) foreach( $arquivos_css as $key => $css ) echo '<link href="'.base_url().'assets/'.$css.'.css" rel="stylesheet">'; ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
</head>
<body>

    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-12 column">


                <nav class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="<?=base_url()?>">Console <span class="text-info">We Crowdcasting</span></a>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="<?php if($this->router->class == 'suporte') echo 'active'; ?>">
                                <a href="<?=base_url()?>suporte" data-toggle="tooltip" title="Suporte"><i class="fa fa-question"></i></a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="<?=base_url()?>entrar" data-toggle="tooltip" title="Entrar"><i class="fa fa-sign-in"></i> Entrar</a>
                            </li>
                        </ul>
                    </div>

                </nav>

                <?= $conteudo ?>

            </div>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?=base_url()?>assets/third-party/JQuery/jquery-1.11.1.min.js"></script>
    <script src="<?=base_url()?>assets/third-party/JQuery/jquery.tablesorter.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=base_url()?>assets/third-party/twitter-bootstrap3/js/bootstrap.min.js"></script>
    <!-- definindo a base do site para os scripts js -->
    <script type="text/javascript"> var base_url = "<?=base_url()?>"; </script>
    <!-- definindo token para evitar CSRF - Cross Site Request Forgery -->
    <script type="text/javascript"> var csrf_token = "<?=$this->security->get_csrf_hash()?>";</script>
    <!-- Include custom js -->
    <script src="<?=base_url()?>assets/js/helper/we_security_helper.js"></script>
    <script src="<?=base_url()?>assets/js/helper/we_serializeJSON_helper.js"></script>
    <script src="<?=base_url()?>assets/js/helper/we_alerta_helper.js"></script>
    <script src="<?=base_url()?>assets/js/helper/we_dialog_helper.js"></script>
    <!-- Carrega scripts dinamicamente -->
    <?php if( isset($arquivos_js) ) foreach( $arquivos_js as $key => $script ) echo '<script src="'.base_url().'assets/'.$script.'.js"></script>'; ?>
</body>
</html>
