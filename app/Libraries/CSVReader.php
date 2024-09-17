<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CSV Reader for CodeIgniter 3.x
 *
 * Library to read the CSV file. It helps to import a CSV file
 * and convert CSV data into an associative array.
 *
 * This library treats the first row of a CSV file
 * as a column header row.
 *
 *
 * @package     CodeIgniter
 * @category    Libraries
 * @author      CodexWorld
 * @license     http://www.codexworld.com/license/
 * @link        http://www.codexworld.com
 * @version     3.0
 */
class CSVReader {


    // Columns names after parsing
    private $fields;
    // Separator used to explode each line
    private $separator = ';';
    // Enclosure used to decorate each field
    private $enclosure = '"';
    // Maximum row size to be used for decoding
    private $max_row_size = 1000000;

    /**
     * Parse a CSV file and returns as an array.
     *
     * @access    public
     * @param    filepath    string    Location of the CSV file
     *
     * @return mixed|boolean
     */
    function parse_csv($filepath)
    {
        if(!file_exists($filepath))
        {
            return FALSE;
        }
        $fp = fopen($filepath, 'r');
        $csvArray = array();
        //$flag = true;
        $header = fgetcsv($fp);
        while (($row = fgetcsv($fp, 10000, ",")) !== FALSE)
        {
			$row = array_map("utf8_encode", $row);
			//if($flag) { $flag = false; continue; }
			//$csvArray[] =$row;
			$csvArray[] = @array_combine($header, $row);
        }
        fclose($fp);
        return  $csvArray;
    }
    function parse_csv1($filepath)
    {
		/*
		$csv = explode("\n", file_get_contents($filepath));
		foreach ($csv as $key => $line)
		{
			$csv[$key] = str_getcsv($line);
			foreach (str_getcsv($line) as $key => $field)
			{
				if(!empty($headers[$key]))
				{
					//$csv[$headers[$key]]='"'.$field.'"';
				}
			}
		}
		return $csv;
		die;
		*/
        //ini_set('memory_limit', '512M');
        //ini_set('max_execution_time', '300');
        // If file doesn't exist, return false
        if(!file_exists($filepath)){
            return FALSE;
        }

        // Open uploaded CSV file with read-only mode
        $csvFile = fopen($filepath, 'r');

        // Get Fields and values
        $this->fields = fgetcsv($csvFile, $this->max_row_size, $this->separator, $this->enclosure);
        $keys_values = explode(',', $this->fields[0]);
        $keys = $this->escape_string($keys_values);

        // Store CSV data in an array
        $csvData = array();
        $i = 1;
        while(($row = fgetcsv($csvFile, $this->max_row_size, $this->separator, $this->enclosure)) !== FALSE)
        {

            // Skip empty lines
            if($row != NULL){
                $values = explode(',', $row[0]);
                if(count($keys) == count($values)){
                    $arr        = array();
                    $new_values = array();
                    $new_values = $this->escape_string($values);
                    for($j = 0; $j < count($keys); $j++){
                        if($keys[$j] != ""){
                            $arr[$j] = $new_values[$j];
                        }
                    }
                    $csvData[$i] = $arr;
                    $i++;
                }
            }
        }
        // Close opened CSV file
        fclose($csvFile);

        return $csvData;
    }

    function escape_string($data){
        $result = array();
        foreach($data as $row){
            $result[] = str_replace('"', '', $row);
        }
        return $result;
    }
}
