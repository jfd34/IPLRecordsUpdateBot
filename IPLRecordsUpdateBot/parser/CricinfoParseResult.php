<?php

/**
 * A parsed table row.
 * 
 * @author jfd34
 */
class CricinfoParseResult {
    
    /**
     * The cell values of the table row. Keys are constants from the DataNames class, values are
     * objects which are instances of subclasses of DataTypes\DataTypeBase.
     * 
     * @access private
     * @var array
     */
    private $_values = [];
    
    /**
     * Returns the value of a cell.
     * 
     * @param int $name The name of the column for which to return the value, as a constant from the
     * DataNames class.
     * @return DataTypes\DataTypeBase The value as an instance of a DataTypes\DataTypeBase subclass.
     */
    public function getValue($name) {
        return $this->_values[$name];
    }
    
    /**
     * Sets the value of a cell.
     * 
     * @param int $name The name of the column for which to set the value, as a constant from the
     * DataNames class.
     * @param DataTypes\DataTypeBase $value The value as an instance of a DataTypes\DataTypeBase subclass.
     */
    public function setValue($name, DataTypes\DataTypeBase $value) {
        $this->_values[$name] = $value;
    }
    
}

?>