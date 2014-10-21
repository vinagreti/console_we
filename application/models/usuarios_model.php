<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_Model extends CI_Model {

    public function carregarResumo( $params = false, $pagina = false, $por_pagina = false, $retornarTotal = false, $contar = false ){ // retorna um resumo dos usuários

        if( isset($params["grupo_id"]) ) // se for definido o parametro grupo_id
            $this->db->where("cod_cliente_grupo", $params["grupo_id"]); // somente usuarios do mesmo grupo

        $this->db->select('dsc_email as email'); // humaniza e/ou define um alias
        $this->db->select('num_telefone_principal as telefone1'); // humaniza e/ou define um alias
        $this->db->select('num_telefone_secundario as telefone2'); // humaniza e/ou define um alias
        $this->db->select('nom_cargo as cargo'); // humaniza e/ou define um alias
        $this->db->select("REPLACE( REPLACE(flg_administrador, 'S', 'Sim') , 'N', 'Não') as admin", FALSE); // humaniza e/ou define um alias
        $this->db->select('ide_cliente_contato as id'); // humaniza e/ou define um alias
        $this->db->select('nom_contato as nome'); // humaniza e/ou define um alias
        $this->db->select('nom_grupo as grupo'); // humaniza e/ou define um alias
        $this->db->where("we_cliente_grupo.cod_cliente", $this->session->userdata("ide_cliente")); // onde o cliente for o mesmo que o cliente em uso
        $this->db->join('we_cliente_grupo', 'we_cliente_grupo.ide_cliente_grupo = we_cliente_contato.cod_cliente_grupo'); // junta a tabela we_cliente_grupo
        $this->db->order_by("nom_contato", "asc"); // ordenando pelo nome

        $this->db->from('we_cliente_contato'); // consulta a tabela we_cliente_contato e insere a resposta na variavle resumo

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

    public function adicionar( $params ){ // adiciona um uauario

        if( ! isset($params["nome"] ) || strlen($params["nome"]) < 6 ) // se o parametro nome tiver menos de 6 caracteres
            return array( "sucesso" => false, "msg" => "O nome deve ter no mínimo 6 caracteres."); // retorna erro

        if( isset( $params["email"] ) && $params["email"] != "" && preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $params["email"]) ){ // verifica se o email foi definido

            $this->db->where( "dsc_email", $params["email"] ); // onde o email for igual ao email passado
            $usuario = $this->db->get("we_cliente_contato")->result(); // consulta a tabela e insere o resultado na variavel usuario

            if( count($usuario) == 0 ){ // se ja houver usuario com o email passado

                $data = array( // define um novo objeto usuario
                    'nom_contato' => $params["nome"] // define o nome
                    , 'cod_cliente' => $this->session->userdata("ide_cliente") // onde o cliente for o mesmo que o cliente em uso
                    , 'cod_cliente_grupo' => $params["grupo"] // define o grupo
                    , 'dsc_email' => $params["email"] // define o email
                    , 'dsc_senha' => md5( time() ) // define a nova senha
                    , 'num_telefone_principal' => $params["telefone1"] // define o telefone
                    , 'num_telefone_secundario' => $params["telefone2"] // define o segunod telefone
                    , 'nom_cargo' => $params["cargo"] // define o cargo
                    , 'flg_administrador' => $params["admin"] // define se é administrador
                );

                $save = $this->db->insert('we_cliente_contato', $data); // salva o novo usuario

                if( $save ){ // se for salvo com sucesso

                    $usuario = $this->find( $this->db->insert_id() ); // busca o novo usuario na tabela

                    $token = md5(uniqid()); // gera um novo token

                    $data = array( // configura os dados para adiconar o token no banco
                        'dsc_token' => $token // define o token
                        , 'cod_cliente_contato' => $usuario[0]->id // define o id do contato
                        , 'dat_criacao' => date( 'Y-m-d H:i:s' ) // define a data de criacao
                        , 'dat_vencimento' => date( 'Y-m-d H:i:s', strtotime("+1 day") ) // define a data de vencimento
                    );

                    $this->db->insert('we_reset_senha_token', $data); // adiciona o token no banco

                    $mensagem = "Olá " . $usuario[0]->nome . ","; // define a mensagem do e-mail de nov usuario criado
                    $mensagem .= "\r\n<p> Seja bem vindo ao <strong>Console ".$this->session->userdata("nom_cliente")."</strong>.</p>";
                    $mensagem .= "\r\n<p> Antes de utilizar o console, por favor, crie uma nova senha através do link abaixo:</p>";
                    $mensagem .= "\r\n<p><a href='" . base_url() . "alterarSenha/?token=$token'>" . base_url() . "alterarSenha/?token=$token</a>.</p>";
                    $mensagem .= "\r\n<p> Atenciosamente,</p>";
                    $mensagem .= "\r\n<p> We Crowdcasting</p>";

                    $this->load->library('email'); // carrega a biblioteca email
                    $this->email->from('no-reply@wecrowdcasting.com', "Console " . $this->session->userdata("nom_cliente") ); // define o(s) remetente(S)
                    $this->email->to( $params["email"] );  // define o(s) destinatário(s)
                    $this->email->subject('Usuário adicionado'); // define o assunto
                    $this->email->message( $mensagem );  // insere a mensagem
                    $this->email->send(); // envia o email

                    $res = array( // define a resposta
                        "sucesso" => true // define como sucesso
                        , "usuario" => $usuario[0] // define a mensagem de sucesso
                        , "msg" => "Usuario adicionado" // define a mensagem de erro
                    );

                } else {

                    $res = array( // define a resposta
                        "sucesso" => false // define como falha
                        , "msg" => "Erro ao criar usuário. Tente novamente mais tarde." // define a mensagem de erro
                    );

                }

            } else {

                $res = array( // define a resposta
                    "sucesso" => false // define como falha
                    , "msg" => "O e-mail <strong>" . $params["email"] . "</strong> já está sendo utilizado." // define a mensagem de erro
                );

            }


        } else {

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "Informe um e-mail válido." // define a mensagem de erro
            );

        }



        return $res; // retorna a resposta

    }

    public function find( $user_id ){ // encontra um usuario pelo seu id

        $this->db->select('dsc_email as email'); // humaniza e/ou define um alias
        $this->db->select('num_telefone_principal as telefone1'); // humaniza e/ou define um alias
        $this->db->select('num_telefone_secundario as telefone2'); // humaniza e/ou define um alias
        $this->db->select('nom_cargo as cargo'); // humaniza e/ou define um alias
        $this->db->select("REPLACE( REPLACE(flg_administrador, 'S', 'Sim') , 'N', 'Não') as admin", FALSE); // humaniza e/ou define um alias
        $this->db->select('ide_cliente_contato as id'); // humaniza e/ou define um alias
        $this->db->select('nom_contato as nome'); // humaniza e/ou define um alias
        $this->db->select('nom_grupo as grupo'); // humaniza e/ou define um alias
        $this->db->where( "ide_cliente_contato", $user_id );
        $this->db->where( "we_cliente_contato.cod_cliente", $this->session->userdata("ide_cliente") ); // onde o cliente for o mesmo que o cliente em uso
        $this->db->join('we_cliente_grupo', 'we_cliente_grupo.ide_cliente_grupo = we_cliente_contato.cod_cliente_grupo'); // junta a tabela we_cliente_grupo

        return $this->db->get("we_cliente_contato")->result(); // consulta e retorna o resultado

    }

    public function carrega( $user_id ){ // carrega completamente um usuario pelo seu id

        $this->db->select('dsc_email as email'); // humaniza e/ou define um alias
        $this->db->select('num_telefone_principal as telefone1'); // humaniza e/ou define um alias
        $this->db->select('num_telefone_secundario as telefone2'); // humaniza e/ou define um alias
        $this->db->select('nom_cargo as cargo'); // humaniza e/ou define um alias
        $this->db->select('flg_administrador as admin'); // humaniza e/ou define um alias
        $this->db->select('ide_cliente_contato as id'); // humaniza e/ou define um alias
        $this->db->select('nom_contato as nome'); // humaniza e/ou define um alias
        $this->db->select('nom_grupo as grupo'); // humaniza e/ou define um alias
        $this->db->select('cod_cliente_grupo as grupo_id'); // humaniza e/ou define um alias
        $this->db->where( "ide_cliente_contato", $user_id );
        $this->db->where( "we_cliente_contato.cod_cliente", $this->session->userdata("ide_cliente") ); // onde o cliente for o mesmo que o cliente em uso
        $this->db->join('we_cliente_grupo', 'we_cliente_grupo.ide_cliente_grupo = we_cliente_contato.cod_cliente_grupo'); // junta a tabela we_cliente_grupo

        $usuario = $this->db->get("we_cliente_contato")->row(); // consulta a tabela e insere a resposta na variavel usuario

        if( $usuario ){

            $res = array( // define a resposta
                "sucesso" => true // define como sucesso
                , "usuario" => $usuario // insere o usuario
                , "msg" => "OK" // define uma mensagem de sucesso
            );

        } else {

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "O usuário não existe ou nao pertence a você." // define uma mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

    public function remover( $params ){ // remove um uauario do banco

        $usuarios = $this->find($params["id"]); // seleciona o usuario no banco

        if( isset($usuarios[0]) ){ // verifica se o usuario existe

            if( $usuarios[0]->id  != $this->session->userdata("ide_cliente_contato") ){ // verifica se não está tentando excluir a si mesmo

                $this->db->where('ide_cliente_contato', $params["id"]); // remove o usuario do banco
                $this->db->where( "cod_cliente", $this->session->userdata("ide_cliente") ); // onde o cliente for o mesmo que o cliente em uso
                $destruido = $this->db->delete('we_cliente_contato');

                $res = array( // respota da remoção do usuario bem sucedida // define a resposta
                    "sucesso" => true // define como sucesso
                    , "msg" => "Usuario removido." // define uma mensagem de sucesso
                );

            } else{

                $res = array( // se estiver tentando excluir a si mesmo // define a resposta
                    "sucesso" => false // define como falha
                    , "msg" => "Você não pode excluir a si mesmo."  // define uma mensagem de erro
                );

            }

        } else{

            $res = array( // respota da remoção do usuario mal sucedida // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "O usuário não existe ou não pertence a você." // define uma mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

    public function editar( $params ){ // edita um usuario no banco

        if( ! isset($params["nome"] ) || strlen($params["nome"]) < 6 ) // se o nome conter menos de 6 caracteres
            return array( "sucesso" => false, "msg" => "O nome deve ter no mínimo 6 caracteres."); // retorna erro

        if( isset( $params["email"] ) && $params["email"] != "" && preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $params["email"]) ){ // verifica se o email foi definido

            $this->db->where( "dsc_email", $params["email"] ); // onde o email for igual ao informado
            $usuario = $this->db->get("we_cliente_contato")->row(); // consulta a tabela e insere a resposta na variavel usuario

            if( $usuario || $params["id"] == $usuario->ide_cliente_contato ){ // se o e-mail nao pertence a outro usuario do mesmo cliente

                 $data = array(); // define a variavel data como um array

                if( isset( $params["nome"] ) ) // de foi passado o nome
                    $data["nom_contato"] = $params["nome"]; // define o nome

                if( isset( $params["grupo"] ) ) // se foi passado o grupo
                    $data["cod_cliente_grupo"] = $params["grupo"]; // define o grupo

                if( isset( $params["email"] ) ) // se foi passado o email
                    $data["dsc_email"] = $params["email"]; // defineo email

                if( isset( $params["telefone1"] ) ) // se foi passado o telefone1
                    $data["num_telefone_principal"] = $params["telefone1"]; // define o telefone1

                if( isset( $params["telefone2"] ) ) // se foi passado o telefone2
                    $data["num_telefone_secundario"] = $params["telefone2"]; // define o telefone2

                if( isset( $params["cargo"] ) ) // se foi passado o cargo
                    $data["nom_cargo"] = $params["cargo"]; // define o cargo

                if( isset( $params["admin"] ) ) // se foi passado o admin
                    $data["flg_administrador"] = $params["admin"]; // define o admin


                $this->db->where('ide_cliente_contato', $params["id"]); // onde oid for igual ao passado

                $update = $this->db->update('we_cliente_contato', $data); // atualiza no banco

                if( $update ){ // se a atualização foi bem sucedida

                    $usuario = $this->find( $params["id"] ); // carrega o novo usuario

                    $res = array( // define a resposta
                        "sucesso" => true // define como sucesso
                        , "msg" => "Usuario editado"  // define uma mensagem de sucesso
                        , "usuario" => $usuario // insere o usuario
                    );

                } else {

                    $res = array( // define a resposta
                        "sucesso" => false // define como falha
                        , "msg" => "O usuário não existe ou nao pertence a você." // define uma mensagem de erro
                    );

                }

            } else {

                $res = array( // define a resposta
                    "sucesso" => false // define como falha
                    , "msg" => "O e-mail <strong>" . $params["email"] . "</strong> já está sendo utilizado." // define uma mensagem de erro
                );

            }


        } else {

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "Informe um e-mail válido." // define uma mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

}