<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eventos extends MY_Controller {

    public function index() { $this->rest(); } // inicia o servidor RESTful definido em /application/core/MY_Controller.php

    protected function listObjects_json( $params ){ // retorna um JSON com o resumo das eventos

        $this->load->model("eventos_model"); // carrega o model de eventos

        $carregar = $this->eventos_model->all( $params ); // busca as eventos do banco

        if( $carregar["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $res = $carregar["resumo"]; // insere o resumo na resposta

        } else { // se a consulta ao banco não for bem sucedida

            header( "HTTP/1.0 400 - ". utf8_decode( $carregar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

}