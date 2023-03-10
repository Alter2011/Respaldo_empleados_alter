<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/phpqrcode/qrlib.php');

class QRcode2
{
    public function generate($params) 
    {
        QRcode::png($params['data'], $params['savename'], $params['level'], $params['size']);
    }
}