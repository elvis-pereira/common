<?php
namespace Erpk\Common\Tests\Citizen;

use Erpk\Common\Tests\TestCase;
use Erpk\Common\Citizen\Helpers;

class HelpersTest extends TestCase
{
    public function testGetHit()
    {
        $this->assertEquals(10590, Helpers::getHit(31212, 62));
    }
}
