<?php

namespace FourViewture\Course\Services;

use Swaggest\JsonSchema\Schema;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use FourViewture\Sync\Services\Provider\ImportProviderInterface;

abstract class AbstractJsonImportService extends AbstractImportService implements ImportProviderInterface
{
    protected CONST JSON_SCHEMA_PATH = 'EXT:course/...';

    /**
     * @throws \InvalidArgumentException
     *
     */
    protected function validateInputData(string $data)
    {
        if (!json_validate($data, 5000, JSON_INVALID_UTF8_IGNORE)) {
            throw new \InvalidArgumentException('Invalid JSON data provided');
        }

        $schema = Schema::import(GeneralUtility::getFileAbsFileName(static::JSON_SCHEMA_PATH));

        $schema->in(json_decode($data, false, 5000, JSON_THROW_ON_ERROR|JSON_INVALID_UTF8_IGNORE));
    }
}
