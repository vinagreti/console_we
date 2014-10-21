<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Canais_Model extends CI_Model {

    public function carregarResumo( $params = false, $pagina = false, $por_pagina = false, $retornarTotal = false, $contar = false ){ // retorna um resumo dos canais

        if( $params ){ // se for definido algum parametro para a consulta ao banco

            if( isset( $params["nome"] ) ){ // se o parametro nome foi definido

                $this->db->like("nom_canal", $params["nome"] ); // busca por ocorrencias com o nome ou parte dele

            }

        }

        $this->db->select('ide_canal as id, nom_canal as nome, num_ordem as ordem'); // define os campso a serem retornados
        $this->db->select("REPLACE( REPLACE(flg_status, 'IN', 'Inativo') , 'AT', 'Ativo') as status", FALSE); // substitui as flags por nomes legíveis
        $this->db->where_in('flg_status', array('AT', 'IN')); // busca por ocorrencias com status ativo e inativo
        $this->db->where('cod_cliente', $this->session->userdata("ide_cliente")); // busca apenas ocorrencias do cliente ao qual o usuario logado pertence
        $this->db->order_by("num_ordem", "asc"); // ordena pelo num_ordem
        $this->db->from('we_canal'); // consulta o banco

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

    public function adicionar( $params ){ // adiciona um novo canal

        if( ! isset($params["nome"] ) || strlen($params["nome"]) < 6 ) // se o nome do canal não for definido ou tiver menos de 6 caracteres
            return array( "sucesso" => false, "msg" => "O nome deve ter no mínimo 6 caracteres."); // retorna um erro

        $this->db->where( 'cod_cliente', $this->session->userdata("ide_cliente") ); // busca apenas ocorrencias do cliente ao qual o usuario logado pertence
        $this->db->where_in('flg_status', array('AT', 'IN')); // busca por ocorrencias com status ativo e inativo
        $this->db->order_by("num_ordem desc"); // ordena pelo num_ordem em ordem decrescente
        $canal = $this->db->get("we_canal")->first_row(); // retorna a primeira linha da consulta

        $ordem = $canal ? $canal->num_ordem + 1 : 1; // se houver algum canal definido, seta a ordem do novo canal com 1 a mais, se não houver nenhum canal, seta a ordem como 1

        $data = array( // define os dados do novo canal
            'nom_canal' => $params["nome"] // define o nome
            , 'flg_status' => $params["status"] // define o status
            , 'num_ordem' => $ordem // define a ordem
            , 'cod_cliente' => $this->session->userdata("ide_cliente") // define o código do cliente
            );

        $save = $this->db->insert('we_canal', $data); // salva o novo canal no banco

        if( $save ){ // se o novo canal for salvo com sucesso

            $this->db->select('ide_canal as id, nom_canal as nome, num_ordem as ordem'); // seleciona o novo canal no banco
            $this->db->select("REPLACE( REPLACE(flg_status, 'IN', 'Inativo') , 'AT', 'Ativo') as status", FALSE); // substitui as flags por nomes legíveis
            $this->db->where( "ide_canal", $this->db->insert_id() ); // consulta pelo ID do novo canal
            $canal = $this->db->get("we_canal")->row(); // retorna o novo canal

            $res = array( // define a resposta
                "sucesso" => true // define como sucesso
                , "canal" => $canal // inclui o resumo do novo canal
                , "msg" => "Canal adicionado" // inclui uma mensagem de sucesso
                );

        } else { // seo novo canal não for salvo com sucesso

            $res = array( // define a respota
                "sucesso" => false // define como falha
                , "msg" => "Erro ao criar canal. Tente novamente mais tarde." // define a mensagem de erro
                );

        }

        return $res; // retorna a resposta

    }

    public function find( $canal_id ){ // retorna o resumo de um canal pelo seu ID

        $this->db->select('ide_canal as id, nom_canal as nome, num_ordem as ordem'); // define os dados a serem retornados
        $this->db->select("REPLACE( REPLACE(flg_status, 'IN', 'Inativo') , 'AT', 'Ativo') as status", FALSE); // substitui as flags por nomes legíveis
        $this->db->where( 'cod_cliente', $this->session->userdata("ide_cliente") ); // busca apenas ocorrencias do cliente ao qual o usuario logado pertence
        $this->db->where( 'ide_canal', $canal_id ); // busca pelo ID fornecido
        return $this->db->get("we_canal")->first_row(); // retorna a primeira ocorrencia encontrada

    }

    public function carrega( $canal_id ){ // retorna todos os dados de um canal pelo seu ID

        $this->db->select('ide_canal as id, nom_canal as nome, num_ordem as ordem, flg_status as status'); // define os dados a serem retornados
        $this->db->where( 'cod_cliente', $this->session->userdata("ide_cliente") ); // busca apenas ocorrencias do cliente ao qual o usuario logado pertence
        $this->db->where( 'ide_canal', $canal_id ); // busca pelo ID fornecido
        $canal = $this->db->get("we_canal")->first_row(); // retorna a primeira ocorrencia encontrada

        if( $canal ){ // se a consulta for bem sucedida

            $res = array( // define a resposta
                "sucesso" => true // define como sucesso
                , "canal" => $canal // inclui os dados do canal
                );

        } else { // se a consulta falhar

            $res = array( // define a resposta
                "sucesso" => false // define como erro
                , "msg" => "O canal não existe ou não pertence a você." // inclui a mensagem de erro
                );

        }

        return $res; // retorna a resposta

    }

    public function editar( $params ){ // edita um canal

        if( (! isset($params["nome"] ) || strlen($params["nome"]) < 6) && ! isset( $params["ordem"] ) ) // se o nome não for definido ou conter menos de 6 caracteres
            return array( "sucesso" => false, "msg" => "O nome deve ter no mínimo 6 caracteres."); // retorna erro

        $data = array(); // cria array data

        if( isset( $params["nome"] ) ) // se o nome for definido
            $data["nom_canal"] = $params["nome"]; // define o nome no array data

        if( isset( $params["status"] ) ) // se o status for definido
            $data["flg_status"] = $params["status"]; // define o status no array data

        $this->db->where( 'ide_canal', $params["id"] ); // define o ID do canal a ser editado

        if( count($data) > 0 ){ // se o array data conter algum dado para ser alterado

            $update = $this->db->update('we_canal', $data); // altera o canal no banco com os novos dados

        } else { // se o array data não conter nenhum parametro

            $update = true; // define o update como bem sucedido

        }

        if( $update ){ // se o update for bem sucedido

            if( isset( $params["ordem"] ) ){ // se foi requisitada alteração da ordem

                $canal = $this->trocarOrdem( $params["id"], $params["ordem"] ); // altera a ordem dos canais

            } else { // se não foi requisitada  aalteração da ordem

                $canal = $this->find( $params["id"] ); // busca o canal no banco

            }

            $res = array( // define a respota de sucesso
                "sucesso" => true // define sucesso
                , "msg" => "Canal editado" // insere mensagem de sucesso
                , "canal" => $canal // insere o canal
                );

        } else { // se o update não for bem sucedido

            $res = array( // define a resposta com mal sucedido
                "sucesso" => false // defina como erro
                , "msg" => "O canal não existe ou nao pertence a você." // insere a mensagem de erro
                );

        }

        return $res; // retorna a resposta

    }

    public function trocarOrdem( $id, $ordem ){ // altera a ordem de um canal

        $canal = $this->find( $id ); // seleciona o canal a ser alterado, na tabela

        $this->db->order_by("num_ordem", "desc"); // ordena pelo num_ordem
        $this->db->where_in('flg_status', array('AT', 'IN')); // busca por ocorrencias com status ativo e inativo
        $this->db->where('cod_cliente', $this->session->userdata("ide_cliente")); // busca apenas ocorrencias do cliente ao qual o usuario logado pertence
        $canal_maior_ordem = $this->db->get('we_canal')->first_row(); // retorna o canal de maior ordem

        if( $ordem == $canal->ordem || $ordem < 1 || $ordem > $canal_maior_ordem->num_ordem){ // se a nova ordem for igual a atual, menor que 1 ou maior que a maior ordem

            return $canal; // retorna um resumo do canal alterado

        } else { // se a nova ordem é diferente a atual

            if( $ordem > $canal->ordem ){ // se a nova posição é superior a atual

                $this->db->select('ide_canal as id, num_ordem as ordem'); // define os campos a serem retornados
                $this->db->where_in('flg_status', array('AT', 'IN')); // busca por ocorrencias com status ativo e inativo
                $this->db->where('cod_cliente', $this->session->userdata("ide_cliente")); // busca apenas ocorrencias do cliente ao qual o usuario logado pertence
                $this->db->where('num_ordem <=', $ordem); // busca ocorrencias com ordem menor ou igual a nova ordem
                $this->db->where('num_ordem >', $canal->ordem); // busca ocorrencias com ordem maior que a ordem atual
                $this->db->order_by("num_ordem", "asc"); // ordena pelo num_ordem
                $resumo = $this->db->get('we_canal')->result(); // retorna os canais

                foreach( $resumo as $key => $cnl ){ // para cada canal selecionado

                    $resumo[$key]->ordem--; // subtrai 1 na ordem

                }

            } else { // se a nova posição é inferior a atual

                $this->db->select('ide_canal as id, num_ordem as ordem'); // define os campos a serem retornados
                $this->db->where_in('flg_status', array('AT', 'IN')); // busca por ocorrencias com status ativo e inativo
                $this->db->where('cod_cliente', $this->session->userdata("ide_cliente")); // busca apenas ocorrencias do cliente ao qual o usuario logado pertence
                $this->db->where('num_ordem >=', $ordem); // busca ocorrencias com ordem maior ou igual a nova ordem
                $this->db->where('num_ordem <', $canal->ordem); // busca ocorrencias com ordem menor que a ordem atual
                $this->db->order_by("num_ordem", "asc"); // ordena pelo num_ordem
                $resumo = $this->db->get('we_canal')->result(); // retorna os canais

                foreach( $resumo as $key => $cnl ){ // para cada canal selecionado

                    $resumo[$key]->ordem++; // soma 1 na ordem

                }

            }

            $canal->ordem = $ordem; // define a nova ordem do canal

            array_push( $resumo , $canal ); // insere o canal editado no array de canais

            foreach( $resumo as $key => $cnl ){ // para cada canal

                $this->db->where( 'ide_canal', $cnl->id ); // onde o ID for igual ao ID do canal

                $update = $this->db->update('we_canal', array("num_ordem" => $cnl->ordem) ); // atualiza a ordem do canal

            }

            return $resumo; // retorna um resumo dos canais alterados

        }

    }

    public function remover( $object_id ){ // remove um canal

        $canal = $this->find($object_id); // seleciona o canal no banco

        if( $canal ){ // verifica se o canal existe

            $this->db->where('ide_canal', $object_id); // remove LÓGICAMENTE o canal do banco
            $this->db->where( "cod_cliente", $this->session->userdata("ide_cliente") ); // busca apenas ocorrencias do cliente ao qual o usuario logado pertence
            $destruido = $this->db->update('we_canal', array("flg_status" => "EX")); // atualiza o status canal para EX - excluido

            if( $destruido ){ // se o canal foi remivdo com sucesso

                $this->db->select('ide_canal as id, num_ordem as ordem'); // retorna o ID e ordem
                $this->db->where('num_ordem >', $canal->ordem ); // seleciona todos os canais com ordem maior que o canal excluído
                $this->db->where_in('flg_status', array('AT', 'IN')); // busca por ocorrencias com status ativo e inativo
                $this->db->where( "cod_cliente", $this->session->userdata("ide_cliente") ); // busca apenas ocorrencias do cliente ao qual o usuario logado pertence
                $superiores = $this->db->get('we_canal')->result(); // retorna os canais

                foreach( $superiores as $key => $superior ){ // para cada canal superior

                    $this->db->where('ide_canal', $superior->id); // onde o ID for igual ao do canal

                    $superiores[$key]->ordem--; // subtrai 1 na ordem do canal

                    $this->db->update('we_canal', array("num_ordem" =>  $superiores[$key]->ordem)); // atualiza o canal com a nova ordem

                }

                $res = array( // respota da remoção do canal bem sucedida
                    "sucesso" => true // define como bem sucedida
                    , "msg" => "Canal removido." // insere uma mensagem de sucesso
                    , "canais" => $superiores // insere os canais editados
                    );

            } else {

                $res = array( // respota da remoção do canal bem sucedida
                    "sucesso" => false // define como falha
                    , "msg" => "Problemas ao remover o canal. Por favor, tente novamente mais tarde." // insere a mensagem de erro
                    );

            }

        } else{ // se o canal não existe

            $res = array( // respota da remoção do canal mal sucedida
                "sucesso" => false // define a resposta como erro
                , "msg" => "O canal não existe ou não pertence a você." // define a mensagem de erro
                );

        }

        return $res; // retorna a resposta

    }
}