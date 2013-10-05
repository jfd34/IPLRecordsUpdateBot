<?php

include 'parser/CricinfoDataParser.php';
include 'parser/CricinfoRawParseResult.php';
include 'parser/CricinfoParseResult.php';
include 'parser/DataNames.php';
include 'parser/DataTypes.php';
include 'parser/translate.php';

include 'UpdateTask.php';
include 'APIInterface.php';
include 'ComplexUpdateTask.php';
include 'StatsUpdateTasks.php';

ini_set('display_errors', 'false');
ini_set('max_execution_time', 2000);

/**
 * Main class of IPLRecordsUpdateBot.
 */
class IPLRecordsUpdateBot {
    
    /**
     * The default limit (number of rows to include in the tables), unless overriden b a specific task.
     * 0 means no limit (all table rows will be included).
     * 
     * @static
     * @access public
     * @var int
     */
    public static $defaultLimit = 5;
    
    /**
     * The bot's username.
     * 
     * @access private
     * @var string
     */
    private $_username = 'IPLRecordsUpdateBot';
    
    /**
     * The bot's password.
     * 
     * @access private
     * @var string
     */
    private $_password;  # REMOVED FOR SECURITY AND/OR PRIVACY REASONS
    
    /**
     * The bot's HTTP User-Agent string.
     * 
     * @access private
     * @var string
     */
    private $_userAgent;  # REMOVED FOR SECURITY AND/OR PRIVACY REASONS
    
    /**
     * The title of the page which the bot has to edit.
     * 
     * @access private
     * @var string
     */
    private $_pageTitle = 'List of Indian Premier League records and statistics';
    
    /**
     * The time when the page has last been edited, in ISO 8601 format. Used to detect edit conflicts.
     * 
     * @access private
     * @var string
     */
    private $_pageLastEditTS;
    
    /**
     * The time (as a Unix timestamp) when the bot started running.
     * 
     * @access private
     * @var int
     */
    private $_startTime;
    
    /**
     * The edit token for editing the page.
     * 
     * @access private
     * @var string
     */
    private $_editToken;
    
    /**
     * Starts the bot.
     * 
     * @access public
     * @static
     */
    public static function start() {
        $bot = new IPLRecordsUpdateBot();
        $bot->exec();
    }
    
    /**
     * Error handler for errors occuring while the bot is running.
     * 
     * @access private
     * @static
     */
    private static function _errorHandler($code, $message, $file, $line) {
        
        file_put_contents(
            dirname(__DIR__) . '\\status\\error_log.txt',
            "CODE:{$code}|MESSAGE:" .nl2br($message) . "|FILE:{$file}|LINE:{$line}\r\n",
            FILE_APPEND
        );
        
        return true;
        
    }
    
    /**
     * Constructor function (private)
     * 
     * @access private
     */
    private function __construct() {
        
    }
    
    /**
     * Starts the bot.
     * 
     * @access public
     */
    public function exec() {
        
        set_error_handler( 'IPLRecordsUpdateBot::_errorHandler', E_ALL ^ E_NOTICE );
        
        $this->_startTime = time();
        
        APIInterface::$instance->headers[] = "User-Agent: {$this->_userAgent}";
        APIInterface::$instance->headers[] = "DNT: 1";
        
        $resume = isset( $_GET['resume'] );
        
        if ( file_exists( dirname(__DIR__) . '\\status\\status.txt' ) && ! $resume ) {
            unlink( dirname(__DIR__) . '\\status\\status.txt' );
        }
        if ( file_exists( dirname(__DIR__) . '\\status\\error_log.txt' ) ) {
            unlink( dirname(__DIR__) . '\\status\\error_log.txt' );
        }
        if ( file_exists( dirname(__DIR__) . '\\status\\edit_failed_backup.txt' ) && ! $resume ) {
            unlink( dirname(__DIR__) . '\\status\\edit_failed_backup.txt' );
        }
        
        $this->_login();
        
        if ( $resume ) {
            $this->_resumeSession();
            # If the backup file exists and resume=1 is set in the URL, resumes the previous edit session.
            # This is used in case an edit conflict or other error occurs when attempting to commit the changes
            # so that the tables to not have to be updated again.
        }
        else {
            $this->_startNewSession();
        }
        
        restore_error_handler();
        
    }
    
    /**
     * Starts a new editing session.
     * 
     * @access private
     */
    private function _startNewSession() {
        
        $this->_getPageText();
        $this->_updatePage();
        $this->_decodePageText();
        
        $this->_editPage();
        
    }
    
    /**
     * Resume the previous editing session, if it failed due to an edit confilct or an error while
     * committing the changes.
     * 
     * @access private
     */
    private function _resumeSession() {
        
        global $PageText;
        
        $this->_getPageText();
        $PageText = file_get_contents( dirname(__DIR__) . '\\status\\edit_failed_backup.txt' );
        
        if ( $PageText === false ) {
            $this->_triggerError( 'Cannot find the backup file', true );
        }
        
        $this->_pageLastEditTS = date( 'Y-m-d\TH:i:sZ', $this->_startTime );
        $this->_editPage();
        
    }
    
    /**
     * Logs in to the bot's account, and checks for new messages on its talk page.
     * 
     * @access private
     */
    private function _login() {
        
        try {
            APIInterface::$instance->login($this->_username, $this->_password);
        }
        catch ( APIInterfaceException $e ) {
            $this->_triggerError( 'Error logging in: ' . $e->getMessage(), true );
        }
        
        # Check if new talk page messages exist
        try {
            
            $obtainNewMsgStatusAPIResult = APIInterface::$instance->query(
                'GET',
                [
                    'action' => 'query',
                    'meta' => 'userinfo',
                    'uiprop' => 'hasmsg',
                ]
            );
            
            if ( isset($obtainNewMsgStatusAPIResult['query']['userinfo']['hasmsg']) ) {
            
                $this->_triggerError( 'New messages are available on the bot\'s talk page (<a href="https://en.wikipedia.org/wiki/User_talk:'
                    . urlencode($this->_username) . '" target="_blank">view</a> | <a href="https://en.wikipedia.org/w/index.php?title=User_talk:'
                    . urlencode($this->_username) . '&amp;diff=cur" target="_blank">last edit</a>)',
                    true
                );
                
            }
            
        }
        catch ( APIInterfaceException $e ) {
            $this->_triggerError( 'Error occured while obtaining new talk page message status: ' . $e->getMessage() );
        }
        
    }
    
    /**
     * Gets the text of the page and the edit token.
     * 
     * @access private
     * @global string The text of the page.
     */
    private function _getPageText() {
        
        global $PageText;
        
        try {
        
            $getPageTextAPIResult = APIInterface::$instance->query(
                'GET',
                [
                    'action' => 'query',
                    'prop' => 'info|revisions',
                    'titles' => $this->_pageTitle,
                    'intoken' => 'edit',
                    'rvprop' => 'content|timestamp',
                ]
            );
            
            $pageInfo = array_values( $getPageTextAPIResult['query']['pages'] )[0];
            
            if ( isset($pageInfo['missing']) || isset($pageInfo['invalid']) ) {
                $this->_triggerError( 'Error occured while obtaining article text/edit token: page does not exist or has an invalid title', true );
            }
            
            $PageText = $pageInfo['revisions'][0]['*'];
            $this->_validatePageText();
            $this->_encodePageText();
            
            $editToken = $pageInfo['edittoken'];
            if ( ! $editToken || $editToken == '+\\' || substr($editToken, -2) != '+\\' ) {
                $this->_triggerError( 'Bad edit token obtained', true );
            }
            $this->_editToken = $editToken;
            
            $this->_pageLastEditTS = $pageInfo['revisions'][0]['timestamp'];
        
        }
        catch ( APIInterfaceException $e ) {
            $this->_triggerError( 'Error occured while obtaining article text/edit token: ' . $e->getMessage(), true );
        }
    
    }
    
    /**
     * Validates the text of the page to make sure it can be edited. This checks if the page is a redirect, or if
     * it has a {{bots}} or {{nobots}} template which does not allow the bot to edit. If the page should not be edited,
     * a fatal error is triggered.
     * 
     * @access private
     * @global string The text of the page.
     */
    private function _validatePageText() {
        
        global $PageText;
        
        if ( preg_match('/\# \s*+ redirect \s*+ \[\[/ixu', $PageText) ) {
            $this->triggerError( 'The page is a redirect to another page.', true );
        }
        
        $botsNotAllowed = (
        
            preg_match( '/ \{\{ \s*+ (?: [Nn]obots | [Bb]ots \s*+\ | (?:.*?\|)? (?:deny \s*+ \= \s*+ all | allow \s*+ \= \s*+ none) ) /sux', $PageText )
            # {{nobots}} or {{bots}} with allow=none or deny=all
            || preg_match('/ \{\{ \s*+ [Bb]ots \s*+ \| (?:.*?\|)? deny \s*+ \= (?: [^\|]*?,)? \s*+ ' . preg_quote($this->_username, '/') . ' \s*+ (?: , | \| | \}\} ) /sux', $PageText)
            
            # {{bots}} with the username in the deny parameter
            
            || 
            (
                preg_match('/ \{\{ \s*+ [Bb]ots \s*+ \| (?:.*?\|)? allow \s*+ \= [^\|]*? (?: \| |\}\} ) /sux', $PageText)
                && ! preg_match('/ \{\{ \s*+ [Bb]ots \s*+ \| (?:.*?\|)? allow \s*+ \= (?: [^\|]*?, )? \s*+ (?:' . preg_quote($this->_username, '/') . ' | all)  \s*+ (?: , | \| | \}\} ) /sux', $PageText)
            )
            # {{bots}} with an allow parameter without the user name or "all"
        
        );
        
        if ( $botsNotAllowed ) {
            $this->triggerError( 'The page has a {{bots}} or {{nobots}} template which does not allow the bot to edit.', true );
        }
        
    }
    
    /**
     * Updates all the statistics tables on the page.
     * 
     * @access private
     * @global array An array of UpdateTask objects which should be run.
     */
    private function _updatePage() {
        
        global $StatsUpdateTasks;
        
        $tasksToRun = explode('|', $_GET['stats']);
        
        foreach ( $StatsUpdateTasks as $taskName => $task ) {
            
            if ( ! in_array($taskName, $tasksToRun) ) continue;
            
            try {
                $task->exec();
                $taskSuccessful = true;
            }
            catch ( UpdateTaskException $e ) {
                $taskSuccessful = false;
                $this->_triggerError( "Exception thrown in task {$taskName}: <div class=\"exception-msg\">" . $e->getMessage() . '</div>' );
            }
            
            file_put_contents( dirname(__DIR__) . '\\status\\status.txt', $taskName . '|' . (int) $taskSuccessful . "\r\n", FILE_APPEND );
            
        }
        
    }
    
    /**
     * Encode portions of the page which should not be changed. These include <nowiki> and <pre> tags,
     * HTML comments and certain characters in template calls.
     * 
     * @access private
     * @global string The text of the page.
     */
    private function _encodePageText() {
        
        global $PageText;
        
        # HTML comments
        $PageText = preg_replace_callback(
            '/\<\!--(.*?)--\>/us',
            function($match) {
                return '<!--' . str_replace(
                        ['&', '<', '>', '{', '}', '|', '!', '='],
                        ['&amp;', '&lt;', '&gt;', '&#123;', '&#125;', '&#124;', '&#33;', '&#61;'],
                        $match[1]
                    ) . '-->';
            },
            $PageText
        );
         
        # Tags where wikitext is not parsed
        $PageText = preg_replace_callback(
            '/(\<(nowiki|pre|math|source|syntaxhighlight)(?(?=\s)[^\>]*+)\>)(.*?)\<\/\2\>/us',  # Allow attributes only if there is a space after the tag name
            function($match) {
                return $match[1] . str_replace(
                        ['&', '<', '>', '{', '}', '|', '!', '='],
                        ['&amp;', '&lt;', '&gt;', '&#123;', '&#125;', '&#124;', '&#33;', '&#61;' ],
                        $match[3]
                    ) . "</{$match[2]}>" ;
            },
            $PageText
        );
         
        # Characters in template calls which may conflict with header and table syntax
        $PageText = preg_replace_callback(
            '/\{\{(?:[^\{\}]++|(?<!\{)\{|\}(?!\})|(?R))*?\}\}/u',
            function($match) {
                return str_replace(['&', '|', '!', '='], ['&amp;', '&#124;', '&#33;', '&#61;'], $match[0]);
            },
            $PageText
        );
        
    }
    
    /**
     * Decodes the page text which has been encoded by _encodePageText() once it has been changed.
     * 
     * @access private
     * @global string The text of the page.
     */
    private function _decodePageText() {
        
        global $PageText;
        
        # Decode encoded comments, nowiki tags etc. before commiting the edit

        $PageText = preg_replace_callback(
            '/\{\{(?:[^\{\}]++|(?<!\{)\{|\}(?!\})|(?R))*?\}\}/u',
            function($match) {
                return html_entity_decode($match[0], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            },
            $PageText
        );
         
        $PageText = preg_replace_callback(
            '/(\<(syntaxhighlight|source|math|pre|nowiki)(?(?=\s)[^\>]*+)\>)(.*?)\<\/\2\>/us',
            function($match) {
                return $match[1] . html_entity_decode($match[3], ENT_QUOTES | ENT_HTML5, 'UTF-8') . '</' . $match[2] . '>' ;
            },
            $PageText
        );
         
        $PageText = preg_replace_callback(
            '/\<\!--(.*?)--\>/us',
            function($match) {
                return '<!--' . html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8') . '-->';
            },
            $PageText
        );
        
    }
    
    /**
     * Commits the page edit to the server.
     * 
     * @access private
     * @global string The text of the page.
     */
    private function _editPage() {
        
        global $PageText;
        
        $endTime = time();
        
        $statusFile = file( dirname(__DIR__) . '\\status\\status.txt' );
        $succeededTasks = 0;
        $failedTasks = 0;
        $editSummary = "[[User:{$this->_username}|{$this->_username}]]: Updating statistics";
        
        # Read the status file and count the number of tasks which succeeded/failed
        # If the status file does not exist for some reason, use a generic edit summary.
        
        if ( $statusFile ) {
            foreach ( $statusFile as $line ) {
                if ( trim($line) == '' ) continue;
                
                @list($name, $status) = explode('|', $line);
                if ( (int) $status ) $succeededTasks++;
                else $failedTasks++;
            }
            $editSummary .= " ({$succeededTasks} updates successful, {$failedTasks} failed)";
        }
        else {
            $this->_triggerError( 'Unable to find the status file.' );
        }
        
        $timeTaken = $endTime - $this->_startTime;
        $editSummary .= ' (' . (int) ($timeTaken / 60) . ':' . str_pad($timeTaken % 60, 2, '0', STR_PAD_LEFT) . ')';
        
        # Store the text to be submitted to a backup file, in case the edit fails.
        file_put_contents( dirname(__DIR__) . '\\status\\edit_failed_backup.txt', $PageText );
        
        $editPageAPIResult = APIInterface::$instance->query(
            'POST',
            [],
            [
                'action' => 'edit',
                'title' => $this->_pageTitle,
                'summary' => $editSummary,
                'text' => $PageText,
                'basetimestamp' => $this->_pageLastEditTS,
                'nocreate' => '1',
                'md5' => md5($PageText),
                'token' => $this->_editToken,
            ]
        );
        
        if ( $editPageAPIResult['edit']['result'] == 'Success' ) {
            unlink(dirname(__DIR__) . '\\status\\edit_failed_backup.txt');  # Delete the backup text file if the edit is sucessful.
            die( "#success|{$editPageAPIResult['edit']['oldrevid']}-{$editPageAPIResult['edit']['newrevid']}" );
        }
        else {
            $this->_triggerError( 'Edit failed.', true );
        }
        
    }
    
    /**
     * Triggers an error message.
     * 
     * @param string $message The error message.
     * @param bool $fatal Set this to true to stop the script and output the error message to the client.
     * If this is false, the script continues to run, and the custom error handler registered for the E_USER_WARNING
     * error level, if set, will be triggered.
     */
    private function _triggerError($message, $fatal = false) {
        
        if ( $fatal ) {
            die( "#error|{$message}" );
        }
        trigger_error( $message, E_USER_WARNING );
    }
    
}

?>