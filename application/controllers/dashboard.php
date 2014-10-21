<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function index() // pagina inicial do sistema
    {

        // carrega os models
        $this->load->model("usuarios_model");
        $this->load->model("grupos_model");
        $this->load->model("vinculados_model");
        $this->load->model("canais_model");
        $this->load->model("posts_model");
        $this->load->model("denuncias_model");

        // Total de usuários
        $data['totalUsuarios'] = $this->usuarios_model->carregarResumo(null, null, null, null, true);

        // Total de grupos de usuários
        $data['totalGrupos'] = $this->grupos_model->carregarResumo(null, null, null, null, true);

        // Total de Repórteres cidadãos
        $data['totalVinculados'] = $this->vinculados_model->carregarResumo(null, null, null, null, true);

        // Total de Canais
        $data['totalCanais'] = $this->canais_model->carregarResumo(null, null, null, null, true);

        // Total de Posts
        $data['totalPosts'] = $this->posts_model->carregarResumo(null, null, null, null, true);

        // Total de Denúncias
        $data['totalDenuncias'] = $this->denuncias_model->carregarResumo(null, null, null, null, true);

        // pega dados desde o ultimo login no sistema
        $params['data_inicial'] = $this->session->userdata("ultimo_login");

        // Total de Repórteres cidadãos dasde o ultimo login
        $data['totalVinculadosUltimoLogin'] = $this->vinculados_model->carregarResumo($params, null, null, null, true);

        // Total de Posts dasde o ultimo login
        $data['totalPostsUltimoLogin'] = $this->posts_model->carregarResumo($params, null, null, null, true);

        // Total de Denúncias dasde o ultimo login
        $data['totalDenunciasUltimoLogin'] = $this->denuncias_model->carregarResumo($params, null, null, null, true);

        $arquivos_js = array(
            'js/library/chart'
            , 'js/event/we_dashboard_event'
            , 'js/controller/we_dashboard_controller'
            , 'js/model/we_dashboard_model'
            , 'js/view/we_dashboard_view');

        $this->template->load('private', 'dashboard/index', $arquivos_js, null, $data); // carrega a pagina inicial

    }

}