<?php
namespace Erpk\Common\Tests;

use Erpk\Common\Tests\TestCase;
use Erpk\Common\EntityManager;

class EntityManagerTest extends TestCase
{
    public function testConstruct()
    {
        $em = new EntityManager();
        $this->assertInstanceOf('Erpk\Common\EntityManager', $em);
    }
}
