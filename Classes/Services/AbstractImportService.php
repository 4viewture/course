<?php

namespace FourViewture\Course\Services;

use FourViewture\Course\Dto\RecordDto;
use FourViewture\Course\Services\De\DrkDb\KurstermineDrkProvider;
use FourViewture\Sync\Domain\Model\SyncConfiguration;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use FourViewture\Sync\Services\Provider\ImportProviderInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use Psr\Log\LoggerAwareTrait;

abstract class AbstractImportService extends \FourViewture\Sync\Services\Provider\AbstractImportService implements ImportServiceInterface, ImportProviderInterface
{
    use LoggerAwareTrait;

    protected CONST TABLE_WITH_COURSES = 'tx_course_domain_model_course';

    protected CONST TABLE_WITH_CATEGORIES = 'sys_category';

    protected CategoryHandlingService $categoryHandlingService;

    protected $backendUserInitialized = false;
    protected AddressHandlingService $addressHandlingService;

    /**
     * @var ConnectionPool
     */
    protected $connectionPool;

    /**
     * @var StorageRepository
     */
    protected $storageRepository;

    /**
     * @var PersistenceManager
     */
    protected $persistenceManager;

    public function __construct(
        PersistenceManager $persistenceManager,
        ?ConnectionPool $connectionPool = null,
        ?StorageRepository $storageRepository = null
    )
    {
        $this->persistenceManager = $persistenceManager;

        $this->connectionPool = $connectionPool;
        if ($this->connectionPool === null) {
            $this->connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        }

        $this->storageRepository = $storageRepository;
        if ($this->storageRepository === null) {
            $this->storageRepository = GeneralUtility::makeInstance(StorageRepository::class);
        }

        /** @var ExtensionConfiguration $configurationUtility */
        $configurationUtility = GeneralUtility::makeInstance(ExtensionConfiguration::class);
    }


    public function injectCategoryHandlingService(CategoryHandlingService $categoryHandlingService)
    {
        $this->categoryHandlingService = $categoryHandlingService;
    }

    public function injectAddressHandlingService(AddressHandlingService $addressHandlingService)
    {
        $this->addressHandlingService = $addressHandlingService;
    }

    protected function getRecord(int $pid, string $importSource, string $importId): ?RecordDto
    {
        $record = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE_WITH_COURSES)
            ->executeQuery('SELECT * FROM ' . self::TABLE_WITH_COURSES . ' WHERE pid = ? and import_source = ? and import_id = ?',
            [
                $pid,
                $importSource,
                $importId
            ]
            )->fetchAssociative();
        if ($record === false) {
            return null;
        }
        return new RecordDto($record);
    }

    public function getCategory(int $pid, string $name)
    {
        $record = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE_WITH_CATEGORIES)
            ->executeQuery('SELECT * FROM ' . self::TABLE_WITH_CATEGORIES . ' WHERE pid = ? and title = ?',
                [
                    $pid,
                    $name
                ]
            )->fetchAssociative();
        if ($record === false) {
            return null;
        }
        return $record;
    }

    protected function useDataHandler($data)
    {
        if (!$this->backendUserInitialized) {
            Bootstrap::initializeBackendAuthentication();
            $this->backendUserInitialized = true;
        }

        /** @var DataHandler $dataHandler */
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);

        $dataHandler->start($data, []);
        $dataHandler->process_datamap();

        if ($dataHandler->errorLog !== []) {
            $this->logger->error('Error(s) while creating content element');
            foreach ($dataHandler->errorLog as $log) {
                // handle error, for example, in a log
                $this->logger->error($log);
            }
        }
    }

    protected function updateRecord(RecordDto $record)
    {
        $data = $record->toArray();
        $uid = $data['uid'] ?? 'NEW';

        $this->useDataHandler(
            [
                self::TABLE_WITH_COURSES => [
                    $uid => $data
                ]
            ]
        );
    }

    protected function insertRecord(array $data): string
    {
        if (empty($data['pid'])) {
            throw new \InvalidArgumentException('pid is required for course import');
        }
        if (empty($data['number'])) {
            throw new \InvalidArgumentException('number is required for course import');
        }
        #if (empty($data['source'])) {
        #    throw new \InvalidArgumentException('number is required for course import');
        #}
        $pool = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE_WITH_COURSES);
        $pool->insert(self::TABLE_WITH_COURSES, $data);
        return $pool->lastInsertId();
    }

    public function _ct(
        PersistenceManager $persistenceManager,
        ?ConnectionPool $connectionPool = null,
        ?StorageRepository $storageRepository = null
    ) {
        $this->persistenceManager = $persistenceManager;
        $this->connectionPool = $connectionPool;
        $this->storageRepository = $storageRepository;
    }

    public function handle(SyncConfiguration $syncConfiguration): void
    {
        $this->import(
            [
                'uri' => $syncConfiguration->getUri(),
                'pid' => $syncConfiguration->getPid(),
            ]
        );
    }

    public function getLog(): string
    {
        return '';
    }

    public function getLabelForTca(): string
    {
        return get_class($this);
    }

    public function getGroupForTca(): string
    {
        return 'Course';
    }

    public function getExtension(): string
    {
        return 'course';
    }
}
