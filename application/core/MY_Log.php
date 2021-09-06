<?php

if ( ! defined('BASEPATH'))
{
    exit('No direct script access allowed');
}
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package   CodeIgniter
 * @author    ExpressionEngine Dev Team
 * @copyright Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license   http://codeigniter.com/user_guide/license.html
 * @link      http://codeigniter.com
 * @since     Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * Logging Class
 *
 * @package    CodeIgniter
 * @subpackage Libraries
 * @category   Logging
 * @author     ExpressionEngine Dev Team
 * @link       http://codeigniter.com/user_guide/general/errors.html
 */
// ------------------------------------------------------------------------

/**
 * Custom Logging Threshold
 *
 * Extends the functionality of the CI_Log class by allowing users to choose which
 * threshold level(s) they want to log, rather than logging all the way up to the
 * given threshold.
 *
 * @package    CodeIgniter
 * @subpackage Libraries
 * @category   Logging
 * @author     Matthew Switzer (StrayIdeas)
 * @link       http://codeigniter.com/wiki/Custom_Logging_Threshold/
 */
class MY_Log extends CI_Log
{

    protected $_log_path;
    protected $_threshold = 1;
    protected $_date_fmt  = 'Y-m-d H:i:s';
    protected $_enabled   = TRUE;
    protected $_levels
                          = array(
            'ERROR' => '1',
            'DEBUG' => '2',
            'INFO'  => '3',
            'DATA'  => '5',            
            'OPER_LOGS_DATA'  => '6',
            'ATT_LOGS_DATA'  => '7',
            'REQUEST_LOGS_DATA'  => '8',
            'CMD_LOGS_DATA'  => '9',
        );

    /**
     * Constructor
     */
    public function __construct()
    {
        $config = &get_config();
        
        $log_config = &get_log_config();

        $this->_log_path = ($config['log_path'] != '') ? $config['log_path'] : APPPATH .
                                                                               'logs/';

        if ( ! is_dir($this->_log_path) OR ! is_really_writable($this->_log_path))
        {
            $this->_enabled = FALSE;
        }

        // also allow threshold values to be passed as an array
        if (is_numeric($config['log_threshold']) OR is_array($config['log_threshold']))
        {
            $this->_threshold = $config['log_threshold'];
        }

        if ($config['log_date_format'] != '')
        {
            $this->_date_fmt = $config['log_date_format'];
        }
    }

    // --------------------------------------------------------------------

    /**
     * Write Log File
     *
     * Generally this function will be called using the global log_message() function
     *
     * @param string the error level
     * @param string the error message
     * @param bool   whether the error is a native PHP error
     *
     * @return bool
     */
    public function write_log($level = 'error', $msg, $php_error = FALSE)
    {
        $log_config = &get_log_config();
        if ($this->_enabled === FALSE)
        {
            return FALSE;
        }

        $level = strtoupper($level);

        if ( ! isset($this->_levels[$level])
             OR ($this->_levels[$level] > $this->_threshold)
             // if the threshold values is an array, check to see if the error level does not exist in it
             OR (is_array($this->_threshold) &&
                 ! in_array($this->_levels[$level], $this->_threshold))
        )
        {
            return FALSE;
        }
        
        if ($level == 'INFO')
        {
            $filepath = $this->_log_path . 'info-log-' . date('Y-m-d') . '.php';
        } 
        else if ($level == 'DATA')
        {
            $filepath = $this->_log_path . 'data-log-' . date('Y-m-d') . '.php';
        }
        else if ($level == 'OPER_LOGS_DATA' && $log_config['OPER_LOGS_DATA'] == TRUE)
        {
            $filepath = $this->_log_path . 'oper-log-' . date('Y-m-d') . '.php';
        }
        else if ($level == 'ATT_LOGS_DATA' && $log_config['ATT_LOGS_DATA'] == TRUE)
        {
            $filepath = $this->_log_path . 'att-log-' . date('Y-m-d') . '.php';
        }
        else if ($level == 'REQUEST_LOGS_DATA' && $log_config['REQUEST_LOGS_DATA'] == TRUE)
        {
            $filepath = $this->_log_path . 'req-log-' . date('Y-m-d') . '.php';
        }
        else if ($level == 'CMD_LOGS_DATA' && $log_config['CMD_LOGS_DATA'] == TRUE)
        {
            $filepath = $this->_log_path . 'cmd-log-' . date('Y-m-d') . '.php';
        }
        elseif ($level == 'ERROR')
        {
            $filepath = $this->_log_path . 'error-' . date('Y-m-d') . '.php';
        }
        else
        {
            $filepath = $this->_log_path . 'log-' . date('Y-m-d') . '.php';
        }

        $message = '';

        if ( ! file_exists($filepath))
        {
            $message .= "<" .
                        "?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?" .
                        ">\n\n";
        }

        if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
        {
            return FALSE;
        }

        $message .= $level . ' ' . (($level == 'INFO') ? ' -' : '-') . ' ' .
                    date($this->_date_fmt) . ' --> ' . print_r($msg, TRUE) . "\n";

        flock($fp, LOCK_EX);
        fwrite($fp, $message);
        flock($fp, LOCK_UN);
        fclose($fp);

        @chmod($filepath, FILE_WRITE_MODE);

        return TRUE;
    }

}

// END Log Class

/* End of file Log.php */
/* Location: ./application/libraries/Log.php */