<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vinculados extends MY_Controller {

    public function __construct() {

        parent::__construct(); // executa o construtor /application/core/MY_Controller

        if( ! in_array("3", $this->session->userdata("modulos") ) ){ // se o módulo 3 não estiver entre os módulos do grupo do usuário

            redirect( base_url() ); // redireciona para a página inicial

        }

    }

    public function index() { $this->rest(); } // inicia o servidor RESTful definido em /application/core/MY_Controller.php

    protected function listObjects_html(){

        $javascript = array( // define osscripts js dinamicos a serem carregados
            "js/event/we_vinculados_evento"
            , "js/helper/we_url_helper"
            , "js/helper/we_download_helper"
            , "js/library/we_tabela_library"
            , "js/model/we_vinculados_model"
            , "js/view/we_vinculados_view"
            , "js/controller/we_vinculados_controller"
        );

        // renderiza a pagina utilizando a library template (/application/library/Template.php)
        $this->template->load( "private", "vinculados/gerenciar", $javascript );

    }

    protected function listObjects_json( $params = false ){ // retorna um resumo dos vinculados

        $pagina = isset($_GET['pagina']) && $_GET['pagina'] > 0 ? $_GET['pagina'] : 1; // define o numero da pagina

        $por_pagina = isset($_GET['por_pagina']) && $_GET['por_pagina'] > 0 ? $_GET['por_pagina'] : 50; // define o total de itens por página

        $this->load->model("vinculados_model"); // instancia o model de vinculados

        $carregarResumo = $this->vinculados_model->carregarResumo( $params, $pagina, $por_pagina, true ); // pega o resumo dos vinculados no banco

        if( $carregarResumo["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $resumo = $carregarResumo["resumo"]; // insere o resumo na resposta

            header( "X-Total-Count: " . $carregarResumo["total"]);

        } else { // se a consulta ao banco não for bem sucedida

            $res = $carregarResumo["msg"];

            header( "HTTP/1.0 400 ". utf8_decode( $carregarResumo["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $resumo ); // responde

    }

    protected function deleteObject( $params ){

        $this->load->model("vinculados_model"); // instancia o model de vinculados

        $deletarVinculado = $this->vinculados_model->remover( $params ); // solicita a remoção do vinculado no banco

        if( $deletarVinculado["sucesso"] ){ // se a remoção bem sucedida

            $res = $deletarVinculado["msg"]; // define a resposta

            header( "HTTP/1.0 200 ". utf8_decode( $deletarVinculado["msg"] ) ); // seta o código e a mensagem de sucesso no cabeçalho da resposta

        } else { // se a remoção não for bem sucedida

            $res = $deletarVinculado["msg"]; // define a resposta

            header( "HTTP/1.0 400 ". utf8_decode( $deletarVinculado["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    public function criaCSV(){

        $this->load->model("vinculados_model"); // instancia o model de vinculados

        $vinculados = $this->vinculados_model->criaCSV(); // pega o resumo dos vinculados no banco

        $this->output->set_header('Content-Type: application/force-download'); // força o download
        $this->output->set_header('Content-Disposition: attachment; filename="usuarios_we_vinculados.csv"'); // define o nome do arquivo
        $this->output->set_content_type('text/csv'); // define o content-type como csv
        $this->output->set_output($vinculados); // retorna o csv

    }

    public function dailyResume(){

        $this->load->model("vinculados_model");

        $resumo = $this->vinculados_model->dailyResume();

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode($resumo);

    }

}