<?php
namespace Erpk\Common\Citizen;

class Rank extends AbstractRank
{
    /**
     * Ranks table
     * @var array
     */
    protected static $ranks = [
        1 => ['Recruit', 0],

        ['Private', 15],
        ['Private*', 45],
        ['Private**', 80],
        ['Private***', 120],

        ['Corporal', 170],
        ['Corporal*', 250],
        ['Corporal**', 350],
        ['Corporal***', 450],

        ['Sergeant', 600],
        ['Sergeant*', 800],
        ['Sergeant**', 1000],
        ['Sergeant***', 1400],

        ['Lieutenant', 1850],
        ['Lieutenant*', 2350],
        ['Lieutenant**', 3000],
        ['Lieutenant***', 3750],

        ['Captain', 5000],
        ['Captain*', 6500],
        ['Captain**', 9000],
        ['Captain***', 12000],

        ['Major', 15500],
        ['Major*', 20000],
        ['Major**', 25000],
        ['Major***', 31000],

        ['Commander', 40000],
        ['Commander*', 52000],
        ['Commander**', 67000],
        ['Commander***', 85000],

        ['Lt. Colonel', 110000],
        ['Lt. Colonel*', 140000],
        ['Lt. Colonel**', 180000],
        ['Lt. Colonel***', 225000],

        ['Colonel', 285000],
        ['Colonel*', 355000],
        ['Colonel**', 435000],
        ['Colonel***', 540000],

        ['General', 660000],
        ['General*', 800000],
        ['General**', 950000],
        ['General***', 1140000],

        ['Field Marshal', 1350E3],
        ['Field Marshal*', 1600E3],
        ['Field Marshal**', 1875E3],
        ['Field Marshal***', 2185E3],

        ['Supreme Marshal', 255E4],
        ['Supreme Marshal*', 300E4],
        ['Supreme Marshal**', 350E4],
        ['Supreme Marshal***', 415E4],

        ['National Force', 49E5],
        ['National Force*', 58E5],
        ['National Force**', 70E5],
        ['National Force***', 90E5],

        ['World Class Force', 115E5],
        ['World Class Force*', 145E5],
        ['World Class Force**', 180E5],
        ['World Class Force***', 220E5],

        ['Legendary Force', 265E5],
        ['Legendary Force*', 315E5],
        ['Legendary Force**', 370E5],
        ['Legendary Force***', 430E5],

        ['God of War', 5E7],
        ['God of War*', 10E7],
        ['God of War**', 20E7],
        ['God of War***', 50E7],

        ['Titan', 1E9],
        ['Titan*', 2E9],
        ['Titan**', 4E9],
        ['Titan***', 10E9]
    ];

    /**
     * Construct Rank object
     * @param int $rankPoints Rank points
     * @param int $rankLevel  Rank level (optionally, when null,
     *                        it will be calculated from rank points)
     * @throws \InvalidArgumentException When rank points is a negative number
     */
    public function __construct($rankPoints, $rankLevel = null)
    {
        if ($rankPoints < 0) {
            throw new \InvalidArgumentException("Rank points cannot be negative number");
        }

        if ($rankLevel === null) {
            $rankLevel = count(self::$ranks);

            if ($rankPoints >= self::$ranks[$rankLevel][1] + 1E10) {
                $battalion = floor(($rankPoints/1E10) - 1);
                $rankLevel += $battalion;
                $this->name =
                    "Legends of the New World: Battalion ".
                    self::toRomanNumeral($battalion);
            } else {
                while ($rankLevel > 1 && $rankPoints < self::$ranks[$rankLevel][1]) {
                    $rankLevel--;
                }
                $this->name = self::$ranks[$rankLevel][0];
            }
        } else {
            $this->name = self::$ranks[$rankLevel][0];
        }

        $this->level = $rankLevel;
        $this->points = $rankPoints;
    }

    /**
     * Converts number to its Roman numeral
     * @author David Costa <gurugeek@php.net>
     * @author Sterling Hughes <sterling@php.net>
     * @license http://www.php.net/license/2_02.txt
     * @param $num Number
     * @param bool $uppercase Uppercase output: default true
     * @return mixed|string The corresponding roman numeral
     */
    public static function toRomanNumeral($num, $uppercase = true)
    {
        $conv = array(10 => array('X', 'C', 'M'),
            5 => array('V', 'L', 'D'),
            1 => array('I', 'X', 'C'));
        $roman = '';

        if ($num < 0) {
            return '';
        }

        $num = (int) $num;

        $digit = (int) ($num / 1000);
        $num -= $digit * 1000;
        while ($digit > 0) {
            $roman .= 'M';
            $digit--;
        }

        for ($i = 2; $i >= 0; $i--) {
            $power = pow(10, $i);
            $digit = (int) ($num / $power);
            $num -= $digit * $power;

            if (($digit == 9) || ($digit == 4)) {
                $roman .= $conv[1][$i] . $conv[$digit+1][$i];
            } else {
                if ($digit >= 5) {
                    $roman .= $conv[5][$i];
                    $digit -= 5;
                }

                while ($digit > 0) {
                    $roman .= $conv[1][$i];
                    $digit--;
                }
            }
        }

        /*
         * Preparing the conversion of big integers over 3999.
         * One of the systems used by the Romans  to represent 4000 and
         * bigger numbers was to add an overscore on the numerals.
         * Because of the non ansi equivalent if the html output option
         * is true we will return the overline in the html code if false
         * we will return a _ to represent the overscore to convert from
         * numeral to arabic we will always expect the _ as a
         * representation of the html overscore.
         */
        $over = '_';
        $overe = '';

        /*
         * Replacing the previously produced multiple MM with the
         * relevant numeral e.g. for 1 000 000 the roman numeral is _M
         * (overscore on the M) for 900 000 is _C_M (overscore on both
         * the C and the M) We initially set the replace to AFS which
         * will be later replaced with the M.
         *
         * 500 000 is   _D (overscore D) in Roman Numeral
         * 400 000 is _C_D (overscore on both C and D) in Roman Numeral
         * 100 000 is   _C (overscore C) in Roman Numeral
         *  90 000 is _X_C (overscore on both X and C) in Roman Numeral
         *  50 000 is   _L (overscore L) in Roman Numeral
         *  40 000 is _X_L (overscore on both X and L) in Roman Numeral
         *  10 000 is   _X (overscore X) in Roman Numeral
         *   5 000 is   _V (overscore V) in Roman Numeral
         *   4 000 is M _V (overscore on the V only) in Roman Numeral
         *
         * For an accurate result the integer shouldn't be higher then
         * 5 999 999. Higher integers are still converted but they do not
         * reflect an historically correct Roman Numeral.
         */
        $roman = str_replace(str_repeat('M', 1000),
            $over.'AFS'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 900),
            $over.'C'.$overe.$over.'AFS'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 500),
            $over.'D'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 400),
            $over.'C'.$overe.$over.'D'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 100),
            $over.'C'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 90),
            $over.'X'.$overe.$over.'C'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 50),
            $over.'L'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 40),
            $over.'X'.$overe.$over.'L'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 10),
            $over.'X'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 5),
            $over.'V'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 4),
            'M'.$over.'V'.$overe, $roman);

        /*
         * Replacing AFS with M used in both 1 000 000
         * and 900 000
         */
        $roman = str_replace('AFS', 'M', $roman);

        /*
         * Checking for lowercase output
         */
        if ($uppercase == false) {
            $roman = strtolower($roman);
        }

        return $roman;
    }

    /**
     * Returns URL to rank image
     * @return string URL to rank image
     */
    public function getImage()
    {
        return $this->level <= count(self::$ranks)
            ? self::encodeImageUrl($this->name, substr_count($this->name, '*'))
            : self::encodeImageUrl('legendary', $this->level - count(self::$ranks) - 1);
    }

    /**
     * Returns rank points needed to advance to next rank level
     * @return int|null Rank points needed to advance or NULL when it's not determined
     */
    public function getPointsToAdvance()
    {
        if (isset(self::$ranks[$this->level + 1])) {
            return self::$ranks[$this->level + 1][1] - $this->points;
        } else {
            $m = $this->points / 1E10;
            return (ceil($m) - $m) * 1E10;
        }
    }
}
