<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HtmlPurifier_lib {

    protected $ci;
    protected $purifier;

    public function __construct() {
        // Load CodeIgniter's instance
        $this->ci =& get_instance();

        // Create a configuration object
        $config = \HTMLPurifier_Config::createDefault();

        // Adjust the configuration as per your needs
        // For example, enabling the HTML5 elements
        $config->set('HTML.Doctype', 'HTML 4.01 Transitional');
        $config->set('HTML.AllowedElements', ['p', 'a', 'img', 'b', 'i', 'u', 'ul', 'ol', 'li']);
        $config->set('HTML.AllowedAttributes', ['a.href', 'img.src', 'img.alt']);

        // Instantiate the purifier object
        $this->purifier = new \HTMLPurifier($config);
    }

    public function purify($dirty_html) {
    // Initialize the data variable as an empty string
    $data = null;

    // Check if the input is not empty and is a string
    if (!empty($dirty_html) && is_string($dirty_html)) {
        // Purify the input to remove potentially harmful content
        $data = $this->purifier->purify($dirty_html);
        // Convert special characters to HTML entities to prevent XSS
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    return $data;
}
public function purify2($dirty_html)
    {
        $config = HTMLPurifier_Config::createDefault();
        // Configure HTMLPurifier as needed
        $purifier = new HTMLPurifier($config);

        return $purifier->purify($dirty_html);
    }

public function purify_decode($encoded_html) {
    // Initialize the data variable as an empty string
    $data = null;

    // Check if the input is not empty and is a string
    if (!empty($encoded_html) && is_string($encoded_html)) {
        // Decode HTML entities back to their corresponding characters
        $data = html_entity_decode($encoded_html, ENT_QUOTES, 'UTF-8');
    }

    return $data;
}

}
