<?php

/**
 * An update task which is used when more than one table must be parsed on a single page, so that the
 * page does not have to be reloaded over and over again. This can be used when a single page of data should be used
 * to update more than one table.
 * 
 * @author jfd34
 */
class ComplexUpdateTask extends UpdateTask {
    
    /**
     * An array containing the options for each task. This must be an indexed array of arrays, each of those arrays
     * having keys with the names of the properties of the UpdateTask class. If a key is omited, the last used value
     * of the property (or if no value has been set, the value of the property on the object itself) will be used.
     * 
     * @access public
     * @var array
     */
    public $options;
    
    /**
     * Constructor function.
     * 
     * @access public
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Starts the task.
     * 
     * @access public
     */
    public function exec() {
    
        global $PageText;
        
        foreach ( $this->options as $options ) {
            
            # Set the properties of the object from each element of the options array.
            $this->uri = isset($options['uri']) ? $options['uri'] : $this->uri;
            $this->tableIndex = isset($options['tableIndex']) ? $options['tableIndex'] : $this->tableIndex;
            $this->sectionHeaders = isset($options['sectionHeaders']) ? $options['sectionHeaders'] : $this->sectionHeaders;
            $this->parseOrder = isset($options['parseOrder']) ? $options['parseOrder'] : $this->parseOrder;
            $this->sortOrder = isset($options['sortOrder']) ? $options['sortOrder'] : $this->sortOrder;
            $this->sortReverse = isset($options['sortReverse']) ? $options['sortReverse'] : $this->sortReverse;
            $this->sortMode = isset($options['sortMode']) ? $options['sortMode'] : $this->sortMode;
            $this->filter = isset($options['filter']) ? $options['filter'] : $this->filter;
            $this->limit = isset($options['limit']) ? $options['limit'] : $this->limit;
            $this->tableOrder = isset($options['tableOrder']) ? $options['tableOrder'] : $this->tableOrder;
            $this->tableAddCallback = isset($options['tableAddCallback']) ? $options['tableAddCallback'] : $this->tableAddCallback;
            
            parent::exec();
            
        }
        
    }
    
}

?>