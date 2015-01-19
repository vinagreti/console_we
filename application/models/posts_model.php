<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posts_Model extends CI_Model {

    public function carregarResumo( $params = false, $pagina = false, $por_pagina = false, $retornarTotal = false, $contar = false ){ // retorna um resumo dos posts

        if( $params ){ // se foi definido algum parametro para a busca

            if( isset( $params["post_id"] ) && $params["post_id"] != "" ){ // se foi definido o parametro post_id

                $this->db->where("ide_post", $params["post_id"]); // busca onde o post_id for igual ao passado

            } else { // se não foi definido o parametro post_id

                if( isset( $params["texto"] ) && $params["texto"] != "" ) // se foi definido o parametro texto
                    $this->db->like("dsc_texto_post", $params["texto"]); // busca onde o texto for parecido com o passado

                if( isset( $params["data_inicial"] ) && $params["data_inicial"] != "" ) // se foi definido o parametro data_inicial
                    $this->db->where( "dat_post >=", date("Y-m-d 00:00:01", strtotime($params["data_inicial"])) ); // busca onde o data_inicial for igual ao passado

                if( isset( $params["data_final"] ) && $params["data_final"] != "" ) // se foi definido o parametro data_final
                    $this->db->where( "dat_post <=", date("Y-m-d 24:59:59", strtotime($params["data_final"])) ); // busca onde o data_final for igual ao passado

                if( isset( $params["localidade"] ) && $params["localidade"] != "" ) // se foi definido o parametro localidade
                    $this->db->like("we_localidade.nom_localidade", $params["localidade"]); // busca onde o localidade for parecido com o passado

                if( isset( $params["canal"] ) && $params["canal"] != "" ) // se foi definido o parametro canal
                    $this->db->like("we_canal.nom_canal", $params["canal"]); // busca onde o canal for parecido com o passado

                if( isset( $params["evento"] ) && $params["evento"] != "" ) // se foi definido o parametro evento
                    $this->db->like("we_evento.nom_evento", $params["evento"]); // busca onde o evento for parecido com o passado

                if( isset( $params["vinculado"] ) && $params["vinculado"] != "" ) // se foi definido o parametro vinculado
                    $this->db->where("CONCAT(we_usuario.nom_usuario, ' ', we_usuario.dsc_sobrenome) LIKE '%".$params["vinculado"]."%'", NULL, FALSE); // busca onde o vinculado for igual ao passado

                if( isset( $params["status"] ) && is_string( $params["status"] ) ) { // se foi definido o parametro status
                    $this->db->where("we_post.flg_status_post", $params["status"]); // busca onde o vinculado for igual ao passado

                } else { // se nao foi definido o parametro status

                    $this->db->where_in('we_post.flg_status_post', array('NP', 'PB')); // remove os excluidos da busca

                }

                if( isset( $params["midias"] ) ){ // se foi definido o parametro midias

                    $params["midias"] = is_array($params["midias"]) ? $params["midias"] : array($params["midias"]); // garante que o parametro midia seja um array

                    $st = ""; // define st como uma string

                    if( in_array('TX', $params["midias"]) ) // se a midia texto foi definida
                        $st .= "(we_post.cod_media IS NULL"; // insere codigos nulos na busca

                    if( in_array('AU', $params["midias"]) ) // se a midia audio foi definida
                        $st .= ( $st == "" ) ? "(we_media.flg_tipo_media ='AU'" : " OR we_media.flg_tipo_media ='AU'"; // insere AU na busca

                    if( in_array('VD', $params["midias"]) ) // se a midia video foi definida
                        $st .= ( $st == "" ) ? "(we_media.flg_tipo_media ='VD'" : " OR we_media.flg_tipo_media ='VD'"; // insere VD na busca

                    if( in_array('FT', $params["midias"]) ) // se a midia foto foi definida
                       $st .= ( $st == "" ) ? "(we_media.flg_tipo_media ='FT'" : " OR we_media.flg_tipo_media ='FT'";  // insere FT na busca

                    $st .= ")"; // fecha a sctring st

                    $this->db->where($st, NULL, FALSE); // define uma clausula where string st, com personalização da query para utilizar or_where em apenas um atributo

                }

            }

        } else { // se não foi definido algum parametro para a busca

            $this->db->where_in('we_post.flg_status_post', array('NP', 'PB')); // excluis o status excluido da busca

        }

        $this->db->select("we_post.ide_post as id"); // humaniza e define alias
        $this->db->select("SUBSTRING(we_post.dsc_texto_post, 1, 50) as texto", FALSE);   // humaniza e/ou define alias
        $this->db->select("DATE_FORMAT(we_post.dat_post, '%d-%m-%Y %H:%i') as data", FALSE);   // humaniza e/ou define alias
        $this->db->select("REPLACE( REPLACE( REPLACE(we_post.flg_status_post, 'NP', 'Despublicado') , 'PB', 'Publicado'), 'EX', 'Excluido') as  status", FALSE);  // humaniza e/ou define alias
        $this->db->select("REPLACE( REPLACE(we_post.flg_api, 'NAO', 'Não') , 'SIM', 'Sim') as api", FALSE);   // humaniza e/ou define alias
        $this->db->select('CONCAT(we_usuario.nom_usuario, " ", we_usuario.dsc_sobrenome) as vinculado', FALSE);   // humaniza e/ou define alias
        $this->db->select("we_evento.nom_evento as evento");   // humaniza e/ou define alias
        $this->db->select("we_media.flg_tipo_media as tipo_midia");   // humaniza e/ou define alias
        $this->db->select("CONCAT('http://', we_media.dsc_url_servidor, REPLACE( REPLACE( REPLACE(we_media.flg_tipo_media, 'FT', '/uploads/images/') , 'VD', '/uploads/videos/') , 'AU', '/uploads/audios/'), we_media.nom_arquivo_media) as url_midia", FALSE);
        $this->db->select("we_localidade.nom_localidade as localidade");   // humaniza e/ou define alias
        $this->db->select("we_canal.nom_canal as canal");   // humaniza e/ou define alias
        $this->db->select("we_post_denuncia.ide_post_denuncia as denuncia");   // humaniza e/ou define alias
        $this->db->join('we_usuario', 'we_usuario.ide_usuario = we_post.cod_usuario'); // junta a tabela we_usuario
        $this->db->join('we_evento', 'we_evento.ide_evento = we_post.cod_evento'); // junta a tabela we_evento
        $this->db->join('we_canal', 'we_canal.ide_canal = we_evento.cod_canal'); // junta a tabela we_canal
        $this->db->join('we_cliente', 'we_cliente.ide_cliente = we_canal.cod_cliente'); // junta a tabela we_cliente
        $this->db->join('we_media', 'we_media.ide_media = we_post.cod_media', 'left'); // junta a tabela we_media
        $this->db->join('we_localidade', 'we_localidade.ide_localidade = we_evento.cod_localidade', 'left'); // junta a tabela we_localidade
        $this->db->join('we_post_denuncia', ' we_post_denuncia.cod_post = we_post.ide_post', "left"); // junta a tabela we_post_denuncia
        $this->db->where("we_cliente.ide_cliente", $this->session->userdata("ide_cliente")); // onde o cliente for o mesmo do cliente em uso
        $this->db->order_by("ide_post", "desc"); // ordena pelo id
        $this->db->from('we_post'); // busca na tabela we_post

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
                    , "msg" => "Erro ao carregar resumo dos POSTS. Tente novamente mais tarde." // insre uma mesagem de erro
                );

            }

        }

	$query_montada = "contar: " . !empty($contar) . " - query: " . $this->db->last_query();

	$query_montada = preg_replace("/\n/"," ",$query_montada);

	error_log($query_montada, 0);

        return $res; // retorna a resposta

    }

    public function find( $id ){ // encontra um post pelo seu id

        $this->db->select("we_post.ide_post as id"); // humaniza e/ou define um alia
        $this->db->select("SUBSTRING(we_post.dsc_texto_post, 1, 50) as texto", FALSE);; // humaniza e/ou define um alia
        $this->db->select("DATE_FORMAT(we_post.dat_post, '%d-%m-%Y %H:%i') as data", FALSE);; // humaniza e/ou define um alia
        $this->db->select("REPLACE( REPLACE( REPLACE(we_post.flg_status_post, 'NP', 'Despublicado') , 'PB', 'Publicado'), 'EX', 'Excluido') as status", FALSE);; // humaniza e/ou define um alia
        $this->db->select("REPLACE( REPLACE(we_post.flg_api, 'NAO', 'Não') , 'SIM', 'Sim') as api", FALSE);; // humaniza e/ou define um alia
        $this->db->select('CONCAT(we_usuario.nom_usuario, " ", we_usuario.dsc_sobrenome) as vinculado', FALSE);; // humaniza e/ou define um alia
        $this->db->select("we_evento.nom_evento as evento");; // humaniza e/ou define um alia
        $this->db->select("we_localidade.nom_localidade as localidade");; // humaniza e/ou define um alia
        $this->db->join('we_usuario', 'we_usuario.ide_usuario = we_post.cod_usuario'); // junta a tabela we_usuario
        $this->db->join('we_evento', 'we_evento.ide_evento = we_post.cod_evento'); // junta a tabela we_evento
        $this->db->join('we_canal', 'we_canal.ide_canal = we_evento.cod_canal'); // junta a tabela we_canal
        $this->db->join('we_cliente', 'we_cliente.ide_cliente = we_canal.cod_cliente'); // junta a tabela we_cliente
        $this->db->join('we_media', 'we_media.ide_media = we_post.cod_media', 'left'); // junta a tabela we_media
        $this->db->join('we_localidade', 'we_localidade.ide_localidade = we_evento.cod_localidade', 'left'); // junta a tabela we_localidade
        $this->db->where("we_cliente.ide_cliente", $this->session->userdata("ide_cliente")); // onde o cliente for o mesmo do cliente em uso
        $this->db->where("we_post.ide_post", $id); // onde o o id do post seja igual ao id passado
        $this->db->order_by("ide_post", "asc"); // ordenando pelo id
        $this->db->from('we_post'); // busca na tabela we_post
        return $this->db->get()->row(); // consulta e retorna o post

    }

    public function carregar( $id ){

        $this->db->select("we_post.ide_post as id");; // humaniza e/ou define um alia
        $this->db->select("we_post.dsc_texto_post as texto");; // humaniza e/ou define um alia
        $this->db->select("DATE_FORMAT(we_post.dat_post, '%d-%m-%Y %H:%i:%s') as data", FALSE);; // humaniza e/ou define um alia
        $this->db->select("we_post.flg_status_post as status");; // humaniza e/ou define um alia
        $this->db->select("we_post.flg_api as api");; // humaniza e/ou define um alia
        $this->db->select('CONCAT(we_usuario.nom_usuario, " ", we_usuario.dsc_sobrenome) as vinculado', FALSE);; // humaniza e/ou define um alia
        $this->db->select('CONCAT("http://", we_usuario.dsc_url_arq_avatar, "/uploads/avatars/", we_usuario.nom_arq_avatar) as usuario_avatar', FALSE); // humaniza avatar
        $this->db->select("we_evento.nom_evento as evento");; // humaniza e/ou define um alia
        $this->db->select("we_localidade.nom_localidade as localidade");; // humaniza e/ou define um alia
        $this->db->select("we_media.flg_tipo_media as tipo_midia");; // humaniza e/ou define um alia
        $this->db->select("CONCAT('http://', we_media.dsc_url_servidor, REPLACE( REPLACE( REPLACE(we_media.flg_tipo_media, 'FT', '/uploads/images/') , 'VD', '/uploads/videos/') , 'AU', '/uploads/audios/'), we_media.nom_arquivo_media) as url_midia", FALSE);
        $this->db->join('we_usuario', 'we_usuario.ide_usuario = we_post.cod_usuario'); // junta a tabela we_usuario
        $this->db->join('we_evento', 'we_evento.ide_evento = we_post.cod_evento'); // junta a tabela we_evento
        $this->db->join('we_canal', 'we_canal.ide_canal = we_evento.cod_canal'); // junta a tabela we_canal
        $this->db->join('we_cliente', 'we_cliente.ide_cliente = we_canal.cod_cliente'); // junta a tabela we_cliente
        $this->db->join('we_media', 'we_media.ide_media = we_post.cod_media', 'left'); // junta a tabela we_media
        $this->db->join('we_localidade', 'we_localidade.ide_localidade = we_evento.cod_localidade', 'left'); // junta a tabela we_localidade
        $this->db->where("we_cliente.ide_cliente", $this->session->userdata("ide_cliente")); // onde o cliente for o mesmo do cliente em uso
        $this->db->where("we_post.ide_post", $id); // onde o o id do post seja igual ao id passado
        $this->db->order_by("ide_post", "asc"); // ordenando pelo id
        $this->db->from('we_post'); // busca na tabela we_post
        $post = $this->db->get()->row(); // consulta e insere o post na variavel post

        if( $post ){ // se retornar algum post

            $res = array( // define a resposta
                "sucesso" => true // define como sucesso
                , "post" => $post // insere o post
            );

        } else { // se não renornar um post

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "O post não existe ou não pertence a você." // insere a resposta
            );

        }

        return $res; // retorna a resposta

    }

    public function editar( $params ){ // edita um post

        $data = array(); // define a variavel data como array

        if( isset( $params["status"] ) ) // se o parametro status for definido
            $data["flg_status_post"] = $params["status"]; // insere o status na o array data

        if( isset( $params["api"] ) ) // se api for definido
            $data["flg_api"] = $params["api"]; // insere api no array data

        $this->db->where( 'ide_post', $params["id"] ); // onde o id for igual ao id passado

        if( count($data) > 0 ){ // se foi definido algum parametro

            $update = $this->db->update('we_post', $data); // atualiza o post com os novos parametros

        } else { // se não foi definido nenhum parametro

            $update = true; // interpreta como editado

        }

        if( $update ){ // se foi editado com sucesso

            $res = array( // define a resposta
                "sucesso" => true // define como sucesso
                , "msg" => "Post editado" // insere uma mensagem de sucesso
                , "post" => $this->find($params["id"]) // insere o post editado
            );

        } else { // se naõ foie ditado com sucesso

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "O post não existe ou nao pertence a você." // insere uma mensagem de erro
            );

        }

        return $res; // retorna a tresposta

    }

    public function remover( $params ){ // remove um post

        $posts = $this->find($params["id"]); // seleciona o post no banco

        if( count($posts) > 0 ){ // se o post existir

            $this->db->where('ide_post', $params["id"]); // onde o id for o mesmo do id passado
            $destruido = $this->db->update('we_post', array("flg_status_post" => "EX")); // define o status como excluido

            if( $destruido ){ // se o post foi remivdo com sucesso

                $res = array( // define a resposta
                    "sucesso" => true // dfine como sucesso
                    , "msg" => "Post removido." // insere uma mensagem de sucesso
                );

            } else {

                $res = array( // define a resposta
                    "sucesso" => false // dfine como falha
                    , "msg" => "Problemas ao remover o post. Por favor, tente novamente mais tarde." // insere uma mensagem de erro
                );

            }

        } else{

            $res = array( // define a resposta
                "sucesso" => false // dfine como falha
                , "msg" => "O post não existe ou não pertence a você." // insere uma mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

    public function dailyResume( $startDate = null, $endDate = null ){

        $endDate = $endDate ? new DateTime($endDate) : new DateTime();

        $endDateClone = clone $endDate;

        $startDate =  $startDate ? new DateTime($startDate) : $endDateClone->sub(new DateInterval('P1M'));

        $this->db->select("DATE_FORMAT(we_post.dat_post, '%d-%m-%Y') as cadastro", FALSE);
        $this->db->from('we_post');
        $this->db->join('we_evento', 'we_evento.ide_evento = we_post.cod_evento'); // junta a tabela we_evento
        $this->db->join('we_canal', 'we_canal.ide_canal = we_evento.cod_canal'); // junta a tabela we_canal
        $this->db->join('we_cliente', 'we_cliente.ide_cliente = we_canal.cod_cliente'); // junta a tabela we_cliente
        $this->db->where('we_post.dat_post >=', date_format($startDate, 'Y-m-d H:i:s'));
        $this->db->where('we_post.dat_post <=', date_format($endDate, 'Y-m-d H:i:s'));
        $this->db->order_by("we_post.dat_post");
        $this->db->where( "we_cliente.ide_cliente", $this->session->userdata("ide_cliente") ); // onde o cliente for o mesmo que o cliente em uso

        $raw_data = $this->db->get()->result(); // insere o resultado na variavel resumo

        $resumo = array();

        foreach( $raw_data as $index => $usuario ){

            isset( $resumo[ $usuario->cadastro ] ) ? $resumo[ $usuario->cadastro ]++ : $resumo[ $usuario->cadastro ] = 1;

        }

        return $resumo;

    }
}
