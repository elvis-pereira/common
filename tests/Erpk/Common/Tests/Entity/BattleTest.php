<?php
namespace Erpk\Common\Tests;

use Erpk\Common\Tests\TestCase;
use Erpk\Common\Entity\Country;
use Erpk\Common\Entity\Battle;

class BattleTest extends TestCase
{
    public function __construct()
    {
        $this->em   = $this->getEntityManager();
        $this->repo = $this->em->getRepository('Erpk\Common\Entity\Battle');
    }
    
    public function testNotFound()
    {
        $this->assertNull($this->repo->find(56465132));
    }
    
    public function testInsertBattle()
    {
        $countries = $this->em->getRepository('Erpk\Common\Entity\Country');
        $regions = $this->em->getRepository('Erpk\Common\Entity\Region');
        
        $attacker = new Country;
        $attacker->setId(35);
        
        $b = new Battle;
        $b->setId(123456789);
        $b->setAttacker($countries->find(35));
        $b->setDefender($countries->find(1));
        $b->setResistance(true);
        $b->setRegion($regions->find(82));
        
        $this->em->persist($b);
        $this->em->flush();
    }
    
    public function testRemoveBattle()
    {
        $b = $this->repo->find(123456789);
        $this->em->remove($b);
        $this->em->flush();
    }
}
