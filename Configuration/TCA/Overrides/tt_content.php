<?php
defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Course',
    'CourseList',
    'Course List'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Course',
    'CourseMonth',
    'Course Month'
);
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Course',
    'AddressDetail',
    'Address Detail'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['course_courselist'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['course_coursemonth'] = 'pi_flexform';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['course_addressdetail'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'course_courselist',
    'FILE:EXT:course/Configuration/FlexForms/CourseList.xml'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'course_coursemonth',
    'FILE:EXT:course/Configuration/FlexForms/CourseList.xml'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'course_addressdetail',
    'FILE:EXT:course/Configuration/FlexForms/AddressDetail.xml'
);
