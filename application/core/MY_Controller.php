<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Controller extends CI_Controller{

    public function __construct() {

        parent::__construct(); // executa o construturo da classe pai

        $this->verificaAutenticacao(); // executa o método verificaAutenticacao()

    }

    private function verificaAutenticacao(){ // verifica se o usuario está tentando utilizar algum modulo sem estar autenticado

        if( ! $this->session->userdata("logged") ){ // se não estiver logado

            if( $this->router->class != 'welcome' && $this->router->class != 'suporte' && $this->router->class != 'seguranca' && $this->router->method != 'entrar' ){ // e estiver acessando um conteúdo privado

                redirect(base_url()."entrar"); // redireicona para a tela de login

            }

        } else {

            $this->load->model("seguranca_model"); // carrega o modulo de segurança

            $this->seguranca_model->atualizaSessaoUsuario(); // atualiza sessao do usuario

        }

    }

    public function rest(){ // rest server

        switch ($this->input->server('REQUEST_METHOD')) { // verifica o tipo de requisição HTTP

            case 'GET': // no caso de uma requisição de tipo GET

                $object_id = $this->input->get("id"); // salva o id da uri

                if( $this->input->is_ajax_request() ) // se for uma reuisição AJAX
                    // se houver id executa o método readObject_json($id) e se não houver executa o método listObjects_json()
                    $object_id ? $this->readObject_json( $object_id ) : $this->listObjects_json( $this->input->get() );

                else // se não for uma requisição AJAX
                    // se houver id executa o método readObject_html($id) e se não houver executa o método listObjects_html()
                    $object_id ? $this->readObject_html( $object_id ) : $this->listObjects_html( $this->input->get() );

            break;

            case 'POST': // no caso de uma requisição de tipo POST

                $this->createObject( $_POST ); // executa o método createObject($params);

            break;

            case 'PUT': // no caso de uma requisição de tipo PUT

                parse_str(file_get_contents("php://input"),$post_vars);

                $this->updateObject( $post_vars ); // executa o método updateObject($params);

            break;

            case 'DELETE': // no caso de uma requisição de tipo DELETE

                $this->deleteObject( $this->input->get() ); // executa o método deleteObject($params);

            break;

            default: // no caso de uma requisição de outros tipos

                show_error(htmlentities("Requisição inválida")); // retorna um erro

            break;

        }

    }
}