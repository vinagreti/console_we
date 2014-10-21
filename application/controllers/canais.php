<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Canais extends MY_Controller {

    public function __construct() {

        parent::__construct(); // executa o construtor /application/core/MY_Controller

        if( ! in_array("2", $this->session->userdata("modulos") ) ){ // se o módulo 2 não estiver entre os módulos do grupo do usuário

            redirect( base_url() ); // redireciona para a página inicial

        }

    }

    public function index() { $this->rest(); } // inicia o servidor RESTful definido em /application/core/MY_Controller.php

    protected function listObjects_html(){ // retorna o html com a estrutura da lista de canais a serem gerenciados

        $javascript = array( // define os scripts js a serem incluidos na renderização da página
            "js/event/we_canais_evento"
            , "js/helper/we_url_helper"
            , "js/library/we_tabela_library"
            , "js/model/we_canais_model"
            , "js/view/we_canais_view"
            , "js/controller/we_canais_controller"
        );

        // renderiza a pagina utilizando a library template (/application/library/Template.php)
        $this->template->load( "private", "canais/gerenciar", $javascript );

    }

    protected function listObjects_json( $params = false ){ // retorna um resumo dos canais em JSON

        $pagina = isset($_GET['pagina']) && $_GET['pagina'] > 0 ? $_GET['pagina'] : 1; // define o numero da pagina

        $por_pagina = isset($_GET['por_pagina']) && $_GET['por_pagina'] > 0 ? $_GET['por_pagina'] : 50; // define o total de itens por página

        $this->load->model("canais_model"); // carrega o model canais

        $carregarResumo = $this->canais_model->carregarResumo( $params, $pagina, $por_pagina, true ); // pega o resumo dos vinculados no banco

        if( $carregarResumo["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $res = $carregarResumo["resumo"]; // insere o resumo na resposta

            header( "X-Total-Count: " . $carregarResumo["total"]);

        } else { // se a consulta ao banco não for bem sucedida

            $res = $carregarResumo["msg"]; // define uma mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $carregarResumo["msg"] ) ); // define o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function readObject_json( $id ){ // retorna os dados do canal tendo como referencia o seu id

        $this->load->model("canais_model");

        $carregar = $this->canais_model->carrega( $id );

        if( $carregar["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $res = $carregar["canal"]; // insere o canal na resposta

        } else { // se a consulta ao banco não for bem sucedida

            $res = $carregar["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $carregar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function createObject( $canal ){ // cria um novo objeto do tipo canal

        $this->load->model("canais_model"); // instancia o model dos canais

        $adicionar = $this->canais_model->adicionar( $canal ); // adiciona de um canal no banco

        if( $adicionar["sucesso"] ){ // se a adição ao banco for bem sucedida

            $res = $adicionar["canal"]; // insere o canal na resposta

            header( "HTTP/1.0 200 ". utf8_decode( $adicionar["msg"] ) );

        } else { // se a adição ao banco não for bem sucedida

            $res = $adicionar["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $adicionar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function updateObject( $canal ){ // edita osdados de um canal

        $this->load->model("canais_model"); // carrega o model de canais

        $editar = $this->canais_model->editar( $canal ); // solicita a edição do canal no banco

        if( $editar["sucesso"] ){ // se a edição no banco for bem sucedida

            $res = $editar["canal"]; // insere a mensagem na resposta

            header( "HTTP/1.0 200 ". utf8_decode( $editar["msg"] ) ); // seta o código e a mensagem de sucesso no cabeçalho da resposta

        } else { // se a consulta ao banco não for bem sucedida

            $res = $editar["msg"]; // define a resposta

            header( "HTTP/1.0 400 ". utf8_decode( $editar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function deleteObject( $params ){ // exclui um canal

        $this->load->model("canais_model"); // instancia o model de canais

        $deletar = $this->canais_model->remover( $params["id"] ); // solicita a remoção do canal no banco

        if( $deletar["sucesso"] ){ // se a remoção bem sucedida

            $res = $deletar["canais"]; // define a resposta

            header( "HTTP/1.0 200 ". utf8_decode( $deletar["msg"] ) ); // seta o código e a mensagem de sucesso no cabeçalho da resposta

        } else { // se a remoção não for bem sucedida

            $res = $deletar["msg"]; // define a resposta

            header( "HTTP/1.0 400 ". utf8_decode( $deletar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    public function formulario_adicao(){ // retorna o modal de adição

        echo $this->load->view('canais/formulario_adicao', "", true); // renderiza o modal de adição

    }

    public function formulario_edicao(){ // retorna o modal de edição

        echo $this->load->view('canais/formulario_edicao', "", true); // renderiza o modal de edição

    }

}