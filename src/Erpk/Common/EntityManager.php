<?php
namespace Erpk\Common;

use Doctrine\ORM;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Proxy\AbstractProxyFactory;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\DriverManager;

class EntityManager extends DoctrineEntityManager
{
    protected static $instance = null;
    protected static $useCopy = false;

    /**
     * Allows to use copy of storage SQLite database.
     * Useful for PHAR archives, which cannot handle database files properly.
     * @param  bool $mode Use copy on TRUE or use default location on FALSE
     * @return void
     */
    public static function useCopy($mode)
    {
        self::$useCopy = (bool)$mode;
    }

    /**
     * Creates instance of EntityManager
     */
    public function __construct()
    {
        $db = __DIR__.'/Storage.db';

        if (self::$useCopy) {
            $tempDir = sys_get_temp_dir();
            $tempDb = $tempDir.'/erpk-common-6c814ae7-ceb3-4aeb-88f4-a42d8f05dcb6';
            copy($db, $tempDb);
            $db = $tempDb;
        }

        $cache = new ArrayCache();
        $config = new ORM\Configuration();
        $config->setMetadataCacheImpl($cache);
        $driverImpl = $config->newDefaultAnnotationDriver(__DIR__.'/Entity');
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir(__DIR__.'/Proxy');
        $config->setProxyNamespace('Erpk\Common\Proxy');
        $config->setAutoGenerateProxyClasses(AbstractProxyFactory::AUTOGENERATE_NEVER);

        $conn = DriverManager::getConnection(
            array(
                'driver' => 'pdo_sqlite',
                'path' => $db
            ),
            $config,
            new EventManager()
        );

        parent::__construct($conn, $config, $conn->getEventManager());
    }

    /**
     * Returns global instance of EntityManager.
     * Although, you should rather use "new EntityManager()" instead.
     * @return EntityManager EntityManager instance
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
