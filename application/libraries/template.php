<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Codeigniter Template Class
*
* This class enables the use of templates
*
* @author    Bruno da Silva João
* @link      http://github.com/vinagreti
*/

class Template
{

    public function __construct()
    {
        $this->CI =& get_instance(); // gets the Codeigniter Controller instance
    }

    /**
    * load
    * This method reder the dynamic content within the templateType
    *
    * $templateType                 The templateType to be shown
    * $view                     The dynamic content to be added to the templateType
    * $arquivos_js = array()    The dynamic Javascript to be loaded
    * $arquivos_css = array()   The dynamic Cascading Style Sheets to be loaded
    * $data = false             The data to be used loading the dynamic html
    */

    public function load( $templateType, $view, $arquivos_js = array(), $arquivos_css = array(), $data = false ){ // render the page

        $template_data["conteudo"] = $this->CI->load->view( $view, $data, true ); // loads the dynamic html

        $template_data["arquivos_css"] = $arquivos_css; // loads the dynamic css

        $template_data["arquivos_js"] = $arquivos_js; // loads the dynamic css

        $this->CI->load->view("templates/$templateType", $template_data); // renderize the content within the template

    }

}