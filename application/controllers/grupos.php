<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grupos extends MY_Controller {

    public function __construct() {

        parent::__construct(); // executa o construtor /application/core/MY_Controller

        if( $this->session->userdata("flg_administrador") != "S" && $this->router->method != 'carregarResumo' ){ // se o usuário não for administrador e o módulo 5 não estiver entre os módulos do grupo do usuário

            redirect( base_url() ); // redireciona para a página inicial

        }

    }

    public function index() { $this->rest(); } // inicia o servidor RESTful definido em /application/core/MY_Controller.php

    protected function listObjects_html(){ // retorna o html da listagem de grupos

        $javascript = array( // define os arquivos js dinamicos a serem carregados.
            "js/event/we_grupos_evento"
            , "js/helper/we_url_helper"
            ,"js/library/we_tabela_library"
            , "js/model/we_grupos_model"
            , "js/view/we_grupos_view"
            , "js/controller/we_grupos_controller"
        );

        $this->template->load( "private", "grupos/gerenciar", $javascript ); // renderiza o template com o conteudo dinamico

    }

    protected function listObjects_json(){ // retorna um resumo dos grupos

        $pagina = isset($_GET['pagina']) && $_GET['pagina'] > 0 ? $_GET['pagina'] : 1; // define o numero da pagina

        $por_pagina = isset($_GET['por_pagina']) && $_GET['por_pagina'] > 0 ? $_GET['por_pagina'] : 30; // define o total de itens por página

        $this->load->model("grupos_model"); // instancia o model grupos

        $carregarResumo = $this->grupos_model->carregarResumo(false, $pagina, $por_pagina, true); // lista com resumo dos grupos

        if( $carregarResumo["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $res = $carregarResumo["resumo"]; // insere o resumo na resposta

            header( "X-Total-Count: " . $carregarResumo["total"] );

        } else { // se a consulta ao banco não for bem sucedida

            $res = $carregarResumo["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $carregarResumo["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function readObject_json( $id ){ // retorna os dados do grupo tendo como referencia o seu id

        $this->load->model("grupos_model");

        $carregar = $this->grupos_model->find( $id );

        if( $carregar["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $res = $carregar["grupo"]; // insere o grupo na resposta

        } else { // se a consulta ao banco não for bem sucedida

            $res = $carregar["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $carregar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function createObject( $grupo ){

        $this->load->model("grupos_model"); // instancia o model dos grupos

        $adicionar = $this->grupos_model->adicionar( $grupo ); // adiciona um grupo no banco

        if( $adicionar["sucesso"] ){ // se a adição ao banco for bem sucedida

            $res = $adicionar["grupo"]; // insere o grupo na resposta

            header( "HTTP/1.0 200 ". utf8_decode( $adicionar["msg"] ) );

        } else { // se a consulta ao banco não for bem sucedida

            $res = $adicionar["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $adicionar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function updateObject( $grupo ){

        $this->load->model("grupos_model");

        $editar = $this->grupos_model->editar( $grupo );

        if( $editar["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $res = $editar["msg"]; // insere a mensagem na resposta

            header( "HTTP/1.0 200 ". utf8_decode( $editar["msg"] ) ); // seta o código e a mensagem de sucesso no cabeçalho da resposta

        } else { // se a consulta ao banco não for bem sucedida

            $res = $editar["msg"]; // define a resposta

            header( "HTTP/1.0 400 ". utf8_decode( $editar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function deleteObject( $params ){

        $this->load->model("grupos_model"); // instancia o model de grupos

        $novoGrupo = isset( $params["novo_grupo_id"] ) ? $params["novo_grupo_id"] : false; // verifica se foi definido um novo grupo para os usuaios do grupo em remoção

        $deletar = $this->grupos_model->remover( $params["id"], $novoGrupo ); // solicita a remoção do grupo no banco

        if( $deletar["sucesso"] ){ // se a remoção bem sucedida

            $res = $deletar["msg"]; // define a resposta

            header( "HTTP/1.0 200 ". utf8_decode( $deletar["msg"] ) ); // seta o código e a mensagem de sucesso no cabeçalho da resposta

        } else { // se a remoção não for bem sucedida

            $res = $deletar["msg"]; // define a resposta

            header( "HTTP/1.0 400 ". utf8_decode( $deletar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    public function formulario_adicao(){ // retorna o modal de adição

        echo $this->load->view('grupos/formulario_adicao', "", true); // renderiza o modal de adição

    }

    public function formulario_edicao(){ // retorna o modal de edição

        echo $this->load->view('grupos/formulario_edicao', "", true); // renderiza o modal de edição

    }

}
