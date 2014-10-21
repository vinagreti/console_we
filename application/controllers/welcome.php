<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function index() // carrega a pagina inicial
	{

        if( $this->session->userdata("logged") == true ) // se o usuario estiver logado
            redirect(base_url()."dashboard"); // carrega o dashboard como pagina inicial

        else // se o usuário nã estiver logado
            $this->template->load('public', 'welcome'); // carrega a pagina welcome

	}

}