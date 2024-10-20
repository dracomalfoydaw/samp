<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Spreadsheet_lib {
    public function __construct() {
        // Initialize PhpSpreadsheet instance
        $this->spreadsheet = new Spreadsheet();
    }

    public function createSheet() {
        return $this->spreadsheet->getActiveSheet();
    }

    public function saveToFile($filePath) {
        $writer = new Xlsx($this->spreadsheet);
        $writer->save($filePath);
    }
}
