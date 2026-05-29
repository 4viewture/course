<?php

namespace FourViewture\Course\Services;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CategoryHandlingService
{
    protected CONST TABLE_WITH_CATEGORIES = 'sys_category';

    protected CONST TABLE_WITH_JOINED_CATEGORIES = 'sys_category_record_mm';

    protected $knownEntries = [];

    public function getCategoriesForRecord(int $uid, string $table): array
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(CategoryHandlingService::TABLE_WITH_JOINED_CATEGORIES)
            ->executeQuery('SELECT * FROM ' . CategoryHandlingService::TABLE_WITH_JOINED_CATEGORIES . ' WHERE uid_foreign = ? AND tablenames = ?',
                [
                    $uid,
                    $table
                ]
            )->fetchAllAssociative();
    }

    public function getCategoryByUid(int $uid): array
    {
        return GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(CategoryHandlingService::TABLE_WITH_CATEGORIES)
            ->executeQuery('SELECT * FROM ' . CategoryHandlingService::TABLE_WITH_CATEGORIES . ' WHERE uid = ?',
                [
                    $uid
                ]
            )->fetchAllAssociative();
    }

    public function getOneCategoryByName(int $pid, string $name): ?array
    {
        $key = md5(json_encode([$pid, $name], JSON_THROW_ON_ERROR));

        if (array_key_exists($key, $this->knownEntries)) {
            return $this->knownEntries[$key];
        }

        $category = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(CategoryHandlingService::TABLE_WITH_CATEGORIES)
            ->executeQuery('SELECT * FROM ' . CategoryHandlingService::TABLE_WITH_CATEGORIES . ' WHERE pid = ? AND title = ?',
                [
                    $pid,
                    $name
                ]
            )->fetchAssociative();
        if ($category === false) {
            return null;
        }

        $this->knownEntries[$key] = $category;

        return $category;
    }
}
