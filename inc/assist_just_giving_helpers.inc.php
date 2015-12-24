<?php

// Poor man's namespace for functions that do not depend on Civi.
// Must be public and static, and pure if possible (or system/IO) 

class assistJustGivingHelpers {

    public static function csvFileToArray($filename) {

        // this prevents problems with different line endings
        // see http://www.thisprogrammingthing.com/2012/oddity-with-fgetcsv/
        ini_set('auto_detect_line_endings', true);

        if ( !file_exists($filename) ) {
            throw new Exception("File not found: $filename");
        }

        $fp = fopen($filename, "r");
        if ( !$fp ) {
            throw new Exception("Couldn't open file: $filename");
        }  
        $returnVal = array();
        $header = null;

        while(($row = fgetcsv($fp)) !== false){
            if($header === null){
                $header = $row;
                continue;
            }

            $newRow = array();
            for($i = 0; $i<count($row); $i++){
                $newRow[$header[$i]] = $row[$i];
            }

            $returnVal[] = $newRow;
        }

        fclose($fp);

        return $returnVal;
    }
}
