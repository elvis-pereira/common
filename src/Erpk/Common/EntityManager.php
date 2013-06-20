<?php
namespace Erpk\Common;

use Doctrine\ORM;

class EntityManager
{
    protected static $instance = null;
    
    public static function getInstance()
    {
        if (!self::$instance) {
            $db = __DIR__.'/Storage.db';
            
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
