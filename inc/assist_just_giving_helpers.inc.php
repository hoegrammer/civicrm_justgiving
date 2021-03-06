<?php

// Poor man's namespace for functions that do not depend on Civi.
// Must be public and static, and pure if possible (or system/IO) 

class assistJustGivingHelpers {

    
    public static function verifyFileAndExtractData($filename) {
        // this prevents problems with different line endings
        // see http://www.thisprogrammingthing.com/2012/oddity-with-fgetcsv/
        $numberOfRecords = 0;
        $maxNumberOfRecords = 100;
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
        $numberOfRecords = count($dataAsArray);
        if ($numberOfRecords > $maxNumberOfRecords) {
            fclose($fp);
            throw new Exception("Too many records ($NumberOfRecords) to process at once: Please split into smaller CSV files with a maximum of $maxNumberOfRecords entries each.");
        }
        if (!self::dateFormatIsValid($dataAsArray)) {
            fclose($fp);
            throw new Exception("One or more dates in the CSV is in the wrong format (want: dd/mm/yyyy)");
        }
        fclose($fp);
        return $dataAsArray;
    }
 
     private static function dateFormatIsValid($dataAsArray) {
       // checking all date fields, not just the one(s) we want to import, 
       // as a sanity check for the file
        $dateFields = array(
          'Page Created Date',
          'Page Event Date',
          'Page Expiry Date',
          'Event Date',
          'Event Expiry Date',
          'Donation Date',
          'Donation Payment Reference Date'
        );
        //  Expect date format dd/mm/yyyy, dd and mm may use a leading 0 if less than 10,
        #$validDateRegex = '/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/\d{4}$/';  // Require leading zero
        $validDateRegex = '/^(0?[1-9]|[12][0-9]|3[01])\/(0?[1-9]|1[012])\/\d{4}$/'; // Optional leading zero
        foreach($dataAsArray as $row) {
          foreach($dateFields as $dateField) {
            if (isset($row[$dateField]) && trim($row[$dateField]) && !preg_match($validDateRegex, trim($row[$dateField]))){
              //error_log("DEBUG1 $dateField ".$row[$dateField].".");
              return false;
            }
          }
        }
        return true;  // No bad dates found
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
