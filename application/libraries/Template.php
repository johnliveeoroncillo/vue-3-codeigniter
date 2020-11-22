<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template {

    private $CI;	

    var $assets_loc = 'assets';
    var $css_loc = 'css';
    var $js_loc = 'js';
    var $img_loc = 'img';
    var $template_data = array();

    public function __construct() {
        $this->CI =& get_instance();
    }

    function set($content_area, $value) {
        $this->template_data[$content_area] = $value;
    }

    function load($view = '', $view_data = array(), $return = false) {
        $this->set('site_title', site_title);
        $this->set('page_content', $this->CI->load->view($view, $view_data, TRUE));
        $this->set('createCSS', $this->initCSS());
        $this->set('createJS', $this->initJS());

        $this->CI->parser->parse('template/view_main_holder', $this->template_data);
    }

    function initCSS() {
        return $this->CI->load->view('template/view_header', '', true);
    }

    function initJS() {
        return $this->CI->load->view('template/view_footer', '', true);
    }
}

