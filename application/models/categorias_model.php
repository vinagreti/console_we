<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorias_Model extends CI_Model {

    public function all( $params = false ){ // lista todas as categorias

        if( $params ){ // se foi definido algum parâmetro para a pesquisa

            if( isset( $params["nome"] ) ){ // se for o parâmetro nome

                $this->db->like("nom_categoria_denuncia", $params["nome"] ); // retorna algo que contenha este nome

            }

        }

        $this->db->select('ide_categoria_denuncia as id, nom_categoria_denuncia as nome'); // define os campso a serem retornados
        $this->db->order_bY("nom_categoria_denuncia", "asc"); // ordena pelo nome da categoria

        $resumo = $this->db->get('we_categoria_denuncia ')->result(); // executa a consulta e retorna o resumo

        if( count($resumo) >= 0 ){ // se a consulta retornar algo

            $res = array( // define a resposta
                "sucesso" => true // define como sucesso
                , "resumo" => $resumo // insere o resumo na resposta
            );

        } else { // se a consulta não retornar um array

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "Erro ao carregar resumo das categorias. Tente novamente mais tarde." // insere uma mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

}