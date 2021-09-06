<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');
    /**
     * Default template
     */
    require_once 'template.php';
    /**
     * Default template implementation.
     * 
     * It is the default renderer of all the pages if any other renderer is not used.
     */
    class LoginRegisterTemplate extends Template
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
     
            $this->CI->load->model('Language_model');
            $session_data = $this->CI->session->userdata('my_userdata');
            $session_lang = $this->_CI->session->userdata('site_lang');

            $return_val = $this->CI->load->viewPartial($view, $data);

            $data['template_content'] = $return_val;

            $user_id = empty($session_data['user_id']) ? '' : $session_data['user_id'];
            //$user_type = empty($session_data['user_type_id']) ? '' : $session_data['user_type_id'];

            $language_array = $this->_CI->Language_model->getalllanguage_array();
            $language_file_arr = get_custom_config_item('language_files_arr');
            $my_language_arr = array();
            if (!empty($language_array))
            {
                foreach ($language_array as $language)
                {

                    if (array_key_exists($language, $language_file_arr))
                    {
                        $my_language_arr[$language_file_arr[$language]] = $language;
                    }
                }
            }
            $data['language_arr'] = $my_language_arr;

            $default_language = get_custom_config_item('default_language');

            $data['current_language'] = empty($session_lang) ? $default_language : $session_lang;
            $data['user_id'] = $user_id;
            $data['user_type'] = $user_type;

            $css_tags = $this->collectCss("login_register", isset($data['local_css']) ? $data['local_css'] : array());
            $data['template_css'] = implode("", $css_tags); //implode("\n", $css_tags);
            $script_tags = $this->collectJs("login_register", isset($data['local_js']) ? $data['local_js'] : array());
            //$this->CI->session->unset_userdata('location');
            $user_data = $this->CI->session->userdata;
            // p($_SESSION);

            if (isset($data['template_title']))
            {
                $data['template_title'] = $data['template_title'];
            }
            $data['template_js'] = implode("", $script_tags); //implode("\n", $script_tags);
            $uri_segment_1 = $this->CI->uri->segment(1);
            $data['uri_segment1'] = $uri_segment_1;

            $data['template_header'] = $this->CI->load->viewPartial($this->viewPath . 'header2', $data);

            $data['template_footer'] = $this->CI->load->viewPartial($this->viewPath . 'footer2', $data);

            $return_val = $this->CI->load->viewPartial($this->viewPath . $this->masterTemplate, $data);
            return $return_val;
        }

    }
    