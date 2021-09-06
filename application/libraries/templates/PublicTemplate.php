<?php

    if (!defined('BASEPATH')) exit('No direct script access allowed');
    /**
     * Default template
     */
    require_once 'template.php';

    /**
     * Default template implementation.
     * 
     * It is the default renderer of all the pages if any other renderer is not used.
     */
    class PublicTemplate extends Template
    {

        public function __construct()
        {
            parent::__construct();

            $this->_CI = & get_instance();
            $this->viewPath = "templates/public/";
        }

        public function render($view, array $data = array())
        {
            $this->CI->load->library('session');
            $this->CI->load->library('form_validation');
            $this->CI->load->helper('url');
            $this->CI->load->model('admin/Configuration_model');
            // $this->CI->load->library('Commonlib');

            $session_data = $this->CI->session->userdata('my_userdata');
//            p($session_data);
            $return_val = $this->CI->load->viewPartial($view, $data);

            $data['template_content'] = $return_val;
            $data['public_user_id'] = empty($session_data['public_user_id']) ? '' : $session_data['public_user_id'];
            $data['public_user_type'] = empty($session_data['public_user_type']) ? '' : $session_data['public_user_type'];
            $data['public_user_name'] = empty($session_data['public_user_name']) ? '' : $session_data['public_user_name'];
            $css_tags = $this->collectCss("public", isset($data['local_css']) ? $data['local_css'] : array());
            $data['template_css'] = implode("", $css_tags); //implode("\n", $css_tags);
            $script_tags = $this->collectJs("public", isset($data['local_js']) ? $data['local_js'] : array());

            $configuration_data = $this->CI->Configuration_model->get_web_config();

            $data['configuration_data'] = $configuration_data;
            if (isset($data['template_title']))
            {
                $data['template_title'] = $data['template_title'];
            }

            $data['template_js'] = implode("", $script_tags); //implode("\n", $script_tags);

            $session_data = check_loggedin_user('member_data');
            if (!empty($session_data))
            {
                // $header = $this->CI->load->viewPartial($this->viewPath . 'hubCentreHeader', $data);
            }
            $controller = $this->CI->router->fetch_class();
            $action = $this->CI->router->fetch_method();

            //from backend
            $data['cms_data'] = get_cms_content('about-us');
            $contact_data = $this->CI->Configuration_model->get_web_config();

            $data['contact_data'] = $contact_data;

            $data['mail_id'] = get_custom_config_item('mail_id');
            //****************
//        $header = $this->CI->load->viewPartial($this->viewPath . 'header', $data);
//            $data['template_footer'] = $this->CI->load->viewPartial($this->viewPath . 'footer', $data);

            $class = $this->CI->router->fetch_class();
            $method = $this->CI->router->fetch_method();

            $data['method'] = $method;
            //set header accd to url
            
            if ($class == 'index')
            {
                $header_class = 'class="front-page no-sidebar site-layout-full-width header-style-5 menu-has-search menu-has-cart header-sticky" ';
            }
            else if ($class == 'Articles')
            {
                $header_class = 'class=" header-style-1 menu-has-search menu-has-cart" ';
            }
            else if ($method == 'details')
//            else if ($class == 'artist' || $class == 'studio' || $class == 'user')
            {
                $header_class = 'class=" woocommerce-page shop-col-3 header-style-1 menu-has-search menu-has-cart"';
            }
            else
            {
                $header_class = 'class="page no-sidebar header-style-1 menu-has-search menu-has-cart" ';
            }

            $data['header_class'] = $header_class;
            $data['template_header'] = $this->CI->load->viewPartial($this->viewPath . 'header', $data);
            $data['template_footer'] = $this->CI->load->viewPartial($this->viewPath . 'footer', $data);

            $meta_data = $this->collect_meta_data(isset($data['local_meta_data']) ? $data['local_meta_data'] : array(), $arr_meta_data = array());
            $data['template_meta_data'] = implode("", $meta_data);


            $meta_data = $this->collect_meta_data(isset($data['local_meta_data']) ? $data['local_meta_data'] : array(), $arr_meta_data = array());
            $data['template_meta_data'] = implode("", $meta_data);

            $return_val = $this->CI->load->viewPartial($this->viewPath . $this->masterTemplate, $data);

            return $return_val;
        }

    }
    