<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts extends MY_Controller {

    public function __construct() {

        parent::__construct(); // executa o construtor /application/core/MY_Controller

        if( ! in_array("4", $this->session->userdata("modulos") ) ){ // se o módulo 4 não estiver entre os módulos do grupo do usuário

            redirect( base_url() ); // redireciona para a página inicial

        }

    }

    public function index() { $this->rest(); } // inicia o servidor RESTful definido em /application/core/MY_Controller.php

    protected function listObjects_html(){ // retorna o html com a estrutura da lista de posts a serem gerenciados

        $javascript = array( // define os scripts js a serem incluidos na renderização da página
            "third-party/twitter-bootstrap3/js/typeahead"
            , "js/helper/we_url_helper"
            , "third-party/twitter-bootstrap3/js/hogan"
            , "third-party/twitter-bootstrap3/js/bootstrap-datepicker"
            , "js/event/we_posts_evento"
            , "js/library/we_tabela_library"
            , "js/model/we_posts_model"
            , "js/view/we_posts_view"
            , "js/controller/we_posts_controller"
        );

        $css = array( "third-party/twitter-bootstrap3/css/bootstrap-datepicker" ); // define os scripts css a serem incluidos na renderização da página

        // renderiza a pagina utilizando a library template (/application/library/Template.php)
        $this->template->load( "private", "posts/gerenciar", $javascript, $css );

    }

    protected function listObjects_json( $params = false ){ // retorna um resumo dos posts

        $pagina = isset($_GET['pagina']) && $_GET['pagina'] > 0 ? $_GET['pagina'] : 1; // define o numero da pagina

        $por_pagina = isset($_GET['por_pagina']) && $_GET['por_pagina'] > 0 ? $_GET['por_pagina'] : 50; // define o total de itens por página

        $this->load->model("posts_model"); // carrega o model

        $carregarResumo = $this->posts_model->carregarResumo( $params, $pagina, $por_pagina, true ); // lista com resumo dos posts

        if( $carregarResumo["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $res = $carregarResumo["resumo"]; // insere o resumo na resposta

            header( "X-Total-Count : " . $carregarResumo['total'] );

        } else { // se a consulta ao banco não for bem sucedida

            $res = $carregarResumo["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $carregarResumo["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function readObject_json( $id ){ // retorna os dados do post tendo como referencia o seu id

        $this->load->model("posts_model"); // carrega o model

        $carregar = $this->posts_model->carregar( $id );

        if( $carregar["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $res = $carregar["post"]; // insere o post na resposta

        } else { // se a consulta ao banco não for bem sucedida

            $res = $carregar["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $carregar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function updateObject( $post ){

        $this->load->model("posts_model"); // carrega o model de posts

        $editar = $this->posts_model->editar( $post ); // solicita a edição do post no banco

        if( $editar["sucesso"] ){ // se a edição no banco for bem sucedida

            $res = $editar["post"]; // insere a mensagem na resposta

            header( "HTTP/1.0 200 ". utf8_decode( $editar["msg"] ) ); // seta o código e a mensagem de sucesso no cabeçalho da resposta

        } else { // se a consulta ao banco não for bem sucedida

            $res = $editar["msg"]; // define a resposta

            header( "HTTP/1.0 400 ". utf8_decode( $editar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function deleteObject( $params ){

        $this->load->model("posts_model"); // instancia o model de posts

        $deletar = $this->posts_model->remover( $params ); // solicita a remoção do post no banco

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

    public function formulario_moderacao(){ // retorna o modal de moderação

        echo $this->load->view('posts/formulario_moderacao', "", true); // renderiza o modal de moderação

    }

    public function modal_detalhes(){ // retorna o modal de detalhes

        echo $this->load->view('posts/modal_detalhes', "", true); // renderiza o modal de detalhes

    }

    public function modal_filtro(){ // retorna o modal de filtro

        echo $this->load->view('posts/modal_filtro', "", true); // renderiza o modal de filtro

    }

    public function dailyResume(){

        $this->load->model("posts_model");

        if(isset($_GET['startDate'])){
            try {
                new DateTime($_GET['startDate']);
            } catch (Exception $e) {
                $resumo = "Invalid start date";
            }

        } else
            $_GET['startDate'] = false;

        if(isset($_GET['endDate'])){
            try {
                new DateTime($_GET['endDate']);
            } catch (Exception $e) {
                $resumo = "Invalid end date";
            }

        } else
            $_GET['endDate'] = false;

        if( ! isset($resumo) )
            $resumo = $this->posts_model->dailyResume( $_GET['startDate'], $_GET['endDate'] );


        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode($resumo);

    }

}