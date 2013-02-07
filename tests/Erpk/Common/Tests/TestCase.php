<?php
namespace Erpk\Common\Tests;

use Erpk\Common\EntityManager;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    public function getEntityManager()
    {
        return EntityManager::getInstance();
    }
}
