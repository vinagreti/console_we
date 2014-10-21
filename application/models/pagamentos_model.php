<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pagamentos_Model extends CI_Model {

    public function all(){ // retorna o resumo dos pagamentos de um cliente

        $this->db->select('ide_cliente_fatura as id, dat_vencimento as data, num_valor as valor, dat_ultimo_aviso as aviso'); // define os campos a serem retornados
        $this->db->select("REPLACE( REPLACE( REPLACE(flg_status_pagamento, 'APG', 'Aguardando pagamento') , 'VNC', 'Não pago'), 'PGO', 'Pago') as status", FALSE); // define um nome humanizado e um alias para ser rtetornado como status
        $this->db->where("cod_cliente", $this->session->userdata("ide_cliente")); // onde houver o id do cliente em uso
        $this->db->order_bY("dat_vencimento", "desc"); // ordena pelo vencimento
        $this->db->from('we_cliente_fatura'); // busca na tabela we_cliente_fatura

        $resumo = $this->db->get()->result(); // salva a resposta na variavel resumo

        if( count($resumo) >= 0 ){ // se a consulta for bem sucedida

            $res = array( // define a resposta
                "sucesso" => true // define como sucesso
                , "resumo" => $resumo // insere o resumo
            );

        } else { // se for mal sucedida

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "Erro ao carregar resumo dos pagamentos. Tente novamente mais tarde." //  insere uma mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

}