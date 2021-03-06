<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Manila');
$autoload['packages']  = array();
$autoload['libraries'] = array('email', 'session', 'database', 'user_agent');
$autoload['drivers']   = array();
$autoload['config']    = array('my_config');
$autoload['helper'] = array('url', 'file', 'directory');
$autoload['language']  = array();
$autoload['model']     = array('business_permit_model');