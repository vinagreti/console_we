<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suporte extends MY_Controller {

    function __construct(){

        parent::__construct(); // executa o construtor /application/core/MY_Controller

    }

    public function index(){ // exibe a pagina inicial do modulo suporte

        $template = $this->session->userdata("logged") ? 'private' : 'public';

        $this->template->load($template, 'suporte/index'); // renderiza o html

    }

    public function manual(){ // exibe o manual do site

        $template = $this->session->userdata("logged") ? 'private' : 'public';

        $this->template->load($template, 'suporte/manual'); // renderiza o html

    }

    public function chamados() // exibe um formulario para abertura de chamado
    {

        if( ! $this->session->userdata("logged") ) // se não estiver logado
            redirect(base_url()); // redireciona para a tela inicial

        if( ! $this->input->post() ){ // se não houver POST

            $javascript = array( // lista de scripts js dinamicos
                "js/event/we_chamados_evento"
                , "js/model/we_chamados_model"
                , "js/view/we_chamados_view"
                , "js/controller/we_chamados_controller"
            );

            $this->template->load('private', 'suporte/chamado', $javascript); // renderiza o template com o conteudo dinamico

        } else{ // se houver post

            $this->load->model("chamados_model"); // instancia o model de usuarios

            $criaChamado = $this->chamados_model->criar( $this->input->post() ); // cria o chamado

            if( ! $criaChamado["sucesso"] ){ // se o chamado for criado com sucesso

                header( "HTTP/1.0 400 ". utf8_decode( $criaChamado["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

            }

            header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

            echo json_encode( $criaChamado["msg"] ); // responde

        }

    }

}