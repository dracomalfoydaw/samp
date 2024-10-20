<?php
use PhpOffice\PhpWord\PhpWord;

class Phpword_lib {
    public function __construct() {
        // Initialize PhpWord instance
        $this->phpword = new PhpWord();
    }

    public function loadTemplate($templatePath) {
        return new \PhpOffice\PhpWord\TemplateProcessor($templatePath);
    }
}
