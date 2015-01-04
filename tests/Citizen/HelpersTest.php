<?php
namespace Erpk\Common\Tests\Citizen;

use Erpk\Common\Tests\TestCase;
use Erpk\Common\Citizen\Helpers;
use Erpk\Common\DateTime;

class HelpersTest extends TestCase
{
    public function testGetAvatar()
    {
        $platoAvatar =
            'http://erpk.static.avatars.s3.amazonaws.com/avatars/'.
            'Citizens/2007/06/04/c81e728d9d4c2f636f067f89cc14862c';

        $this->assertEquals(
            $platoAvatar.'.jpg',
            Helpers::getAvatar(
                2,
                new DateTime('2007-06-04'),
                Helpers::AVATAR_ORIGINAL
            )
        );
    }

    public function testGetHit()
    {
        $this->assertEquals(10590, Helpers::getHit(31212, 62));
    }

    public function testGetDivision()
    {
        $this->assertEquals(1, Helpers::getDivision(0));
        $this->assertEquals(1, Helpers::getDivision(34));
        $this->assertEquals(2, Helpers::getDivision(35));
        $this->assertEquals(2, Helpers::getDivision(49));
        $this->assertEquals(3, Helpers::getDivision(50));
        $this->assertEquals(3, Helpers::getDivision(69));
        $this->assertEquals(4, Helpers::getDivision(70));
        $this->assertEquals(4, Helpers::getDivision(150));
    }
}
