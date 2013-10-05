<?php

/**
 * The default callback for the tableAddCallback for all update tasks.
 * 
 * @param string $string The content of the table cell.
 * @param int $pos The position (column number) of the cell in the row.
 * @param int $name The type of the content of the cell (a constant from the DataNames class).
 * @param CricinfoParseResult $row The row which is to be written.
 * @return string The new content of the cell.
 */
function _defaultTableAddCallback($string, $pos, $name, CricinfoParseResult $row) {
    
    # Make the text bold in the first column of the table (except if it is DataNames::GROUND, which already contains formatting).
    if ( $pos == 0 && $name != DataNames::GROUND ) {
        $string = "'''{$string}'''";
    }

    # Some cells must always be aligned left.
    $alwaysAlignLeft = [
        DataNames::PLAYER, DataNames::PLAYER_NOFLAG, DataNames::TEAM, DataNames::OPPOSITION_TEAM, DataNames::SERIES_RECORDS_TEAM,
        DataNames::PARTNERSHIP_MEMBERS, DataNames::PARTNERSHIP_MEMBERS_NOFLAG, DataNames::TEAM1, DataNames::TEAM2, DataNames::PLAYER_CURRENT_TEAM
    ];

    if ( in_array($name, $alwaysAlignLeft) ) {
        $string = "style=\"text-align:left\"|{$string}";
    }

    # DataNames::GROUND must be aligned left with small text.
    if ( $name == DataNames::GROUND ) {
        $string = "style=\"text-align:left;font-size:85%\"|{$string}";
    }
    
    return $string;

}

/**
 * @global $StatsUpdateTasks The tasks for updating the tables in the article.
 */
$StatsUpdateTasks = [

    'TEAM_HIGHEST_TOTALS'                             => new UpdateTask(),
    'TEAM_LOWEST_TOTALS'                              => new UpdateTask(),
    'TEAM_HIGHEST_MATCH_AGGREGATES'                   => new UpdateTask(),
    'TEAM_LOWEST_MATCH_AGGREGATES'                    => new UpdateTask(),
    'TEAM_LARGEST_VICTORIES'                          => new ComplexUpdateTask(),
    'TEAM_SMALLEST_VICTORIES'                         => new ComplexUpdateTask(),
    'BATTING_MOST_RUNS'                               => new UpdateTask(),
    'BATTING_BEST_STRIKE_RATE'                        => new UpdateTask(),
    'BATTING_BEST_AVERAGE'                            => new UpdateTask(),
    'BATTING_HIGHEST_SCORE'                           => new UpdateTask(),
    'BATTING_MOST_RUNS_SERIES'                        => new UpdateTask(),
    'BATTING_MOST_SIXES'                              => new UpdateTask(),
    'BATTING_MOST_RUNS_BOUNDARIES_INNINGS'            => new UpdateTask(),
    'BOWLING_MOST_WICKETS'                            => new UpdateTask(),
    'BOWLING_BEST_STRIKE_RATE'                        => new UpdateTask(),
    'BOWLING_BEST_AVERAGE'                            => new UpdateTask(),
    'BOWLING_BEST_ECONOMY_RATE'                       => new UpdateTask(),
    'BOWLING_BEST_FIGURES_INNINGS'                    => new UpdateTask(),
    'BOWLING_MOST_RUNS_INNINGS'                       => new UpdateTask(),
    'BOWLING_MOST_WICKETS_SERIES'                     => new UpdateTask(),
    'FIELDING_MOST_DISMISSALS_KEEPER'                 => new UpdateTask(),
    'FIELDING_MOST_CATCHES_NON_KEEPER'                => new UpdateTask(),
    'FIELDING_MOST_DISMISSALS_INNINGS_KEEPER'         => new UpdateTask(),
    'FIELDING_MOST_CATCHES_INNINGS_NON_KEEPER'        => new UpdateTask(),
    'FIELDING_MOST_DISMISSALS_SERIES_KEEPER'          => new UpdateTask(),
    'FIELDING_MOST_CATCHES_SERIES_NON_KEEPER'         => new UpdateTask(),
    'BATTING_HIGHEST_PARTNERSHIP_WICKET'              => new UpdateTask(),
    'BATTING_HIGHEST_PARTNERSHIP_RUNS'                => new UpdateTask(),
    'MOST_MATCHES'                                    => new UpdateTask(),
    'MOST_EXTRAS_INNINGS'                             => new UpdateTask(),

];

#######################################################################################
#                                    TEAM RECORDS                                     #
#######################################################################################

# ----------------------- TEAM HIGHEST TOTALS ----------------------

$StatsUpdateTasks['TEAM_HIGHEST_TOTALS']->uri = 'http://stats.espncricinfo.com/ipl2009/engine/records/team/highest_innings_totals.html?id=117;type=trophy';

$StatsUpdateTasks['TEAM_HIGHEST_TOTALS']->sectionHeaders = [
    'Team records', 'Highest totals',
];

$StatsUpdateTasks['TEAM_HIGHEST_TOTALS']->parseOrder = [
    DataNames::TEAM, DataNames::SCORE, DataNames::OVERS, DataNames::RUN_RATE, DataNames::INNINGS_NUMBER, 6 => DataNames::OPPOSITION_TEAM,
    DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

$StatsUpdateTasks['TEAM_HIGHEST_TOTALS']->sortOrder = [
    DataNames::SCORE, DataNames::RUN_RATE, DataNames::DATE,
];

$StatsUpdateTasks['TEAM_HIGHEST_TOTALS']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['TEAM_HIGHEST_TOTALS']->tableOrder = [
    DataNames::SCORE, DataNames::TEAM, DataNames::OPPOSITION_TEAM, DataNames::OVERS, DataNames::RUN_RATE, DataNames::INNINGS_NUMBER,
    DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

# ----------------------- TEAM LOWEST TOTALS -----------------------

$StatsUpdateTasks['TEAM_LOWEST_TOTALS']->uri = 'http://stats.cricinfo.com/ipl2009/engine/records/team/lowest_innings_totals.html?id=117;type=trophy';

$StatsUpdateTasks['TEAM_LOWEST_TOTALS']->sectionHeaders = [
    'Team records', 'Lowest totals',
];

$StatsUpdateTasks['TEAM_LOWEST_TOTALS']->parseOrder = [
    DataNames::TEAM, DataNames::SCORE, DataNames::OVERS, DataNames::RUN_RATE, DataNames::INNINGS_NUMBER, 6 => DataNames::OPPOSITION_TEAM,
    DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

$StatsUpdateTasks['TEAM_LOWEST_TOTALS']->sortOrder = [
    DataNames::SCORE, DataNames::RUN_RATE, DataNames::DATE,
];

$StatsUpdateTasks['TEAM_LOWEST_TOTALS']->sortMode = CricinfoDataParser::SORT_ASCENDING;

$StatsUpdateTasks['TEAM_LOWEST_TOTALS']->sortReverse = [
    DataNames::DATE,
];

$StatsUpdateTasks['TEAM_LOWEST_TOTALS']->tableOrder = [
    DataNames::SCORE, DataNames::TEAM, DataNames::OPPOSITION_TEAM, DataNames::OVERS, DataNames::RUN_RATE, DataNames::INNINGS_NUMBER,
    DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

# ----------------------- TEAM HIGHEST MATCH AGGREGATES -----------------------


$StatsUpdateTasks['TEAM_HIGHEST_MATCH_AGGREGATES']->uri = 'http://stats.cricinfo.com/ipl2009/engine/records/team/highest_match_aggregates.html?id=117;type=trophy';

$StatsUpdateTasks['TEAM_HIGHEST_MATCH_AGGREGATES']->sectionHeaders = [
    'Team records', 'Highest match aggregates',
];

$StatsUpdateTasks['TEAM_HIGHEST_MATCH_AGGREGATES']->parseOrder = [
    DataNames::TEAM1, DataNames::TEAM2, DataNames::RUNS, DataNames::WICKETS, DataNames::OVERS, DataNames::RUN_RATE,
    7 => DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

$StatsUpdateTasks['TEAM_HIGHEST_MATCH_AGGREGATES']->sortOrder = [
    DataNames::RUNS, DataNames::RUN_RATE, DataNames::WICKETS, DataNames::DATE,
];

$StatsUpdateTasks['TEAM_HIGHEST_MATCH_AGGREGATES']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['TEAM_HIGHEST_MATCH_AGGREGATES']->sortReverse = [
    DataNames::WICKETS,
];

$StatsUpdateTasks['TEAM_HIGHEST_MATCH_AGGREGATES']->tableOrder = [
    DataNames::RUNS, DataNames::TEAM1, DataNames::TEAM2, DataNames::OVERS, DataNames::RUN_RATE, DataNames::WICKETS,
    DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];


# ----------------------- TEAM LOWEST MATCH AGGREGATES -----------------------


$StatsUpdateTasks['TEAM_LOWEST_MATCH_AGGREGATES']->uri = 'http://stats.cricinfo.com/ipl2009/engine/records/team/lowest_match_aggregates.html?id=117;type=trophy';

$StatsUpdateTasks['TEAM_LOWEST_MATCH_AGGREGATES']->sectionHeaders = [
    'Team records', 'Lowest match aggregates',
];

$StatsUpdateTasks['TEAM_LOWEST_MATCH_AGGREGATES']->parseOrder = [
    DataNames::TEAM1, DataNames::TEAM2, DataNames::RUNS, DataNames::WICKETS, DataNames::OVERS, DataNames::RUN_RATE,
    7 => DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

$StatsUpdateTasks['TEAM_LOWEST_MATCH_AGGREGATES']->sortOrder = [
    DataNames::RUNS, DataNames::RUN_RATE, DataNames::WICKETS, DataNames::DATE,
];

$StatsUpdateTasks['TEAM_LOWEST_MATCH_AGGREGATES']->sortMode = CricinfoDataParser::SORT_ASCENDING;

$StatsUpdateTasks['TEAM_LOWEST_MATCH_AGGREGATES']->sortReverse = [
    DataNames::WICKETS, DataNames::DATE
];

$StatsUpdateTasks['TEAM_LOWEST_MATCH_AGGREGATES']->tableOrder = [
    DataNames::RUNS, DataNames::TEAM1, DataNames::TEAM2, DataNames::OVERS, DataNames::RUN_RATE, DataNames::WICKETS,
    DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];


# ----------------------- TEAM LARGEST VICTORIES -----------------------

$StatsUpdateTasks['TEAM_LARGEST_VICTORIES']->uri = 'http://stats.cricinfo.com/ipl2009/engine/records/team/largest_margins.html?id=117;type=trophy';

$StatsUpdateTasks['TEAM_LARGEST_VICTORIES']->options = [
    
    # By runs
    [
        'tableIndex' => 0,
        'sectionHeaders' => [ 'Team records', 'Largest victories', 'By runs' ],
        'parseOrder' => [
            DataNames::TEAM, DataNames::MARGIN_RUNS, DataNames::TARGET, 4 => DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE,
            DataNames::SCORECARD_LINK
        ],
        'sortOrder' => [
            DataNames::MARGIN_RUNS, DataNames::TARGET, DataNames::DATE,
        ],
        'sortMode' => CricinfoDataParser::SORT_DESCENDING,
        'tableOrder' => [
            DataNames::MARGIN_RUNS, DataNames::TEAM, DataNames::TARGET, DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE,
            DataNames::SCORECARD_LINK,
        ],
    ],
    
    # By wickets
    [
        'tableIndex' => 1,
        'sectionHeaders' => [ 'Team records', 'Largest victories', 'By wickets' ],
        'parseOrder' => [
            DataNames::TEAM, DataNames::MARGIN_WICKETS, DataNames::BALLS_REMAINING, DataNames::TARGET, DataNames::OVERS, 6 => DataNames::OPPOSITION_TEAM,
            DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
        ],
        'sortOrder' => [
            DataNames::MARGIN_WICKETS, DataNames::TARGET, DataNames::BALLS_REMAINING, DataNames::DATE,
        ],
        'sortMode' => CricinfoDataParser::SORT_DESCENDING,
        'tableOrder' => [
            DataNames::MARGIN_WICKETS, DataNames::TEAM, DataNames::TARGET, DataNames::BALLS_REMAINING, DataNames::OVERS,
            DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
        ],
        
    ],
    
    # By balls remaining
    [
        'tableIndex' => 2,
        'sectionHeaders' => [ 'Team records', 'Largest victories', 'By balls remaining' ],
        'parseOrder' => [
            DataNames::TEAM, DataNames::MARGIN_WICKETS, DataNames::BALLS_REMAINING, DataNames::TARGET, DataNames::OVERS, DataNames::MAX_OVERS,
            7 => DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK
        ],
        'sortOrder' => [
            DataNames::BALLS_REMAINING, DataNames::TARGET, DataNames::MARGIN_WICKETS, DataNames::DATE,
        ],
        'sortMode' => CricinfoDataParser::SORT_DESCENDING,
        'tableOrder' => [
            DataNames::BALLS_REMAINING, DataNames::TEAM, DataNames::TARGET, DataNames::MARGIN_WICKETS, DataNames::OVERS,
            DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
        ],
    ],
    
];


# ----------------------- TEAM SMALLEST VICTORIES -----------------------

$StatsUpdateTasks['TEAM_SMALLEST_VICTORIES']->uri = 'http://stats.cricinfo.com/ipl2009/engine/records/team/smallest_margins.html?id=117;type=trophy';

$StatsUpdateTasks['TEAM_SMALLEST_VICTORIES']->options = [
    
    # By runs
    [
        'tableIndex' => 0,
        'sectionHeaders' => [ 'Team records', 'Smallest victories', 'By runs' ],
        'parseOrder' => [
            DataNames::TEAM, DataNames::MARGIN_RUNS, DataNames::TARGET, 4 => DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE,
            DataNames::SCORECARD_LINK
        ],
        'sortOrder' => [
            DataNames::MARGIN_RUNS, DataNames::TARGET, DataNames::DATE,
        ],
        'sortMode' => CricinfoDataParser::SORT_ASCENDING,
        'sortReverse' => [
            DataNames::DATE,
        ],
        'tableOrder' => [
            DataNames::MARGIN_RUNS, DataNames::TEAM, DataNames::TARGET, DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE,
            DataNames::SCORECARD_LINK,
        ],
    ],
    
    # By wickets
    [
        'tableIndex' => 1,
        'sectionHeaders' => [ 'Team records', 'Smallest victories', 'By wickets' ],
        'parseOrder' => [
            DataNames::TEAM, DataNames::MARGIN_WICKETS, DataNames::BALLS_REMAINING, DataNames::TARGET, DataNames::OVERS, 6 => DataNames::OPPOSITION_TEAM,
            DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK
        ],
        'sortOrder' => [
            DataNames::MARGIN_WICKETS, DataNames::TARGET, DataNames::BALLS_REMAINING, DataNames::DATE,
        ],
        'sortMode' => CricinfoDataParser::SORT_ASCENDING,
        'sortReverse' => [
            DataNames::DATE,
        ],
        'tableOrder' => [
            DataNames::MARGIN_WICKETS, DataNames::TEAM, DataNames::TARGET, DataNames::BALLS_REMAINING, DataNames::OVERS,
            DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
        ],
        
    ],
    
    # By balls remaining
    [
        'tableIndex' => 2,
        'sectionHeaders' => [ 'Team records', 'Smallest victories', 'By balls remaining' ],
        'parseOrder' => [
            DataNames::TEAM, DataNames::MARGIN_WICKETS, DataNames::BALLS_REMAINING, DataNames::TARGET, DataNames::OVERS, DataNames::MAX_OVERS,
            7 => DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK
        ],
        'sortOrder' => [
            DataNames::BALLS_REMAINING, DataNames::TARGET, DataNames::MARGIN_WICKETS, DataNames::DATE,
        ],
        'sortMode' => CricinfoDataParser::SORT_ASCENDING,
        'sortReverse' => [
            DataNames::DATE,
        ],
        'tableOrder' => [
            DataNames::BALLS_REMAINING, DataNames::TEAM, DataNames::TARGET, DataNames::MARGIN_WICKETS, DataNames::OVERS,
            DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
        ],
    ],
    
];

#######################################################################################
#                                  BATTING RECORDS                                    #
#######################################################################################

# ----------------------- BATTING MOST RUNS -----------------------

$StatsUpdateTasks['BATTING_MOST_RUNS']->uri = 'http://stats.espncricinfo.com/ipl2009/engine/records/batting/most_runs_career.html?id=117;type=trophy';

$StatsUpdateTasks['BATTING_MOST_RUNS']->sectionHeaders = [
    'Individual records', 'Batting records', 'Most runs',
];

$StatsUpdateTasks['BATTING_MOST_RUNS']->parseOrder = [
    DataNames::PLAYER, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::INNINGS, DataNames::NOT_OUT, DataNames::RUNS,
    DataNames::HIGH_SCORE, DataNames::BATTING_AVG, DataNames::BALLS, DataNames::BATTING_SR, DataNames::BATTING_100,
    DataNames::BATTING_50, DataNames::BATTING_0, DataNames::BATTING_4, DataNames::BATTING_6,

    '*1' => DataNames::PLAYER_CURRENT_TEAM,
];

$StatsUpdateTasks['BATTING_MOST_RUNS']->sortOrder = [
    DataNames::RUNS, DataNames::BATTING_AVG, DataNames::BATTING_SR, DataNames::HIGH_SCORE, DataNames::BATTING_100, DataNames::BATTING_50,
    DataNames::BATTING_6, DataNames::BATTING_4, DataNames::PLAYER,
];

$StatsUpdateTasks['BATTING_MOST_RUNS']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['BATTING_MOST_RUNS']->sortReverse = [
    DataNames::PLAYER,
];

$StatsUpdateTasks['BATTING_MOST_RUNS']->tableOrder = [
    DataNames::RUNS, DataNames::PLAYER, DataNames::PLAYER_CURRENT_TEAM, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::INNINGS,
    DataNames::BALLS, DataNames::BATTING_SR, DataNames::BATTING_AVG, DataNames::HIGH_SCORE, DataNames::BATTING_100, DataNames::BATTING_50,
    DataNames::BATTING_4, DataNames::BATTING_6,
];

# ----------------------- BATTING BEST STRIKE RATE -----------------------

$StatsUpdateTasks['BATTING_BEST_STRIKE_RATE']->uri = 'http://stats.cricinfo.com/ipl2009/engine/records/batting/highest_career_strike_rate.html?id=117;type=trophy';

$StatsUpdateTasks['BATTING_BEST_STRIKE_RATE']->sectionHeaders = [
    'Individual records', 'Batting records', 'Best strike rate',
];

$StatsUpdateTasks['BATTING_BEST_STRIKE_RATE']->parseOrder = [
    DataNames::PLAYER, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::INNINGS, DataNames::NOT_OUT, DataNames::RUNS,
    DataNames::HIGH_SCORE, DataNames::BATTING_AVG, DataNames::BALLS, DataNames::BATTING_SR, DataNames::BATTING_100,
    DataNames::BATTING_50, DataNames::BATTING_0, DataNames::BATTING_4, DataNames::BATTING_6,

    '*1' => DataNames::PLAYER_CURRENT_TEAM,
];

$StatsUpdateTasks['BATTING_BEST_STRIKE_RATE']->sortOrder = [
    DataNames::BATTING_SR, DataNames::RUNS, DataNames::BATTING_AVG, DataNames::HIGH_SCORE, DataNames::BATTING_100, DataNames::BATTING_50,
    DataNames::BATTING_6, DataNames::BATTING_4, DataNames::PLAYER,
];

$StatsUpdateTasks['BATTING_BEST_STRIKE_RATE']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['BATTING_BEST_STRIKE_RATE']->sortReverse = [
    DataNames::PLAYER,
];

$StatsUpdateTasks['BATTING_BEST_STRIKE_RATE']->filter = function(CricinfoParseResult $row) {
    return $row->getValue(DataNames::BALLS)->value >= 125;
};

$StatsUpdateTasks['BATTING_BEST_STRIKE_RATE']->tableOrder = [
    DataNames::BATTING_SR, DataNames::PLAYER, DataNames::PLAYER_CURRENT_TEAM, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::INNINGS,
    DataNames::RUNS, DataNames::BALLS, DataNames::BATTING_AVG, DataNames::HIGH_SCORE, DataNames::BATTING_100, DataNames::BATTING_50,
    DataNames::BATTING_4, DataNames::BATTING_6,
];


# ----------------------- BATTING BEST AVERAGE -----------------------

$StatsUpdateTasks['BATTING_BEST_AVERAGE']->uri = 'http://stats.cricinfo.com/ipl2010/engine/records/batting/highest_career_batting_average.html?id=117;type=trophy';

$StatsUpdateTasks['BATTING_BEST_AVERAGE']->sectionHeaders = [
    'Individual records', 'Batting records', 'Best average',
];

$StatsUpdateTasks['BATTING_BEST_AVERAGE']->parseOrder = [
    DataNames::PLAYER, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::INNINGS, DataNames::NOT_OUT, DataNames::RUNS,
    DataNames::HIGH_SCORE, DataNames::BATTING_AVG, DataNames::BALLS, DataNames::BATTING_SR, DataNames::BATTING_100,
    DataNames::BATTING_50, DataNames::BATTING_0, DataNames::BATTING_4, DataNames::BATTING_6,

    '*1' => DataNames::PLAYER_CURRENT_TEAM,
];

$StatsUpdateTasks['BATTING_BEST_AVERAGE']->sortOrder = [
    DataNames::BATTING_AVG, DataNames::RUNS, DataNames::BATTING_SR, DataNames::HIGH_SCORE, DataNames::BATTING_100, DataNames::BATTING_50,
    DataNames::BATTING_6, DataNames::BATTING_4, DataNames::PLAYER,
];

$StatsUpdateTasks['BATTING_BEST_AVERAGE']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['BATTING_BEST_AVERAGE']->sortReverse = [
    DataNames::PLAYER,
];

$StatsUpdateTasks['BATTING_BEST_AVERAGE']->filter = function(CricinfoParseResult $row) {
    return $row->getValue(DataNames::INNINGS)->value >= 10;
};

$StatsUpdateTasks['BATTING_BEST_AVERAGE']->tableOrder = [
    DataNames::BATTING_AVG, DataNames::PLAYER, DataNames::PLAYER_CURRENT_TEAM, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::INNINGS,
    DataNames::RUNS, DataNames::BALLS, DataNames::BATTING_SR, DataNames::HIGH_SCORE, DataNames::BATTING_100, DataNames::BATTING_50,
    DataNames::BATTING_4, DataNames::BATTING_6,
];


# ----------------------- BATTING HIGHEST SCORE -----------------------

$StatsUpdateTasks['BATTING_HIGHEST_SCORE']->uri = 'http://stats.cricinfo.com/ipl2009/engine/records/batting/most_runs_innings.html?id=117;type=trophy';

$StatsUpdateTasks['BATTING_HIGHEST_SCORE']->sectionHeaders = [
    'Individual records', 'Batting records', 'Highest score',
];

$StatsUpdateTasks['BATTING_HIGHEST_SCORE']->parseOrder = [
    DataNames::PLAYER, DataNames::HIGH_SCORE, DataNames::BALLS, DataNames::BATTING_4, DataNames::BATTING_6, DataNames::BATTING_SR,
    7 => DataNames::TEAM, DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

$StatsUpdateTasks['BATTING_HIGHEST_SCORE']->sortOrder = [
    DataNames::HIGH_SCORE, DataNames::BATTING_SR, DataNames::BATTING_6, DataNames::BATTING_4, DataNames::PLAYER, DataNames::DATE,
];

$StatsUpdateTasks['BATTING_HIGHEST_SCORE']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['BATTING_HIGHEST_SCORE']->sortReverse = [
    DataNames::PLAYER,
];

$StatsUpdateTasks['BATTING_HIGHEST_SCORE']->tableOrder = [
    DataNames::HIGH_SCORE, DataNames::PLAYER, DataNames::TEAM, DataNames::OPPOSITION_TEAM, DataNames::BALLS, DataNames::BATTING_SR,
    DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];


# ----------------------- BATTING MOST RUNS IN A SERIES -----------------------

$StatsUpdateTasks['BATTING_MOST_RUNS_SERIES']->uri = 'http://stats.cricinfo.com/ipl2009/engine/records/batting/most_runs_series.html?id=117;type=trophy';

$StatsUpdateTasks['BATTING_MOST_RUNS_SERIES']->sectionHeaders = [
    'Individual records', 'Batting records', 'Most runs in a series',
];

$StatsUpdateTasks['BATTING_MOST_RUNS_SERIES']->parseOrder = [
    DataNames::PLAYER, DataNames::MATCHES, DataNames::INNINGS, DataNames::NOT_OUT, DataNames::RUNS, DataNames::HIGH_SCORE,
    DataNames::BATTING_AVG, DataNames::BALLS, DataNames::BATTING_SR, DataNames::BATTING_100, DataNames::BATTING_50, DataNames::BATTING_0,
    DataNames::BATTING_4, DataNames::BATTING_6,

    '*1' => DataNames::SERIES_RECORDS_SEASON,
    '*2' => DataNames::SERIES_RECORDS_TEAM,
];

$StatsUpdateTasks['BATTING_MOST_RUNS_SERIES']->sortOrder = [
    DataNames::RUNS, DataNames::BATTING_AVG, DataNames::BATTING_SR, DataNames::HIGH_SCORE, DataNames::BATTING_100, DataNames::BATTING_50,
    DataNames::BATTING_6, DataNames::BATTING_4, DataNames::PLAYER,
];

$StatsUpdateTasks['BATTING_MOST_RUNS_SERIES']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['BATTING_MOST_RUNS_SERIES']->sortReverse = [
    DataNames::PLAYER,
];

$StatsUpdateTasks['BATTING_MOST_RUNS_SERIES']->tableOrder = [
    DataNames::RUNS, DataNames::PLAYER, DataNames::SERIES_RECORDS_TEAM, DataNames::SERIES_RECORDS_SEASON, DataNames::MATCHES,
    DataNames::INNINGS, DataNames::BALLS, DataNames::BATTING_SR, DataNames::BATTING_AVG, DataNames::HIGH_SCORE, DataNames::BATTING_100,
    DataNames::BATTING_50, DataNames::BATTING_4, DataNames::BATTING_6,
];


# ----------------------- BATTING MOST SIXES -----------------------

$StatsUpdateTasks['BATTING_MOST_SIXES']->uri = 'http://stats.espncricinfo.com/ipl2009/engine/records/batting/most_sixes_career.html?id=117;type=trophy';

$StatsUpdateTasks['BATTING_MOST_SIXES']->sectionHeaders = [
    'Individual records', 'Batting records', 'Most sixes',
];

$StatsUpdateTasks['BATTING_MOST_SIXES']->parseOrder = [
    DataNames::PLAYER, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::INNINGS, DataNames::NOT_OUT, DataNames::RUNS,
    DataNames::HIGH_SCORE, DataNames::BATTING_AVG, DataNames::BALLS, DataNames::BATTING_SR, DataNames::BATTING_100,
    DataNames::BATTING_50, DataNames::BATTING_0, DataNames::BATTING_4, DataNames::BATTING_6,

    '*1' => DataNames::PLAYER_CURRENT_TEAM,
];

$StatsUpdateTasks['BATTING_MOST_SIXES']->sortOrder = [
    DataNames::BATTING_6, DataNames::BATTING_AVG, DataNames::RUNS, DataNames::BATTING_SR, DataNames::HIGH_SCORE, DataNames::BATTING_100,
    DataNames::BATTING_50, DataNames::BATTING_4, DataNames::PLAYER,
];

$StatsUpdateTasks['BATTING_MOST_SIXES']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['BATTING_MOST_SIXES']->sortReverse = [
    DataNames::PLAYER,
];

$StatsUpdateTasks['BATTING_MOST_SIXES']->tableOrder = [
    DataNames::BATTING_6, DataNames::PLAYER, DataNames::PLAYER_CURRENT_TEAM, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::INNINGS,
    DataNames::RUNS, DataNames::BALLS, DataNames::BATTING_4,
];


# ----------------------- BATTING MOST RUNS FROM BOUNDARIES IN AN INNINGS -----------------------

$StatsUpdateTasks['BATTING_MOST_RUNS_BOUNDARIES_INNINGS']->uri = 'http://stats.espncricinfo.com/ipl2009/engine/records/batting/most_runs_from_fours_sixes_innings.html?id=117;type=trophy';

$StatsUpdateTasks['BATTING_MOST_RUNS_BOUNDARIES_INNINGS']->sectionHeaders = [
    'Individual records', 'Batting records', 'Most runs from boundaries in an innings',
];

$StatsUpdateTasks['BATTING_MOST_RUNS_BOUNDARIES_INNINGS']->parseOrder = [
    DataNames::PLAYER, DataNames::HIGH_SCORE, DataNames::BALLS, DataNames::BATTING_4, DataNames::BATTING_6, DataNames::BATTING_4_6, DataNames::BATTING_SR,
    8 => DataNames::TEAM, DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

$StatsUpdateTasks['BATTING_MOST_RUNS_BOUNDARIES_INNINGS']->sortOrder = [
    DataNames::BATTING_4_6, DataNames::BATTING_6, DataNames::BATTING_4, DataNames::HIGH_SCORE, DataNames::BATTING_SR, DataNames::PLAYER, DataNames::DATE,
];

$StatsUpdateTasks['BATTING_MOST_RUNS_BOUNDARIES_INNINGS']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['BATTING_MOST_RUNS_BOUNDARIES_INNINGS']->sortReverse = [
    DataNames::PLAYER, DataNames::DATE,
];

$StatsUpdateTasks['BATTING_MOST_RUNS_BOUNDARIES_INNINGS']->tableOrder = [
    DataNames::BATTING_4_6, DataNames::PLAYER, DataNames::TEAM, DataNames::OPPOSITION_TEAM, DataNames::BATTING_4, DataNames::BATTING_6,
    DataNames::HIGH_SCORE, DataNames::BALLS, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

#######################################################################################
#                                  BOWLING RECORDS                                    #
#######################################################################################

# ----------------------- BOWLING MOST WICKETS -----------------------

$StatsUpdateTasks['BOWLING_MOST_WICKETS']->uri = 'http://stats.cricinfo.com/ipl2009/engine/records/bowling/most_wickets_career.html?id=117;type=trophy';

$StatsUpdateTasks['BOWLING_MOST_WICKETS']->sectionHeaders = [
    'Individual records', 'Bowling records', 'Most wickets',
];

$StatsUpdateTasks['BOWLING_MOST_WICKETS']->parseOrder = [
    DataNames::PLAYER, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::INNINGS, DataNames::OVERS, DataNames::MAIDENS,
    DataNames::RUNS, DataNames::WICKETS, DataNames::BOWLING_FIGURES, DataNames::BOWLING_AVG, DataNames::BOWLING_ECON,
    DataNames::BOWLING_SR, DataNames::BOWLING_4W, DataNames::BOWLING_5W,

    '*1' => DataNames::PLAYER_CURRENT_TEAM,
];

$StatsUpdateTasks['BOWLING_MOST_WICKETS']->sortOrder = [
    DataNames::WICKETS, DataNames::BOWLING_ECON, DataNames::BOWLING_AVG, DataNames::BOWLING_SR, DataNames::BOWLING_FIGURES, DataNames::BOWLING_5W,
    DataNames::BOWLING_4W, DataNames::PLAYER,
];

$StatsUpdateTasks['BOWLING_MOST_WICKETS']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['BOWLING_MOST_WICKETS']->sortReverse = [
    DataNames::PLAYER, DataNames::BOWLING_ECON, DataNames::BOWLING_SR, DataNames::BOWLING_AVG,
];

$StatsUpdateTasks['BOWLING_MOST_WICKETS']->tableOrder = [
    DataNames::WICKETS, DataNames::PLAYER, DataNames::PLAYER_CURRENT_TEAM, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::INNINGS,
    DataNames::OVERS, DataNames::MAIDENS, DataNames::RUNS, DataNames::BOWLING_FIGURES, DataNames::BOWLING_AVG, DataNames::BOWLING_ECON,
    DataNames::BOWLING_SR,
];


# ----------------------- BOWLING BEST STRIKE RATE -----------------------

$StatsUpdateTasks['BOWLING_BEST_STRIKE_RATE']->uri = 'http://stats.cricinfo.com/ipl2009/engine/records/bowling/best_career_strike_rate.html?id=117;type=trophy';

$StatsUpdateTasks['BOWLING_BEST_STRIKE_RATE']->sectionHeaders = [
    'Individual records', 'Bowling records', 'Best strike rates',
];

$StatsUpdateTasks['BOWLING_BEST_STRIKE_RATE']->parseOrder = [
    DataNames::PLAYER, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::OVERS, DataNames::MAIDENS,
    DataNames::RUNS, DataNames::WICKETS, DataNames::BOWLING_FIGURES, DataNames::BOWLING_AVG, DataNames::BOWLING_ECON,
    DataNames::BOWLING_SR, DataNames::BOWLING_4W, DataNames::BOWLING_5W,

    '*1' => DataNames::PLAYER_CURRENT_TEAM,
];

$StatsUpdateTasks['BOWLING_BEST_STRIKE_RATE']->sortOrder = [
    DataNames::BOWLING_SR, DataNames::WICKETS, DataNames::BOWLING_ECON, DataNames::BOWLING_AVG, DataNames::BOWLING_FIGURES, DataNames::BOWLING_5W,
    DataNames::BOWLING_4W, DataNames::PLAYER,
];

$StatsUpdateTasks['BOWLING_BEST_STRIKE_RATE']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['BOWLING_BEST_STRIKE_RATE']->sortReverse = [
    DataNames::PLAYER, DataNames::BOWLING_ECON, DataNames::BOWLING_SR, DataNames::BOWLING_AVG,
];

$StatsUpdateTasks['BOWLING_BEST_STRIKE_RATE']->tableOrder = [
    DataNames::BOWLING_SR, DataNames::PLAYER, DataNames::PLAYER_CURRENT_TEAM, DataNames::PLAYING_SPAN, DataNames::MATCHES,
    DataNames::OVERS, DataNames::MAIDENS, DataNames::RUNS, DataNames::WICKETS, DataNames::BOWLING_FIGURES, DataNames::BOWLING_AVG,
    DataNames::BOWLING_ECON,
];

$StatsUpdateTasks['BOWLING_BEST_STRIKE_RATE']->filter = function(CricinfoParseResult $row) {
    $overs = (int) $row->getValue(DataNames::OVERS)->value;
    $balls = $row->getValue(DataNames::OVERS)->value - $overs;
    return $overs * 6 + $balls >= 250;  # Minimum of 250 balls
};


# ----------------------- BOWLING BEST AVERAGE -----------------------

$StatsUpdateTasks['BOWLING_BEST_AVERAGE']->uri = 'http://stats.cricinfo.com/ipl2009/engine/records/bowling/best_career_bowling_average.html?id=117;type=trophy';

$StatsUpdateTasks['BOWLING_BEST_AVERAGE']->sectionHeaders = [
    'Individual records', 'Bowling records', 'Best averages',
];

$StatsUpdateTasks['BOWLING_BEST_AVERAGE']->parseOrder = [
    DataNames::PLAYER, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::OVERS, DataNames::MAIDENS,
    DataNames::RUNS, DataNames::WICKETS, DataNames::BOWLING_FIGURES, DataNames::BOWLING_AVG, DataNames::BOWLING_ECON,
    DataNames::BOWLING_SR, DataNames::BOWLING_4W, DataNames::BOWLING_5W,

    '*1' => DataNames::PLAYER_CURRENT_TEAM,
];

$StatsUpdateTasks['BOWLING_BEST_AVERAGE']->sortOrder = [
    DataNames::BOWLING_AVG, DataNames::WICKETS, DataNames::BOWLING_ECON, DataNames::BOWLING_SR, DataNames::BOWLING_FIGURES, DataNames::BOWLING_5W,
    DataNames::BOWLING_4W, DataNames::PLAYER,
];

$StatsUpdateTasks['BOWLING_BEST_AVERAGE']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['BOWLING_BEST_AVERAGE']->sortReverse = [
    DataNames::PLAYER, DataNames::BOWLING_ECON, DataNames::BOWLING_SR, DataNames::BOWLING_AVG,
];

$StatsUpdateTasks['BOWLING_BEST_AVERAGE']->tableOrder = [
    DataNames::BOWLING_AVG, DataNames::PLAYER, DataNames::PLAYER_CURRENT_TEAM, DataNames::PLAYING_SPAN, DataNames::MATCHES,
    DataNames::OVERS, DataNames::MAIDENS, DataNames::RUNS, DataNames::WICKETS, DataNames::BOWLING_FIGURES, DataNames::BOWLING_SR,
    DataNames::BOWLING_ECON,
];

$StatsUpdateTasks['BOWLING_BEST_AVERAGE']->filter = function(CricinfoParseResult $row) {
    $overs = (int) $row->getValue(DataNames::OVERS)->value;
    $balls = $row->getValue(DataNames::OVERS)->value - $overs;
    return $overs * 6 + $balls >= 250;  # Minimum of 250 balls
};


# ----------------------- BOWLING BEST ECONOMY RATE -----------------------

$StatsUpdateTasks['BOWLING_BEST_ECONOMY_RATE']->uri = 'http://stats.cricinfo.com/ipl2009/engine/records/bowling/best_career_economy_rate.html?id=117;type=trophy';

$StatsUpdateTasks['BOWLING_BEST_ECONOMY_RATE']->sectionHeaders = [
    'Individual records', 'Bowling records', 'Best economy rates',
];

$StatsUpdateTasks['BOWLING_BEST_ECONOMY_RATE']->parseOrder = [
    DataNames::PLAYER, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::OVERS, DataNames::MAIDENS,
    DataNames::RUNS, DataNames::WICKETS, DataNames::BOWLING_FIGURES, DataNames::BOWLING_AVG, DataNames::BOWLING_ECON,
    DataNames::BOWLING_SR, DataNames::BOWLING_4W, DataNames::BOWLING_5W,

    '*1' => DataNames::PLAYER_CURRENT_TEAM,
];

$StatsUpdateTasks['BOWLING_BEST_ECONOMY_RATE']->sortOrder = [
    DataNames::BOWLING_ECON, DataNames::WICKETS, DataNames::BOWLING_AVG, DataNames::BOWLING_SR, DataNames::BOWLING_FIGURES, DataNames::BOWLING_5W,
    DataNames::BOWLING_4W, DataNames::PLAYER,
];

$StatsUpdateTasks['BOWLING_BEST_ECONOMY_RATE']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['BOWLING_BEST_ECONOMY_RATE']->sortReverse = [
    DataNames::PLAYER, DataNames::BOWLING_ECON, DataNames::BOWLING_SR, DataNames::BOWLING_AVG,
];

$StatsUpdateTasks['BOWLING_BEST_ECONOMY_RATE']->tableOrder = [
    DataNames::BOWLING_ECON, DataNames::PLAYER, DataNames::PLAYER_CURRENT_TEAM, DataNames::PLAYING_SPAN, DataNames::MATCHES,
    DataNames::OVERS, DataNames::MAIDENS, DataNames::RUNS, DataNames::WICKETS, DataNames::BOWLING_FIGURES, DataNames::BOWLING_SR,
    DataNames::BOWLING_AVG,
];

$StatsUpdateTasks['BOWLING_BEST_ECONOMY_RATE']->filter = function(CricinfoParseResult $row) {
    $overs = (int) $row->getValue(DataNames::OVERS)->value;
    $balls = $row->getValue(DataNames::OVERS)->value - $overs;
    return $overs * 6 + $balls >= 250;  # Minimum of 250 balls
};


# ----------------------- BOWLING BEST FIGURES IN AN INNINGS -----------------------

$StatsUpdateTasks['BOWLING_BEST_FIGURES_INNINGS']->uri = 'http://stats.espncricinfo.com/ipl2009/engine/records/bowling/best_figures_innings.html?id=117;type=trophy';

$StatsUpdateTasks['BOWLING_BEST_FIGURES_INNINGS']->sectionHeaders = [
    'Individual records', 'Bowling records', 'Best bowling figures in an innings',
];

$StatsUpdateTasks['BOWLING_BEST_FIGURES_INNINGS']->parseOrder = [
    DataNames::PLAYER, DataNames::OVERS, DataNames::MAIDENS, DataNames::RUNS, DataNames::WICKETS, DataNames::BOWLING_ECON,
    7 => DataNames::TEAM, DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
    
    '*1' => DataNames::BOWLING_FIGURES_CONSTRUCTED,
];

$StatsUpdateTasks['BOWLING_BEST_FIGURES_INNINGS']->sortOrder = [
    DataNames::WICKETS, DataNames::RUNS, DataNames::BOWLING_ECON, DataNames::MAIDENS, DataNames::PLAYER, DataNames::DATE,
];

$StatsUpdateTasks['BOWLING_BEST_FIGURES_INNINGS']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['BOWLING_BEST_FIGURES_INNINGS']->sortReverse = [
    DataNames::PLAYER, DataNames::RUNS, DataNames::BOWLING_ECON,
];

$StatsUpdateTasks['BOWLING_BEST_FIGURES_INNINGS']->tableOrder = [
    DataNames::BOWLING_FIGURES_CONSTRUCTED, DataNames::PLAYER, DataNames::TEAM, DataNames::OVERS, DataNames::MAIDENS, DataNames::BOWLING_ECON,
    DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];


# ----------------------- BOWLING MOST RUNS IN AN INNINGS -----------------------

$StatsUpdateTasks['BOWLING_MOST_RUNS_INNINGS']->uri = 'http://stats.espncricinfo.com/ipl2009/engine/records/bowling/most_runs_conceded_innings.html?id=117;type=trophy';

$StatsUpdateTasks['BOWLING_MOST_RUNS_INNINGS']->sectionHeaders = [
    'Individual records', 'Bowling records', 'Most runs conceded in an innings',
];

$StatsUpdateTasks['BOWLING_MOST_RUNS_INNINGS']->parseOrder = [
    DataNames::PLAYER, DataNames::OVERS, DataNames::MAIDENS, DataNames::RUNS, DataNames::WICKETS, DataNames::BOWLING_ECON,
    7 => DataNames::TEAM, DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

$StatsUpdateTasks['BOWLING_MOST_RUNS_INNINGS']->sortOrder = [
    DataNames::RUNS, DataNames::WICKETS, DataNames::BOWLING_ECON, DataNames::MAIDENS, DataNames::PLAYER, DataNames::DATE,
];

$StatsUpdateTasks['BOWLING_MOST_RUNS_INNINGS']->sortMode = CricinfoDataParser::SORT_ASCENDING;

$StatsUpdateTasks['BOWLING_MOST_RUNS_INNINGS']->sortReverse = [
    DataNames::RUNS, DataNames::BOWLING_ECON, DataNames::DATE,
];

$StatsUpdateTasks['BOWLING_MOST_RUNS_INNINGS']->tableOrder = [
    DataNames::RUNS, DataNames::PLAYER, DataNames::TEAM, DataNames::OVERS, DataNames::MAIDENS, DataNames::WICKETS, DataNames::BOWLING_ECON,
    DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];


# ----------------------- BOWLING MOST WICKETS IN A SERIES -----------------------

$StatsUpdateTasks['BOWLING_MOST_WICKETS_SERIES']->uri = 'http://stats.espncricinfo.com/ipl2009/engine/records/bowling/most_wickets_series.html?id=117;type=trophy';

$StatsUpdateTasks['BOWLING_MOST_WICKETS_SERIES']->sectionHeaders = [
    'Individual records', 'Bowling records', 'Most wickets in a series',
];

$StatsUpdateTasks['BOWLING_MOST_WICKETS_SERIES']->parseOrder = [
    DataNames::PLAYER, DataNames::MATCHES, DataNames::OVERS, DataNames::MAIDENS, DataNames::RUNS, DataNames::WICKETS,
    DataNames::BOWLING_FIGURES, DataNames::BOWLING_AVG, DataNames::BOWLING_ECON, DataNames::BOWLING_SR, DataNames::BOWLING_4W,
    DataNames::BOWLING_5W,

    '*1' => DataNames::SERIES_RECORDS_SEASON,
    '*2' => DataNames::SERIES_RECORDS_TEAM,
];

$StatsUpdateTasks['BOWLING_MOST_WICKETS_SERIES']->sortOrder = [
    DataNames::WICKETS, DataNames::BOWLING_ECON, DataNames::BOWLING_AVG, DataNames::BOWLING_SR, DataNames::BOWLING_FIGURES,
    DataNames::BOWLING_5W, DataNames::BOWLING_4W, DataNames::PLAYER,
];

$StatsUpdateTasks['BOWLING_MOST_WICKETS_SERIES']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['BOWLING_MOST_WICKETS_SERIES']->sortReverse = [
    DataNames::PLAYER, DataNames::BOWLING_ECON, DataNames::BOWLING_AVG, DataNames::BOWLING_SR,
];

$StatsUpdateTasks['BOWLING_MOST_WICKETS_SERIES']->tableOrder = [
    DataNames::WICKETS, DataNames::PLAYER, DataNames::SERIES_RECORDS_TEAM, DataNames::SERIES_RECORDS_SEASON, DataNames::MATCHES, DataNames::OVERS,
    DataNames::MAIDENS, DataNames::RUNS, DataNames::BOWLING_ECON, DataNames::BOWLING_AVG, DataNames::BOWLING_SR, DataNames::BOWLING_FIGURES,
];

#######################################################################################
#                                 FIELDING RECORDS                                    #
#######################################################################################

# ----------------------- FIELDING MOST DISMISSALS AS KEEPER -----------------------

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_KEEPER']->uri = 'http://stats.espncricinfo.com/ipl2009/engine/records/keeping/most_dismissals_career.html?id=117;type=trophy';

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_KEEPER']->sectionHeaders = [
    'Individual records', 'Wicketkeeping and fielding records', 'Most dismissals',
];

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_KEEPER']->parseOrder = [
    DataNames::PLAYER, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::INNINGS, DataNames::DISMISSALS, DataNames::CATCHES,
    DataNames::STUMPINGS, DataNames::MAX_DISMISSALS_INNINGS, DataNames::AVG_DISMISSALS_INNINGS,
    
    '*1' => DataNames::PLAYER_CURRENT_TEAM,
];

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_KEEPER']->sortOrder = [
    DataNames::DISMISSALS, DataNames::AVG_DISMISSALS_INNINGS, DataNames::MAX_DISMISSALS_INNINGS, DataNames::PLAYER,
];

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_KEEPER']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_KEEPER']->sortReverse = [
    DataNames::PLAYER,
];

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_KEEPER']->tableOrder = [
    DataNames::DISMISSALS, DataNames::PLAYER, DataNames::PLAYER_CURRENT_TEAM, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::INNINGS,
    DataNames::CATCHES, DataNames::STUMPINGS, DataNames::MAX_DISMISSALS_INNINGS, DataNames::AVG_DISMISSALS_INNINGS,
];


# ----------------------- FIELDING MOST CATCHES AS NON-KEEPER -----------------------

$StatsUpdateTasks['FIELDING_MOST_CATCHES_NON_KEEPER']->uri = 'http://stats.espncricinfo.com/ipl2009/engine/records/fielding/most_catches_career.html?id=117;type=trophy';

$StatsUpdateTasks['FIELDING_MOST_CATCHES_NON_KEEPER']->sectionHeaders = [
    'Individual records', 'Wicketkeeping and fielding records', 'Most catches (non-keeper)',
];

$StatsUpdateTasks['FIELDING_MOST_CATCHES_NON_KEEPER']->parseOrder = [
    DataNames::PLAYER, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::INNINGS, DataNames::CATCHES, DataNames::MAX_DISMISSALS_INNINGS,
    DataNames::AVG_DISMISSALS_INNINGS,
    
    '*1' => DataNames::PLAYER_CURRENT_TEAM,
];

$StatsUpdateTasks['FIELDING_MOST_CATCHES_NON_KEEPER']->sortOrder = [
    DataNames::CATCHES, DataNames::AVG_DISMISSALS_INNINGS, DataNames::MAX_DISMISSALS_INNINGS, DataNames::PLAYER,
];

$StatsUpdateTasks['FIELDING_MOST_CATCHES_NON_KEEPER']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['FIELDING_MOST_CATCHES_NON_KEEPER']->sortReverse = [
    DataNames::PLAYER,
];

$StatsUpdateTasks['FIELDING_MOST_CATCHES_NON_KEEPER']->tableOrder = [
    DataNames::CATCHES, DataNames::PLAYER, DataNames::PLAYER_CURRENT_TEAM, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::INNINGS,
    DataNames::MAX_DISMISSALS_INNINGS, DataNames::AVG_DISMISSALS_INNINGS,
];


# ----------------------- FIELDING MOST DISMISSALS IN AN INNINGS AS KEEPER -----------------------

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_INNINGS_KEEPER']->uri = 'http://stats.espncricinfo.com/ipl2009/engine/records/keeping/most_dismissals_innings.html?id=117;type=trophy';

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_INNINGS_KEEPER']->sectionHeaders = [
    'Individual records', 'Wicketkeeping and fielding records', 'Most dismissals in an innings',
];

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_INNINGS_KEEPER']->parseOrder = [
    DataNames::PLAYER, DataNames::DISMISSALS, DataNames::CATCHES, DataNames::STUMPINGS, DataNames::INNINGS_NUMBER,
    6 => DataNames::TEAM, DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_INNINGS_KEEPER']->sortOrder = [
    DataNames::DISMISSALS, DataNames::PLAYER, DataNames::DATE,
];

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_INNINGS_KEEPER']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_INNINGS_KEEPER']->sortReverse = [
    DataNames::PLAYER,
];

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_INNINGS_KEEPER']->tableOrder = [
    DataNames::DISMISSALS, DataNames::PLAYER, DataNames::TEAM, DataNames::INNINGS_NUMBER, DataNames::OPPOSITION_TEAM, DataNames::CATCHES,
    DataNames::STUMPINGS, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];


# ----------------------- FIELDING MOST CATCHES IN AN INNINGS AS NON-KEEPER -----------------------

$StatsUpdateTasks['FIELDING_MOST_CATCHES_INNINGS_NON_KEEPER']->uri = 'http://stats.espncricinfo.com/ipl2009/engine/records/fielding/most_catches_innings.html?id=117;type=trophy';

$StatsUpdateTasks['FIELDING_MOST_CATCHES_INNINGS_NON_KEEPER']->sectionHeaders = [
    'Individual records', 'Wicketkeeping and fielding records', 'Most catches in an innings (non-keeper)',
];

$StatsUpdateTasks['FIELDING_MOST_CATCHES_INNINGS_NON_KEEPER']->parseOrder = [
    DataNames::PLAYER, DataNames::CATCHES, DataNames::INNINGS_NUMBER, 4 => DataNames::TEAM, DataNames::OPPOSITION_TEAM,
    DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

$StatsUpdateTasks['FIELDING_MOST_CATCHES_INNINGS_NON_KEEPER']->sortOrder = [
    DataNames::CATCHES, DataNames::PLAYER, DataNames::DATE,
];

$StatsUpdateTasks['FIELDING_MOST_CATCHES_INNINGS_NON_KEEPER']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['FIELDING_MOST_CATCHES_INNINGS_NON_KEEPER']->sortReverse = [
    DataNames::PLAYER,
];

$StatsUpdateTasks['FIELDING_MOST_CATCHES_INNINGS_NON_KEEPER']->tableOrder = [
    DataNames::CATCHES, DataNames::PLAYER, DataNames::TEAM, DataNames::INNINGS_NUMBER, DataNames::OPPOSITION_TEAM,
    DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];


# ----------------------- FIELDING MOST DISMISSALS IN A SERIES AS KEEPER -----------------------

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_SERIES_KEEPER']->uri = 'http://stats.espncricinfo.com/ipl2009/engine/records/keeping/most_dismissals_series.html?id=117;type=trophy';

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_SERIES_KEEPER']->sectionHeaders = [
    'Individual records', 'Wicketkeeping and fielding records', 'Most dismissals in a series',
];

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_SERIES_KEEPER']->parseOrder = [
    DataNames::PLAYER, DataNames::MATCHES, DataNames::INNINGS, DataNames::DISMISSALS, DataNames::CATCHES, DataNames::STUMPINGS,
    DataNames::MAX_DISMISSALS_INNINGS, DataNames::AVG_DISMISSALS_INNINGS,
    
    '*1' => DataNames::SERIES_RECORDS_SEASON,
    '*2' => DataNames::SERIES_RECORDS_TEAM,
];

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_SERIES_KEEPER']->sortOrder = [
    DataNames::DISMISSALS, DataNames::AVG_DISMISSALS_INNINGS, DataNames::MAX_DISMISSALS_INNINGS, DataNames::PLAYER,
];

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_SERIES_KEEPER']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_SERIES_KEEPER']->sortReverse = [
    DataNames::PLAYER,
];

$StatsUpdateTasks['FIELDING_MOST_DISMISSALS_SERIES_KEEPER']->tableOrder = [
    DataNames::DISMISSALS, DataNames::PLAYER, DataNames::SERIES_RECORDS_TEAM, DataNames::SERIES_RECORDS_SEASON, DataNames::MATCHES,
    DataNames::CATCHES, DataNames::STUMPINGS, DataNames::MAX_DISMISSALS_INNINGS, DataNames::AVG_DISMISSALS_INNINGS,
];


# ----------------------- FIELDING MOST CATCHES IN A SERIES AS NON-KEEPER -----------------------

$StatsUpdateTasks['FIELDING_MOST_CATCHES_SERIES_NON_KEEPER']->uri = 'http://stats.espncricinfo.com/indian-premier-league-2011/engine/records/fielding/most_catches_series.html?id=117;type=trophy';

$StatsUpdateTasks['FIELDING_MOST_CATCHES_SERIES_NON_KEEPER']->sectionHeaders = [
    'Individual records', 'Wicketkeeping and fielding records', 'Most catches in a series (non-keeper)',
];

$StatsUpdateTasks['FIELDING_MOST_CATCHES_SERIES_NON_KEEPER']->parseOrder = [
    DataNames::PLAYER, DataNames::MATCHES, DataNames::INNINGS, DataNames::CATCHES, DataNames::MAX_DISMISSALS_INNINGS,
    DataNames::AVG_DISMISSALS_INNINGS,
    
    '*1' => DataNames::SERIES_RECORDS_SEASON,
    '*2' => DataNames::SERIES_RECORDS_TEAM,
];

$StatsUpdateTasks['FIELDING_MOST_CATCHES_SERIES_NON_KEEPER']->sortOrder = [
    DataNames::CATCHES, DataNames::AVG_DISMISSALS_INNINGS, DataNames::MAX_DISMISSALS_INNINGS, DataNames::PLAYER,
];

$StatsUpdateTasks['FIELDING_MOST_CATCHES_SERIES_NON_KEEPER']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['FIELDING_MOST_CATCHES_SERIES_NON_KEEPER']->sortReverse = [
    DataNames::PLAYER,
];

$StatsUpdateTasks['FIELDING_MOST_CATCHES_SERIES_NON_KEEPER']->tableOrder = [
    DataNames::CATCHES, DataNames::PLAYER, DataNames::SERIES_RECORDS_TEAM, DataNames::SERIES_RECORDS_SEASON, DataNames::MATCHES,
    DataNames::MAX_DISMISSALS_INNINGS, DataNames::AVG_DISMISSALS_INNINGS,
];


#######################################################################################
#                            BATTING PARTNERSHIP RECORDS                              #
#######################################################################################

# Due to technical limitations, it is not possible to include the contribution and/or final scores of the batsmen in the result (requires spidering over about 15 scorecards)
# It is not possible to distinguish conflicting names as they are not linked to their profile pages
# so if these functions are called the result wikitext must be checked after the edit (even though conflicting names are currently extremely rare)

# ----------------------- HIGHEST PARTNERSHIP BY WICKET -----------------------

$StatsUpdateTasks['BATTING_HIGHEST_PARTNERSHIP_WICKET']->uri = 'http://stats.espncricinfo.com/ipl2010/engine/records/fow/highest_partnerships_by_wicket.html?id=117;type=trophy';

$StatsUpdateTasks['BATTING_HIGHEST_PARTNERSHIP_WICKET']->sectionHeaders = [
    'Partnership records', 'Highest partnerships by wicket',
];

$StatsUpdateTasks['BATTING_HIGHEST_PARTNERSHIP_WICKET']->parseOrder = [
    DataNames::PARTNERSHIP_WKT, DataNames::PARTNERSHIP_RUNS, 3 => DataNames::PARTNERSHIP_MEMBERS, DataNames::TEAM, DataNames::OPPOSITION_TEAM,
    DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

$StatsUpdateTasks['BATTING_HIGHEST_PARTNERSHIP_WICKET']->limit = 0;

$StatsUpdateTasks['BATTING_HIGHEST_PARTNERSHIP_WICKET']->sortOrder = [
    DataNames::PARTNERSHIP_WKT,
];

$StatsUpdateTasks['BATTING_HIGHEST_PARTNERSHIP_WICKET']->sortMode = CricinfoDataParser::SORT_ASCENDING;

$StatsUpdateTasks['BATTING_HIGHEST_PARTNERSHIP_WICKET']->tableOrder = [
    DataNames::PARTNERSHIP_WKT, DataNames::PARTNERSHIP_RUNS, DataNames::PARTNERSHIP_MEMBERS, DataNames::TEAM, DataNames::OPPOSITION_TEAM,
    DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

# ----------------------- HIGHEST PARTNERSHIP BY RUNS -----------------------

$StatsUpdateTasks['BATTING_HIGHEST_PARTNERSHIP_RUNS']->uri = 'http://stats.espncricinfo.com/ipl2009/engine/records/fow/highest_partnerships_for_any_wicket.html?id=117;type=trophy';

$StatsUpdateTasks['BATTING_HIGHEST_PARTNERSHIP_RUNS']->sectionHeaders = [
    'Partnership records', 'Highest partnerships by runs',
];

$StatsUpdateTasks['BATTING_HIGHEST_PARTNERSHIP_RUNS']->parseOrder = [
    DataNames::PARTNERSHIP_MEMBERS, DataNames::PARTNERSHIP_RUNS, DataNames::PARTNERSHIP_WKT, 4 => DataNames::TEAM, DataNames::OPPOSITION_TEAM,
    DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

$StatsUpdateTasks['BATTING_HIGHEST_PARTNERSHIP_RUNS']->sortOrder = [
    DataNames::PARTNERSHIP_RUNS, DataNames::PARTNERSHIP_WKT, DataNames::DATE,
];

$StatsUpdateTasks['BATTING_HIGHEST_PARTNERSHIP_RUNS']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['BATTING_HIGHEST_PARTNERSHIP_RUNS']->tableOrder = [
    DataNames::PARTNERSHIP_RUNS, DataNames::PARTNERSHIP_WKT, DataNames::PARTNERSHIP_MEMBERS, DataNames::TEAM, DataNames::OPPOSITION_TEAM,
    DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];


#######################################################################################
#                               MISCELLANEOUS RECORDS                                 #
#######################################################################################

# ----------------------- MOST MATCHES -----------------------

$StatsUpdateTasks['MOST_MATCHES']->uri = 'http://stats.cricinfo.com/ipl2009/engine/records/individual/most_matches_career.html?id=117;type=trophy';

$StatsUpdateTasks['MOST_MATCHES']->sectionHeaders = [
    'Miscellaneous records', 'Most matches',
];

$StatsUpdateTasks['MOST_MATCHES']->parseOrder = [
    DataNames::PLAYER, DataNames::PLAYING_SPAN, DataNames::MATCHES, DataNames::RUNS, DataNames::HIGH_SCORE, DataNames::BATTING_AVG,
    DataNames::BATTING_100, DataNames::WICKETS, DataNames::BOWLING_FIGURES, DataNames::BOWLING_AVG, DataNames::BOWLING_5W,
    DataNames::CATCHES, DataNames::STUMPINGS,
    
    '*1' => DataNames::PLAYER_CURRENT_TEAM,
    '*2' => DataNames::CATCHES_AND_STUMPINGS,
];

$StatsUpdateTasks['MOST_MATCHES']->sortOrder = [
    DataNames::MATCHES, DataNames::PLAYER,
];

$StatsUpdateTasks['MOST_MATCHES']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['MOST_MATCHES']->sortReverse = [
    DataNames::PLAYER,
];

$StatsUpdateTasks['MOST_MATCHES']->tableOrder = [
    DataNames::MATCHES, DataNames::PLAYER, DataNames::PLAYER_CURRENT_TEAM, DataNames::PLAYING_SPAN, DataNames::RUNS, DataNames::BATTING_AVG,
    DataNames::WICKETS, DataNames::BOWLING_AVG, DataNames::CATCHES_AND_STUMPINGS,
];


# ----------------------- MOST EXTRAS IN AN INNINGS -----------------------

$StatsUpdateTasks['MOST_EXTRAS_INNINGS']->uri = 'http://stats.espncricinfo.com/indian-premier-league-2013/engine/records/team/most_extras_innings.html?id=117;type=trophy';

$StatsUpdateTasks['MOST_EXTRAS_INNINGS']->sectionHeaders = [
    'Miscellaneous records', 'Most extras conceded in an innings',
];

$StatsUpdateTasks['MOST_EXTRAS_INNINGS']->parseOrder = [
    DataNames::TEAM, DataNames::SCORE, DataNames::OVERS, DataNames::EXTRAS, DataNames::BYES, DataNames::LEG_BYES, DataNames::WIDES,
    DataNames::NO_BALLS, 9 => DataNames::OPPOSITION_TEAM, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

$StatsUpdateTasks['MOST_EXTRAS_INNINGS']->sortOrder = [
    DataNames::EXTRAS, DataNames::SCORE, DataNames::DATE,
];

$StatsUpdateTasks['MOST_EXTRAS_INNINGS']->sortMode = CricinfoDataParser::SORT_DESCENDING;

$StatsUpdateTasks['MOST_EXTRAS_INNINGS']->tableOrder = [
    DataNames::EXTRAS, DataNames::OPPOSITION_TEAM, DataNames::SCORE, DataNames::OVERS, DataNames::BYES, DataNames::LEG_BYES,
    DataNames::WIDES, DataNames::NO_BALLS, DataNames::TEAM, DataNames::GROUND, DataNames::DATE, DataNames::SCORECARD_LINK,
];

#######################################################################################
#                              END OF STATS UPDATE TASKS                              #
#######################################################################################

foreach ( $StatsUpdateTasks as $task ) {
    # Set all tasks without a tableAddCallback property to the default callback.
    if ( ! isset($task->tableAddCallback) ) $task->tableAddCallback = '_defaultTableAddCallback';

    # Set all tasks without a limit to the default limit. Set the limit to 0 to explicitly specify that there is no limit.
    if ( ! isset($task->limit) ) $task->limit = IPLRecordsUpdateBot::$defaultLimit;
}

?>