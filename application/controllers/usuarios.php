<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends MY_Controller {


    public function __construct() {

        parent::__construct(); // executa o construtor /application/core/MY_Controller

        if( ! in_array("1", $this->session->userdata("modulos") ) ){ // se o módulo 1 não estiver entre os módulos do grupo do usuário

            redirect( base_url() ); // redireciona para a página inicial

        }

    }

    public function index() { $this->rest(); } // inicia o servidor RESTful definido em /application/core/MY_Controller.php

    protected function listObjects_html(){ // retorna o html com a estrutura da lista de usuarios a serem gerenciados

        $javascript = array( // scripts a serem incluidos na renderização da página
            "js/event/we_usuarios_evento"
            , "js/helper/we_url_helper"
            , "js/library/we_tabela_library"
            , "js/model/we_usuarios_model"
            , "js/view/we_usuarios_view"
            , "js/controller/we_usuarios_controller"
        );

        // renderiza a pagina utilizando a library template (/application/library/Template.php)
        $this->template->load( "private", "usuarios/gerenciar", $javascript );

    }

    protected function listObjects_json( $params ){ // retorna um resumo dos usuarios

        $pagina = isset($_GET['pagina']) && $_GET['pagina'] > 0 ? $_GET['pagina'] : 1; // define o numero da pagina

        $por_pagina = isset($_GET['por_pagina']) && $_GET['por_pagina'] > 0 ? $_GET['por_pagina'] : 50; // define o total de itens por página

        $this->load->model("usuarios_model"); // instancia o model de usuarios

        $carregarResumo = $this->usuarios_model->carregarResumo( $params, $pagina, $por_pagina, true ); // pega o resumo dos vinculados no banco

        if( $carregarResumo["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $res = $carregarResumo["resumo"]; // insere o resumo na resposta

            header( "X-Total-Count: " . $carregarResumo["total"]);

        } else { // se a consulta ao banco não for bem sucedida

            $res = $carregarResumo["msg"];

            header( "HTTP/1.0 400 ". utf8_decode( $carregarResumo["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function readObject_json( $id ){ // retorna os dados do usuario tendo como referencia o seu id

        $this->load->model("usuarios_model");

        $carregar = $this->usuarios_model->carrega( $id );

        if( $carregar["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $res = $carregar["usuario"]; // insere o usuario na resposta

        } else { // se a consulta ao banco não for bem sucedida

            $res = $carregar["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $carregar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function createObject( $usuario ){

        $this->load->model("usuarios_model"); // instancia o model dos usuarios

        $adicionar = $this->usuarios_model->adicionar( $usuario ); // adiciona um usuario no banco

        if( $adicionar["sucesso"] ){ // se a adição ao banco for bem sucedida

            $res = $adicionar["usuario"]; // insere o usuario na resposta

            header( "HTTP/1.0 200 ". utf8_decode( $adicionar["msg"] ) );

        } else { // se a consulta ao banco não for bem sucedida

            $res = $adicionar["msg"]; // mensagem de erro

            header( "HTTP/1.0 400 ". utf8_decode( $adicionar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function updateObject( $usuario ){

        $this->load->model("usuarios_model"); // carrega o model de usuarios

        $editar = $this->usuarios_model->editar( $usuario ); // solicita a edição do usuario no banco

        if( $editar["sucesso"] ){ // se a edição no banco for bem sucedida

            $res = $editar["usuario"]; // insere a mensagem na resposta

            header( "HTTP/1.0 200 ". utf8_decode( $editar["msg"] ) ); // seta o código e a mensagem de sucesso no cabeçalho da resposta

        } else { // se a consulta ao banco não for bem sucedida

            $res = $editar["msg"]; // define a resposta

            header( "HTTP/1.0 400 ". utf8_decode( $editar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

    protected function deleteObject( $params ){

        $this->load->model("usuarios_model"); // instancia o model de usuarios

        $deletar = $this->usuarios_model->remover( $params ); // solicita a remoção do usuario no banco

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

    public function formulario_selecao(){ // retorna o modal com o formulario de selecao

        echo $this->load->view('usuarios/formulario_selecao', "", true); // renderiza o modal de selecao

    }

    public function formulario_adicao(){ // retorna o modal com o formulario de adição

        echo $this->load->view('usuarios/formulario_adicao', "", true); // renderiza o modal de adição

    }

    public function formulario_edicao(){ // retorna o modal com o formulario de edição

        echo $this->load->view('usuarios/formulario_edicao', "", true); // renderiza o modal de edição

    }

}