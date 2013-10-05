<?php

/**
 * A raw parse result, containing only strings, before they are parsed to objects.
 * 
 * @author jfd34
 */
class CricinfoRawParseResult {
    
    /**
     * The cell values of the table row. Keys are constants from the DataNames class, values are strings.
     * 
     * @access private
     * @var array
     */
    private $_values = [];
    
    /**
     * The values of the href attributes of table cells containing links. Keys are constants from the DataNames class, values are strings.
     * 
     * @access private
     * @var array
     */
    private $_hrefValues = [];
    
    /**
     * The note (row with class="note" associated with the table row).
     */
    private $_note;
    
    /**
     * Returns the value of a cell.
     * 
     * @param int $name The name of the column for which to return the value, as a constant from the
     * DataNames class.
     * @return string The value of the cell as a string.
     */
    public function getValue($name) {
        if ( ! isset($this->_values[$name]) ) {
            return null;
        }
        
        return $this->_values[$name];
    }
    
    /**
     * Sets the value of a cell.
     * 
     * @param int $name The name of the column for which to set the value, as a constant from the
     * DataNames class.
     * @param string $value The value of the cell.
     */
    public function setValue($name, $value) {
        $this->_values[$name] = $value;
    }
    
    public function getHref($name) {
        if ( ! isset($this->_hrefValues[$name]) ) {
            return null;
        }
        
        return $this->_hrefValues[$name];
    }
    
    /**
     * Sets the href attribute value of a cell.
     * 
     * @param int $name The name of the column for which to set the value, as a constant from the
     * DataNames class.
     * @param string $value The value of the cell's link href attribute.
     */
    public function setHref($name, $value) {
        $this->_hrefValues[$name] = $value;
    }
    
    /**
     * Getter function
     * 
     * @property-read array $names An array containing the names (as constants of the DataNames class) which are used
     * as cell values in the row.
     * 
     * @property-read string $note The note (row with class="note" associated with the table row).
     */
    public function __get($name) {
        
        switch ( $name ) {
            case 'names' :
                return array_keys($this->_values);
                
            case 'note' :
                return $this->_note;
            
            default :
                trigger_error("Property {$name} does not exist in " . __CLASS__, E_USER_NOTICE);
        }
        
    }
    
}

?>