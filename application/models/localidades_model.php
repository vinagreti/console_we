<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Localidades_Model extends CI_Model {

    public function all( $params = false ){ // retorna um resumo das localidades

        if( $params ){ // se houver algum parametro para a busca

            if( isset( $params["nome"] ) ){ // verifica se o parametro nome está sendo informado

                $this->db->like("nom_localidade", $params["nome"] ); // se houver parte do nome

            }

        }

        $this->db->select('ide_localidade as id, nom_localidade as nome'); // define os campos a serem retornados
        $this->db->order_bY("nom_localidade", "asc"); // ordena por nome
        $this->db->from('we_localidade'); // busca na tabela we_localidade

        $resumo = $this->db->get()->result(); // grava a resposta na variavel resumo

        if( count($resumo) >= 0 ){ // se a busca for bem sucedida

            $res = array( // define a resposta
                "sucesso" => true // define como sucessp
                , "resumo" => $resumo // insere o resumo
            );

        } else { // se a busca for mal sucedida

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "Erro ao carregar resumo das localidades. Tente novamente mais tarde." // insere a mensagem de resposta
            );

        }

        return $res; // retorna a resposta

    }

}