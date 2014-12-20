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

        $rank = new Rank(1E10 + 1);
        $this->assertEquals(69, $rank->getLevel());
        $this->assertEquals('Titan***', $rank->getName());
        $this->assertEquals(1E10 - 1, $rank->getPointsToAdvance());

        $rank = new Rank(2E10 + 1);
        $this->assertEquals(70, $rank->getLevel());
        $this->assertEquals('Legends of the New World: Battalion I', $rank->getName());
        $this->assertEquals(3E10 - (2E10 + 1), $rank->getPointsToAdvance());
        $this->assertEquals(
            'http://s1.www.erepublik.net/images/modules/ranks/legendary_0.png',
            $rank->getImage()
        );

        $rank = new Rank(3E10 + 1);
        $this->assertEquals(71, $rank->getLevel());
        $this->assertEquals('Legends of the New World: Battalion II', $rank->getName());
        $this->assertEquals(4E10 - (3E10 + 1), $rank->getPointsToAdvance());

        $rank = new Rank(15E10 + 1);
        $this->assertEquals(83, $rank->getLevel());
        $this->assertEquals('Legends of the New World: Battalion XIV', $rank->getName());
        $this->assertEquals(16E10 - (15E10 + 1), $rank->getPointsToAdvance());

        $rank = new Rank(null, 64);
        $this->assertEquals(64, $rank->getLevel());
        $this->assertEquals('God of War**', $rank->getName());
        $this->assertEquals(
            'http://s1.www.erepublik.net/images/modules/ranks/god_of_war_2.png',
            $rank->getImage()
        );

        $rank = new Rank(300E4);
        $this->assertEquals(47, $rank->getLevel());
        $this->assertEquals('Supreme Marshal*', $rank->getName());

        $rank = new Rank(null, 1);
        $this->assertEquals(1, $rank->getLevel());
        $this->assertEquals('Recruit', $rank->getName());
    }
}
