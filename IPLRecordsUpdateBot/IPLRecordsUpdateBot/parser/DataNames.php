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
 * Constants which are used as names of table column values. Each name has a data type associated with it,
 * and may also have a custom constructor which specifies how strings are parsed into DataTypes\DataTypeBase
 * subclass instances for values having that name.
 */
class DataNames {
    
    const PLAYER = 0;
    
    const PLAYER_NOFLAG = 1;
    
    const TEAM = 2;
    
    const OPPOSITION_TEAM = 3;
    
    const SCORE = 4;
    
    const OVERS = 5;
    
    const RUN_RATE = 6;
    
    const INNINGS_NUMBER = 7;
    
    const GROUND = 8;
    
    const DATE = 9;
    
    const SCORECARD_LINK = 10;
    
    const RUNS = 11;
    
    const BALLS = 12;
    
    const WICKETS = 13;
    
    const MARGIN_RUNS = 14;
    
    const MARGIN_WICKETS = 15;
    
    const TARGET = 16;
    
    const TEAM1 = 17;
    
    const TEAM2 = 18;
    
    const SEASON_ARTICLE = 19;
    
    const PLAYING_SPAN = 20;
    
    const MATCHES = 21;
    
    const INNINGS = 22;
    
    const HIGH_SCORE = 23;
    
    const NOT_OUT = 24;
    
    const BATTING_AVG = 25;
    
    const BATTING_SR = 26;
    
    const BATTING_100 = 27;
    
    const BATTING_50 = 28;
    
    const BATTING_0 = 29;
    
    const BATTING_4 = 30;
    
    const BATTING_6 = 31;
    
    const BATTING_4_6 = 32;
    
    const MAIDENS = 33;
    
    const BOWLING_FIGURES = 34;
    
    const BOWLING_AVG = 35;
    
    const BOWLING_SR = 36;
    
    const BOWLING_ECON = 37;
    
    const BOWLING_4W = 38;
    
    const BOWLING_5W = 39;
    
    const DISMISSALS = 40;
    
    const CATCHES = 41;
    
    const STUMPINGS = 42;
    
    const MAX_DISMISSALS_INNINGS = 43;
    
    const AVG_DISMISSALS_INNINGS = 44;
    
    const PARTNERSHIP_WKT = 45;
    
    const PARTNERSHIP_RUNS = 46;
    
    const PARTNERSHIP_MEMBERS = 47;
    
    const PARTNERSHIP_MEMBERS_NOFLAG = 48;
    
    const EXTRAS = 49;
    
    const BYES = 50;
    
    const LEG_BYES = 51;
    
    const WIDES = 52;
    
    const NO_BALLS = 53;
    
    const SERIES_RECORDS_SEASON = 54;
    
    const SERIES_RECORDS_TEAM = 55;
    
    const CATCHES_AND_STUMPINGS = 56;
    
    const PLAYER_CURRENT_TEAM = 57;
    
    const BOWLING_FIGURES_CONSTRUCTED = 58;
    
    const MAX_OVERS = 59;
    
    const BALLS_REMAINING = 60;
   
}

/*
    The types for each of the DataNames constants. The "DataTypes\" namespace prefix is automatically prepended.
 */
$DataNameTypes = [
    
    DataNames::PLAYER                       => 'Player',
    DataNames::PLAYER_NOFLAG                => 'Player',
    DataNames::TEAM                         => 'Team',
    DataNames::OPPOSITION_TEAM              => 'Team',
    DataNames::SCORE                        => 'Score',
    DataNames::OVERS                        => 'Float',
    DataNames::RUN_RATE                     => 'Float',
    DataNames::INNINGS_NUMBER               => 'Integer',
    DataNames::GROUND                       => 'Ground',
    DataNames::DATE                         => 'Date',
    DataNames::SCORECARD_LINK               => 'ExternalLink',
    DataNames::RUNS                         => 'Integer',
    DataNames::BALLS                        => 'Integer',
    DataNames::WICKETS                      => 'Integer',
    DataNames::MARGIN_RUNS                  => 'NumericSortedString',
    DataNames::MARGIN_WICKETS               => 'NumericSortedString',
    DataNames::TARGET                       => 'Integer',
    DataNames::TEAM1                        => 'Team',
    DataNames::TEAM2                        => 'Team',
    DataNames::PLAYING_SPAN                 => 'String',
    DataNames::MATCHES                      => 'Integer',
    DataNames::INNINGS                      => 'Integer',
    DataNames::HIGH_SCORE                   => 'NumericSortedString',
    DataNames::NOT_OUT                      => 'Integer',
    DataNames::BATTING_AVG                  => 'Float',
    DataNames::BATTING_SR                   => 'Float',
    DataNames::BATTING_100                  => 'Integer',
    DataNames::BATTING_50                   => 'Integer',
    DataNames::BATTING_0                    => 'Integer',
    DataNames::BATTING_4                    => 'Integer',
    DataNames::BATTING_6                    => 'Integer',
    DataNames::BATTING_4_6                  => 'Integer',
    DataNames::SEASON_ARTICLE               => 'SeasonArticleLink',
    DataNames::MAIDENS                      => 'Integer',
    DataNames::BOWLING_FIGURES              => 'BowlingFigures',
    DataNames::BOWLING_AVG                  => 'Float',
    DataNames::BOWLING_ECON                 => 'Float',
    DataNames::BOWLING_SR                   => 'Float',
    DataNames::BOWLING_4W                   => 'Integer',
    DataNames::BOWLING_5W                   => 'Integer',
    DataNames::DISMISSALS                   => 'Integer',
    DataNames::CATCHES                      => 'Integer',
    DataNames::STUMPINGS                    => 'Integer',
    DataNames::MAX_DISMISSALS_INNINGS       => 'Integer',
    DataNames::AVG_DISMISSALS_INNINGS       => 'Float',
    DataNames::PARTNERSHIP_WKT              => 'NumericSortedString',
    DataNames::PARTNERSHIP_RUNS             => 'NumericSortedString',
    DataNames::PARTNERSHIP_MEMBERS          => 'Partnership',
    DataNames::PARTNERSHIP_MEMBERS_NOFLAG   => 'Partnership',
    DataNames::EXTRAS                       => 'Integer',
    DataNames::BYES                         => 'Integer',
    DataNames::LEG_BYES                     => 'Integer',
    DataNames::WIDES                        => 'Integer',
    DataNames::NO_BALLS                     => 'Integer',
    DataNames::SERIES_RECORDS_SEASON        => 'SeasonArticleLink',
    DataNames::SERIES_RECORDS_TEAM          => 'Team',
    DataNames::CATCHES_AND_STUMPINGS        => 'Integer',
    DataNames::PLAYER_CURRENT_TEAM          => '*',
    DataNames::BOWLING_FIGURES_CONSTRUCTED  => 'BowlingFigures',
    DataNames::MAX_OVERS                    => 'Float',
    DataNames::BALLS_REMAINING              => 'Integer',
    
];

/*
    Decimal precision for names whose type is set to Float.
 */
$DataNameFloatPrecision = [
    DataNames::OVERS                        => 1,
    DataNames::MAX_OVERS                    => 1,
    DataNames::RUN_RATE                     => 2,
    DataNames::BATTING_AVG                  => 2,
    DataNames::BATTING_SR                   => 2,
    DataNames::BOWLING_AVG                  => 2,
    DataNames::BOWLING_ECON                 => 2,
    DataNames::AVG_DISMISSALS_INNINGS       => 3,
];


/*
    Custom constructors for certain data names. These functions must accept three parameters:
    - The value of the table cell associated with the data name.
    - The href attribute of the table cell value if it contains a link (null if there is no link)
    - A CricinfoRawParseResult object containing the raw parse result.
    
    The function must return a value of the type associated with the data name in the $DataNameTypes array.
    
    If a data name has no default conructor, the value of the table cell is passed as the first parameter to the constructor
    of the type mentioned in the $DataNameTypes array.
*/
$DataNameConstructors = [
    
    DataNames::PLAYER => function($value, $href, CricinfoRawParseResult $result) {
        
        global $CricinfoPlayerNameTranslationTable;
        
        preg_match(CricinfoDataParser::PLAYER_ID_REGEX, $href, $idMatch);
        $id = (int) $idMatch[1];
        
        if ( isset($CricinfoPlayerNameTranslationTable[$id]) ) {  # Check for the UID and use it if it exists
            return new DataTypes\Player( $id );
        }
        
        return new DataTypes\Player( $value );
        
    },
    
    DataNames::PLAYER_NOFLAG => function($value, $href, CricinfoRawParseResult $result) {
        $player = call_user_func($DataNameConstructors[DataNames::PLAYER], $value, $href);
        $player->useFlag = false;
        return $player;
    },
    
    DataNames::OPPOSITION_TEAM => function($value, $href, $result) {
        return new DataTypes\Team( substr($value, 2) );  # Remove "v "
    },
    
    DataNames::GROUND => function($value, $href, CricinfoRawParseResult $result) {
        
        global $CricinfoGroundNameTranslationTable;
        
        preg_match(CricinfoDataParser::GROUND_ID_REGEX, $href, $idMatch);
        $id = (int) $idMatch[1];
        
        return new DataTypes\Ground($id);
        
    },
    
    DataNames::SCORECARD_LINK => function($value, $href, CricinfoRawParseResult $result) {
        return new DataTypes\ExternalLink( "http://www.espncricinfo.com{$href}" );  # Resolve relative URIs
    },
    
    DataNames::PLAYING_SPAN => function($value, $href, CricinfoRawParseResult $result) {
        return new DataTypes\String( str_replace('-', '&#8211;', $value) );  # Replace hyphen with en-dash
    },
    
    DataNames::SEASON_ARTICLE => function($value, $href, CricinfoRawParseResult $result) {
        return new DataTypes\SeasonArticleLink( date( 'Y', strtotime($result->getValue(DataNames::DATE)) ) );
    },
    
    DataNames::PARTNERSHIP_MEMBERS => function($value, $href, CricinfoRawParseResult $result) {
        list($player1Name, $player2Name) = explode(', ', $value);
        return new DataTypes\Partnership(
            new DataTypes\Player($player1Name),
            new DataTypes\Player($player2Name)
        );
    },
    
    DataNames::PARTNERSHIP_MEMBERS_NOFLAG => function($value, $href, CricinfoRawParseResult $result) {
        $partners = call_user_func($DataNameConstructors[DataNames::PARTNERSHIP_MEMBERS], $value);
        $partners->player1->useFlag = false;
        $partners->player2->useFlag = false;
        return $partners;
    },
    
    DataNames::SERIES_RECORDS_SEASON => function($value, $href, CricinfoRawParseResult $result) {
        $seasonYearMappings = [ '2007/08' => '2008', '2009' => '2009', '2009/10' => '2010', '2011' => '2011', '2012' => '2012', '2013' => '2013', ];
        
        preg_match(CricinfoDataParser::SERIES_RECORDS_TEAM_YEAR_REGEX, $result->note, $noteMatch);
        return new DataTypes\SeasonArticleLink( $seasonYearMappings[$noteMatch[2]] );
    },
    
    DataNames::SERIES_RECORDS_TEAM => function($value, $href, CricinfoRawParseResult $result) {        
        preg_match(CricinfoDataParser::SERIES_RECORDS_TEAM_YEAR_REGEX, $result->note, $noteMatch);
        return new DataTypes\Team( $noteMatch[1] );
    },
    
    DataNames::CATCHES_AND_STUMPINGS => function($value, $href, CricinfoRawParseResult $result) {
        return new DataTypes\Integer( $result->getValue(DataNames::CATCHES) + $result->getValue(DataNames::STUMPINGS) );
    },
    
    DataNames::PLAYER_CURRENT_TEAM => function($value, $href, CricinfoRawParseResult $result) {
        $playerObj = new DataTypes\Player( $result->getValue(DataNames::PLAYER) );
        
        if ( ! isset( $playerObj->team ) ) {  # For retired players
            return new DataTypes\Undefined();
        }
        
        return new DataTypes\Team( $playerObj->team );
    },
    
    DataNames::BOWLING_FIGURES_CONSTRUCTED => function($value, $href, CricinfoRawParseResult $result) {
        return new DataTypes\BowlingFigures( $result->getValue(DataNames::WICKETS) . '/' . $result->getValue(DataNames::RUNS) );
    },
    
];
    
?>