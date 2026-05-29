<?php
return [
    'ctrl' => [
        'title' => 'Course',
        'label' => 'number',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'security' => [
            'ignorePageTypeRestriction' => true
        ],
        'searchFields' => 'number,additional_text,course_type,cource_description,course_index',
        'iconfile' => 'EXT:course/Resources/Public/Icons/tx_course_domain_model_course.svg'
    ],
    'types' => [
        '1' => [
            'showitem' => implode(
                ',',
                [
                    'sys_language_uid, l10n_parent, l10n_diffsource',
                        'course_description',
                        '--palette--;;courseIds',
                        '--palette--;;dateRange',
                        'address',
                        '--palette--;;agb',
                        '--palette--;;registration',
                        '--palette--;;costs',
                        'additional_text, import_source,import_id',
                    '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories',
                    'categories',
                    '--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access',
                        'hidden, starttime, endtime',
                ]
            ),
        ]
    ],
    'palettes' => [
        'courseIds' => [
            'showitem' => 'number, course_type, course_index',
        ],
        'dateRange' => [
            'showitem' => 'course_start_date, course_end_date',
        ],
        'agb' => [
            'showitem' => 'link_for_agb, ',
        ],
        'registration' => [
            'showitem' => 'link_for_registration, available_places',
        ],
        'costs' => [
            'showitem' => 'costs, currency, costs_text',
        ],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => ['type' => 'language'],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_course_domain_model_course',
                'foreign_table_where' => 'AND tx_course_domain_model_course.pid=###CURRENT_PID### AND tx_course_domain_model_course.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'l10n_state' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'number' => [
            'exclude' => false,
            'label' => 'Course Number',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'required' => true
            ],
        ],
        'additional_text' => [
            'exclude' => false,
            'label' => 'Additional Text',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'enableRichtext' => true,
            ],
        ],
        'course_start_date' => [
            'exclude' => false,
            'label' => 'Start Date',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'course_end_date' => [
            'exclude' => false,
            'label' => 'End Date',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'link_for_agb' => [
            'exclude' => false,
            'label' => 'Link for AGB',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
            ],
        ],
        'course_type' => [
            'exclude' => false,
            'label' => 'Course Type',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'course_description' => [
            'exclude' => false,
            'label' => 'Description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
                'enableRichtext' => false,
            ],
        ],
        'course_index' => [
            'exclude' => false,
            'label' => 'Course Index',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'costs' => [
            'exclude' => false,
            'label' => 'Costs',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'currency' => [
            'exclude' => false,
            'label' => 'Currenty',
            'config' => [
                'type' => 'input',
                'size' => 3,
                'eval' => 'trim'
            ],
        ],
        'costs_text' => [
            'exclude' => false,
            'label' => 'Costs',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],

        'available_places' => [
            'exclude' => false,
            'label' => 'Available Places',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'link_for_registration' => [
            'exclude' => false,
            'label' => 'Link for Registration',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
            ],
        ],
        'categories' => [
            'config' => [
                'type' => 'category'
            ]
        ],
        'import_id' => [
            'label' => 'Import ID',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'import_source' => [
            'label' => 'Import Source',
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'address' => [
            'exclude' => true,
            'label' => 'Address',
            'config' => [
                'type' => 'group',
                'allowed' => 'tt_address',
                'default' => 0,
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'suggestOptions' => [
                    'default' => [
                        'additionalSearchFields' => 'name,slug',
                    ],
                ],
            ],
        ],
    ],
];
