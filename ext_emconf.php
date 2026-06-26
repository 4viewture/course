<?php

$EM_CONF['course'] = [
    'title' => 'Course Extension',
    'description' => 'Allows to import several courses from exchangeable providers',
    'category' => 'plugin',
    'author' => 'Kay Strobach',
    'author_email' => 'hello@4viewture.de',
    'state' => 'alpha',
    'version' => '0.0.1',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
