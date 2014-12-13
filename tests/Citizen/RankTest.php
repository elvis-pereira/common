<?php
namespace Erpk\Common\Tests\Citizen;

use Erpk\Common\Tests\TestCase;
use Erpk\Common\Citizen\Rank;

class RankTest extends TestCase
{
    public function testLevels()
    {
        $e = false;
        try {
            $rank = new Rank(-999);
            $this->assertEquals(1, $rank->getLevel());
        } catch (\InvalidArgumentException $ex) {
            $e = true;
        }
        $this->assertTrue(true, $e);


        $rank = new Rank(0);
        $this->assertEquals(1, $rank->getLevel());

        $rank = new Rank(328020752);
        $this->assertEquals(64, $rank->getLevel());
        $this->assertEquals('God of War**', $rank->getName());
        $this->assertEquals(171979248, $rank->getPointsToAdvance());
        $this->assertEquals(
            'http://s1.www.erepublik.net/images/modules/ranks/god_of_war_2.png',
            $rank->getImage()
        );

        $rank = new Rank(10000000001);
        $this->assertEquals(69, $rank->getLevel());
        $this->assertEquals('Titan***', $rank->getName());
        $this->assertEquals(79999999999, $rank->getPointsToAdvance());

        $rank = new Rank(90000000000);
        $this->assertEquals(70, $rank->getLevel());
        $this->assertEquals(null, $rank->getPointsToAdvance());

        $rank = new Rank(null, 64);
        $this->assertEquals(64, $rank->getLevel());
        $this->assertEquals('God of War**', $rank->getName());
        $this->assertEquals(
            'http://s1.www.erepublik.net/images/modules/ranks/god_of_war_2.png',
            $rank->getImage()
        );

        $rank = new Rank(null, 1);
        $this->assertEquals(1, $rank->getLevel());
        $this->assertEquals('Recruit', $rank->getName());
    }
}
