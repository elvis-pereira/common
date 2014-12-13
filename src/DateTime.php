<?php
namespace Erpk\Common;

use DateTimeZone;
use DateInterval;

class DateTime extends \DateTime
{
    const FIRST_DAY = '2007-11-20';
    const ERPK_TIMEZONE = 'America/Los_Angeles';
    
    public function __construct($time = 'now')
    {
        parent::__construct(
            $time,
            new DateTimeZone(self::ERPK_TIMEZONE)
        );
    }
    
    public static function createFromDay($day)
    {
        $dateTime = new self(self::FIRST_DAY);
        $dateTime->add(new DateInterval('P'.$day.'D'));
        return $dateTime;
    }
    
    public function getDay()
    {
        $firstDay = new self(self::FIRST_DAY);
        $diff = $this->diff($firstDay);
        return $diff->days;
    }
}
