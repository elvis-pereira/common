<?php
namespace Erpk\Common\Citizen;

use DateTime;

class Helpers
{
    public static function getAvatar($id, DateTime $createdAt, $size = null)
    {
        return
            'http://static.erepublik.com/uploads/avatars/Citizens/'.
            $createdAt->format('Y/m/d').'/'.
            md5($id).($size ? '_'.$size.'x'.$size : '').'.jpg';
    }
    
    public static function getHit($strength, $rankLevel, $firePower = 0, $eliteCitizen = false)
    {
        $mod = $eliteCitizen ? 1.1 : 1;
        return floor($mod*(10 * (1 + $strength/400) * (1 + $rankLevel/5) * (1 + $firePower/100)));
    }
    
    public static function getDivision($level)
    {
        if ($level <= 24) {
            return 1;
        } elseif ($level <= 29) {
            return 2;
        } elseif ($level <= 36) {
            return 3;
        } else {
            return 4;
        }
    }
}
