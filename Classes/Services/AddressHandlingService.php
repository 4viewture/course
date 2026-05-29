<?php

// @todo check for existence of address, but do not create them? or just on same pid?

namespace FourViewture\Course\Services;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AddressHandlingService
{
    protected CONST TABLE_WITH_ADDRESSES = 'tt_address';

    protected $knownEntries = [];

    public function getOneByName(int $pid, string $name): ?array
    {
        $key = md5(json_encode([$pid, $name], JSON_THROW_ON_ERROR));

        if (array_key_exists($key, $this->knownEntries)) {
            return $this->knownEntries[$key];
        }

        $address = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE_WITH_ADDRESSES)
            ->executeQuery('SELECT * FROM ' . self::TABLE_WITH_ADDRESSES . ' WHERE pid = ? AND last_name = ?',
                [
                    $pid,
                    $name
                ]
            )->fetchAssociative();
        if ($address === false) {
            return null;
        }

        $this->knownEntries[$key] = $address;

        return $address;
    }
}
