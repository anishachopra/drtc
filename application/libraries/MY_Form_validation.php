<?php

    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

    class MY_Form_validation extends CI_Form_validation
    {

        private $_CI;

        public function __construct()
        {
            parent::__construct();

            $this->_CI = & get_instance();
        }

        function run($module = '', $group = '')
        {
            (is_object($module)) AND $this->CI = &$module;
            return parent::run($group);
        }

        public function validate_file_upload($controlName, $module)
        {
            $myconfig = get_custom_config_item($module);

            if (!is_dir($myconfig['upload_path']))
            {
                mkdir($myconfig['upload_path'], 0755, TRUE);
            }

            $this->_CI->load->library('upload');

            $this->_CI->upload->initialize($myconfig);

            $message = '';

            if (!$this->_CI->upload->dryRunUpload($controlName))
            {
                $message = $this->_CI->upload->display_errors();
                $this->_CI->form_validation->set_message('validate_file_upload', $message);
            }

            return empty($message);
        }

        // --------------------------------------------------------------------

        public function unique($str, $field)
        {

            $arr = explode('.', $field);

            $table = $arr[0];

            $database_name = "";
            $arr1 = explode("|", $table);
            if (isset($arr1[1]))
            {
                $database_name = $arr1[0].".";
                $table = $arr1[1];
            }

            $column = $arr[1];

            $exclusionField = $exclusionFieldValue = $extraCondition = '';

            if (count($arr) == 4 || count($arr) == 5)
            {
                $exclusionField = $arr[2];
//                p($exclusionField);
                $exclusionFieldValue = $arr[3];

                if (!empty($exclusionField) && !empty($exclusionFieldValue))
                {
                    $extraCondition = " AND $exclusionField <> '$exclusionFieldValue'";
                }
            }
            if (count($arr) == 6)
            {
                $exclusionField1 = $arr[2];
                $exclusionFieldValue1 = $arr[3];
                $exclusionField2 = $arr[4];
                $exclusionFieldValue2 = $arr[5];
                if ((!empty($exclusionField1) && !empty($exclusionFieldValue1) ) || (!empty($exclusionFieldValue2) && !empty($exclusionFieldValue2)))
                {
                    $extraCondition = " AND $exclusionField1 <> '$exclusionFieldValue1' AND $exclusionField2 = '$exclusionFieldValue2'";
                }
            }

            $this->_CI->form_validation->set_message('unique', '%s already exists.');
            $query = $this->_CI->db->query("SELECT COUNT(*) AS duplicate FROM $database_name$table WHERE $column = '$str' $extraCondition");
            $row = $query->row();

            //echo $this->_CI->db->last_query();
            // exit;

            if (count($arr) == 5)
            {
                return ($row->duplicate > 1) ? FALSE : TRUE;
            }
            else
            {
                return ($row->duplicate > 0) ? FALSE : TRUE;
            }
        }

        public function check_unique($str, $field)
        {

            $arr = explode('.', $field);

            $count_field = count($arr);
            $user_email = $str;
            $user_type_id = !empty($arr[3]) ? $arr[3] : '';
            $user_id = !empty($arr[4]) ? $arr[4] : '';



            $colum_field = "";
            if ($arr[0] == "email")
            {
                $colum_field = "email";
            }
            else
            {
                $colum_field = "username";
            }

            $this->_CI->form_validation->set_message('check_unique', '%s already exists.');
            $this->_CI->db->where($colum_field, $user_email);
            if (!empty($user_id))
            {
                if (!empty($user_type_id) && $user_type_id == 1)
                {
                    $this->_CI->db->where('id <>', $user_id);
                    $this->_CI->db->where('user_type_id =', $user_type_id);
                }
            }
            $owner_query = $this->_CI->db->get('owner');

            $this->_CI->db->where($colum_field, $user_email);
            if (!empty($user_id))
            {

                if (!empty($user_type_id) && $user_type_id == 3)
                {
                    $this->_CI->db->where('id <>', $user_id);
                    $this->_CI->db->where('user_type_id =', $user_type_id);
                }
            }
            $contractor_query = $this->_CI->db->get('contractor');

            $this->_CI->db->where($colum_field, $user_email);
            if (!empty($user_id))
            {

                if (!empty($user_type_id) && $user_type_id == 2)
                {
                    $this->_CI->db->where('id <>', $user_id);
                    $this->_CI->db->where('user_type_id =', $user_type_id);
                }
            }
            $engineering_office_query = $this->_CI->db->get('engineering_office');

            if ($owner_query->num_rows() > 0 || $contractor_query->num_rows() > 0 || $engineering_office_query->num_rows() > 0)
            {

                return FALSE;
            }
            else
            {

                return TRUE;
            }
        }

        /*         * ************************Use for api***************************** */

        public function check_opt($str, $field)
        {
            $this->_CI->load->library('commonlib');
            $arr = explode('.', $field);
            $dataValues = array(
                'otp_mobile' => $arr[2],
                'otp_number' => $str
            );
            $this->_CI->form_validation->set_message('check_opt', '%s invalid.');
            $result = $this->_CI->commonlib->verify_otp($dataValues);
            if ($result == FALSE)
            {
                return FALSE;
            }
            else
            {
                return TRUE;
            }
        }

        public function valid_date($date)
        {
            $d = DateTime::createFromFormat('Y-m-d', $date);

            return $d && $d->format('Y-m-d') === $date;
        }

        public function check_seat_data($str, $seat_data)
        {
            $seat_data = json_decode($seat_data, 1);
            $seat_exist = false;
            foreach ($seat_data as $i => $v)
            {
                foreach ($v['cols'] as $ci => $cv)
                {
                    if ($cv['state'] != 0)
                    {
                        $seat_exist = true;
                        break;
                    }

                    if ($seat_exist == true)
                    {
                        break;
                    }
                }
            }
            return $seat_exist;
        }

    }
    