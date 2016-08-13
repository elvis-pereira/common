<?php
namespace Erpk\Common\Tests\Citizen;

use Erpk\Common\Tests\TestCase;
use Erpk\Common\Citizen\AirRank;

class AirRankTest extends TestCase
{
    public function testLevels()
    {
        $e = false;
        try {
            $rank = new AirRank(-999);
            $this->assertEquals(1, $rank->getLevel());
        } catch (\InvalidArgumentException $ex) {
            $e = true;
        }
        $this->assertTrue(true, $e);


        $rank = new AirRank(0);
        $this->assertEquals(1, $rank->getLevel());

        $rank = new AirRank(5300);
        $this->assertEquals(17, $rank->getLevel());
        $this->assertEquals('Staff Sergeant***', $rank->getName());
        $this->assertEquals(800, $rank->getPointsToAdvance());
        $this->assertEquals(
            'http://s1.www.erepublik.net/images/modules/ranks/staff_sergeant_3.png',
            $rank->getImage()
        );

        $rank = new AirRank(null, 50);
        $this->assertEquals(50, $rank->getLevel());
        $this->assertEquals('Group Captain', $rank->getName());
        $this->assertEquals(null, $rank->getPointsToAdvance());
        $this->assertEquals(
            'http://s1.www.erepublik.net/images/modules/ranks/group_captain_0.png',
            $rank->getImage()
        );
    }
}
