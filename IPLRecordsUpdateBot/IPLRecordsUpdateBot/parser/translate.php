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
 
/*
    Translation table to convert Cricinfo player, team and ground names to their real names for use on Wikipedia
*/
 
$CricinfoPlayerNameTranslationTable = [
 
    /*
        ---------------- PLAYER NAME TRANSLATION TABLE STARTS HERE ----------------
 
        Each entry in the translation table must have the Cricinfo name as its key. The value should be an array with the following parameters:
        - team: The player's curent team (to be omitted for former/retired players)
        - country: The nation which the player represents (This should be the cricket board the player is affiliated with, not necessarily the place of birth or origin)
        - first: First name
        - last: Last name
        - page: page title of the player's article if not the same as "first> <last>", used for disambiguation purposes.
        - sort: sort key of the player's name if not the same as "<last>, <first>". Refer to the {{DEFAULTSORT: ...}} tag in the player's article
                and http://en.wikipedia.org/wiki/Wikipedia:Categorization_of_people#Ordering_names_in_a_category if there are any doubts
 
        If two players have exactly the same names on Cricinfo, the name can be used for ONE of the players, and the unique IDs can be used as keys for the remaining.
        The unique ID can be obtained from the Cricinfo profile page URI as follows:
        http://www.espncricinfo.com/.../content/.../player/[id].html where [id] is the unique ID
 
        DO NOT REMOVE ANY INJURED, BANNED OR RETIRED PLAYER FROM THE LIST.
        If a player is currently unable to play, but still considered to be part of a team, the player's name should remain under the respective team.
        Players not considered part of any team (e.g. retired players) should be added to the "Other players" section at the end.
    */
 
    # CHENNAI SUPER KINGS

    'SK Raina'                    =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'Suresh',              'last' => 'Raina',              ],
    'M Vijay'                     =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'Murali',              'last' => 'Vijay',              ],
    'F du Plessis'                =>  [ 'team' => 'Chennai Super Kings', 'country' => 'South Africa',         'first' => 'Faf',                 'last' => 'du Plessis',         ],
    'S Badrinath'                 =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'Subramaniam',         'last' => 'Badrinath',          ],
    'MEK Hussey'                  =>  [ 'team' => 'Chennai Super Kings', 'country' => 'Australia',            'first' => 'Michael',             'last' => 'Hussey',             ],
    'S Anirudha'                  =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'Anirudha',            'last' => 'Srikkanth',          'sort' => 'Anirudha Srikkanth' ],
    'CH Morris'                   =>  [ 'team' => 'Chennai Super Kings', 'country' => 'South Africa',         'first' => 'Chris',               'last' => 'Morris',             'page' => 'Chris Morris (cricketer)' ],
    'B Aparajith'                 =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'Baba',                'last' => 'Aparajith',          ],
    'RA Jadeja'                   =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'Ravindra',            'last' => 'Jadeja',             ],
    'V Shankar'                   =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'Vijay',               'last' => 'Shankar'             ],
    'DJ Bravo'                    =>  [ 'team' => 'Chennai Super Kings', 'country' => 'West Indies',          'first' => 'Dwayne',              'last' => 'Bravo'               ],
    'JA Morkel'                   =>  [ 'team' => 'Chennai Super Kings', 'country' => 'South Africa',         'first' => 'Albie',               'last' => 'Morkel'              ],
    'WP Saha'                     =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'Wriddhiman',          'last' => 'Saha'                ],
    'MS Dhoni'                    =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'Mahendra Singh',      'last' => 'Dhoni',              ],
    'R Karthikeyan'               =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'R',                   'last' => 'Karthikeyan',        ],
    'A Dananjaya'                 =>  [ 'team' => 'Chennai Super Kings', 'country' => 'Sri Lanka',            'first' => 'Akila',               'last' => 'Dananjaya',          ],
    'MM Sharma'                   =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'Mohit',               'last' => 'Sharma',             ],
    'RG More'                     =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'Ronit',               'last' => 'More',               ],
    'SB Jakati'                   =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'Shadab',              'last' => 'Jakati',             ],
    'BW Hilfenhaus'               =>  [ 'team' => 'Chennai Super Kings', 'country' => 'Australia',            'first' => 'Ben',                 'last' => 'Hilfenhaus',         ],
    'DP Nannes'                   =>  [ 'team' => 'Chennai Super Kings', 'country' => 'Australia',            'first' => 'Dirk',                'last' => 'Nannes',             ],
    'AS Rajpoot'                  =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'Ankit',               'last' => 'Rajpoot',            ],
    'B Laughlin'                  =>  [ 'team' => 'Chennai Super Kings', 'country' => 'Australia',            'first' => 'Ben',                 'last' => 'Laughlin',           'page' => 'Ben Laughlin (cricketer)' ],
    'Imtiaz Ahmed'                =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'Imtiyaz',             'last' => 'Ahmed',              ],  # Cricinfo spells it as "Imtiaz", but use the Wikipedia spelling "Imtiyaz" as Imtiaz Ahmed is also a former Pakistani cricketer
    'KMDN Kulasekara'             =>  [ 'team' => 'Chennai Super Kings', 'country' => 'Sri Lanka',            'first' => 'Nuwan',               'last' => 'Kulasekara',         ],
    'JO Holder'                   =>  [ 'team' => 'Chennai Super Kings', 'country' => 'West Indies',          'first' => 'Jason',               'last' => 'Holder',             ],
    'R Ashwin'                    =>  [ 'team' => 'Chennai Super Kings', 'country' => 'India',                'first' => 'Ravichandran',        'last' => 'Ashwin',             ],
 
    # DELHI DAREDEVILS

    'V Sehwag'                    =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Virender',            'last' => 'Sehwag',             ],
    'KM Jadhav'                   =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Kedar',               'last' => 'Jadhav',             ],
    'U Chand'                     =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Unmukt',              'last' => 'Chand',              ],
    'MC Juneja'                   =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Manprit',             'last' => 'Juneja',             ],
    'KP Pietersen'                =>  [ 'team' => 'Delhi Daredevils', 'country' => 'England',              'first' => 'Kevin',               'last' => 'Pietersen',          ],
    'DPMD Jayawardene'            =>  [ 'team' => 'Delhi Daredevils', 'country' => 'Sri Lanka',            'first' => 'Mahela',              'last' => 'Jayawardene',        ],
    'DA Warner'                   =>  [ 'team' => 'Delhi Daredevils', 'country' => 'Australia',            'first' => 'David',               'last' => 'Warner',             'page' => 'David Warner (cricketer)' ],
    'Y Venugopal Rao'             =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Venugopal',           'last' => 'Rao',                'page' => 'Yalaka Venugopal Rao',  'sort' => 'Venugopal Rao, Yalaka' ],  # Venugopal Rao is the common name, but it should be sorted with Yalaka as Rao is not a last name
    'GH Bodi'                     =>  [ 'team' => 'Delhi Daredevils', 'country' => 'South Africa',         'first' => 'Gulam',               'last' => 'Bodi',               ],
    'BJ Rohrer'                   =>  [ 'team' => 'Delhi Daredevils', 'country' => 'Australia',            'first' => 'Ben',                 'last' => 'Rohrer',             ],
    'Y Nagar'                     =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Yogesh',              'last' => 'Nagar',              ],
    'AD Russell'                  =>  [ 'team' => 'Delhi Daredevils', 'country' => 'West Indies',          'first' => 'Andre',               'last' => 'Russell',            ],
    'J Botha'                     =>  [ 'team' => 'Delhi Daredevils', 'country' => 'South Africa',         'first' => 'Johan',               'last' => 'Botha',              'page' => 'Johan Botha (cricketer' ],
    'RE van der Merwe'            =>  [ 'team' => 'Delhi Daredevils', 'country' => 'South Africa',         'first' => 'Roelof',              'last' => 'van der Merwe',      ],
    'IK Pathan'                   =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Irfan',               'last' => 'Pathan',             ],
    'SS Nayak'                    =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Sujit',               'last' => 'Nayak',              ],
    'JD Ryder'                    =>  [ 'team' => 'Delhi Daredevils', 'country' => 'New Zealand',          'first' => 'Jesse',               'last' => 'Ryder',              ],
    'BMAJ Mendis'                 =>  [ 'team' => 'Delhi Daredevils', 'country' => 'Sri Lanka',            'first' => 'Jeevan',              'last' => 'Mendis',             ],
    'NV Ojha'                     =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Naman',               'last' => 'Ojha',               ],
    'CM Gautam'                   =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Muralidharen',        'last' => 'Gautam',             ],
    'P Negi'                      =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Pawan',               'last' => 'Negi',               ],
    'AB Agarkar'                  =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Ajit',                'last' => 'Agarkar',            ],
    'A Nehra'                     =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Ashish',              'last' => 'Nehra',              ],
    'M Morkel'                    =>  [ 'team' => 'Delhi Daredevils', 'country' => 'South Africa',         'first' => 'Morné',               'last' => 'Morkel',             'sort' => 'Morkel, Morne' ],
    'VR Aaron'                    =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Varun',               'last' => 'Aaron',              ],
    'UT Yadav'                    =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Umesh',               'last' => 'Yadav',              ],
    'S Nadeem'                    =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Shahbaz',             'last' => 'Nadeem',             ],
    'S Kaul'                      =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Siddarth',            'last' => 'Kaul',               ],
    'RH Dias'                     =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Royston',             'last' => 'Dias',               ],
    'AS Singhvi'                  =>  [ 'team' => 'Delhi Daredevils', 'country' => 'India',                'first' => 'Aristh',              'last' => 'Singhvi',            ],
 
    # KINGS XI PUNJAB

    'PC Valthaty'                 =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Paul',                'last' => 'Valthaty',           ],
    'Mandeep Singh'               =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Mandeep',             'last' => 'Singh',              ],
    'SE Marsh'                    =>  [ 'team' => 'Kings XI Punjab', 'country' => 'Australia',            'first' => 'Shaun',               'last' => 'Marsh',              ],
    'DA Miller'                   =>  [ 'team' => 'Kings XI Punjab', 'country' => 'South Africa',         'first' => 'David',               'last' => 'Miller',             'page' => 'David Miller (cricketer)' ],
    'Sunny Singh'                 =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Sunny',               'last' => 'Singh',              'page' => 'Sunny Singh (cricketer)' ],
    'Gurkeerat Singh'             =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Gurkeerat',           'last' => 'Singh',              ],
    'DJ Hussey'                   =>  [ 'team' => 'Kings XI Punjab', 'country' => 'Australia',            'first' => 'David',               'last' => 'Hussey',             ],
    'SD Chitnis'                  =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Siddharth',           'last' => 'Chitnis',            ],
    'M Vohra'                     =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Manan',               'last' => 'Vohra',              ],
    'LA Pomersbach'               =>  [ 'team' => 'Kings XI Punjab', 'country' => 'Australia',            'first' => 'Luke',                'last' => 'Pomersbach',         ],
    'Bipul Sharma'                =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Bipul',               'last' => 'Sharma',             ],
    'AD Mascarenhas'              =>  [ 'team' => 'Kings XI Punjab', 'country' => 'England',              'first' => 'Dimitri',             'last' => 'Mascarenhas',        ],
    'R Sathish'                   =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Rajagopal',           'last' => 'Sathish',            ],
    'Azhar Mahmood'               =>  [ 'team' => 'Kings XI Punjab', 'country' => 'England',              'first' => 'Azhar',               'last' => 'Mahmood',            'sort' => 'Azhar Mahmood' ],
    'AC Gilchrist'                =>  [ 'team' => 'Kings XI Punjab', 'country' => 'Australia',            'first' => 'Adam',                'last' => 'Gilchrist',          ],
    'N Saini'                     =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Nitin',               'last' => 'Saini',              ],
    'Harmeet Singh'               =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Harmeet',             'last' => 'Singh',              'page' => 'Harmeet Singh (cricketer born 1987)',  'sort' => 'Harmeet Singh' ],  # Here Singh is a middle name, not a surname - full name is "Harmeet Singh Bansal"
    'P Kumar'                     =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Praveen',             'last' => 'Kumar',              ],
    'PP Chawla'                   =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Piyush',              'last' => 'Chawla',             ],
    'BA Bhatt'                    =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Bhargav',             'last' => 'Bhatt',              ],
    'P Awana'                     =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Parvinder',           'last' => 'Awana',              ],
    'RJ Harris'                   =>  [ 'team' => 'Kings XI Punjab', 'country' => 'Australia',            'first' => 'Ryan',                'last' => 'Harris',             'page' => 'Ryan Harris (cricketer)' ],
    'MS Gony'                     =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Manpreet',            'last' => 'Gony',               ],
    'Sandeep Sharma (1)'          =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Sandeep',             'last' => 'Sharma',             ],  # The (1) might be because another player has the same name. Although the Wikipedia article does not say he plays for Kings XI, by checking birth dates it is most likely this one.
    'A Choudhary'                 =>  [ 'team' => 'Kings XI Punjab', 'country' => 'India',                'first' => 'Aniket',              'last' => 'Choudhary'           ],
    'MG Neser'                    =>  [ 'team' => 'Kings XI Punjab', 'country' => 'Australia',            'first' => 'Michael',             'last' => 'Neser',              ],
 
    # KOLKATA KNIGHT RIDERS

    'G Gambhir'                   =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'India',                'first' => 'Gautam',              'last' => 'Gambhir',            ],
    'MK Tiwary'                   =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'India',                'first' => 'Manoj',               'last' => 'Tiwary',             ],
    'EJG Morgan'                  =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'England',              'first' => 'Eoin',                'last' => 'Morgan',             ],
    'DB Das'                      =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'India',                'first' => 'Debabrata',           'last' => 'Das',                ],
    'JH Kallis'                   =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'South Africa',         'first' => 'Jacques',             'last' => 'Kallis',             ],
    'LR Shukla'                   =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'India',                'first' => 'Laxmi Ratan',         'last' => 'Shukla',             ],
    'R Bhatia'                    =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'India',                'first' => 'Rajat',               'last' => 'Bhatia',             ],
    'RN ten Doeschate'            =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'Netherlands',          'first' => 'Ryan',                'last' => 'ten Doeschate',      ],  # Per Dutch naming conventions, "ten Doeschate" is the surname
    'Shakib Al Hasan'             =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'Bangladesh',           'first' => 'Shakib Al',           'last' => 'Hasan',              ],
    'YK Pathan'                   =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'India',                'first' => 'Yusuf',               'last' => 'Pathan',             ],
    'R McLaren'                   =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'South Africa',         'first' => 'Ryan',                'last' => 'McLaren',            ],
    'BJ Haddin'                   =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'Australia',            'first' => 'Brad',                'last' => 'Haddin',             ],
    'MS Bisla'                    =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'India',                'first' => 'Manvinder',           'last' => 'Bisla',              ],
    'BB McCullum'                 =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'New Zealand',          'first' => 'Brendon',             'last' => 'McCullum',           ],
    'S Ladda'                     =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'India',                'first' => 'Sarabjit',            'last' => 'Ladda',              ],
    'JL Pattinson'                =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'Australia',            'first' => 'James',               'last' => 'Pattinson',          ],
    'PJ Sangwan'                  =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'India',                'first' => 'Pradeep',             'last' => 'Sangwan',            ],
    'Shami Ahmed'                 =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'India',                'first' => 'Shami',               'last' => 'Ahmed',              ],
    'Iqbal Abdulla'               =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'India',                'first' => 'Iqbal',               'last' => 'Abdulla',            ],
    'L Balaji'                    =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'India',                'first' => 'Lakshmipathy',        'last' => 'Balaji',             ],
    'B Lee'                       =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'Australia',            'first' => 'Brett',               'last' => 'Lee',                ],
    'SP Narine'                   =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'West Indies',          'first' => 'Sunil',               'last' => 'Narine',             ],
    'SMSM Senanayake'             =>  [ 'team' => 'Kolkata Knight Riders', 'country' => 'Sri Lanka',            'first' => 'Sachithra',           'last' => 'Senanayake',         ],
 
    # MUMBAI INDIANS

    'AC Blizzard'                 =>  [ 'team' => 'Mumbai Indians', 'country' => 'Australia',            'first' => 'Aiden',               'last' => 'Blizzard',           ],
    'AT Rayudu'                   =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Ambati',              'last' => 'Rayudu',             ],
    'SR Tendulkar'                =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Sachin',              'last' => 'Tendulkar',          ],
    'RT Ponting'                  =>  [ 'team' => 'Mumbai Indians', 'country' => 'Australia',            'first' => 'Ricky',               'last' => 'Ponting',            ],
    'SA Yadav'                    =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Suryakumar',          'last' => 'Yadav',              ],
    'RG Sharma'                   =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Rohit',               'last' => 'Sharma',             ],
    'PJ Hughes'                   =>  [ 'team' => 'Mumbai Indians', 'country' => 'Australia',            'first' => 'Phillip',             'last' => 'Hughes',             ],
    'R Dhawan'                    =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Rishi',               'last' => 'Dhawan',             ],
    'JEC Franklin'                =>  [ 'team' => 'Mumbai Indians', 'country' => 'New Zealand',          'first' => 'James',               'last' => 'Franklin',           'page' => 'James Franklin (cricketer)'  ],
    'JDP Oram'                    =>  [ 'team' => 'Mumbai Indians', 'country' => 'New Zealand',          'first' => 'Jacob',               'last' => 'Oram',               ],
    'DR Smith'                    =>  [ 'team' => 'Mumbai Indians', 'country' => 'West Indies',          'first' => 'Dwayne',              'last' => 'Smith',              ],
    'KA Pollard'                  =>  [ 'team' => 'Mumbai Indians', 'country' => 'West Indies',          'first' => 'Kieron',              'last' => 'Pollard',            ],
    'Jalaj S Saxena'              =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Jalaj',               'last' => 'Saxena',             ],
    'Amitoze Singh'               =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Amitoze',             'last' => 'Singh',              ],
    'GJ Maxwell'                  =>  [ 'team' => 'Mumbai Indians', 'country' => 'Australia',            'first' => 'Glenn',               'last' => 'Maxwell',            ],
    'AR Patel'                    =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Akshar',              'last' => 'Patel',              ],
    'SH Marathe'                  =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Sushant',             'last' => 'Marathe',            ],
    'KD Karthik'                  =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Dinesh',              'last' => 'Karthik',            ],
    'AP Tare'                     =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Aditya',              'last' => 'Tare',               ],
    'Harbhajan Singh'             =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Harbhajan',           'last' => 'Singh',              'sort' => 'Harbhajan Singh' ],
    'JJ Bumrah'                   =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Jasprit',             'last' => 'Bumrah',             ],
    'MM Patel'                    =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Munaf',               'last' => 'Patel',              ],
    'YS Chahal'                   =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Yuzvendra',           'last' => 'Chahal',             ],
    'MG Johnson'                  =>  [ 'team' => 'Mumbai Indians', 'country' => 'Australia',            'first' => 'Mitchell',            'last' => 'Johnson',            'page' => 'Mitchell Johnson (cricketer)' ],
    'PP Ojha'                     =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Pragyan',             'last' => 'Ojha',               ],
    'P Suyal'                     =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Pawan',               'last' => 'Suyal',              ],
    'DS Kulkarni'                 =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Dhawal',              'last' => 'Kulkarni',           ],
    'SL Malinga'                  =>  [ 'team' => 'Mumbai Indians', 'country' => 'Sri Lanka',            'first' => 'Lasith',              'last' => 'Malinga',            ],
    'AN Ahmed'                    =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Abu Nechim',          'last' => 'Ahmed',              ],  # See [[Abdullahi Yusuf Ahmed]] for an example of how such names are sorted
    'NM Coulter-Nile'             =>  [ 'team' => 'Mumbai Indians', 'country' => 'Australia',            'first' => 'Nathan',              'last' => 'Coulter-Nile'        ],
    'JJ Khan'                     =>  [ 'team' => 'Mumbai Indians', 'country' => 'India',                'first' => 'Javed',               'last' => 'Khan',               'page' => 'Javed Khan (cricketer)' ],
 
    # PUNE WARRIORS INDIA

    'TL Suman'                    =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Tirumalasetti',       'last' => 'Suman',              ],
    'Harpreet Singh'              =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Harpreet',            'last' => 'Singh',              'page' => 'Harpreet Singh (cricketer)',  'sort' => 'Harpreet Singh' ],
    'MJ Clarke'                   =>  [ 'team' => 'Pune Warriors India', 'country' => 'Australia',            'first' => 'Michael',             'last' => 'Clarke',             'page' => 'Michael Clarke (cricketer)' ],
    'LRPL Taylor'                 =>  [ 'team' => 'Pune Warriors India', 'country' => 'New Zealand',          'first' => 'Ross',                'last' => 'Taylor',             ],
    'Tamim Iqbal'                 =>  [ 'team' => 'Pune Warriors India', 'country' => 'Bangladesh',           'first' => 'Tamim',               'last' => 'Iqbal'               ],
    'AP Majumdar'                 =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Anustup',             'last' => 'Majumdar',           ],
    'M Manhas'                    =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Mithun',              'last' => 'Manhas',             ],
    'MK Pandey'                   =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Manish',              'last' => 'Pandey'              ],
    'MN Samuels'                  =>  [ 'team' => 'Pune Warriors India', 'country' => 'West Indies',          'first' => 'Marlon',              'last' => 'Samuels',            ],
    'AJ Finch'                    =>  [ 'team' => 'Pune Warriors India', 'country' => 'Australia',            'first' => 'Aaron',               'last' => 'Finch',              ],
    'UA Birla'                    =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Udit',                'last' => 'Birla',              ],
    'DS Jadhav'                   =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Dheeraj',             'last' => 'Jadhav',             ],
    'LJ Wright'                   =>  [ 'team' => 'Pune Warriors India', 'country' => 'England',              'first' => 'Luke',                'last' => 'Wright',             ],
    'Yuvraj Singh'                =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Yuvraj',              'last' => 'Singh',              ],
    'MR Marsh'                    =>  [ 'team' => 'Pune Warriors India', 'country' => 'Australia',            'first' => 'Mitchell',            'last' => 'Marsh',              ],
    'AM Nayar'                    =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Abhishek',            'last' => 'Nayar',              ],
    'SPD Smith'                   =>  [ 'team' => 'Pune Warriors India', 'country' => 'Australia',            'first' => 'Steve',               'last' => 'Smith',              'page' => 'Steve Smith (cricketer born 1989)' ],
    'AD Mathews'                  =>  [ 'team' => 'Pune Warriors India', 'country' => 'Sri Lanka',            'first' => 'Angelo',              'last' => 'Mathews',            ],
    'Parvez Rasool'               =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Parvez',              'last' => 'Rasool',             ],
    'RV Gomez'                    =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Raiphi',              'last' => 'Gomez',              ],
    'RV Uthappa'                  =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Robin',               'last' => 'Uthappa',            ],
    'M Rawat'                     =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Mahesh',              'last' => 'Rawat',              ],
    'ER Dwivedi'                  =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Eklavya',             'last' => 'Dwivedi',            ],
    'AB Dinda'                    =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Ashok',               'last' => 'Dinda',              ],
    'R Sharma'                    =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Rahul',               'last' => 'Sharma',             'page' => 'Rahul Sharma (Indian cricketer)' ],
    'B Kumar'                     =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Bhuvneshwar',         'last' => 'Kumar',              ],
    'SB Wagh'                     =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Shrikant',            'last' => 'Wagh',               ],
    'K Upadhyay'                  =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Krishnakant',         'last' => 'Upadhyay',           ],
    'AG Murtaza'                  =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Ali',                 'last' => 'Murtaza',            ],
    'BAW Mendis'                  =>  [ 'team' => 'Pune Warriors India', 'country' => 'Sri Lanka',            'first' => 'Ajantha',             'last' => 'Mendis',             ],
    'KW Richardson'               =>  [ 'team' => 'Pune Warriors India', 'country' => 'Australia',            'first' => 'Kane',                'last' => 'Richardson',         ],
    'WD Parnell'                  =>  [ 'team' => 'Pune Warriors India', 'country' => 'South Africa',         'first' => 'Wayne',               'last' => 'Parnell'             ],
    'IC Pandey'                   =>  [ 'team' => 'Pune Warriors India', 'country' => 'India',                'first' => 'Ishwar',              'last' => 'Pandey',             ],
 
    # RAJASTHAN ROYALS

    'AL Menaria'                  =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Ashok',               'last' => 'Menaria',            ],
    'AM Rahane'                   =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Ajinkya',             'last' => 'Rahane',             ],
    'BJ Hodge'                    =>  [ 'team' => 'Rajasthan Royals', 'country' => 'Australia',            'first' => 'Brad',                'last' => 'Hodge',              ],
    'R Dravid'                    =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Rahul',               'last' => 'Dravid',             ],
    'Sachin Baby'                 =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Sachin',              'last' => 'Baby',               ],
    'OA Shah'                     =>  [ 'team' => 'Rajasthan Royals', 'country' => 'England',              'first' => 'Owais',               'last' => 'Shah',               ],
    'A Chandila'                  =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Ajit',                'last' => 'Chandila',           ],
    'AA Chavan'                   =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Ankeet',              'last' => 'Chavan',             ],
    'SR Watson'                   =>  [ 'team' => 'Rajasthan Royals', 'country' => 'Australia',            'first' => 'Shane',               'last' => 'Watson',             ],
    'JP Faulkner'                 =>  [ 'team' => 'Rajasthan Royals', 'country' => 'Australia',            'first' => 'James',               'last' => 'Faulkner',           'page' => 'James Faulkner (cricketer)' ],
    'STR Binny'                   =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Stuart',              'last' => 'Binny',              ],
    'KK Cooper'                   =>  [ 'team' => 'Rajasthan Royals', 'country' => 'West Indies',          'first' => 'Kevon',               'last' => 'Cooper',             ],
    'MKDJ Perera'                 =>  [ 'team' => 'Rajasthan Royals', 'country' => 'Sri Lanka',            'first' => 'Kusal',               'last' => 'Perera',             ],
    'SV Samson'                   =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Sanju',               'last' => 'Samson',             ],
    'SP Goswami'                  =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Shreevats',           'last' => 'Goswami',            ],
    'DH Yagnik'                   =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Dishant',             'last' => 'Yagnik',             ],
    'R Shukla'                    =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Rahul',               'last' => 'Shukla',             ],
    'FH Edwards'                  =>  [ 'team' => 'Rajasthan Royals', 'country' => 'West Indies',          'first' => 'Fidel',               'last' => 'Edwards',            ],
    'GB Hogg'                     =>  [ 'team' => 'Rajasthan Royals', 'country' => 'Australia',            'first' => 'Brad',                'last' => 'Hogg',               ],
    'SW Tait'                     =>  [ 'team' => 'Rajasthan Royals', 'country' => 'Australia',            'first' => 'Shaun',               'last' => 'Tait',               ],
    'S Sreesanth'                 =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Sreesanth',           'last' => '',                   'sort' => 'Sreesanth, Shanthakumaran' ],  # Shanthakumaran is not used in the common name, so keep last name as an empty string.
    'SK Trivedi'                  =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Siddharth',           'last' => 'Trivedi',            ],
    'S Badree'                    =>  [ 'team' => 'Rajasthan Royals', 'country' => 'West Indies',          'first' => 'Samuel',              'last' => 'Badree',             ],
    'VS Malik'                    =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Vikramjeet',          'last' => 'Malik',              ],
    'A Singh'                     =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Amit',                'last' => 'Singh',              ],
    'P Tambe'                     =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Pravin',              'last' => 'Tambe',              ],
 
    # This one conflicts with another Harmeet Singh (of Kings XI Punjab), so use the unique ID instead of the name
    422847                        =>  [ 'team' => 'Rajasthan Royals', 'country' => 'India',                'first' => 'Harmeet',             'last' => 'Singh',              'page' => 'Harmeet Singh (cricketer born 1992)' ],
 
    # ROYAL CHALLENGERS BANGALORE

    'CA Pujara'                   =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Cheteshwar',          'last' => 'Pujara',             ],
    'KK Nair'                     =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Karun',               'last' => 'Nair',               ],
    'V Kohli'                     =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Virat',               'last' => 'Kohli',              ],
    'TM Dilshan'                  =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'Sri Lanka',            'first' => 'Tillakaratne',        'last' => 'Dilshan',            ],
    'SS Tiwary'                   =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Saurabh',             'last' => 'Tiwary',             ],
    'S Sohal'                     =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Sunny',               'last' => 'Sohal',              ],
    'A Mukund'                    =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Abhinav',             'last' => 'Mukund',             ],
    'MA Agarwal'                  =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Mayank',              'last' => 'Agarwal',            ],
    'CH Gayle'                    =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'West Indies',          'first' => 'Chris',               'last' => 'Gayle',              ],
    'VH Zol'                      =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Vijay',               'last' => 'Zol',                ],
    'AB McDonald'                 =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'Australia',            'first' => 'Andrew',              'last' => 'McDonald',           'page' => 'Andrew McDonald (cricketer)' ],
    'MC Henriques'                =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'Australia',            'first' => 'Moisés',              'last' => 'Henriques',          ],
    'DL Vettori'                  =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'New Zealand',          'first' => 'Daniel',              'last' => 'Vettori',            ],
    'DT Christian'                =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'Australia',            'first' => 'Daniel',              'last' => 'Christian',          ],
    'CD Barnwell'                 =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'West Indies',          'first' => 'Christopher',         'last' => 'Barnwell',           ],
    'AB de Villiers'              =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'South Africa',         'first' => 'AB',                  'last' => 'de Villiers',        'sort' => 'Villiers, Abraham' ],
    'KB Arun Karthik'             =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Arun',                'last' => 'Karthik',            ],
    'SP Jackson'                  =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Sheldon',             'last' => 'Jackson',            'page' => 'Sheldon Jackson (cricketer)' ],
    'KL Rahul'                    =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Lokesh',              'last' => 'Rahul',              ],
    'HV Patel'                    =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Harshal',             'last' => 'Patel',              ],
    'KP Appanna'                  =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'KP',                  'last' => 'Appanna',            'sort' => 'Appanna, Kotarangada' ],
    'R Vinay Kumar'               =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Vinay',               'last' => 'Kumar',              ],
    'J Syed Mohammad'             =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Syed',                'last' => 'Mohammed',           'sort' => 'Syed Mohammad' ],  # Cricinfo uses the spelling "Mohammad", but the Wikipedia article is titled "Syed Mohammed"
    'RP Singh'                    =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'R. P.',               'last' => 'Singh',              'sort' => 'Singh, Rudra Pratap' ],
    'P Parameswaran'              =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Prasanth',            'last' => 'Parameswaran',       ],
    'A Mithun'                    =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Abhimanyu',           'last' => 'Mithun',             ],
    'Z Khan'                      =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Zaheer',              'last' => 'Khan',               ],
    'JD Unadkat'                  =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Jaydev',              'last' => 'Unadkat',            ],
    'S Aravind'                   =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Sreenath',            'last' => 'Aravind',            ],
    'M Kartik'                    =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Murali',              'last' => 'Kartik',             ],
    'M Muralitharan'              =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'Sri Lanka',            'first' => 'Muttiah',             'last' => 'Muralitharan',       ],
    'S Sandeep Warrier'           =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Sandeep',             'last' => 'Warrier',            ],
    'Pankaj Singh'                =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'India',                'first' => 'Pankaj',              'last' => 'Singh',              ],
    'R Rampaul'                   =>  [ 'team' => 'Royal Challengers Bangalore', 'country' => 'West Indies',  'first' => 'Ravi',                'last' => 'Rampaul',            ],
 
    # SUNRISERS HYDERABAD

    'B Chipli'                    =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Bharat',              'last' => 'Chipli',             ],
    'CL White'                    =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'Australia',            'first' => 'Cameron',             'last' => 'White',              ],
    'JP Duminy'                   =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'South Africa',         'first' => 'JP',                  'last' => 'Duminy',             'sort' => 'Duminy, Jean Paul' ],
    'S Dhawan'                    =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Shikhar',             'last' => 'Dhawan',             ],
    'PA Reddy'                    =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Akshath',             'last' => 'Reddy',              ],
    'GH Vihari'                   =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Hanuma',              'last' => 'Vihari',             ],
    'CA Lynn'                     =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'Australia',            'first' => 'Chris',               'last' => 'Lynn',               ],
    'DB Ravi Teja'                =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Dwaraka Ravi',        'last' => 'Teja',               ],
    'X Thalaivan Sargunam'        =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Thalaivan',           'last' => 'Sargunam',           ],
    'A Ashish Reddy'              =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Ashish',              'last' => 'Reddy',              ],
    'AA Jhunjhunwala'             =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Abhishek',            'last' => 'Jhunjhunwala',       ],
    'NLTC Perera'                 =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'Sri Lanka',            'first' => 'Thisara',             'last' => 'Perera',             ],
    'BB Samantray'                =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Biplab',              'last' => 'Samantray',          ],
    'NL McCullum'                 =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'New Zealand',          'first' => 'Nathan',              'last' => 'McCullum',           ],
    'DJG Sammy'                   =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'West Indies',          'first' => 'Darren',              'last' => 'Sammy',              ],
    'S Rana'                      =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Sachin',              'last' => 'Rana',               ],
    'KV Sharma'                   =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Karan',               'last' => 'Sharma',             ],
    'KC Sangakkara'               =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'Sri Lanka',            'first' => 'Kumar',               'last' => 'Sangakkara',         ],
    'PA Patel'                    =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Parthiv',             'last' => 'Patel',              ],
    'Q de Kock'                   =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'South Africa',         'first' => 'Quinton',             'last' => 'de Kock',            ],
    'I Sharma'                    =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Ishant',              'last' => 'Sharma',             ],
    'Ankit Sharma'                =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Ankit',               'last' => 'Sharma',             'page' => 'Ankit Sharma (cricketer)' ],
    'DW Steyn'                    =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'South Africa',         'first' => 'Dale',                'last' => 'Steyn',              ],
    'V Pratap Singh'              =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Veer Pratap',         'last' => 'Singh',              ],
    'A Mishra'                    =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Amit',                'last' => 'Mishra',             ],
    'Anand Rajan'                 =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Anand',               'last' => 'Rajan',              ],
    'CJ McKay'                    =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'Australia',            'first' => 'Clint',               'last' => 'McKay'               ],
    'S Tyagi'                     =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Sudeep',              'last' => 'Tyagi',              ],
    'P Prasanth'                  =>  [ 'team' => 'Sunrisers Hyderabad', 'country' => 'India',                'first' => 'Padmanabhan',         'last' => 'Prasanth',           ],
 
    # OTHER PLAYERS
    # See comment at the beginning for when a player must be added here. However, do not remove any entry from this list.

    'HH Gibbs'                    =>  [ 'country' => 'South Africa',         'first' => 'Herschelle',          'last' => 'Gibbs',              ],
    'A Symonds'                   =>  [ 'country' => 'Australia',            'first' => 'Andrew',              'last' => 'Symonds',            ],
    'YV Takawale'                 =>  [ 'country' => 'India',                'first' => 'Yogesh',              'last' => 'Takawale',           ],
    'MN van Wyk'                  =>  [ 'country' => 'South Africa',         'first' => 'Morné',               'last' => 'van Wyk',            ],
    'P Amarnath'                  =>  [ 'country' => 'India',                'first' => 'Palani',              'last' => 'Amarnath',           ],
    'Mashrafe Mortaza'            =>  [ 'country' => 'Bangladesh',           'first' => 'Mashrafe',            'last' => 'Mortaza',            ],
    'Sohail Tanvir'               =>  [ 'country' => 'Pakistan',             'first' => 'Sohail',              'last' => 'Tanvir',             'sort' => 'Sohail Tanvir' ],
    'A Kumble'                    =>  [ 'country' => 'India',                'first' => 'Anil',                'last' => 'Kumble',             ],
    'DE Bollinger'                =>  [ 'country' => 'Australia',            'first' => 'Doug',                'last' => 'Bollinger',          ],
    'MF Maharoof'                 =>  [ 'country' => 'Sri Lanka',            'first' => 'Farveez',             'last' => 'Maharoof',           ],
    'ST Jayasuriya'               =>  [ 'country' => 'Sri Lanka',            'first' => 'Sanath',              'last' => 'Jayasuriya',         ],
    'SC Ganguly'                  =>  [ 'country' => 'India',                'first' => 'Sourav',              'last' => 'Ganguly',            ],
    'ML Hayden'                   =>  [ 'country' => 'Australia',            'first' => 'Matthew',             'last' => 'Hayden',             ],
    'GC Smith'                    =>  [ 'country' => 'South Africa',         'first' => 'Graeme',              'last' => 'Smith',              ],
    'SA Asnodkar'                 =>  [ 'country' => 'India',                'first' => 'Swapnil',             'last' => 'Asnodkar',           ],
    'AC Voges'                    =>  [ 'country' => 'Australia',            'first' => 'Adam',                'last' => 'Voges',              ],
    'MV Boucher'                  =>  [ 'country' => 'South Africa',         'first' => 'Mark',                'last' => 'Boucher',            ],
    'JR Hopes'                    =>  [ 'country' => 'Australia',            'first' => 'James',               'last' => 'Hopes',              ],
    'SM Katich'                   =>  [ 'country' => 'Australia',            'first' => 'Simon',               'last' => 'Katich',             ],
    'MJ Lumb'                     =>  [ 'country' => 'England',              'first' => 'Michael',             'last' => 'Lumb',               'page' => 'Michael Lumb (cricketer)' ],
    'PD Collingwood'              =>  [ 'country' => 'England',              'first' => 'Paul',                'last' => 'Collingwood',        ],
    'RS Bopara'                   =>  [ 'country' => 'England',              'first' => 'Ravi',                'last' => 'Bopara',             ],
    'SK Warne'                    =>  [ 'country' => 'Australia',            'first' => 'Shane',               'last' => 'Warne',              ],
    'WPUJC Vaas'                  =>  [ 'country' => 'Sri Lanka',            'first' => 'Chaminda',            'last' => 'Vaas',               ],
    'VY Mahesh'                   =>  [ 'country' => 'India',                'first' => 'Yo',                  'last' => 'Mahesh',             ],
    'SJ Srivastava'               =>  [ 'country' => 'India',                'first' => 'Shalabh',             'last' => 'Srivastava',         ],
    'Joginder Sharma'             =>  [ 'country' => 'India',                'first' => 'Joginder',            'last' => 'Sharma',             ],
    'AC Thomas'                   =>  [ 'country' => 'South Africa',         'first' => 'Alfonso',             'last' => 'Thomas',             ],
    'SM Pollock'                  =>  [ 'country' => 'South Africa',         'first' => 'Shaun',               'last' => 'Pollock',            ],
    'GD McGrath'                  =>  [ 'country' => 'Australia',            'first' => 'Glenn',               'last' => 'McGrath',            ],
    'RR Powar'                    =>  [ 'country' => 'India',                'first' => 'Ramesh',              'last' => 'Powar',              ],
    'VRV Singh'                   =>  [ 'country' => 'India',                'first' => 'V. R. V.',            'last' => 'Singh',              'sort' => 'Singh, Vikram Raj Vir' ],
    'JJ van der Wath'             =>  [ 'country' => 'South Africa',         'first' => 'Johan',               'last' => 'van der Wath',       ],
    'A Flintoff'                  =>  [ 'country' => 'England',              'first' => 'Andrew',              'last' => 'Flintoff',           ],
    'Mohammad Asif'               =>  [ 'country' => 'Pakistan',             'first' => 'Mohammad',            'last' => 'Asif',               'sort' => 'Mohammad Asif' ],
    'B Geeves'                    =>  [ 'country' => 'Australia',            'first' => 'Brett',               'last' => 'Geeves',             ],
    'MDKJ Perera'                 =>  [ 'country' => 'Sri Lanka',            'first' => 'Kusal',               'last' => 'Perera',             ],
    'TD Paine'                    =>  [ 'country' => 'Australia',            'first' => 'Tim',                 'last' => 'Paine',              ],
    'C Madan'                     =>  [ 'country' => 'India',                'first' => 'Chandan',             'last' => 'Madan',              ],
    'AG Paunikar'                 =>  [ 'country' => 'India',                'first' => 'Amit',                'last' => 'Paunikar',           ],
    'KH Devdhar'                  =>  [ 'country' => 'India',                'first' => 'Kedar',               'last' => 'Devdhar',            ],
    'U Kaul'                      =>  [ 'country' => 'India',                'first' => 'Uday',                'last' => 'Kaul',               ],
    'DT Patil'                    =>  [ 'country' => 'India',                'first' => 'Devraj',              'last' => 'Patil',              ],
    'SS Shaikh'                   =>  [ 'country' => 'India',                'first' => 'Shoaib',              'last' => 'Shaikh',             ],
    'L Ronchi'                    =>  [ 'country' => 'New Zealand',          'first' => 'Luke',                'last' => 'Ronchi',             ],
    'DJ Jacobs'                   =>  [ 'country' => 'South Africa',         'first' => 'Davy',                'last' => 'Jacobs',             ],
    'Kamran Akmal'                =>  [ 'country' => 'Pakistan',             'first' => 'Kamran',              'last' => 'Akmal',              ],
    'PR Shah'                     =>  [ 'country' => 'India',                'first' => 'Pinal',               'last' => 'Shah',               ],
    'M Kaif'                      =>  [ 'country' => 'India',                'first' => 'Mohammad',            'last' => 'Kaif',               ],
    'B Sumanth'                   =>  [ 'country' => 'India',                'first' => 'Bodapati',            'last' => 'Sumanth',            ],
    'VVS Laxman'                  =>  [ 'country' => 'India',                'first' => 'VVS',                 'last' => 'Laxman',             ],
 
    #   ----------------  PLAYER NAME TRANSLATION TABLE ENDS HERE ----------------

];
 
 
$CricinfoTeamNameTranslationTable = [
 
    /*
        This table is used to translate the short team names used in Cricinfo records to their actual names.
        Each entry should have the Cricinfo name as the key.
        The value should be an array with two parameters:
        - name (the actual name of the team)
        - alias (the alias name used as the first parameter in the {{Cr-IPL}} template
 
        Do not remove defunct teams from the list.
    */
 
    'Super Kings'       => [ 'name' => 'Chennai Super Kings',              'alias' => 'chen'    ],
    'Daredevils'        => [ 'name' => 'Delhi Daredevils',                 'alias' => 'delhi'   ],
    'Kings XI'          => [ 'name' => 'Kings XI Punjab',                  'alias' => 'kings'   ],
    'KKR'               => [ 'name' => 'Kolkata Knight Riders',            'alias' => 'kolk'    ],
    'Mum Indians'       => [ 'name' => 'Mumbai Indians',                   'alias' => 'mumb'    ],
    'Warriors'          => [ 'name' => 'Pune Warriors India',              'alias' => 'pune',   ],
    'Royals'            => [ 'name' => 'Rajasthan Royals',                 'alias' => 'raja'    ],
    'RCB'               => [ 'name' => 'Royal Challengers Bangalore',      'alias' => 'bang'    ],
    'Sunrisers'         => [ 'name' => 'Sunrisers Hyderabad',              'alias' => 'hyde'    ],
    'Chargers'          => [ 'name' => 'Deccan Chargers',                  'alias' => 'decc'    ],
    'Kochi'             => [ 'name' => 'Kochi Tuskers Kerala',             'alias' => 'koch'    ],
 
    'Chennai Super Kings'                 => [ 'name' => 'Chennai Super Kings',              'alias' => 'chen'    ],
    'Delhi Daredevils'                    => [ 'name' => 'Delhi Daredevils',                 'alias' => 'delhi'   ],
    'Kings XI Punjab'                     => [ 'name' => 'Kings XI Punjab',                  'alias' => 'kings'   ],
    'Kolkata Knight Riders'               => [ 'name' => 'Kolkata Knight Riders',            'alias' => 'kolk'    ],
    'Mumbai Indians'                      => [ 'name' => 'Mumbai Indians',                   'alias' => 'mumb'    ],
    'Pune Warriors India'                 => [ 'name' => 'Pune Warriors India',              'alias' => 'pune',   ],
    'Rajasthan Royals'                    => [ 'name' => 'Rajasthan Royals',                 'alias' => 'raja'    ],
    'Royal Challengers Bangalore'         => [ 'name' => 'Royal Challengers Bangalore',      'alias' => 'bang'    ],
    'Sunrisers Hyderabad'                 => [ 'name' => 'Sunrisers Hyderabad',              'alias' => 'hyde'    ],
    'Deccan Chargers'                     => [ 'name' => 'Deccan Chargers',                  'alias' => 'decc'    ],
    'Kochi Tuskers Kerala'                => [ 'name' => 'Kochi Tuskers Kerala',             'alias' => 'koch'    ],
 
    'Pune Warriors'                 => [ 'name' => 'Pune Warriors India',              'alias' => 'pune',   ],  # Pune Warriors India is sometimed referred to in Cricinfo by this name
];
 
 
$CricinfoGroundNameTranslationTable = [
 
    /*
        Translates ground names in Cricinfo to their actual names and locations.
        The Cricinfo short names cannot be used here as they conflict very often (e.g. "Mumbai" refers to Wankhede Stadium and DY Patil Stadium)
        This table uses the Cricinfo unique IDs of the grounds, which is found in the URIs of their profile pages:
            http://www.espncricinfo.com/.../content/ground/[id].html where [id] is the unique ID
 
        Each entry must have the unique ID as the key, and the value must be an array with "name" and "location" parameters
        whose values are the name and location/city of the ground respectively.
 
        If the name or location needs to be disambiguated, enter it in the form "<pagename>|<displayname>"
 
    */
 
    # INDIAN GROUNDS

    58008     =>  [ 'name' => 'M. A. Chidambaram Stadium',                                  'location' => 'Chennai' ],
    58324     =>  [ 'name' => 'Wankhede Stadium',                                           'location' => 'Mumbai' ],
    57991     =>  [ 'name' => 'Punjab Cricket Association Stadium',                         'location' => 'Mohali' ],
    57980     =>  [ 'name' => 'Eden Gardens',                                               'location' => 'Kolkata' ],
    57897     =>  [ 'name' => 'M. Chinnaswamy Stadium',                                     'location' => 'Bangalore' ],
    343050    =>  [ 'name' => 'DY Patil Stadium',                                           'location' => 'Navi Mumbai' ],
    58142     =>  [ 'name' => 'Rajiv Gandhi International Cricket Stadium',                 'location' => 'Hyderabad, India|Hyderabad' ],
    58040     =>  [ 'name' => 'Feroz Shah Kotla',                                           'location' => 'Delhi' ],
    58162     =>  [ 'name' => 'Sawai Mansingh Stadium',                                     'location' => 'Jaipur' ],
    58317     =>  [ 'name' => 'Brabourne Stadium',                                          'location' => 'Mumbai' ],
    57851     =>  [ 'name' => 'Sardar Patel Stadium',                                       'location' => 'Ahmedabad' ],
    58027     =>  [ 'name' => 'Barabati Stadium',                                           'location' => 'Cuttack' ],
    375326    =>  [ 'name' => 'Vidarbha Cricket Association Ground',                        'location' => 'Nagpur' ],
    58056     =>  [ 'name' => 'HPCA Cricket Stadium',                                       'location' => 'Dharamsala, Himachal Pradesh|Dharamsala' ],
    58230     =>  [ 'name' => 'Jawaharlal Nehru Stadium, Kochi|Jawaharlal Nehru Stadium',   'location' => 'Kochi' ],
    58150     =>  [ 'name' => 'Holkar Cricket Stadium',                                     'location' => 'Indore' ],
    545380    =>  [ 'name' => 'Subrata Roy Sahara Stadium',                                 'location' => 'Pune' ],
    58547     =>  [ 'name' => 'APCA-VDCA Stadium',                                          'location' => 'Visakhapatnam' ],
    485865    =>  [ 'name' => 'JSCA International Cricket Stadium',                         'location' => 'Ranchi' ],
    601879    =>  [ 'name' => 'Raipur International Cricket Stadium',                       'location' => 'Raipur' ],
 
    # SOUTH AFRICAN GROUNDS (FOR 2010 SEASON)

    59068     =>  [ 'name' => 'Newlands Cricket Ground',                                    'location' => 'Cape Town' ],
    59159     =>  [ 'name' => 'St George\'s Oval|St George\'s Park',                        'location' => 'Port Elizabeth' ],
    59089     =>  [ 'name' => 'Kingsmead Cricket Ground',                                   'location' => 'Durban' ],
    59079     =>  [ 'name' => 'SuperSport Park',                                            'location' => 'Centurion, Gauteng|Centurion' ],
    59120     =>  [ 'name' => 'Wanderers Stadium',                                          'location' => 'Johannesburg' ],
    59098     =>  [ 'name' => 'Buffalo Park',                                               'location' => 'East London, Eastern Cape|East London' ],
    59042     =>  [ 'name' => 'Chevrolet Park|OUTsurance Oval',                             'location' => 'Bloemfontein' ],
    59135     =>  [ 'name' => 'De Beers Diamond Oval',                                      'location' => 'Kimberley, Northern Cape|Kimberley' ],
 
];
 
?>