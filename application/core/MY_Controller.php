<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class My_Controller extends CI_Controller
{

    /**
     * $ajaxRequest : this is the variable which contains the requested page is via ajax call or not. by default it is false and will be set as false and will be set as true in constructor after validating the request type.
     *
     */
    public $ajaxRequest = false;
    public $template = NULL;

    public function __construct()
    {
        parent::__construct();

        /**
         * validating the request type is ajax or not and setting up the $ajaxRequest variable as true/false.
         *
         * */
        $requestType = $this->input->server('HTTP_X_REQUESTED_WITH');
        $this->ajaxRequest = strtolower($requestType) == 'xmlhttprequest';
        /**
         * set the default template as blank when the request type is ajax
         */
        if ($this->ajaxRequest === true) {
            $this->load->setTemplate('blank');
        }

        $module = $this->router->fetch_module();

        switch ($module) {
            case 'public':
                $this->load->setTemplate('public');
                break;
        }
    }

    public function _remap($method, $params = array())
    {
        //            p($_SESSION);
        $this->load->helper('url');

        $module = $this->router->fetch_module();
        $class = $this->router->fetch_class();

        if ($module == 'admin') {
            $redirectToLogin = true;

            if (($method == 'login' && is_array($params) && count($params) == 1 && $params[0] == 'redirectForcefully') ||
                ($method == 'validate' && is_array($params) && count($params) == 1 && $params[0] == 'redirectForcefully') ||
                ($method == 'forgot_password')
            ) {
                $redirectToLogin = false;
            }

            $method_check = array('', 'login', 'logout', 'validate');
            $uri_method = $this->uri->segment(3);

            if ($redirectToLogin == true) {

                $loggedin = $this->session->userdata('user_id');
                if (empty($loggedin)) {
                    $message = $this->session->flashdata('login_operation_message');
                    if (!empty($message)) {
                        $this->session->set_flashdata('login_operation_message', $message);
                    }
                    redirect('admin/user/login/redirectForcefully/');
                }
            }
        } elseif ($module == 'public') {

            $arr = array(
                //                    'details',
                //                    'studio-profile',
                'profile',
            );
            $artist_arr = array(
                'artist/(:any)/(:num)',
                'artist-profile',
            );
            $studio_arr = array(
                'studio/(:any)/(:num)',
                'studio-profile',
            );
            $user_arr = array(
                'user-profile',
            );
            $arr_userdata = GetLoggedinUserData();

            if (empty($arr_userdata["public_user_id"])) {

                //                    p($method);
                if (array_search($method, $arr) !== false) {

                    $referrer = uri_string();
                    $this->session->set_userdata('login_referrer', $referrer); // $method

                    redirect('/');
                }
            } else {

                if ($arr_userdata['public_user_type'] == "user") {
                    if (array_search($method, $user_arr) !== FALSE) {
                        $referrer = uri_string();
                        $this->session->set_userdata('login_referrer', $referrer); // $method
                        redirect('user-profile');
                    }
                } elseif ($arr_userdata['public_user_type'] == "artist") {

                    if (array_search($method, $artist_arr) !== FALSE) {
                        $referrer = uri_string();
                        $this->session->set_userdata('login_referrer', $referrer); // $method
                        redirect('artist/(:any)/(:num)');
                    }
                } elseif ($arr_userdata['public_user_type'] == "studio") {

                    if (array_search($method, $studio_arr) !== FALSE) {
                        $referrer = uri_string();
                        $this->session->set_userdata('login_referrer', $referrer); // $method
                        redirect('studio/(:any)/(:num)');
                    }
                }
            }
        }
        if (method_exists($this, $method)) {
            call_user_func_array(array($this, $method), $params);
        } else {
            show_404();
        }
    }

    public
    function _check_user_role($method, $module)
    {

        $config_user_access = get_custom_config_item('user_access', 'menu_config');
        $url_class = $this->uri->segment(2);

        if (
            !empty($_SESSION['user_type']) &&
            in_array($url_class, $config_user_access[$_SESSION['user_type']])
        ) {
        } else {

            redirect('admin/dashboard');
        }
    }
}
