<?php
namespace Erpk\Common;

use Doctrine\ORM;

class EntityManager
{
    protected static $instance = null;
    protected static $useCopy = false;
    
    public static function useCopy($mode)
    {
        self::$useCopy = (bool)$mode;
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            $db = __DIR__.'/Storage.db';

            if (self::$useCopy) {
                $tempDir = sys_get_temp_dir();
                $tempDb = $tempDir.'/erpk-common-6c814ae7-ceb3-4aeb-88f4-a42d8f05dcb6';
                copy($db, $tempDb);
                $db = $tempDb;
            }
            
            $paths = array(__DIR__.'/Model');
            $conn = array(
                'driver' => 'pdo_sqlite',
                'path' => $db,
            );
            
            $config = ORM\Tools\Setup::createAnnotationMetadataConfiguration($paths);
            $config->setAutoGenerateProxyClasses(true);
            $entityManager = ORM\EntityManager::create($conn, $config);
            self::$instance = $entityManager;
        }
        return self::$instance;
    }
}
