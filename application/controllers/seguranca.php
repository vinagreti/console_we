<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seguranca extends MY_Controller {

    public function index() // se o metodo index for executado
    {

        redirect(base_url()); // redireciona para a pagina inicial

    }

    public function entrar(){ // formulário de login

        if( $this->session->userdata("logged") ) // se o usuário já estiver logado
            redirect(base_url()); // redireciona para  atela de login

        if( ! $this->input->post() ){ // se não houver post

            $javascript = array( // define os scripts js dinamicos a serem carregados
                "js/event/we_seguranca_evento"
                , "js/model/we_seguranca_model"
                , "js/view/we_seguranca_view"
                , "js/controller/we_seguranca_controller"
            );

            // renderiza a pagina utilizando a library template (/application/library/Template.php)
            $this->template->load('public', 'seguranca/entrar', $javascript); 

        }

        else{

            $this->load->model("seguranca_model"); // instancia o model de usuarios

            $autentica = $this->seguranca_model->autentica( $this->input->post() ); // confere os dados passados com os do banco

            if( $autentica["sucesso"] ){ // se a autenticação for bem sucedida

                $res = base_url()."dashboard"; // insere uma url para redirecionamento na resposta

            } else { // se a consulta ao banco não for bem sucedida

                $res = $autentica["msg"]; // define a mensagem de erro

                header( "HTTP/1.0 400 ". utf8_decode( $res ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

            }

            header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

            echo json_encode( $res ); // responde

        }

    }

    public function sair(){ // executa o logout

        if( ! $this->session->userdata("logged") ) // se o usuário não estiver logado
            redirect(base_url()); // redireciona para a tela inicial

        $this->session->sess_destroy(); // destroi a sessão

        redirect(base_url()."entrar"); // redireciona para a tela de login

    }

    public function recuperarSenha(){ // formulário de recuperação de senha

        if( $this->session->userdata("logged") ) // se o usuário estiver logado
            redirect(base_url()); // redireciona para a tela inicial

        if( ! $this->input->post() ){ // se houver $_POST

            $javascript = array( // define os scripts js dinamicos a serem carregados
                "js/event/we_seguranca_evento"
                , "js/model/we_seguranca_model"
                , "js/view/we_seguranca_view"
                , "js/controller/we_seguranca_controller"
            );

            // renderiza a pagina utilizando a library template (/application/library/Template.php)
            $this->template->load('public', 'seguranca/recuperarSenha', $javascript);

        } else{ // se não houver $_POST

            $this->load->model("seguranca_model"); // instancia o model de usuarios

            $recuperarSenha = $this->seguranca_model->recuperarSenha( $this->input->post() ); // confere os dados passados com os do banco

            if( $recuperarSenha["sucesso"] ){ // se a recuperarção de senha for bem sucedida

                $res = $recuperarSenha["msg"]; // insere a mensagem de sucesso na resposta

            } else { // se a consulta ao banco não for bem sucedida

                $res = $recuperarSenha["msg"]; // define a mensagem de erro

                header( "HTTP/1.0 400 ". utf8_decode( $res ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

            }

            header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

            echo json_encode( $res ); // responde

        }

    }

    public function alterarSenha(){ // exibe formulário de alteração de senha

        if( ! $this->input->post() ){ // se não houver $_POST

            $javascript = array( // define os scripts js dinamicos a serem carregados
                "js/event/we_seguranca_evento"
                , "js/model/we_seguranca_model"
                , "js/view/we_seguranca_view"
                , "js/controller/we_seguranca_controller"
            );

            if( $this->session->userdata("logged") ){ // se o usuário estiver logado

                // renderiza a pagina com template privado, utilizando a library template (/application/library/Template.php)
                $this->template->load( 'private', 'seguranca/alterarSenha', $javascript);

            } else if( $_GET["token"] ){ // se o usuário forneceu um token

                $this->load->model("seguranca_model"); // carrega o model seguranca

                $token_exist_res = $this->seguranca_model->verificaValidadeAlterarSenhaToken( $_GET["token"] ); // verifica se o token é válido

                if( $token_exist_res["sucesso"] ){ // se o token for válido

                    // renderiza a pagina com template público, utilizando a library template (/application/library/Template.php)
                    $this->template->load( 'public', 'seguranca/alterarSenha', $javascript);

                } else { // se o token for inválido

                    // renderiza a pagina com template público, utilizando a library template (/application/library/Template.php)
                    $this->template->load( 'public', 'seguranca/tokenInvalido');

                }

            } else // se o usuário nao estiver logado e não fornecer um token
                redirect(base_url()); // redireciona para a tela inicial

        } else { // se houver $_POST

            $this->load->model("seguranca_model"); // carrega o model segurança

            $alterarSenha = $this->seguranca_model->alterarSenha( $this->input->post() ); // solicita a alteração da senha no banco

            if( $alterarSenha["sucesso"] ){ // se a alteração de senha for bem sucedida

                $res = $alterarSenha["msg"]; // insere a mensagem de sucesso na resposta

            } else { // se a consulta ao banco não for bem sucedida

                $res = $alterarSenha["msg"];

                header( "HTTP/1.0 400 ". utf8_decode( $alterarSenha["msg"] ) ); // seta o código e a mensagem de erro no cabeçalho da resposta

            }

            header('Content-Type: application/json'); // define o tipo de conteúdo no cabeçalho da resposta

            echo json_encode( $res ); // responde

        }

    }

}