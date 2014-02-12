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
 * An UpdateTask object is used for updating a specific table.
 * 
 * @author jfd34
 */
class UpdateTask {
    
    /**
     * Regular expression for matching a wikitext table and capturing the body portion.
     */
    const TABLE_REGEX = '/ ^ \{\| .*? \n (?: (?:\!|\|\-).*? \n)* \|\- .*? \n ( (?:\|\-? (?s) .*? (?-s) \n)*? ) \|\} /mux';
    
    /**
     * The CricinfoDataParser object for loading data for this task.
     * 
     * @access private
     * @var CricinfoDataParser
     */
    private $_parser;
    
    /**
     * The URI of the page containing the data.
     * 
     * @access public
     * @var string
     */
    public $uri;
    
    /**
     * The URI of the loaded page when the load() method was last called. When the load() method is called
     * again and the $uri property matches this, the data will be parsed directly without being fetched again.
     * 
     * @access private
     * @var string
     */
    private $_loadedURI;
    
    /**
     * The position of the table to be parsed in the page HTML.
     * 
     * @access public
     * @var int
     */
    public $tableIndex = 0;
    
    /**
     * An array containing the section headers under which the table to be updated is located.
     * The string at index 0 is a level 2 section header, index 1 is a level 3 header under that header,
     * and so on.
     * 
     * @access public
     * @var array
     */
    public $sectionHeaders;
    
    /**
     * The order in which the table should be parsed. Values should be constants of
     * the DataNames class. For numeric keys, the key is the 0-based position of the column within the table.
     * String keys are treated as special types, which are usually used when the result has to be determined
     * using the value of more than one data cell, or the entire row. See the description of the $_specialTypes
     * property of the CricinfoDataParser class for more about special types.
     * 
     * @access public
     * @var array
     */
    public $parseOrder;
    
    /**
     * The order in which the rows in the tale should be sorted. Values should be constants
     * from the DataNames class and should be in the $parseOrder array. Special types cannot be used.
     * The value of the table cell with the name corresponding to the value at index 0 of this array
     * is first used for sorting. If the values are equal, then the value at index 1 is used, if they are still
     * equal, the value at index 2 is used, and so on, until non-equal values are found or the last element in
     * the array is reached, in which case the order of sorting of the equal rows is undefined. If this is not an
     * array, no sorting is done and the order of the table rows in the result is the same as that in
     * the original page.
     * 
     * @access public
     * @var array
     */
    public $sortOrder;
    
    /**
     * An array containing constants of the DataNames class, which have to be sorted in
     * reverse order. (e.g. if $sortMode is CricinfoDataParser::SORT_DESCENDING, then these values are sorted in
     * ascending order.)
     * 
     * @access public
     * @var array
     */
    public $sortReverse;
    
    /**
     * Either CricinfoDataParser::SORT_ASCENDING or CricinfoDataParser::SORT_DESCENDING.
     * 
     * @access public
     * @var int
     */
    public $sortMode;
    
    /**
     * A callback function to filter out results not matching a certain condition.
     * The function must accept one parameter, a CricinfoParseResult object, and return a boolean value.
     * Table rows for which the function returns true will be retained, rows for which it returns false will be
     * removed. If this is not callable object or a valid function name, the results are not filtered.
     * 
     * @access public
     * @var callable
     */
    public $filter;
    
    /**
     * The maximum number of rows to be included in the final result. 0 for no limit.
     * 
     * @access public
     * @var int
     */
    public $limit;
    
    /**
     * The order in which the columns in the parsed tables should be arranged in the final table.
     * Values should be constants from the DataNames class and should be in the $parseOrder array.
     * Special types can be used.
     * 
     * @access public
     * @var array
     */
    public $tableOrder;
    
    /**
     * A callback function that will be executed before a cell is added to the final table in the article,
     * which can be used to modify the content of the cell.
     * The function must accept four parameters:
     * - The content of the table cell.
     * - The zero-based column number of the cell (as per the final table order)
     * - The type of the content of the cell, as a constant from the DataNames class.
     * - The row which is to be written, as a CricinfoParseResult object
     * 
     * The function, if it modifies the cell content, should return the string which will be the new cell content.
     * Otherwise, it must return the original string (first parameter).
     * 
     * @access public
     * @var callable
     */
    public $tableAddCallback;
    
    /**
     * Constructor function.
     * 
     * @access public
     */
    public function __construct() {
        $this->_parser = new CricinfoDataParser();
    }
    
    /**
     * Executes the task.
     * 
     * @access public
     * @global The text of the page to be updated.
     */
    public function exec() {
    
        global $PageText, $DataNameFloatPrecision;
        
        $sectionHeaderPosition = $this->_getSectionHeaderPosition();
        
        if ( $sectionHeaderPosition === false )  {
            throw new UpdateTaskException('Section header not found.');
        }
        
        $this->_parseData();
        
        $rows = [];
        $rowStrings = [];
        
        foreach ( $this->_parser->result as $row ) {
            
            $rows[] = $row;
            $fieldStrings = [];
            
            foreach ( $this->tableOrder as $pos => $name ) {
                $rowValue = $row->getValue($name);
                
                if ( $rowValue instanceof DataTypes\Float && isset($DataNameFloatPrecision[$name]) ) {
                    $fieldString = $rowValue->formatToString( $DataNameFloatPrecision[$name] );
                }
                else {
                    $fieldString = $rowValue->formatToString();
                }
                
                if ( is_callable($this->tableAddCallback) ) {
                    $fieldString = call_user_func( $this->tableAddCallback, $fieldString, $pos, $name, $row );
                }
                
                $fieldStrings[] = self::_escapeUnsafeTemplateChars($fieldString);
            }
            
            $rowStrings[] = self::_joinFieldStrings($fieldStrings);
            
        }
        
        $tableBodyString = implode("\n|-\n", $rowStrings) . "\n";
        
        preg_match( self::TABLE_REGEX, $PageText, $tableMatch, 0, $sectionHeaderPosition );
        if ( ! $tableMatch ) {
            throw new UpdateTaskException('Table not found or is improperly formatted.');
        }
        
        $PageText = str_replace( $tableMatch[1], $tableBodyString, $PageText );
        
    }
    
    /**
     * Parses the data from the $uri property which is to be used for this task.
     * 
     * @access private
     */
    private function _parseData() {
        
        # Fetch the data only on the first call and on subsequent calls where the $uri property
        # has changed.
        # If this method has been called a second time without changing the $uri property,
        # parse the data directly without re-fetching it.
        
        if ( $this->uri != $this->_loadedURI ) {
            $this->_parser->load($this->uri);
            $this->_loadedURI = $this->uri;
        }
        
        $this->_parser->parse(
            $this->tableIndex,
            $this->parseOrder,
            $this->limit,
            $this->sortOrder,
            $this->sortMode,
            $this->sortReverse,
            $this->filter
        );
        
    }
    
    /**
     * Get the position of the section header for this task from the $PageText global variable.
     * 
     * @access private
     * @global The text of the page to update.
     */
    private function _getSectionHeaderPosition() {
        
        global $PageText;
        $i = 0;
        $lastIndex = 0;
        
        do {
            $lastIndex = strpos( $PageText, "\n" . str_repeat('=', $i + 2) . $this->sectionHeaders[$i] . str_repeat('=', $i + 2), $lastIndex );
            $i++;
        }
        while ( $i < count($this->sectionHeaders) && $lastIndex !== false );
        
        return $lastIndex;
        
    }
    
    /**
     * Escape unsafe characters in inserted template calls with HTML entities, such as those which have a different meaning inside
     * and outside templates and which may conflict with the table syntax. This is decoded before changes are
     * committed to the server.
     * 
     * @access private
     * @param string $str The string in which to escape template calls.
     * @return string The string with template calls escaped.
     * @static
     */
    private static function _escapeUnsafeTemplateChars($str) {
        
        return preg_replace_callback(
            '/ \{\{ (?:[^\{\}]++ | \{(?!\{) | (?<!\{)\{ | (?R))*? \}\} /xu',
            function($match) {
                return str_replace( [ '&', '!', '|', '=' ], [ '&amp;', '&#33;', '&#124;', '&#61;' ], $match[0] );
            },
            $str
        );
        
    }
    
    /**
     * Create a table row string from an array of cell strings,
     * 
     * @access private
     * @param array $fieldStrings An array containing the cell strings to join.
     * @return string The row string.
     * @static
     */
    private static function _joinFieldStrings($fieldStrings) {
        
        $rowString = '| ';
        $numFields = count($fieldStrings);
        
        foreach ( $fieldStrings as $key => $fieldString ) {
            
            if ( $numFields - $key == 1 ) {  # Final cell
                $rowString .= $fieldString;
            }
            elseif ( strpos($fieldString, "\n") !== false ) {
                # When the cell content contains a newline, the single-pipe table cell separator
                # should be used
                $rowString .= $fieldString . "\n| ";
            }
            else {
                $rowString .= $fieldString . " || ";
            }
            
        }
        
        return $rowString;
        
    }
    
}

/**
 * An exception thrown from within an update task.
 * 
 * @author jfd34
 */
class UpdateTaskException extends Exception {
    
}

?>