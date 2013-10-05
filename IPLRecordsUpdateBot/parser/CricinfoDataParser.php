<?php

/*
    The MIT License (MIT)

    Copyright (c) 2013 "jfd34"

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.
*/

/**
 * Parser for ESPNCricinfo stats tables.
 * 
 * @author jfd34
 */
class CricinfoDataParser {
    
    /**
     * The regular expression used to extact a player's UID from the profile page URI.
     */
    const PLAYER_ID_REGEX = '%/content/player/(\d+)\.html$%'; 
    
    /**
     * The regular expression used to extact a match UID from the scorecard URI.
     */
    const MATCH_ID_REGEX = '%/engine/match/(\d+)\.html$%';
    
    /**
     * The regular expression used to extact a player's UID from the profile page URI.
     */
    const GROUND_ID_REGEX = '%/content/ground/(\d+)\.html$%';
    
    /**
     * The regular expression used to extract the team and season from the note under a table entry
     * for some series-related records.
     */
    const SERIES_RECORDS_TEAM_YEAR_REGEX = '/^\(([\w\d\s]++)\) - .*, (\d{4}(?:\/\d{2})?)$/u';
    
    /**
     * Sort thr parse results in ascending order.
     */
    const SORT_ASCENDING = 0;
    
    /**
     * Sort thr parse results in descending order.
     */
    const SORT_DESCENDING = 1;
    
    /**
     * The DOMDocument object of the page HTML.
     * 
     * @access private
     * @var DOMDocument
     */
    private $_pageDOM;
    
    /**
     * An array containing the results of parsing the table (as CricinfoParseResult objects).
     * 
     * @access private
     * @var array
     */
    private $_result;
    
    /**
     * An array containing integers (constants from the DataNames class) representing special types.
     * Special types differ from normal types in the following ways:
     * - A special type must have a custom constructor registered in the global $DataNameConstructors array.
     * - The first two parameters to the custom constructor are set to null. Only the third parameter (the CricinfoRawParseResult
     *   object) is passed.
     * 
     * @access private
     * @var array
     */
    private $_specialTypes;
 
    /**
     * Loads the data from the given URI.
     * 
     * @param string $uri The URI of the Cricinfo statistics page to parse.
     * @access public
     */
    public function load($uri) {
        
        $html = file_get_contents($uri);
        sleep(15);  # Per robots.txt

        if ( $html === false ) {
            throw new UpdateTaskException("CricinfoDataParser: Unable to load data (URI: {$uri})");
        }
 
        $this->pageDOM = new DOMDocument();
        @($this->pageDOM->loadHTML($html));
        $this->pageDOM->preserveWhiteSpace = false;
 
    }
    
    /**
     * Parses the table which was loaded with the load() method.
     * 
     * @param int $tableIndex The position of the table (with class="engineTable" attribult) in the HTML. 
     * (0-based)
     * 
     * @param array $parseOrder The order in which the table should be parsed. Values should be constants of
     * the DataNames class. For numeric keys, the key is the 0-based position of the column within the table.
     * String keys are treated as special types, which are usually used when the result has to be determined
     * using the value of more than one data cell, or the entire row. See the description of the $_specialTypes
     * property for more about special types.
     * 
     * @param int $limit The maximum number of rows to be included in the final result. 0 for no limit.
     * 
     * @param array $sortOrder The order in which the rows in the tale should be sorted. Values should be constants
     * from the DataNames class and should be in the $parseOrder array. Special types cannot be used.
     * The value of the table cell with the name corresponding to the value at index 0 of this array
     * is first used for sorting. If the values are equal, then the value at index 1 is used, if they are still
     * equal, the value at index 2 is used, and so on, until non-equal values are found or the last element in
     * the array is reached, in which case the order of sorting of the equal rows is undefined. If this is not an
     * array, no sorting is done and the order of the table rows in the result is the same as that in
     * the original page.
     * 
     * @param int $sortMode Either CricinfoDataParser::SORT_ASCENDING or CricinfoDataParser::SORT_DESCENDING.
     * 
     * @param array $sortReverse An array containing constants of the DataNames class, which have to be sorted in
     * reverse order. (e.g. if $sortMode is CricinfoDataParser::SORT_DESCENDING, then these values are sorted in
     * ascending order.)
     * 
     * @param callable $filter A callback function to filter out results not matching a certain condition.
     * The function must accept one parameter, a CricinfoParseResult object, and return a boolean value.
     * Table rows for which the function returns true will be retained, rows for which it returns false will be
     * removed. If this is not callable object or a valid function name, the results are not filtered.
     */
    public function parse($tableIndex, $parseOrder, $limit = 0, $sortOrder = null, $sortMode = CricinfoDataParser::SORT_DESCENDING, $sortReverse = [], $filter = null) {
        
        $this->_result = [];
        $this->_specialTypes = [];
        
        $xpath = new DOMXPath($this->pageDOM);
 
        # Select all the rows from the table with class="engineTable" at $tableIndex
        $tableList = $xpath->query("//table[@class = 'engineTable']");
        $table = $tableList->item($tableIndex);
        $rows = $xpath->query("tbody/tr[starts-with(@class, 'data')]", $table);
        $notes = $xpath->query("tbody/tr[@class = 'note']", $table);
        
        $rawResult = [];
        
        # Parse the result
        for ( $i = 0; $i < $rows->length; $i++ ) {
            
            $rowData = new CricinfoRawParseResult();
 
            foreach ( $parseOrder as $pos => $name ) {
                
                # String keys are considered to be special types, which should not be iterated until parsing completes.
                if ( ! is_numeric($pos) ) {
                    $this->_specialTypes[] = $name;
                    continue;
                }
                
                $tableCell = $rows->item($i)->getElementsByTagName('td')->item($pos);
                $rowData->setValue( $name, $tableCell->nodeValue );

                if ( $rows->item($i)->getElementsByTagName('td')->item($pos)->getElementsByTagName('a')->length ) {
                    $rowData->setHref( $name, $tableCell->getElementsByTagName('a')->item(0)->getAttribute('href') );
                }
                else $valueHref = null;

            }
            
            # Parse the associated row with class="note"
            $rowData->note = ($notes->length > 0) ? $notes->item($i)->getElementsByTagName('td')->item(0)->nodeValue : null;  # To avoid a fatal error (calling a method on a non-object), should checked whether there are notes first.
 
            $rawResult[] = $rowData;
 
        }
        
        foreach ( $rawResult as $rowIndex => $rowData ) {
            $this->_result[$rowIndex] = $this->_convertRawParseResult($rowData);
        }
        
        # If a callback function is passed to $filter, filter the array
        if ( is_callable($filter) ) {
            $this->_result = array_values(array_filter($this->_result, $filter));
        }
        
        if ( is_array($sortOrder) ) {
            usort(
                $this->_result,
                
                function(CricinfoParseResult $row1, CricinfoParseResult $row2) use ($sortOrder, $sortReverse) {
                    
                    foreach ( $sortOrder as $name ) {
                        $key1 = $row1->getValue($name)->sortKey;
                        $key2 = $row2->getValue($name)->sortKey;
                        
                        if ( $key1 == $key2 ) continue;
                        
                        return (($key1 > $key2) ? 1 : -1) * (( $sortReverse && in_array($name, $sortReverse) ) ? -1 : 1);
                    }
                    
                    return 0;
                    
                }
            );
            
            if ( $sortMode == CricinfoDataParser::SORT_DESCENDING ) {
                $this->_result = array_reverse($this->_result);
            }
        }
        
        if ( $limit ) {
            $this->_result = array_slice($this->_result, 0, $limit);
        }
        
    }
    
    /**
     * Converts a raw parse result to a CricinfoParseResult object and returns it.
     * 
     * @global The data types (subclasses of DataTypes\DataTypeBase) for each name in the DataNames class.
     * @global The custom constructors for certain names in the DataNames class.
     */
    private function _convertRawParseResult(CricinfoRawParseResult $data) {
        
        global $DataNameTypes, $DataNameConstructors;
        
        $result = new CricinfoParseResult();
        
        foreach ( $data->names as $name ) {
            
            # The '-' is has a special meaning "undefined"
            if ( $data->getValue($name) == '-' ) {
                $result->setValue( $name, new DataTypes\Undefined() );
            }
            else if ( isset($DataNameConstructors[$name]) ) {
                # If a custom constructor is set
                $result->setValue( $name, call_user_func( $DataNameConstructors[$name], $data->getValue($name), $data->getHref($name), $data ) );
                
                $dataTypeClass = "DataTypes\\{$DataNameTypes[$name]}";
                if ( ( $DataNameTypes[$name] == '*' && ! ($result->getValue($name) instanceof DataTypes\DataTypeBase) ) || ( $DataNameTypes[$name] != '*' && ! ($result->getValue($name) instanceof $dataTypeClass) ) ) {
                    throw new Exception('Object returned by custom constructor of type ' . get_class($result->getValue($name)) . " does not match type in \$DataNameTypes: DataTypes\\{$DataNameTypes[$name]}");
                }
            }
            else {
                $dataTypeClass = "DataTypes\\{$DataNameTypes[$name]}";
                $result->setValue( $name, new $dataTypeClass( $data->getValue($name) ) );
            }
            
        }
        
        
        # Iterate over the special types
        if ( $this->_specialTypes ) {
            
            foreach ( $this->_specialTypes as $name ) {
            
                if ( isset($DataNameConstructors[$name]) ) {
                    $result->setValue( $name, call_user_func( $DataNameConstructors[$name], null, null, $data ) );
                    
                    $dataTypeClass = "DataTypes\\{$DataNameTypes[$name]}";
                    if ( ( $DataNameTypes[$name] == '*' && ! ($result->getValue($name) instanceof DataTypes\DataTypeBase) ) || ( $DataNameTypes[$name] != '*' && ! ($result->getValue($name) instanceof $dataTypeClass) ) ) {
                        throw new Exception('Object returned by custom constructor of type ' . get_class($result->getValue($name)) . " does not match type in \$DataNameTypes: DataTypes\\{$DataNameTypes[$name]}");
                    }
                }
                else {
                    throw new Exception('Special types must have a custom constructor registered.');
                }
                
            }
        
        }
        
        return $result;
        
    }
    
    /**
     * Getter function
     * 
     * @property-read array $result An array containing the parsed table rows as CricinfoParseResult objects.
     */
    public function __get($name) {
        
        switch ( $name ) {
            case 'result' :
                return $this->_result;
                
            default :
                trigger_error("Property {$name} does not exist in " . __CLASS__, E_USER_NOTICE);
        }
        
    }
 
}
 
?>