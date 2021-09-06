<?php

    if (!defined('BASEPATH')) exit('No direct script access allowed');
    require_once APPPATH . '/third_party/PHPExcel.php';

    class Excel
    {
        public function __construct()
        {
            require_once APPPATH . '/third_party/PHPExcel.php';
            
           // $this->excel = new PHPExcel();      
        }
    }
    