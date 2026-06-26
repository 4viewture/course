<?php
defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Course',
    'CourseList',
    [
        \FourViewture\Course\Controller\CourseController::class => 'list, month',
        \FourViewture\Course\Controller\AddressController::class => 'show'
    ],
    // non-cacheable actions
    [
        \FourViewture\Course\Controller\CourseController::class => 'list, month',
        \FourViewture\Course\Controller\AddressController::class => ''
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Course',
    'CourseMonth',
    [
        \FourViewture\Course\Controller\CourseController::class => 'month, list',
        \FourViewture\Course\Controller\AddressController::class => 'show'
    ],
    // non-cacheable actions
    [
        \FourViewture\Course\Controller\CourseController::class => 'month, list',
        \FourViewture\Course\Controller\AddressController::class => ''
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Course',
    'AddressDetail',
    [
        \FourViewture\Course\Controller\AddressController::class => 'show'
    ],
    // non-cacheable actions
    [
        \FourViewture\Course\Controller\AddressController::class => ''
    ]
);
