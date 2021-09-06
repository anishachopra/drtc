<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');
    /**
     * Base Template class
     */

    /**
     * Base Template class for other Template's comfort
     */
    abstract class Template
    {

        const DS = DIRECTORY_SEPARATOR;

        //Path of the views within the Template folder
        protected $viewPath;
        //Holder for CI instance
        //We may need to use the CI library
        protected $CI;
        //Default Name of the the master template file
        protected $masterTemplate = 'master';
        //Default template name
        protected $template = 'admin';

        public function __construct()
        {
            $this->CI = & get_instance();
            $this->viewPath = 'templates' . self::DS . $this->template . self::DS;
        }

        /**
         * Abstract functio that all child classes must implement
         * 
         * @param string $view
         * @param array $data
         * @param boolean $return
         */
        abstract public function render($view, array $data = array());

        /**
         * Build an array of all the require css files as defined in
         * static_config.php and provided by the action in $data['local_css']
         * 
         * @param array $local_css
         * @return multitype:string
         */
        public function collectCss($modulename, $local_css = array())
        {
            if ($modulename == "public")
            {
                $css_arr = array_values($this->CI->config->item('public_default_css'));
            }
            elseif ($modulename == "admin")
            {
                $css_arr = array_values($this->CI->config->item('admin_default_css'));
            }
            elseif ($modulename == "login_register")
            {
                $css_arr = array_values($this->CI->config->item('login_register_css'));
            }
            else
            {
                $css_arr = array_values($this->CI->config->item('default_css'));
            }

            $config_css = $this->CI->config->item('css_arr');

            if (!empty($local_css) && is_array($local_css))
            {
                foreach ($local_css as $css_file)
                {
                    if (isset($config_css[$css_file]))
                    {
                        $css_arr[] = $config_css[$css_file];
                    }
                }
            }

            $css = array();
            if (!empty($css_arr) && is_array($css_arr))
            {
                foreach ($css_arr as $cssFile)
                {
                    $params = '';
                    if (isset($cssFile['name']) && file_exists($cssFile['name']))
                    {
                        $modtime = filemtime($cssFile['name']);
                        $params = "?" . $modtime;
                    }

                    $remote = empty($cssFile['remote']) ? false : $cssFile['remote'];

                    if ($remote == true)
                    {
                        $css_text = '<link href="' . $cssFile['name'] . $params . '" rel="stylesheet" type="text/css"';
                    }
                    else
                    {
                        $css_text = '<link href="' . base_url() . $cssFile['name'] . $params . '" rel="stylesheet" type="text/css"';
                    }

                    if (isset($cssFile['media']))
                    {
                        $css_text .= ' media="' . $cssFile['media'] . '"';
                    }
                    $css_text .= ' />' . "\n";

                    $css[] = $css_text;
                }
            }
            return $css;
        }

        /**
         * Build an array of all the require JavaScript files as defined in
         * static_config.php and provided by the action in $data['local_js']
         * 
         * @param array $local_js
         * @return multitype:string
         */
        public function collectJs1($local_js = array())
        {
            $js_arr = $this->CI->config->item('default_js');
            $config_js_arr = $this->CI->config->item('js_arr');

            if (!empty($local_js) && is_array($local_js))
            {
                foreach ($local_js as $js_index => $js_name)
                {
                    if (!isset($config_js_arr[$js_index]))
                    {
                        $js_arr[$js_index] = $js_name;
                    }
                }
            }

            $js = array();
            if (!empty($js_arr) && is_array($js_arr))
            {
                foreach ($js_arr as $jsFile)
                {
                    $params = '';
                    if (isset($jsFile['name']) && file_exists($jsFile['name']))
                    {
                        $modtime = filemtime($jsFile['name']);
                        $params = "?" . $modtime;
                    }
                    $js_tag = '<script type="text/javascript" charset="UTF-8" src="' . base_url() . $jsFile['server'] . $jsFile['name'] . $params . '"';
                    $js_tag .= '></script>' . "\n";
                    $js[] = $js_tag;
                }
            }
            return $js;
        }

        public function collectJs($modulename, $local_js = array())
        {
            if ($modulename == "public")
            {
                $js_arr = array_values($this->CI->config->item('public_default_js'));
            }
            elseif ($modulename == "admin")
            {
                $js_arr = array_values($this->CI->config->item('admin_default_js'));
            }
            elseif ($modulename == "login_register")
            {
                $js_arr = array_values($this->CI->config->item('login_register_js'));
            }
            else
            {
                $js_arr = array_values($this->CI->config->item('default_js'));
            }

            //$js_arr = $this->CI->config->item('public_default_js');
            $config_js_arr = $this->CI->config->item('js_arr');

            if (!empty($local_js) && is_array($local_js))
            {
                foreach ($local_js as $js_index)
                {
                    if (isset($config_js_arr[$js_index]))
                    {
                        $js_arr[] = $config_js_arr[$js_index];
                    }
                }
            }

            $js = array();
            if (!empty($js_arr) && is_array($js_arr))
            {

                foreach ($js_arr as $jsFile)
                {

                    $params = '';
                    if (isset($jsFile['name']) && file_exists($jsFile['name']))
                    {
                        $modtime = filemtime($jsFile['name']);
                        $params = "?" . $modtime;
                    }
                    $remote = empty($jsFile['remote']) ? false : $jsFile['remote'];

                    if ($remote == true)
                    {
                        $js_tag = '<script type="text/javascript" charset="UTF-8" src="' . $jsFile['name'] . $params . '"';
                    }
                    else
                    {
                        $js_tag = '<script type="text/javascript" charset="UTF-8" src="' . base_url() . $jsFile['name'] . $params . '"';
                    }

                    $js_tag .= '></script>' . "\n";
                    $js[] = $js_tag;
                }
            }
            return $js;
        }

        public function getLoggedInUserInfo()
        {
            $return_val = array();
            if (!empty($this->CI->db_session))
            {
                $user_id = $this->CI->db_session->userdata('user_id');
                if (!empty($user_id))
                {
                    $return_val = $this->CI->db_session->userdata();
                }
            }
            return $return_val;
        }
        
        public function collect_meta_data($local_meta_data = array(), $db_meta_data = array())
        {
            $arr_return = array();
            $arr1 = $local_meta_data;
            $arr2 = array();
            $arr_output = array();

            $arr = get_custom_config_item('meta_data');

            if (!empty($db_meta_data) && is_array($db_meta_data))
            {
                foreach ($db_meta_data as $key => $meta_data)
                {
                    if ($key == 'page_title')
                    {
                        $arr2['meta:title'] = $meta_data;
                    }
                    else
                    {
                        $tmp_key = str_replace('meta_', 'meta:', $key);
                        $arr2[$tmp_key] = $meta_data;
                    }
                }
            }
            
            if (!empty($arr) && is_array($arr))
            {
                $key_local_meta_data = array_keys($arr1);

                foreach ($arr as $key => $meta_data)
                {
                    if (array_key_exists($key, $arr1) && !empty($arr1[$key]))
                    {
                        $arr_output[$key] = $arr1[$key];
                    }
                    elseif (array_key_exists($key, $arr2) && !empty($arr2[$key]))
                    {
                        $arr_output[$key] = $arr2[$key];
                    }
                    else
                    {
                        $arr_output[$key] = array_key_exists($key, $arr) ? $arr[$key] : '';
                    }
                }

           
            }
            
            if(!empty($local_meta_data))
            {
                $arr_output = array_merge($arr_output, $local_meta_data);
            }
            
            if (!empty($arr_output) && is_array($arr_output))
            {
                foreach ($arr_output as $key => $meta_data)
                {
                    if (substr($key, 0, 2) == 'og' && empty($meta_data))
                    {
                        unset($arr_output[$key]);
                    }
                }
            }

            if (!empty($arr_output) && is_array($arr_output))
            {
                foreach ($arr_output as $key => $meta_data)
                {
                    if ($key == 'meta:title')
                    {
                        $arr_return[] = '<title>' . $meta_data . '</title>' . "\n";
                    }
                    elseif (substr($key, 0, 2) == 'og')
                    {
                        $arr_return[] = '<meta property="' . $key . '" content="' . $meta_data . '" />' . "\n";
                    }
                    else
                    {
                        $tmp_key = str_replace('meta:', '', $key);
                        $arr_return[] = '<meta name="' . $tmp_key . '" content="' . $meta_data . '">' . "\n";
                    }
                }
            }

            return $arr_return;
        }
    }
    
