<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eventos_Model extends CI_Model {

    public function all( $params = false ){ // retorna um resuo dos eventos

        if( $params ){ // se foi definido algum parametro para a busca

            if( isset( $params["nome"] ) ){ // se foi definido o nome a busca

                $this->db->like("nom_evento", $params["nome"] ); // busca ocorrencias que contenham algo como o nome

            }

        }

        $this->db->select('ide_evento as id, nom_evento as nome'); // define os campos a serem retornados
        $this->db->order_bY("nom_evento", "asc"); // ordena pelo nome de forma ascendente
        $this->db->from('we_evento'); // busca na tabela we_evento

        $resumo = $this->db->get()->result(); // executa a busca

        if( count($resumo) >= 0 ){ // se a consulta for bem sucedida

            $res = array( // define a resposta
                "sucesso" => true // define como sucesso
                , "resumo" => $resumo // insere o resumo na resposta
            );

        } else { // se a consulta for mal sucedida

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "Erro ao carregar resumo das eventos. Tente novamente mais tarde." // insere uma mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

}