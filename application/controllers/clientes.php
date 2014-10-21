<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes extends MY_Controller {

    public function __construct() {

        parent::__construct(); // executa o construtor /application/core/MY_Controller

        if( ! in_array("6", $this->session->userdata("modulos") ) ){ // Se o módulo 6 não estiver definido no grupo do usuario

            redirect( base_url() ); // retorna a página inicial

        }

    }

    public function index() { $this->rest(); } // inicia o servidor RESTful definido em /application/core/MY_Controller.php

    public function dados() { // retorna um formulario html com os dados do cliente

        $javascript = array( // define os scripts js a serem carregados
            "js/event/we_clientes_evento"
            , "js/model/we_clientes_model"
            , "js/view/we_clientes_view"
            , "js/controller/we_clientes_controller"
        );

        $this->load->model("clientes_model"); // carrega o model de clientes

        $consulta = $this->clientes_model->find( $this->session->userdata("ide_cliente") ); // busca o cliente no banco

        switch ($consulta["cliente"]->status) { // verifica o status do clientes
            case 'Inativo': // caso seja inativo
                $consulta["cliente"]->status_color = "text-danger"; // define a cor como vermelha
                break;

            case 'Aguardando pagamento': // caso seja aguardando pagamento
                $consulta["cliente"]->status_color = "text-warning"; // define a cor como laranja
                break;

            default: // se não for nem inativo nem aguardando
                $consulta["cliente"]->status_color = "text-success"; // define a cor como verde
                break;
        }

        $this->template->load('private', 'clientes/editar', $javascript, null, $consulta["cliente"]); // carrega o template com o conteúdo dinamico

    }

    protected function updateObject( $cliente ){

        $this->load->model("clientes_model"); // carrega o model de clientes

        $editar = $this->clientes_model->editar( $cliente ); // solicita a edição do cliente no banco

        if( $editar["sucesso"] ){ // se a edição no banco for bem sucedida

            $res = $editar["cliente"]; // insere a mensagem na resposta

            header( "HTTP/1.0 200 ". utf8_decode( $editar["msg"] ) ); // seta o código e a mensagem de sucesso no cabeçalho da resposta

        } else { // se a consulta ao banco não for bem sucedida

            $res = $editar["msg"]; // define a resposta

            header( "HTTP/1.0 400 ". utf8_decode( $editar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }
}