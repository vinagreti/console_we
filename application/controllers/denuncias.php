<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Denuncias extends MY_Controller {

    public function __construct() {

        parent::__construct(); // executa o construtor /application/core/MY_Controller

        if( ! in_array("5", $this->session->userdata("modulos") ) ){ // se o módulo 5 não estiver entre os módulos do grupo do usuário

            redirect( base_url() ); // redireciona para a página inicial

        }

    }

    public function index() { $this->rest(); } // inicia o servidor RESTful definido em /application/core/MY_Controller.php

    protected function listObjects_html(){

        $javascript = array(
            "third-party/twitter-bootstrap3/js/typeahead"
            , "js/helper/we_url_helper"
            , "third-party/twitter-bootstrap3/js/hogan"
            , "third-party/twitter-bootstrap3/js/bootstrap-datepicker"
            , "js/event/we_denuncias_evento"
            , "js/library/we_tabela_library"
            , "js/model/we_denuncias_model"
            , "js/view/we_denuncias_view"
            , "js/controller/we_denuncias_controller"
        );

        $css = array( "third-party/twitter-bootstrap3/css/bootstrap-datepicker" );

        $this->template->load( "private", "denuncias/gerenciar", $javascript, $css );

    }

    protected function listObjects_json( $params ){ // retorna um resumo das denuncias

        $pagina = isset($_GET['pagina']) && $_GET['pagina'] > 0 ? $_GET['pagina'] : 1; // define o numero da pagina

        $por_pagina = isset($_GET['por_pagina']) && $_GET['por_pagina'] > 0 ? $_GET['por_pagina'] : 50; // define o total de itens por página

        $this->load->model("denuncias_model");

        $carregarResumo = $this->denuncias_model->carregarResumo( $params, $pagina, $por_pagina, true ); // pega o resumo dos vinculados no banco

        if( $carregarResumo["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $res = $carregarResumo["resumo"]; // insere o resumo na resposta

            header( "X-Total-Count: " . $carregarResumo["total"]);

        } else { // se a consulta ao banco não for bem sucedida

            $res = $carregarResumo["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $carregarResumo["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function readObject_json( $id ){ // retorna uma denuncia

        $this->load->model("denuncias_model");

        $carregar = $this->denuncias_model->carregar( $id ); // denuncia

        if( $carregar["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $res["denuncia"] = $carregar["denuncia"]; // insere o resumo na resposta
            $res["post"] = $carregar["post"];

        } else { // se a consulta ao banco não for bem sucedida

            $res = $carregar["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $carregar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    public function modal_filtro(){ // retorna o html do modal filtro de denuncias

        echo $this->load->view('denuncias/modal_filtro', "", true); // renderiza o html

    }

    public function modal_detalhes(){ // retorna o html do modal detalhes de denuncias

        echo $this->load->view('denuncias/modal_detalhes', "", true); // renderiza o html

    }

    public function dailyResume(){

        $this->load->model("denuncias_model");

        $resumo = $this->denuncias_model->dailyResume();

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode($resumo);

    }

}