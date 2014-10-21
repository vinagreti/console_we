<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Denuncias_Model extends CI_Model {

    public function carregarResumo( $params = false, $pagina = false, $por_pagina = false, $retornarTotal = false, $contar = false ){

        if( $params ){

            if( isset( $params["denuncia_id"] ) && $params["denuncia_id"] != "" )
                $this->db->where("ide_post_denuncia", $params["denuncia_id"]);

            if( isset( $params["post_id"] ) && $params["post_id"] != "" )
                $this->db->where("we_post.ide_post", $params["post_id"]);

            if( isset( $params["texto"] ) && $params["texto"] != "" )
                $this->db->like("we_post.dsc_texto_post", $params["texto"]);

            if( isset( $params["data_inicial"] ) && $params["data_inicial"] != "" )
                $this->db->where( "dat_denuncia >=", date("Y-m-d 00:00:01", strtotime($params["data_inicial"])) );

            if( isset( $params["data_final"] ) && $params["data_final"] != "" )
                $this->db->where( "dat_denuncia <=", date("Y-m-d 24:59:59", strtotime($params["data_final"])) );

            if( isset( $params["evento"] ) && $params["evento"] != "" )
                $this->db->like("we_evento.nom_evento", $params["evento"]);

            if( isset( $params["vinculado"] ) && $params["vinculado"] != "" )
                $this->db->where("CONCAT(we_usuario.nom_usuario, ' ', we_usuario.dsc_sobrenome) LIKE '%".$params["vinculado"]."%'", NULL, FALSE);

            if( isset( $params["categoria"] ) && $params["categoria"] != "" )
                $this->db->like("nom_categoria_denuncia", $params["categoria"]);

        }

        $this->db->select('ide_post_denuncia as id, nom_categoria_denuncia as categoria, nom_evento as evento');
        $this->db->select("SUBSTRING(we_post_denuncia.dsc_observacoes, 1, 40) as texto", FALSE);
        $this->db->select('CONCAT(we_usuario.nom_usuario, " ", we_usuario.dsc_sobrenome) as vinculado', FALSE);
        $this->db->select("SUBSTRING(we_post.dsc_texto_post, 1, 40) as post", FALSE);
        $this->db->select("DATE_FORMAT(dat_denuncia, '%d-%m-%Y %H:%i') as data", FALSE);
        $this->db->join('we_post', 'we_post.ide_post = we_post_denuncia.cod_post');
        $this->db->join('we_evento', 'we_evento.ide_evento = we_post.cod_evento');
        $this->db->join('we_canal', 'we_canal.ide_canal = we_evento.cod_canal');
        $this->db->join('we_cliente', 'we_cliente.ide_cliente = we_canal.cod_cliente');
        $this->db->join('we_categoria_denuncia', 'we_categoria_denuncia.ide_categoria_denuncia  = we_post_denuncia.cod_categoria_denuncia');
        $this->db->join('we_usuario', 'we_usuario.ide_usuario = we_post_denuncia.cod_usuario_denunciante');
        $this->db->where("we_cliente.ide_cliente", $this->session->userdata("ide_cliente"));
        $this->db->order_by("dat_denuncia", "asc");
        $this->db->from('we_post_denuncia ');

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

        return $res;

    }

    public function carregar( $id ){

        $this->db->where('we_post_denuncia.ide_post_denuncia', $id);
        $this->db->where("we_cliente.ide_cliente", $this->session->userdata("ide_cliente"));
        $this->db->select('we_post_denuncia.ide_post_denuncia as id');
        $this->db->select('we_post_denuncia.cod_post as cod_post');
        $this->db->select('we_post_denuncia.dsc_observacoes as texto');
        $this->db->select('we_categoria_denuncia.nom_categoria_denuncia as categoria');
        $this->db->select('CONCAT(we_usuario.nom_usuario, " ", we_usuario.dsc_sobrenome) as vinculado', FALSE);
        $this->db->select("DATE_FORMAT(we_post_denuncia.dat_denuncia, '%d-%m-%Y %H:%i') as data", FALSE);
        $this->db->select('CONCAT("http://", we_usuario.dsc_url_arq_avatar, "/uploads/avatars/", we_usuario.nom_arq_avatar) as usuario_avatar', FALSE); // humaniza avatar
        $this->db->join('we_post', 'we_post.ide_post = we_post_denuncia.cod_post');
        $this->db->join('we_evento', 'we_evento.ide_evento = we_post.cod_evento');
        $this->db->join('we_canal', 'we_canal.ide_canal = we_evento.cod_canal');
        $this->db->join('we_cliente', 'we_cliente.ide_cliente = we_canal.cod_cliente');
        $this->db->join('we_categoria_denuncia', 'we_categoria_denuncia.ide_categoria_denuncia  = we_post_denuncia.cod_categoria_denuncia');
        $this->db->join('we_usuario', 'we_usuario.ide_usuario = we_post_denuncia.cod_usuario_denunciante');

        $this->db->order_by("dat_denuncia", "asc");

        $denuncia = $this->db->get('we_post_denuncia ')->result();

        if( count($denuncia) > 0 ){

            $this->load->model("posts_model");
            $post = $this->posts_model->carregar($denuncia[0]->cod_post);

            if( $post["sucesso"] ){

                $res = array(
                    "sucesso" => true
                    , "denuncia" => $denuncia[0]
                    , "post" => $post["post"]
                );

            } else {

                $res = array(
                    "sucesso" => false
                    , "msg" => "O post não existe ou não pertence a você."
                );

            }


        } else {

            $res = array(
                "sucesso" => false
                , "msg" => "A denúncia não existe ou não pertence a você."
            );

        }

        return $res;

    }

    public function dailyResume( $startDate = null, $endDate = null ){

        $endDate = $endDate ? new DateTime($endDate) : new DateTime();

        $endDateClone = clone $endDate;

        $startDate =  $startDate ? new DateTime($startDate) : $endDateClone->sub(new DateInterval('P1M'));

        $this->db->select("DATE_FORMAT(we_post_denuncia.dat_denuncia, '%d-%m-%Y') as cadastro", FALSE);
        $this->db->from('we_post_denuncia');
        $this->db->join('we_post', 'we_post.ide_post = we_post_denuncia.cod_post');
        $this->db->join('we_evento', 'we_evento.ide_evento = we_post.cod_evento'); // junta a tabela we_evento
        $this->db->join('we_canal', 'we_canal.ide_canal = we_evento.cod_canal'); // junta a tabela we_canal
        $this->db->join('we_cliente', 'we_cliente.ide_cliente = we_canal.cod_cliente'); // junta a tabela we_cliente
        $this->db->where('we_post_denuncia.dat_denuncia >=', date_format($startDate, 'Y-m-d H:i:s'));
        $this->db->where('we_post_denuncia.dat_denuncia <=', date_format($endDate, 'Y-m-d H:i:s'));
        $this->db->order_by("we_post_denuncia.dat_denuncia");
        $this->db->where( "we_cliente.ide_cliente", $this->session->userdata("ide_cliente") ); // onde o cliente for o mesmo que o cliente em uso

        $raw_data = $this->db->get()->result(); // insere o resultado na variavel resumo

        $resumo = array();

        foreach( $raw_data as $index => $denuncias ){

            isset( $resumo[ $denuncias->cadastro ] ) ? $resumo[ $denuncias->cadastro ]++ : $resumo[ $denuncias->cadastro ] = 1;

        }

        return $resumo;

    }
}