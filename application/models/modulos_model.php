<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulos_Model extends CI_Model {

    public function all(){ // retorna um resumo dos modulos do sistema

        $this->db->select('ide_modulo as id, nom_modulo as nome'); // define os campso a serem retornados
        $this->db->order_bY("nom_modulo", "asc"); // ordena pelo nome
        $this->db->from('we_modulos_web'); // busca na tabela we_modulos_web

        $resumo = $this->db->get()->result(); // efetua a consulta

        if( count($resumo) >= 0 ){ // se a consulta for bem sucedida

            $res = array( // define a resposta
                "sucesso" => true // define como sucesso
                , "resumo" => $resumo // insere o resumo
            );

        } else { // se for mal sucedida

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "Erro ao carregar resumo dos módulos do sistema. Tente novamente mais tarde." // insere uma mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

}