<?php

namespace DataTypes {
    
    /**
     * Base class for all data types
     * 
     * @author jfd34
     */
    abstract class DataTypeBase {
        
        /**
         * Getter function.
         *
         * @property mixed $value The value of the type object.
         * @property-read mixed $sortKey The sort key for the type object, used when sorting table rows.
         * @access public
         */
        public function __get($name) {
            
            switch ( $name ) {
                case 'value' :
                    return $this->_getValue();
                    
                case 'sortKey' :
                    return $this->_getSortKey();
                
                default :
                    trigger_error("Property {$name} does not exist in " . __CLASS__, E_USER_NOTICE);
            }
            
        }
        
        /**
         * Setter function.
         *
         * @property mixed $value The value of the type object.
         * @access public
         */
        public function __set($name, $value) {
            
            switch ( $name ) {
                case 'value' :
                    $this->_setValue($value);
                    break;
                    
                default :
                    throw new UpdateTaskUpdateTaskException("Property {$name} does not exist in class " . __CLASS__ . " or is read-only.");
            }
            
        }
        
        /**
         * Returns the value of the type object.
         * 
         * @return mixed The value of the type object.
         * @access protected
         */
        abstract protected function _getValue();
        
        /**
         * Sets the value of the type object.
         *
         * @param mixed $value The value to be set.
         * @access protected
         */
        abstract protected function _setValue($value);
        
        /**
         * Returns the sort key of the type object. The sort key is used when sorting results after parsing.
         * 
         * @return mixed The sort key of the type object.
         * @access protected
         */
        abstract protected function _getSortKey();
        
        /**
         * Formats the type object to a string.
         * 
         * @return string The string representation of the type object.
         * @access public
         */
        abstract public function formatToString();
        
    }
    
    class Undefined extends DataTypeBase {
        
        protected function _getValue() {
            return null;
        }
        
        protected function _setValue($value) {
            
        }
        
        protected function _getSortKey() {
            return null;
        }
        
        public function formatToString() {
            return '-';
        }
        
    }
    
    /**
     * A simple integer.
     * 
     * @author jfd34
     */
    class Integer extends DataTypeBase {
        
        /**
         * The value of the type object.
         *
         * @access private
         * @var int
         */
        private $_value;
        
        /**
         * Constructor function.
         * 
         * @param int $value The value to be set
         */
        public function __construct($value) {
            $this->value = $value;
        }
        
        protected function _getValue() {
            return $this->_value;
        }
        
        protected function _setValue($value) {
            $this->_value = (int) $value;
        }
        
        protected function _getSortKey() {
            return $this->_value;
        }
        
        public function formatToString() {
            return (string) $this->value;
        }
        
    }
    
    /**
     * A simple floating-point number.
     * 
     * @author jfd34
     */
    class Float extends DataTypeBase {
        
        /**
         * The value of the type object.
         *
         * @access private
         * @var float
         */
        private $_value;
        
        /**
         * Constructor function.
         * 
         * @param float $value The value to be set
         */
        public function __construct($value) {
            $this->value = $value;
        }
        
        protected function _getValue() {
            return $this->_value;
        }
        
        protected function _setValue($value) {
            $this->_value = (float) $value;
        }
        
        protected function _getSortKey() {
            return $this->_value;
        }
        
        /**
         * @param int $precision The number of decimal places to use in the returned string.
         */
        public function formatToString($precision = null) {
            if ( isset($precision) ) {
                $value = (string) round($this->value, $precision);

                if ( $precision > 0 ) {
                    if ( strpos($value, '.') !== false ) {
                        $value = str_pad($value, strpos($value, '.') + $precision + 1, '0');
                    }
                    else {
                        $value .= '.' . str_repeat('0', $precision);
                    }
                    
                    return $value;
                }
            }
            
            return (string) $this->value;
        }
        
    }
    
    /**
     * A simple string.
     * 
     * @author jfd34
     */
    class String extends DataTypeBase {
        
        /**
         * The value of the type object.
         *
         * @access private
         * @var string
         */
        private $_value;
        
        /**
         * Constructor function.
         * 
         * @param string $value The value to be set
         */
        public function __construct($value) {
            $this->value = $value;
        }
        
        protected function _getValue() {
            return $this->_value;
        }
        
        protected function _setValue($value) {
            $this->_value = (string) $value;
        }
        
        protected function _getSortKey() {
            return $this->_value;
        }
        
        public function formatToString() {
            return $this->value;
        }
        
    }
    
    /**
     * A string value with an integer sort key. The sort key is determined by casting the string to an integer.
     * 
     * @author jfd34
     */
    class NumericSortedString extends DataTypeBase {
        
        /**
         * The value of the type object.
         *
         * @access private
         * @var string
         */
        private $_value;
        
        /**
         * The integer sort key of the type object.
         *
         * @access private
         * @var int
         */
        private $_sortKey = 0;
        
        /**
         * Constructor function.
         * 
         * @param string $value The value to be set
         */
        public function __construct($value) {
            $this->value = $value;
        }
        
        protected function _getValue() {
            return $this->_value;
        }
        
        protected function _setValue($value) {
            $this->_value = (string) $value;
            $this->_sortKey = (float) $value;
        }
        
        protected function _getSortKey() {
            return $this->_sortKey;
        }
        
        public function formatToString() {
            return "{{ntsh|{$this->_sortKey}}}" . $this->value;
        }
        
    }
    
    /**
     * A simple date.
     * 
     * @author jfd34
     */
    class Date extends DataTypeBase {
        
        /**
         * The value of the type object as a Unix timestamp.
         *
         * @access private
         * @var float
         */
        private $_timestamp;
        
        /**
         * The default date format to output when using the formatToString() method.
         * 
         * @access public
         * @static
         * @var string
         */
        public static $format = 'j F Y';
        
        /**
         * Constructor function.
         * 
         * @param string|int $value A date string or Unix timestamp (integer) to use as the value.
         */
        public function __construct($value) {
            $this->value = is_int($value) ? $value : strtotime($value);
        }
        
        protected function _getValue() {
            return $this->_timestamp;
        }
        
        protected function _setValue($value) {
            $this->_timestamp = (int) $value;
        }
        
        protected function _getSortKey() {
            return $this->_timestamp;
        }
        
        public function formatToString() {
            return '{{ntsh|' . date('Ymd', $this->value) . '}}' . date(self::$format, $this->value);
        }
        
    }
    
    /**
     * A data type representing an individual player.
     * 
     * @author jfd34
     */
    class Player extends DataTypeBase {
        
        /**
         * Set this to false to suppress the flag icon of the player's country before the name.
         * 
         * @access public
         * @var bool
         */
        public $useFlag = true;
        
        /**
         * The player's Cricinfo name or UID.
         *
         * @access private
         * @var string|int
         */
        private $_value;
        
        /**
         * The player's country.
         *
         * @access public
         * @var string
         */
        public $country;
        
        /**
         * The player's current team. Null for retired players.
         *
         * @access public
         * @var string
         */
        public $team;
        
        /**
         * The player's first name.
         *
         * @access public
         * @var string
         */
        public $firstName;
        
        /**
         * The player's last name.
         *
         * @access public
         * @var string
         */
        public $lastName;
        
        /**
         * The player's Wikipedia article title, if not the same as (firstname lastname). Used for disambiguation purposes.
         *
         * @access public
         * @var string
         */
        public $wikiArticle;
        
        /**
         * The player's sort key, if not the same as (lastname, firstname).
         *
         * @access public
         * @var string
         */
        public $nameSortKey;
        
        /**
         * Constructor function.
         * 
         * @param string|int $value The Cricinfo player name as a string or the player's Cricinfo UID (found in the profile page URL) as an integer.
         * UIDs are only applicable under certain circumstances.
         */
        public function __construct($value) {
            $this->value = $value;
        }
        
        protected function _getValue() {
            return $this->_value;
        }
        
        /**
         * @global The table which is used for transforming Cricinfo names to actual names and also contains
         * data about the player's current team, country, Wikipedia article title and sort key.
         */
        protected function _setValue($value) {
            
            global $CricinfoPlayerNameTranslationTable;
            
            if ( ! is_string($value) && ! is_int($value) ) {
                throw new UpdateTaskException("Player name must be a string or an integer.");
            }
            
            $this->_value = $value;
            
            $tableEntry = @$CricinfoPlayerNameTranslationTable[$value];
            if ( ! $tableEntry ) throw new UpdateTaskException("Player not found in transformation table: {$value}");
            
            $this->team = isset($tableEntry['team']) ? $tableEntry['team'] : null;
            $this->country = $tableEntry['country'];
            $this->firstName = $tableEntry['first'];
            $this->lastName = $tableEntry['last'];
            $this->wikiArticle = isset($tableEntry['page']) ? $tableEntry['page'] : null;
            $this->nameSortKey = isset($tableEntry['sort']) ? $tableEntry['sort'] : null;
            
        }
        
        protected function _getSortKey() {
            return isset($this->nameSortKey) ? $this->nameSortKey : "{$this->lastName}, {$this->firstName}";
        }
        
        /**
         * @param $useSortName Set this to false if you do not want to use a {{sortname}} template in the returned string.
         */
        public function formatToString($useSortName = true) {
            $string = ( $this->useFlag ? "{{flagicon|{$this->country}}} " : '' );
            
            if ( $useSortName ) {
                $string .= "{{sortname|1={$this->firstName}|2={$this->lastName}";
                $string .= ( $this->wikiArticle ? "|3={$this->wikiArticle}" : '' );
                $string .= ( $this->nameSortKey ? "|4={$this->sortKey}" : '' );
                $string .= '}}';
            }
            else {
                $string .= '[[' . ( $this->wikiArticle ? $this->wikiArticle . '|' : '' ) . $this->firstName . ' ' . $this->lastName . ']]';
            }
            
            return $string;
        }
        
    }
    
    /**
     * A data type representing a team.
     * 
     * @author jfd34
     */
    class Team extends DataTypeBase {
        
        /**
         * The team's name.
         *
         * @access public
         * @var string
         */
        public $name;
        
        /**
         * The team's alias parameter for the {{cr-IPL}} template.
         *
         * @access public
         * @var string
         */
        public $crIPLAlias;
        
        /**
         * Constructor function.
         * 
         * @param string $value The name of the team. Names listed in translate.php are accepted.
         */
        public function __construct($value) {
            $this->value = $value;
        }
        
        protected function _getValue() {
            return $this->name;
        }
        
        /**
         * @global The table used transform Cricinfo short team names into actual team names.
         */
        protected function _setValue($value) {
            global $CricinfoTeamNameTranslationTable;
            
            $tableEntry = @$CricinfoTeamNameTranslationTable[$value];
            if ( ! $tableEntry ) throw new UpdateTaskException("Team not found in transformation table: {$value}");
            
            $this->name = $tableEntry['name'];
            $this->crIPLAlias = $tableEntry['alias'];
        }
        
        protected function _getSortKey() {
            return $this->name;
        }
        
        public function formatToString() {
            return "{{cr-IPL|{$this->crIPLAlias}}}";
        }
        
    }
    
    /**
     * A data type representing a ground.
     * 
     * @author jfd34
     */
    class Ground extends DataTypeBase {
        
        /**
         * The ground's Cricinfo UID (found in the profile page URI)
         *
         * @access private
         * @var int
         */
        private $_uid;
        
        /**
         * The ground's name.
         *
         * @access public
         * @var string
         */
        public $name;
        
        /**
         * The ground's location.
         *
         * @access public
         * @var string
         */
        public $location;
        
        /**
         * Constructor function.
         * 
         * @param int $value The Cricinfo UID of the ground. This can be obtained from the URI of its profile page.
         */
        public function __construct($value) {
            $this->value = $value;
        }
        
        protected function _getValue() {
            return $this->_uid;
        }
        
        /**
         * @global The table used to translate Cricinfo ground UIDs to actual names.
         */
        protected function _setValue($value) {
            global $CricinfoGroundNameTranslationTable;
            
            $this->_uid = (int) $value;
            
            $tableEntry = @$CricinfoGroundNameTranslationTable[$this->_uid];
            if ( ! $tableEntry ) throw new UpdateTaskException("Ground not found in transformation table: {$value}");
            
            $this->name = $tableEntry['name'];
            $this->location = $tableEntry['location'];
        }
        
        protected function _getSortKey() {
            return $this->location . ', ' . $this->name;
        }
        
        public function formatToString() {
            return "'''[[{$this->location}]]''' – [[{$this->name}]]";
        }
        
    }
    
    /**
     * A data type representing a match score.
     * 
     * @author jfd34
     */
    class Score extends DataTypeBase {
        
        /**
         * The number of runs scored.
         *
         * @access public
         * @var int
         */
        public $runs;
        
        /**
         * The number of wickets lost.
         *
         * @access public
         * @var int
         */
        public $wickets;
        
        /**
         * Constructor function.
         * 
         * @param string $value The value to be set. Should be a string in the form "runs/wickets" (not the Australian format "wickets/runs")
         */
        public function __construct($value) {
            $this->value = $value;
        }
        
        protected function _getValue() {
            return $this->runs . (($this->wickets != 10) ? "/{$this->wickets}" : '');
        }
        
        protected function _setValue($value) {
            @list($runs, $wickets) = explode('/', $value);
            if ( ! isset($wickets) ) $wickets = 10;
            
            $this->runs = (int) $runs;
            $this->wickets = (int) $wickets;
        }
        
        protected function _getSortKey() {
            return ($this->runs + 1) + 1 / ($this->wickets + 1);  # Add 1 to both runs and wickets to avoid divisions by zero.
        }
        
        public function formatToString() {
            return "{{ntsh|{{#expr:{$this->runs} + 1 / ({$this->wickets} + 1)}}}}{$this->value}";
        }
    }
    
    /**
     * A data type representing bowling figures.
     * 
     * @author jfd34
     */
    class BowlingFigures extends DataTypeBase {
        
        /**
         * The number of runs conceded.
         *
         * @access public
         * @var int
         */
        public $runs;
        
        /**
         * The number of wickets taken.
         *
         * @access public
         * @var int
         */
        public $wickets;
        
        /**
         * Constructor function.
         * 
         * @param string $value The value to be set. Should be a string in the form "wickets/runs"
         */
        public function __construct($value) {
            $this->value = $value;
        }
        
        protected function _getValue() {
            return "{$this->wickets}/{$this->runs}";
        }
        
        protected function _setValue($value) {
            list($wickets, $runs) = explode('/', $value);
            $this->runs = (int) $runs;
            $this->wickets = (int) $wickets;
        }
        
        protected function _getSortKey() {
            return ($this->wickets + 1) + 1 / ($this->runs + 1);  # Add 1 to both runs and wickets to avoid divisions by zero.
        }
        
        public function formatToString() {
            return "{{ntsh|{{#expr:{$this->wickets} + 1 / ({$this->runs} + 1)}}}}{$this->value}";
        }
        
    }
    
    /**
     * A data type representing two players in a partnership.
     * 
     * @author jfd34
     */
    class Partnership extends DataTypeBase {
        
        /**
         * The first player.
         * 
         * @access public
         * @var DataTypes\Player
         */
        public $player1;
        
        /**
         * The second player.
         * 
         * @access public
         * @var DataTypes\Player
         */
        public $player2;
        
        /**
         * Constructor function.
         * 
         * @param Player $player1 The first player.
         * @param Player $player2 The second player.
         */
        public function __construct(Player $player1, Player $player2) {
            $this->player1 = $player1;
            $this->player2 = $player2;
        }
        
        protected function _getValue() {
            return [$this->_player1, $this->_player2];
        }
        
        protected function _setValue($value) {
            $this->player1 = $value[0];
            $this->player2 = $value[1];
        }
        
        protected function _getSortKey() {
            if ( $this->player1->sortKey < $this->player2->sortKey ) {
                return $this->player1->sortKey;
            }
            return $this->player2->sortKey;
        }
        
        public function formatToString() {
            # Note that HTML has to be used here - wikitext for bulleted lists is newline-sensitive, and may break
            # table syntax.
            return "<ul><li>" . $this->player1->formatToString( false ) . "</li><li>" . $this->player2->formatToString( false ) . "</li></ul>";
        }
        
    }
    
    /**
     * A data type representing a link fo a particular tournament year.
     * 
     * @author jfd34
     */
    class SeasonArticleLink extends DataTypeBase {
        
        /**
         * The year of the tournament. This is returned/set with the $value property.
         * 
         * @access private
         * @var int
         */
        private $_year;
        
        /**
         * Constructor function.
         * 
         * @param int $value The year of the tournament.
         */
        public function __construct($value) {
            $this->value = $value;
        }
        
        protected function _getValue() {
            return $this->_year;
        }
        
        protected function _setValue($value) {
            $this->_year = (int) $value;
        }
        
        protected function _getSortKey() {
            return $this->_year;
        }
        
        public function formatToString() {
            return "[[{$this->_year} Indian Premier League|{$this->_year}]]";
        }
        
    }
    
    /**
     * A data type representing a link to an external URI.
     * 
     * @author jfd34
     */
    class ExternalLink extends DataTypeBase {
        
        /**
         * The URI of the external link. This is returned/set with the $value property.
         * 
         * @access private
         * @var string
         */
        private $_url;
        
        /**
         * The text to be displayed in the external link.
         * 
         * @access public
         * @var string
         */
        public $displayText;
        
        /**
         * Constructor function.
         * 
         * @param string $value The URI of the external link.
         * @param string $displayText The text to be displayed in the external link.
         */
        public function __construct($value, $displayText = null) {
            $this->value = $value;
            $this->displayText = $displayText;
        }
        
        protected function _getValue() {
            return $this->_url;
        }
        
        protected function _setValue($value) {
            $this->_url = (string) $value;
        }
        
        protected function _getSortKey() {
            return $this->displayText ?: $this->_url;
        }
        
        public function formatToString() {
            return "[{$this->_url}" . ($this->displayText ? ' ' . $this->displayText .']' : ']');
        }
        
    }
    
}