<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grupos_Model extends CI_Model {

    public function carregarResumo( $params = false, $pagina = false, $por_pagina = false, $retornarTotal = false, $contar = false ){ // retorna um resumo dos grupos

        $this->db->select('ide_cliente_grupo as id, nom_grupo as nome, grupo_padrao as padrao'); // define os campso a serem retornados
        $this->db->where('cod_cliente', $this->session->userdata("ide_cliente")); // com id do mesmo cliente
        $this->db->order_by("nom_grupo", "asc"); // ordenados pelo nome de forma ascendente
        $this->db->from('we_cliente_grupo'); // retorna o resumo

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
                    , "msg" => "Erro ao carregar resumo dos GRUPOS. Tente novamente mais tarde." // insre uma mesagem de erro
                );

            }

        }

        return $res; // retorna a resposta

    }

    public function find( $grupo_id ){ // encontra um grupo pelo seu id

        $this->db->select('ide_cliente_grupo as id, nom_grupo as nome'); // define os campos a serem retornados

        $this->db->where( 'ide_cliente_grupo', $grupo_id ); // busca pelo id do grupo

        $this->db->where('cod_cliente', $this->session->userdata("ide_cliente")); // busca pelo id do cliente

        $grupo = $this->db->get('we_cliente_grupo')->row(); // consulta a retorna a primeira linha

        if( $grupo ){ // se retornar algo

            $grupo->modulos = array(); // define os modulos do grupo como um array

            $modulos = $this->db->get_where( "we_permissao_grupo", array( "cod_cliente_grupo" => $grupo_id ) )->result(); // retorna a lista de modulos

            foreach( $modulos as $index => $modulo ){ // para cada modulo em modulos

                array_push( $grupo->modulos, $modulo->cod_modulo ); // insere o codigo do modulo nos modulos do grupo

            }

            $res = array( // define a resposta
                "sucesso" => true // define como sucesso
                , "grupo" => $grupo // insere o grupo
            );

        } else { // se naõ retornar nada

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "O grupo não existe ou não pertence a você." // insere a mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

    public function adicionar( $params ){ // adiciona um grupo

        if( ! isset($params["nome"] ) || strlen($params["nome"]) < 6 ) // se o nome possuir menos de 6 caracteres
            return array( "sucesso" => false, "msg" => "O nome deve ter no mínimo 6 caracteres."); // retorna uma mensagem de erro

        $data = array( // define os novos dados do grupo
           'nom_grupo' => $params["nome"] ,
           'cod_cliente' => $this->session->userdata("ide_cliente")
        );

        $save = $this->db->insert('we_cliente_grupo', $data); // insre o novo grupo

        if( $save ){ // se foi inserido com sucesso

            $grupo_id = $this->db->insert_id();

            if( isset( $params["modulos"] ) ){ // se foram definidos os modulos

                $this->atualizarModulos( $params["modulos"], $grupo_id ); // atualiza os modulos do grupo

            }

            $this->db->select('ide_cliente_grupo as id, nom_grupo as nome'); // define os dados a serem retornados
            $this->db->where( "ide_cliente_grupo", $grupo_id ); // busca pelo pelo id do grupo inserido
            $grupo = $this->db->get("we_cliente_grupo")->row(); // retorna o grupo

            $res = array( // define a resposta
                "sucesso" => true // define como sucesso
                , "grupo" => $grupo // insere o grupo
                , "msg" => "Grupo adicionado" // insere a mensagem de sucesso
            );

        } else { // se houve falha na inserção

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "Erro ao criar grupo. Tente novamente mais tarde." // insere a mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

    public function editar( $params ){ // edita um grupo

        if( ! isset($params["nome"] ) || strlen($params["nome"]) < 6 ) // se o nome tiver menos de 6 caracteres
            return array( "sucesso" => false, "msg" => "O nome deve ter no mínimo 6 caracteres."); // retorna uma mensagem de erro

        $grupo = $this->db->get_where( "we_cliente_grupo", array( "ide_cliente_grupo" => $params["id"] ) )->result(); // consulta os dados do grupo

        if( $grupo[0]->grupo_padrao == "N" ){ // se não estiver tentando excluir o Grupo Padrão

            $data = array(); // define data como um array

            if( isset( $params["nome"] ) ) // se foi definido o nome
                $data["nom_grupo"] = $params["nome"]; // insere o parametro nome em data

            $this->db->where('ide_cliente_grupo', $params["id"]); // onde o id do grupo for o id informado

            $update = $this->db->update('we_cliente_grupo', $data); // atualiza os dados

            if( $update ){ // se foi atualizado com sucesso

                $params["modulos"] = isset( $params["modulos"] ) ? $params["modulos"] : array(); // garante que modulso seja array

                $this->atualizarModulos( $params["modulos"], $params["id"] ); // atualiza os modulos do grupo

                $res = array( // define a resposta
                    "sucesso" => true // define como sucesso
                    , "msg" => "Grupo editado" // insere uma mensagem de sucesso
                );

            } else { // se não foi atualizado com sucesso

                $res = array( // define a resposta
                    "sucesso" => false // define como falha
                    , "msg" => "O grupo não existe ou nao pertence a você." // insere a ensagem de erro
                );

            }

        } else { // se tiver tentando editar o Grupo Padrão

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "O Grupo Padrão não pode ser editado." // insere a mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

    private function atualizarModulos( $modulos, $grupo_id ){ // atualiza os modulos de um grupo

        if( is_string( $modulos ) ) $modulos = array( $modulos ); // // garante que modulos seja um array

        $this->db->where('cod_cliente_grupo', $grupo_id); // onde as permissoes tem o id do grupo
        $this->db->delete('we_permissao_grupo'); // remove as permissoes

        if( count( $modulos ) > 0 ){ // se foi definido algum modulo novo

            $permissoes = array(); // define as novas permissoes

            foreach( $modulos as $index => $valor ){ // para cada modulo em modulos

                array_push( $permissoes, array( "cod_cliente_grupo" =>  $grupo_id, "cod_modulo" => $valor) ); // insere o codigo do modulo nas permissoes

            }

            $this->db->insert_batch('we_permissao_grupo', $permissoes); // insere todas as novas permissoes na tabela

        }


    }

    public function remover( $object_id, $novo_grupo_id ){ // remove um grupo

        $this->db->where('cod_cliente', $this->session->userdata("ide_cliente")); // seleciona o grupo no banco
        $this->db->where('ide_cliente_grupo', $object_id); // pelo seu ID
        $grupo = $this->db->get( "we_cliente_grupo" )->row(); // retorna o objeto

        if( $grupo ){ // verifica se o grupo existe

            if( $grupo->grupo_padrao == "N" ){ // se não estiver tentando excluir o Grupo Padrão

                if( isset($novo_grupo_id) ){ // se um novo grupo foi definido para os usuarios do grupo a ser removido

                    $usuarios = $this->db->get_where( "we_cliente_contato", array( "cod_cliente_grupo" => $object_id ) )->result(); // verifica se existem usuarios no grupo

                    foreach( $usuarios as $key => $usuario ){ // para cada usuario

                        $data["cod_cliente_grupo"] = $novo_grupo_id; // define o codigo do novo grupo

                        $this->db->where('ide_cliente_contato', $usuario->ide_cliente_contato); // no usuario com o mesmo id

                        $editado = $this->db->update('we_cliente_contato', $data); // edita o usuario

                    }

                }

                $usuarios = $this->db->get_where( "we_cliente_contato", array( "cod_cliente_grupo" => $object_id ) ); // verifica se existem usuarios no grupo

                if( $usuarios->num_rows() == 0 ){

                    $this->db->where('cod_cliente_grupo', $object_id); // remove as permissoes do grupo do banco
                    $destruido = $this->db->delete('we_permissao_grupo'); // remove do banco

                    $this->db->where('ide_cliente_grupo', $object_id); // remove o grupo do banco
                    $destruido = $this->db->delete('we_cliente_grupo'); // remove do banco

                    $res = array( // define a resposta
                        "sucesso" => true // define como bem sucedida
                        , "msg" => "Grupo removido." // insere mensagem de sucesso
                    );

                } else {

                    $res = array( // define a respota
                        "sucesso" => false // define como falha
                        , "msg" => "O Grupo possui usuarios. Antes de removê-lo, mova os usuarios para outro grupo." // insere a resposta de sucesso
                    );

                }

            } else { // se tiver tentando excluir o Grupo Padrão

                $res = array( // define a resposta
                    "sucesso" => false // define como erro
                    , "msg" => "O Grupo Padrão não pode ser removido." // insere uma mensagem de erro
                );

            }


        } else{

            $res = array( // define a resposta
                "sucesso" => false // define como erro
                , "msg" => "O grupo não existe ou não pertence a você." // insere uma mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

}
