<?php

// @todo check for existence of address, but do not create them? or just on same pid?

namespace FourViewture\Course\Services;

use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AddressHandlingService
{
    protected CONST TABLE_WITH_ADDRESSES = 'tt_address';

    protected $knownEntries = [];

    public function getOneByName(int $pid, string $name, bool $autoCreate = true): ?array
    {
        $key = md5(json_encode([$pid, $name], JSON_THROW_ON_ERROR));

        if (array_key_exists($key, $this->knownEntries)) {
            return $this->knownEntries[$key];
        }

        $address = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE_WITH_ADDRESSES)
            ->executeQuery('SELECT * FROM ' . self::TABLE_WITH_ADDRESSES . ' WHERE pid = ? AND (last_name = ? || name = ?) LIMIT 1',
                [
                    $pid,
                    $name,
                    $name
                ]
            )->fetchAssociative();
        if ($address === false && $autoCreate) {
            $this->createByName($pid, $name);
            return $this->getOneByName($pid, $name, false);
        }

        $this->knownEntries[$key] = $address;

        return $address;
    }

    protected function createByName(int $pid, string $name): int
    {
        if (PHP_SAPI !== 'cli') {
            Bootstrap::initializeBackendAuthentication();
        }

        $data = [
            'pid' => $pid,
            'name' => $name,
        ];

        // Simple split for first and last name
        $nameParts = explode(' ', $name, 2);
        if (count($nameParts) === 2) {
            $data['first_name'] = $nameParts[0];
            $data['last_name'] = $nameParts[1];
        } else {
            $data['last_name'] = $name;
        }

        /** @var DataHandler $dataHandler */
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
        $dataHandler->start([self::TABLE_WITH_ADDRESSES => ['NEW' => $data]], []);
        $dataHandler->process_datamap();

        if (isset($dataHandler->substNEWwithIDs['NEW'])) {
            return (int)$dataHandler->substNEWwithIDs['NEW'];
        }

        return 0;
    }
}
