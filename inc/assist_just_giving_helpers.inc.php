<?php

// Poor man's namespace for functions that do not depend on Civi.
// Must be public and static, and pure if possible (or system/IO) 

class assistJustGivingHelpers {

    
    public static function extractDataFromQuotedCSVFile($filename) {
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
        if (!self::csvIsQuoted($fp)) {
            fclose($fp);
            throw new Exception("CSV is not quoted (or file is empty)");           
        }
        $dataAsArray = self::csvFileToArray($fp);
        fclose($fp);
        return $dataAsArray;
    }
 
     private static function csvIsQuoted($fp) {
         /*if (feof($fp) ) { fclose($fp); throw new Exception("Empty/null file"); }*/  // Null file (or single-line file?)
         $first_line = fgets($fp);
         rewind($fp); // Leave $fp at start of file so subsquent use finds $fp at start of file
         return $first_line && $first_line[0] == '"';
     }
 
     private static function csvFileToArray($fp) {
 
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
 
         rewind($fp); // Leave $fp at start in case $fp subsequently used
 
         return $returnVal;
     }
 }
