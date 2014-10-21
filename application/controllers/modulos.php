<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulos extends MY_Controller {


    public function __construct() {

        parent::__construct(); // executa o construtor /application/core/MY_Controller

        if( $this->session->userdata("flg_administrador") != "S" ){ // se o módulo 5 não estiver entre os módulos do grupo do usuário

            redirect( base_url() ); // redireciona para a página inicial

        }

    }

    public function index() { $this->rest(); } // inicia o servidor RESTful definido em /application/core/MY_Controller.php

    protected function listObjects_json(){ // retorna um JSON com o resumo dos módulos do sistema

        $this->load->model("modulos_model");

        $carregarResumo = $this->modulos_model->all(); // lista de metodos fake - sem pegar do banco

        if( $carregarResumo["sucesso"] ){ // se a consulta ao banco for bem sucedida

            $res = $carregarResumo["resumo"]; // insere o resumo na resposta

        } else { // se a consulta ao banco não for bem sucedida

            header( "HTTP/1.0 400 - ". utf8_decode( $carregarResumo["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

        }

        header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

        echo json_encode( $res ); // responde

    }

}