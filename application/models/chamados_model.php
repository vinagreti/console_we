<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chamados_Model extends CI_Model {

    public function criar( $params ){ // cria um novo chamado

        // define a mensagem do e-mail de nov usuario criado
        $mensagem = "Olá " . $this->session->userdata("nom_contato") . ","; // insere o nome do usuario
        $mensagem .= "\r\n<p> Seu chamado foi aberto com sucesso!</p>";
        $mensagem .= "<hr>";
        $mensagem .= "\r\n\r\n<p><em> ".$params["assunto"]."</em></p>"; // insere o assunto na mensagem
        $mensagem .= "\r\n\r\n<p><em> ".$params["texto"]."</em></p>"; // insere o texto na mensagem
        $mensagem .= "<hr>";
        $mensagem .= "\r\n<p> Em breve entraremos em contato.</p>";
        $mensagem .= "\r\n<p> Atenciosamente,</p>";
        $mensagem .= "\r\n<p> We Crowdcasting</p>";

        $this->load->library('email'); // carrega a biblioteca email
        $this->email->from('no-reply@wecrowdcasting.com', "Console " . $this->session->userdata("nom_cliente") ); // define o remetente
        $this->email->to( $this->session->userdata("dsc_email"), 'contato@wecrowdcasting.com', 'bruno@tzadi.com' ); // define os destinatarios
        $this->email->subject('Novo chamado'); // define o assunto
        $this->email->message( $mensagem ); // insere a mensagem no email
        $enviado = $this->email->send(); // envia o email

        if( $enviado ){ // se for enviado com sucesso

            $res = array( // define a resposta
                "sucesso" => true // define como sucesso
                , "msg" => "Chamado aberto!" // insere uma mensgem de sucesso
            );

        } else { // se não foi enviado com sucesso

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "Erro ao abrir chamado. Tente novamente mais tarde." // define a mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

}