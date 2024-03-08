<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'third_party/htmlpurifier-4.15.0/library/HTMLPurifier.auto.php';

class Htmlpurifier_lib
{
    public function purify($dirty_html)
    {
        $config = HTMLPurifier_Config::createDefault();
        // Configure HTMLPurifier as needed
        $purifier = new HTMLPurifier($config);

        return $purifier->purify($dirty_html);
    }
}
