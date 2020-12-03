<?php

require_once __DIR__ . "/../vendor/autoload.php";

// __DIR__ . "/../ehpad.xlsx"
function getAllRows($excelFile) {

    $residences = [];

    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
    $reader->setReadDataOnly(TRUE);
    $spreadsheet = $reader->load( $excelFile );

    $worksheet = $spreadsheet->getActiveSheet();

    $rows = [];
    $header= [];

    foreach ($worksheet->getRowIterator() as $rownum => $row) {
        // if( $rownum == 7600 ) { break;}
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE);

        echo "NEW ROW NUM :  $rownum <br />";

        $colnum = 0;
        foreach ($cellIterator as  $cell) {
            
            if( $colnum == 0  ) { $residence = new stdClass(); }

            if( $rownum != 1 ) {
                if( $colnum == 6 && $cell->getValue() != "NA" ) {
                    $rows[$rownum][$header[$colnum]] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($cell->getValue());
                } else {
                    $rows[$rownum][$header[$colnum]] = $cell->getValue();
                }
                
            } else {
                $header[] = $cell->getValue();
            }
            $colnum++;
        }

    }

    return array($header, $rows);

}
