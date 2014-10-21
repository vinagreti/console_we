<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vinculados_Model extends CI_Model {

    public function carregarResumo( $params = false, $pagina = false, $por_pagina = false, $retornarTotal = false, $contar = false ){ // retorna um resumo dos usuarios vinculados/reporteres

        if( $params ){ // se foi definido algum parametro pra busca

            if( isset( $params["nome"] ) ){ // verifica se o nome foi definido

                $this->db->like("nom_usuario", $params["nome"] ); // onde o nome for parecido com o nome passado

                $this->db->or_like("dsc_sobrenome", $params["nome"] ); // ou onde o sobrenome for parecido com o nome passado

            }

            if( isset( $params["data_inicial"] ) && $params["data_inicial"] != "" ){ // se foi definido o parametro data_inicial
                $startDate = new DateTime($params["data_inicial"]);
                $this->db->where( "dat_vinculo >= ", date_format($startDate, 'Y-d-m H:i:s') ); // busca onde o data_inicial for igual ao passado
            }
        }

        $this->db->select('we_usuario.ide_usuario as id, we_usuario.dsc_email as email'); // define os campos a serem retornados
        $this->db->select('CONCAT("http://", dsc_url_arq_avatar, "/uploads/avatars/", nom_arq_avatar) as avatar', FALSE); // humaniza avatar
        $this->db->select('CONCAT(we_usuario.nom_usuario, " ", we_usuario.dsc_sobrenome) as nome', FALSE); // humaniza e define um alias para o nome
        $this->db->select("DATE_FORMAT(we_usuario.dat_nascimento, '%d/%m/%Y') as nascimento", FALSE); // humaniza e define um alias
        $this->db->select("DATE_FORMAT(we_cliente_usuarios.dat_ultima_atividade, '%d/%m/%Y %H:%i:%s') as ultima_atividade", FALSE); // humaniza e define um alias
        $this->db->select("DATE_FORMAT(we_cliente_usuarios.dat_vinculo, '%d/%m/%Y %H:%i:%s') as vinculo", FALSE); // humaniza e define um alias para o nome
        $this->db->select("REPLACE( REPLACE(REPLACE(we_cliente_usuarios.flg_status, 'AT', 'Inativo'), 'EX', 'Excluído') , 'BN', 'Banido') as status", FALSE); // humaniza e define um alias
        $this->db->where('cod_cliente', $this->session->userdata("ide_cliente")); // onde o codigod oc liente for o mesmo do em uso
        $this->db->order_by("nom_usuario", "asc"); // ordena por nome
        $this->db->join('we_cliente_usuarios', 'we_usuario.ide_usuario = we_cliente_usuarios.cod_usuario'); // junta a tabela we_cliente_usuarios
        $this->db->from('we_usuario'); // busca na tabela we_usuario

        if( $por_pagina ) {

            $this->db->limit( $por_pagina );

            if( $pagina )
                $this->db->offset( ($pagina * $por_pagina) - $por_pagina );

        }

        if( $contar ){

            $res = $this->db->count_all_results();

        } else {

            $resumo =  $this->db->get()->result(); // insere o resultado na variavel resumo

            if( count($resumo) >= 0 ){ // se a consulta for bem sucedida

                $res = array( // define a resposta
                    "sucesso" => true // define como sucesso
                    , "resumo" => $resumo // insre o resumo
                );

                if( $retornarTotal ){

                    $res["total"] = $this->carregarResumo($params, false, false, false, true);

                }

            } else { // se for mal sucedida

                $res = array( // define a resposta
                    "sucesso" => false // define como falha
                    , "msg" => "Erro ao carregar resumo dos Usuários WE Vinculados. Tente novamente mais tarde." // insre uma mesagem de erro
                );

            }

        }

        return $res; // retorna a resposta

    }

    public function find( $id ){ // retorna um usuario vinculado

        $this->db->select('ide_usuario as id, dsc_email as email'); // humaniza a define a lias
        $this->db->select('CONCAT("http://", dsc_url_arq_avatar, "/uploads/avatars/", nom_arq_avatar) as avatar', FALSE); // humaniza avatar
        $this->db->select('CONCAT(nom_usuario, " ", dsc_sobrenome) as nome', FALSE); // humaniza a define a lias
        $this->db->select("DATE_FORMAT(we_usuario.dat_nascimento, '%d/%m/%Y') as nascimento", FALSE); // humaniza a define a lias
        $this->db->select("DATE_FORMAT(we_cliente_usuarios.dat_ultima_atividade, '%d/%m/%Y %H:%i:%s') as ultima_atividade", FALSE); // humaniza a define a lias
        $this->db->select("DATE_FORMAT(we_cliente_usuarios.dat_vinculo, '%d/%m/%Y %H:%i:%s') as vinculo", FALSE); // humaniza a define a lias
        $this->db->where('cod_cliente', $this->session->userdata("ide_cliente")); // onde o id do cliente for o mesmo doc liente em uso
        $this->db->where('cod_usuario', $id); // ond eo codigo do usuario for o mesmo do codigo passado como parametro
        $this->db->order_by("nom_usuario", "asc"); // ordena pelo nome
        $this->db->join('we_cliente_usuarios', 'we_usuario.ide_usuario = we_cliente_usuarios.cod_usuario'); // junta a tabela we_usuario
        $this->db->from('we_usuario'); // busca na tabela we_usuario
        $resposta = $this->db->get()->result(); // consulta e insere a resposta na variavel resposta

        return $resposta; // retorna a resposta

    }

    public function remover( $params ){ // remove um usuario vinculado logicamente

        $vinculados = $this->find($params["id"]); // seleciona o vinculado no banco

        if( count($vinculados) > 0 ){ // verifica se o vinculado existe

            $this->db->where('cod_usuario', $params["id"]); // onde o id for igual ao passado naos parametros
            $destruido = $this->db->delete('we_cliente_usuarios'); // define o novo status

            if( $destruido ){ // se o vinculado foi remivdo com sucesso

                $res = array( // define a resposta
                    "sucesso" => true // bem sucedida
                    , "msg" => "Vinculado removido." // insere uma mensagem de sucesso
                );

            } else { // se a remoção for mal sucedida

                $res = array( // define a resposta
                    "sucesso" => false // define como falha
                    , "msg" => "Problemas ao remover o vinculado. Por favor, tente novamente mais tarde." // insere uma mensagem de erro
                );

            }

        } else{ // se o vinculado nao existe

            $res = array( // define uma resposta
                "sucesso" => false // define como falha
                , "msg" => "O vinculado não existe ou não pertence a você." // insere uma mensagem de erro
            );

        }

        return $res; // retorna uma resposta

    }

    public function criaCSV(){ // cria um CSV dos vinculados

        $this->db->select('ide_usuario as id, dsc_email as email'); // define um alias
        $this->db->select('CONCAT("http://", dsc_url_arq_avatar, "/uploads/avatars/", nom_arq_avatar) as avatar', FALSE); // humaniza avatar
        $this->db->select('CONCAT(nom_usuario, " ", dsc_sobrenome) as nome', FALSE); // humaniza e define um alias
        $this->db->select("DATE_FORMAT(we_usuario.dat_nascimento, '%d/%m/%Y') as nascimento", FALSE); // humaniza e define um alias
        $this->db->select("DATE_FORMAT(we_cliente_usuarios.dat_ultima_atividade, '%d/%m/%Y %H:%i:%s') as ultima_atividade", FALSE); // humaniza e define um alias
        $this->db->select("DATE_FORMAT(we_cliente_usuarios.dat_vinculo, '%d/%m/%Y %H:%i:%s') as vinculo", FALSE); // humaniza e define um alias
        $this->db->where('cod_cliente', $this->session->userdata("ide_cliente")); // onde o id do cliente for igual ao id em uso
        $this->db->order_by("nom_usuario", "asc"); // ordena pelo nome
        $this->db->join('we_cliente_usuarios', 'we_usuario.ide_usuario = we_cliente_usuarios.cod_usuario'); // junta a tabela we_usuario
        $this->db->from('we_usuario'); // busca na tabela we_usuario
        $resumo = $this->db->get(); // insere a resposta na variavel resumo

        $delimiter = ","; // define os delimitadores do arquivo CSV
        $newline = "\r\n"; // define a forma de quebra de linha

        $this->load->dbutil(); // carrega o helper dbutil()
        return $this->dbutil->csv_from_result($resumo, $delimiter, $newline); // cria e retorna o arquivo CSV
    }

    public function dailyResume( $startDate = null, $endDate = null ){

        $endDate = $endDate ? new DateTime($endDate) : new DateTime();

        $endDateClone = clone $endDate;

        $startDate =  $startDate ? new DateTime($startDate) : $endDateClone->sub(new DateInterval('P1M'));

        $this->db->select("DATE_FORMAT(we_usuario.dat_cadastro, '%d-%m-%Y') as cadastro", FALSE);
        $this->db->where('cod_cliente', $this->session->userdata("ide_cliente")); // onde o id do cliente for o mesmo doc liente em uso
        $this->db->where('we_usuario.dat_cadastro >=', date_format($startDate, 'Y-m-d H:i:s'));
        $this->db->where('we_usuario.dat_cadastro <=', date_format($endDate, 'Y-m-d H:i:s'));
        $this->db->join('we_cliente_usuarios', 'we_usuario.ide_usuario = we_cliente_usuarios.cod_usuario'); // junta a tabela we_usuario
        $this->db->order_by("dat_cadastro"); // ordena pelo nome
        $this->db->from('we_usuario'); // busca na tabela we_usuario

        $raw_data = $this->db->get()->result(); // insere o resultado na variavel resumo

        $resumo = array();

        foreach( $raw_data as $index => $denuncias ){

            isset( $resumo[ $denuncias->cadastro ] ) ? $resumo[ $denuncias->cadastro ]++ : $resumo[ $denuncias->cadastro ] = 1;

        }

        return $resumo;

    }
}