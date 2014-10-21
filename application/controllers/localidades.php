<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Localidades extends MY_Controller {

    public function index() { $this->rest(); } // inicia o servidor RESTful definido em /application/core/MY_Controller.php

    protected function listObjects_json( $params ){ // retorna um JSON com o resumo das localidades

        $this->load->model("localidades_model"); // carrega o model de localidades

        $carregar = $this->localidades_model->all( $params ); // busca as localidades do banco

        if( $carregar["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $res = $carregar["resumo"]; // insere o resumo na resposta

        } else { // se a consulta ao banco não for bem sucedida

            header( "HTTP/1.0 400 - ". utf8_decode( $carregar["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

}