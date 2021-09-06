<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Common library function goes here
 */
class Commonlibrary
{

    private $_CI;    // CodeIgniter instance

    public function __construct()
    {
        $this->_CI = & get_instance();
    }

    public function generatePassword($length = 9, $strength = 0)
    {
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1)
        {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2)
        {
            $vowels .= "AEUY";
        }
        if ($strength & 4)
        {
            $consonants .= '23456789';
        }
        if ($strength & 8)
        {
            $consonants .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++)
        {
            if ($alt == 1)
            {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            }
            else
            {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }

    public function deleteFile($fileName)
    {
        if (file_exists($fileName))
            unlink($fileName);
    }

    public function CreateDirectory($dirname)
    {
        if (!file_exists($dirname))
        {
            mkdir($dirname, 0755);
        }
    }

    public function parseFilePath($fileType, $fileId, $module)
    {
        switch ($module)
        {
            default:
                $fileName = $fileId . '.' . $fileType;
        }

        $this->_CI->load->config('report_config');
        $arr = $this->_CI->config->item($module);

        $fileDir = $arr['upload_path'];

        return $fileDir . $fileName;
    }

    public function is_file_uploaded($user_field = '')
    {
        $return = FALSE;
        if (isset($_FILES[$user_field]) && $_FILES[$user_field]['size'] > 0)
        {
            $return = TRUE;
        }
        return $return;
    }

    public function sendmail($to_email, $to_name, $subject, $body, $mailtype = "html", $from_name = EMAIL_FROM_NAME, $from_email = EMAIL_FROM_EMAIL, $bcc = "", $attachment = array())
    {
        //$config = get_custom_config_item('email_config');

//        $config = Array(
//            'protocol' => 'smtp',
//            'smtp_host' => 'ssl://smtp.googlemail.com',
//            'smtp_port' => 465,
//            'smtp_user' => 'moonlineproperty18',
//            'smtp_pass' => 'moonline33',
//            'mailtype'  => 'html', 
//            'charset'   => 'iso-8859-1'
//        );
//
//        $this->_CI->load->library('email', $config);
        $this->_CI->load->library('email');

        $this->_CI->email->clear(TRUE);
        $this->_CI->email->set_newline("\r\n");
        $this->_CI->email->from($from_email, $from_name);
        $this->_CI->email->to($to_email);
        if (!empty($bcc))
        {
            $this->_CI->email->cc($bcc);
        }

        $this->_CI->email->set_mailtype($mailtype);
        $this->_CI->email->subject($subject);
        $this->_CI->email->message($body);
//        p($attachment);
        if (!empty($attachment))
        {
            foreach($attachment as $attach)
            {
                $file_to_attach = $attach['file_path'];
                $file_name = $attach['file_name'];
                $this->_CI->email->attach($file_to_attach, 'attachment', $file_name);
            }
        }

        if ($this->_CI->email->send())
        {
            log_message('MY_INFO', 'Email Success');
            log_message('MY_INFO', 'To Email: ' . $to_email);
            log_message('MY_INFO', 'Subject: ' . $subject);
            log_message('MY_INFO', 'Body: ' . $body);
            $return = TRUE;
        }
        else
        {
            log_message('MY_INFO', 'Email Error');
            log_message('MY_INFO', $to_email);
            log_message('MY_INFO', $this->_CI->email->print_debugger());
            log_message('MY_INFO', $body);
            $return = FALSE;
        }
        return $return;
    }

    public function sendsms($recipient = "", $message = "", $company_id = '')
    {

        if (!empty($company_id))
        {
            if (!empty($recipient) && !empty($message))
            {
                $this->_CI->load->library('Companysmslib');
                $sms_api_record = $this->get_company_api_credentials($company_id, $specific = 'sms_api');


                if (!empty($sms_api_record))
                {

                    $username = $sms_api_record->sms_api_username;
                    $apikey = $sms_api_record->sms_api_key;
                    $apisecret = $sms_api_record->sms_api_secret;
                    $sms_api_provider = $sms_api_record->sms_api_provider;

                    $company_sms_config = array();

                    switch ($sms_api_provider)
                    {
                        case 'Clicksend':
                            if (!empty($username) && !empty($apikey))
                            {
                                $company_sms_config['username'] = $username;
                                $company_sms_config['apikey'] = $apikey;
                                $company_sms_config['provider'] = 'Clicksend';
                                $company_sms_config['from'] = 'XYZ';
                            }
                            break;
                        case 'Nexmo':
                            if (!empty($apikey) && !empty($apisecret))
                            {
                                $company_sms_config['api_key'] = $apikey;
                                $company_sms_config['api_secret'] = $apisecret;
                                $company_sms_config['provider'] = 'Nexmo';
                                $company_sms_config['from'] = 'XYZ';
                            }
                            break;
                        default :
                            return false;
                    }

                    if (!empty($company_sms_config))
                    {
                        $return = $this->_CI->companysmslib->sendSms($recipient, $message, $company_sms_config);
                    }
                    else
                    {
                        $return = FALSE;
                    }
                }
                else
                {
                    $return = FALSE;
                }
            }
        }
        else
        {
            $this->_CI->load->library('smslib');
            if (!empty($recipient) && !empty($message))
            {
                $return = $this->_CI->smslib->sendSms($recipient, $message);
            }
        }

        return $return;
    }

    public function rrmdir($dir)
    {
        if (is_dir($dir))
        {
            $objects = scandir($dir);
            foreach ($objects as $object)
            {
                if ($object != "." && $object != "..")
                {
                    if (filetype($dir . "/" . $object) == "dir")
                        rrmdir($dir . "/" . $object);
                    else
                        unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public function getdrodownoption($arr_tmp)
    {
        $return = $this->_CI->load->viewPartial("dropdown", $arr_tmp);
        return $return;
    }

    public function getpreviewlink($file_name, $base_url = '')
    {

        $preview_link = '';
        $tmp_base_url = '';
        if (!isset($base_url) || $base_url == '')
        {
            $tmp_base_url = base_url();
        }
        else
        {
            $tmp_base_url = $base_url;
        }

        if (file_exists($file_name))
        {

            $preview_link = '<a rel="' . $tmp_base_url . $file_name . '" href="' . $tmp_base_url . $file_name . '" class="preview">Click here to preview <i class="action-icon fa fa-image"></i></a>';
        }

//                $preview_link = '<a href="' . $tmp_base_url . $file_name . '" class="preview"><img src="assets/admin-images/icons/preview.png" alt="Preview" title="Preview" /></a>';
//        
        return $preview_link;
    }

    public function unlinkFile($file_name, $file_path)
    {

        $this->_CI->load->helper('path_helper');
        $path_system = set_realpath($file_path);
        $unlink_file_name = $path_system . $file_name;
        if (file_exists($unlink_file_name))
        {
            unlink($unlink_file_name);
        }
    }

    /// $arr : config item of file
    public function upload_files($arr, $file_name, $file_type)
    {
        $return = array();
        $filename = $file_name;
        $exts = pathinfo($filename, PATHINFO_EXTENSION);
        $randimg = generateRandomString();
        $arr_doc_type = explode("/", $file_type);
        $ext = "." . $arr_doc_type[1];
        $return['location_doc'] = strtolower($randimg . "." . $exts);
        $return['tmp_upload_path'] = $arr['upload_path'];
        return $return;
    }

    public function create_unique_slug($string, $table, $field = 'slug', $key = NULL, $value = NULL)
    {
        $t = & get_instance();
        $slug = url_title($string);
        $slug = strtolower($slug);
        $i = 0;
        $params = array();
        $params[$field] = $slug;

        if ($key)
            $params["$key !="] = $value;

        while ($t->db->where($params)->get($table)->num_rows())
        {
            if (!preg_match('/-{1}[0-9]+$/', $slug))
                $slug .= '-' . ++$i;
            else
                $slug = preg_replace('/[0-9]+$/', ++$i, $slug);

            $params [$field] = $slug;
        }
        return $slug;
    }

    function GetCaptcha()
    {
        $this->_CI->load->helper('captcha');
        $vals = array(
            'img_path' => 'assets/images/captcha/',
            'img_url' => base_url() . 'assets/images/captcha/',
            'img_width' => '225',
            'img_height' => 75,
            'expiration' => 7200,
            'word_length' => 5,
            'font_path' => FCPATH . 'assets/consola.ttf',
            'pool' => '0123456789abcdefghijklmnopqrstuvwxyz'
        );
        $img_path = 'assets/images/captcha/';
        $img_url = base_url();
        /* Generate the captcha */
        $captcha = create_captcha($vals, $img_path, $img_url);
        return $captcha;
    }

    public function is_file_exists($file)
    {
        $return = FALSE;
        if (file_exists($file))
        {
            $return = TRUE;
        }
        return $return;
    }

    public function is_file($file)
    {
        $return = FALSE;
        if (is_file($file))
        {
            $return = TRUE;
        }
        return $return;
    }

}
