<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pagamentos extends MY_Controller {

    public function __construct() {

        parent::__construct(); // executa o construtor /application/core/MY_Controller

        if( ! in_array("7", $this->session->userdata("modulos") ) ){ // Se o módulo 7 não estiver definido no grupo do usuario

            redirect( base_url() ); // retorna a página inicial

        }

    }

    public function index() { $this->rest(); } // inicia o servidor RESTful definido em /application/core/MY_Controller.php

    protected function listObjects_html(){ // retorna o html da listagem de pagamentos

        $javascript = array( // define os scripts js dinamicos
            "js/event/we_pagamentos_evento"
            ,"js/library/we_tabela_library"
            , "js/model/we_pagamentos_model"
            , "js/view/we_pagamentos_view"
            , "js/controller/we_pagamentos_controller"
        );

        $this->template->load( "private", "pagamentos/historico", $javascript ); // renderiza o html

    }

    public function listObjects_json( $params ){ // retorna um resumo dos pagamentos

        $this->load->model("pagamentos_model");

        $all = $this->pagamentos_model->all( $params ); // lista com resumo dos pagamentos

        if( $all["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $res = $all["resumo"]; // insere o resumo na resposta

        } else { // se a consulta ao banco não for bem sucedida

            $res = $all["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $all["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

}