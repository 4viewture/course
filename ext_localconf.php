<?php
defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Course',
    'CourseList',
    [
        \FourViewture\Course\Controller\CourseController::class => 'list'
    ],
    // non-cacheable actions
    [
        \FourViewture\Course\Controller\CourseController::class => 'list'
    ]
);
