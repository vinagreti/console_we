<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seguranca_Model extends CI_Model {

    public function autentica( $params ){ // autentica o usuario

        if( isset( $params["email"] ) && $params["email"] != "" && isset( $params["senha"] ) && $params["senha"] != "" ){ // se foram passados o email e senha

            $this->db->select("ide_cliente_contato, dat_ultimo_login");   // humaniza e/ou define alias

            $this->db->select("DATE_FORMAT(we_cliente_contato.dat_ultimo_login, '%d-%m-%Y %H:%i:%s') as data", FALSE);   // humaniza e/ou define alias

            $this->db->where( "dsc_email", $params["email"] ); // onde o email for igual ao passado

            $this->db->where( "dsc_senha", md5( $params["senha"] ) ); // onde a senha for igual ao md5 da senha passada

            $this->db->join('we_cliente', 'we_cliente.ide_cliente = we_cliente_contato.cod_cliente'); // junta a tabela cliente

            $usuario = $this->db->get("we_cliente_contato")->row(); // consulta e retorna o resultado na variavel usuario

            if( $usuario ){ // se retornar um usuario

                $this->db->where("ide_cliente_contato", $usuario->ide_cliente_contato); // onde o id do usuario for igual ao da
                $this->db->set("dat_ultimo_login", "now()", false);
                $this->db->update( 'we_cliente_contato' );

                $this->session->set_userdata("logged", true); // define o usuario como logado na sessão

                $this->session->set_userdata("ide_cliente_contato", $usuario->ide_cliente_contato); // define o id do cliente na sessao

                $this->session->set_userdata("ultimo_login_br", $usuario->data);

                $this->session->set_userdata("ultimo_login", $usuario->dat_ultimo_login);

                $res = array( // define a resposta
                    "sucesso" => true // define como sucesso
                    , "usuario" => $usuario // insere o usuario
                    , "msg" => "OK" // insere uma mensagem de sucesso
                );

            } else { // se não retornar nenhum usuario

                $res = array( // define a resposta
                    "sucesso" => false // define como falha
                    , "msg" => "E-mail e senha não conferem." // insere uma mensagem de erro
                );

            }

        } else { // se não for passado o nome ou senha

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "Informe o email e senha para eftuar login." // insere uma mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

    public function recuperarSenha( $params ){ // envia uma senha para o email informado

        if( isset( $params["email"] ) && $params["email"] != "" ){ // se foi informado um email

            $this->db->where( "dsc_email", $params["email"] ); // onde o email for igual ao informado

            $usuario = $this->db->get("we_cliente_contato")->row(); // consulta o banco e insere o usuario na variavel usuario

            if( $usuario ){ // se retornar um usuario

                $this->db->where("dat_utilizacao", "0000-00-00 00:00:00"); // onde os tokens forem antigos ou nao utilizados
                $this->db->where("cod_cliente_contato", $usuario->ide_cliente_contato); // onde o id do cliente seja o esmo do cliente em uso
                $update = $this->db->update( 'we_reset_senha_token', array("dat_utilizacao" => date( 'Y-m-d H:i:s' ) ) ); // atualiza a data de utilizacao de um token

                $token = md5(uniqid()); // gera os novo token

                $data = array( // configura os dados para adiconar o novo  token no banco
                    'dsc_token' => $token // define o token
                    , 'cod_cliente_contato' => $usuario->ide_cliente_contato // define o usuario que deseja alterar a senha
                    , 'dat_criacao' => date( 'Y-m-d H:i:s' ) // define a data de criacao do token
                    , 'dat_vencimento' => date( 'Y-m-d H:i:s', strtotime("+1 day") ) // define a data de vencimento do token
                );

                $this->db->insert('we_reset_senha_token', $data); // adiciona o token no banco

                // define uma mensagem de email
                $mensagem = "Olá " . $usuario->nom_contato . ","; // define o nome do usuario
                $mensagem .= "\r\n<p> Recebemos uma solicitação de alteração de senha.</p>";
                $mensagem .= "\r\n<p> Caso tenha solicitado a alteração, clique no link abaixo para criar uma nova senha:</p>";
                $mensagem .= "\r\n<p>" . base_url() . "alterarSenha/?token=$token.</p>";
                $mensagem .= "\r\n<p> Caso não tenha solicitado a alteração, apenas ignore este e-mail.</p>";
                $mensagem .= "\r\n<p> Atenciosamente,</p>";
                $mensagem .= "\r\n<p> We Crowdcasting</p>";

                $this->load->library('email'); // carrega a biblioteca email
                $this->email->from('no-reply@wecrowdcasting.com', 'Console WE Crowdcasting'); // define o(s) remetente(S)
                $this->email->to( $params["email"] );  // define o(s) destinatario(S)
                $this->email->subject('Recuperação de senha'); // define o assunto
                $this->email->message( $mensagem );  // insere a mensagem
                $this->email->send(); // envia o email

                $res = array( // define a resposta
                    "sucesso" => true // define como sucesso
                    , "msg" => "Um link de recuperacao de senha foi enviado para o email <strong>". $params["email"] ."</strong>. Você tem até 24 horas pára utilizá-lo." // insere uma mensagem de sucesso
                );

            } else { // se naõ retornar nenhum usuário

                $res = array( // define a resposta
                    "sucesso" => false // define como falha
                    , "msg" => "O e-mail ".$params["email"]." não está cadastrado." // insere uma mensagem de erro
                );

            }

        } else {

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "Informe seu email para recuperar sua senha." // insere uma mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

    public function alterarSenha( $params ){ // altera a senha do usuario

        if( $params["senha1"] == $params["senha2"] ){ // verifica se as senhas conferem

            if( isset($_GET["token"]) ){ // se foi fornecido um token

                $token_exist_res = $this->verificaValidadeAlterarSenhaToken( $_GET["token"] ); // verifica se o token é valido

                if( $token_exist_res["sucesso"] ){ // se o token for válido

                    $this->db->where("ide_reset_senha_token", $token_exist_res["token"]->ide_reset_senha_token); // atualiza a data deutilização do token
                    $update = $this->db->update( 'we_reset_senha_token', array("dat_utilizacao" => date( 'Y-m-d H:i:s' ) ) );

                    $this->db->where("ide_cliente_contato", $token_exist_res["token"]->cod_cliente_contato); // altera a senha do usuário
                    $this->db->update( 'we_cliente_contato', array("dsc_senha" => md5( $params["senha1"] ) ) );

                    $this->session->sess_destroy(); // destroi a sessão atual

                    $res = array( // define a resposta
                        "sucesso" => true // define como sucesso
                        , "msg" => "Senha alterada com sucesso." // insere uma mensagem de sucesso
                    );

                } else { // se o token for inválido

                    $res = $token_exist_res; // seta a repsota com a mensagem de erro

                }

            } else if ( $this->session->userdata("logged") ) { // ou se o usuário estiver logado

                $this->db->where("ide_cliente_contato", $this->session->userdata("ide_cliente_contato")); // onde o id do usuario for igual ao da sessao
                $this->db->update( 'we_cliente_contato', array("dsc_senha" => md5( $params["senha1"] ) ) ); // atualiza a senha

                $res = array( // define a resposta
                    "sucesso" => true // define como sucesso
                    , "msg" => "Senha alterada com sucesso." // insere uma mensagem de sucesso
                );

            }

        } else { // se as senhas forem diferentes

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "A nova senha e a confirmação da nova senha devem ser iguais." // insere uma mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

    public function verificaValidadeAlterarSenhaToken( $token ){ // verifica a validade de um token

        $this->db->where( "dsc_token", $token ); // onde houver o token
        $token = $this->db->get("we_reset_senha_token")->row(); // consulta o banco e insere a resposta na variavel token

        if( $token ){ // verifica se o token existe

            if( $token->dat_utilizacao == "0000-00-00 00:00:00" ){ // se o token ja foi utilizado ou outro foi criado

                if( $token->dat_vencimento >= date( 'Y-m-d H:i:s' ) ){ // se a validade do token é posterior a data atual

                    $res = array( // define a resposta
                        "sucesso" => true // define como sucesso
                        , "token" => $token // insere o token
                    );

                } else { // se a validade do token não é posterior a data atual

                    $res = array( // define a resposta
                        "sucesso" => false // define como falha
                        , "msg" => "O token de recuperação de senha está vencido. Por favor, solicite novamente a recuperação de senha." // insere uma mensagem de erro
                    );

                }

            } else {

                $res = array( // define a resposta
                    "sucesso" => false // define como falha
                    , "msg" => "O token já foi utilizado ou outro token de recuperação de senha foi gerado." // insere uma mensagem de erro
                );

            }

        } else { // se o token ainda não foi utilizado ou se não foi criado outro

            $res = array( // define a resposta
                "sucesso" => false // define como falha
                , "msg" => "O token não existe." // insere uma mensagem de erro
            );

        }

        return $res; // retorna a resposta

    }

    public function atualizaSessaoUsuario(){ // atualiza os dados da sessao de um usuario

        $this->db->select("we_cliente_contato.cod_cliente, we_cliente.nom_cliente, we_cliente_contato.ide_cliente_contato, we_cliente_contato.nom_contato, we_cliente_contato.dsc_email,we_cliente_contato.flg_administrador, we_cliente_contato.cod_cliente_grupo");

        $this->db->where( "ide_cliente_contato", $this->session->userdata("ide_cliente_contato") ); // onde o id for igual ao id da sessao

        $this->db->join('we_cliente', 'we_cliente.ide_cliente = we_cliente_contato.cod_cliente'); // junta a tabela cliente

        $usuario = $this->db->get("we_cliente_contato")->row(); // consulta o banco e insere o resultado na variavel usuario

        $permissao = $this->db->get_where("we_permissao_grupo", array( "cod_cliente_grupo" => $usuario->cod_cliente_grupo ) )->result(); // retorna as permissoes do usuario e insere na  variavel permissao

        $modulos = array(); // define a variavel modulos como um array

        if( count($permissao) > 0 ){ // se houver algum modulo permitido

            foreach( $permissao as $key => $modulo ){ // para cada modulo nas permissoes

                array_push($modulos, $modulo->cod_modulo); // insere o codigo do modulo no array modulos

            }

        }

        // atualiza as variaveis de sessao
        $this->session->set_userdata("modulos", $modulos);

        $this->session->set_userdata("ide_cliente", $usuario->cod_cliente);

        $this->session->set_userdata("nom_cliente", $usuario->nom_cliente);

        $this->session->set_userdata("nom_contato", $usuario->nom_contato);

        $this->session->set_userdata("ide_cliente_contato", $usuario->ide_cliente_contato);

        $this->session->set_userdata("dsc_email", $usuario->dsc_email);

        $this->session->set_userdata("flg_administrador", $usuario->flg_administrador);

        return true; // retorna verdadeiro

    }

}