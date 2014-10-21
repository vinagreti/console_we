<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes_Model extends CI_Model {

    public function find( $id ){ // seleciona um cliente no banco pelo seu id

        // define os campos a serem retornados, seus aliases e o formato
        $this->db->select("ide_cliente as id");
        $this->db->select("flg_status_cliente as status");
        $this->db->select("REPLACE( REPLACE( REPLACE(flg_status_cliente, 'ATV', 'Ativo') , 'INA', 'Inativo'), 'APG', 'Aguardando pagamento') as status", FALSE);
        $this->db->select("cod_unico_cliente as codigo_unico");
        $this->db->select("DATE_FORMAT(dat_cadastro, '%d-%m-%Y %H:%i') as cadastro", FALSE);
        $this->db->select("nom_cliente as nome");
        $this->db->select("num_cnpj as cnpj");
        $this->db->select("nom_razao_social as razao_social");
        $this->db->select("dsc_logradouro as logradouro");
        $this->db->select("num_logradouro as numero");
        $this->db->select("dsc_logradouro_complemento as complemento");
        $this->db->select("num_logradouro_cep as cep");
        $this->db->select("nom_logradouro_cidade as cidade");
        $this->db->select("sig_logradouro_uf as uf");
        $this->db->select("sig_logradouro_pais as pais");
        $this->db->select("num_telefone as telefone");
        $this->db->select("dsc_permalink_admin as permalink");

        $this->db->where("ide_cliente", $id); // onde houver o mesmo id
        $this->db->from('we_cliente'); // na tabela we_cliente

        $cliente = $this->db->get()->row(); // retorna a primeira linha

        if( count($cliente) >= 0 ){ // se retornar algo

            $res = array( // define a resposta
                "sucesso" => true // define como sucesso
                , "cliente" => $cliente // insere o cliente
            );

        } else {

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "Erro ao carregar cliente. Tente novamente mais tarde." // insere uma mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

    public function editar( $params ){ // edita um cliente

        $data = array(); // define $data como um array

        if( count($params) > 1 ){ // se foi passado algum parametro para atualizar

            // verifica os parametros passados
            if( isset( $params["nome"] ) )
                $data["nom_cliente"] = $params["nome"];
            if( isset( $params["status"] ) )
                $data["flg_status"] = $params["status"];
            if( isset( $params["nome"] ) )
                $data["nom_cliente"] = $params["nome"];
            if( isset( $params["cnpj"] ) )
                $data["num_cnpj"] = $params["cnpj"];
            if( isset( $params["razao_social"] ) )
                $data["nom_razao_social"] = $params["razao_social"];
            if( isset( $params["logradouro"] ) )
                $data["dsc_logradouro"] = $params["logradouro"];
            if( isset( $params["numero"] ) )
                $data["num_logradouro"] = $params["numero"];
            if( isset( $params["complemento"] ) )
                $data["dsc_logradouro_complemento"] = $params["complemento"];
            if( isset( $params["cep"] ) )
                $data["num_logradouro_cep"] = $params["cep"];
            if( isset( $params["cidade"] ) )
                $data["nom_logradouro_cidade"] = $params["cidade"];
            if( isset( $params["uf"] ) )
                $data["sig_logradouro_uf"] = $params["uf"];
            if( isset( $params["pais"] ) )
                $data["sig_logradouro_pais"] = $params["pais"];
            if( isset( $params["telefone"] ) )
                $data["num_telefone"] = $params["telefone"];
            if( isset( $params["permalink"] ) )
                $data["dsc_permalink_admin"] = $params["permalink"];

            $this->db->where( 'ide_cliente', $this->session->userdata("ide_cliente") ); // onde o id do cliente for igual ao que o usuario está vinculado

        }

        $update = $this->db->set('we_cliente', $data); // atualiza os dados

        if( $update ){ // se os dados foram atualizados

            $cliente = $this->find( $params["id"] ); // seleciona o cliente no banco

            $res = array( // deifne a resposta
                "sucesso" => true // define como sucesso
                , "msg" => "Dados editados" //  insere uma mensagem de sucesso
                , "cliente" => $cliente // insere o cliente
            );

        } else { // se os dados nao forama tualizados

            $res = array( // deifne a resposta
                "sucesso" => false // deifne como falha
                , "msg" => "Problema na atualização dos dados. Tente novamente mais tarde." // insere a mensagem de erro
            );

        }

        return $res; // retorna o resultado

    }
}