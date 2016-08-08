<?php
namespace Erpk\Common\Citizen;

class AirRank
{
    /**
     * Current rank points
     * @var int
     */
    protected $points;

    /**
     * URL to rank image
     * @var string
     */
    protected $image;

    /**
     * Current rank name
     * @var string
     */
    protected $name;

    /**
     * Current rank level
     * @var int
     */
    protected $level;

    /**
     * Ranks table
     * @var array
     */
    protected static $ranks = [
        1 => ['Airman', 0],

        ['Airman 1st Class', 10],
        ['Airman 1st Class*', 25],
        ['Airman 1st Class**', 45],
        ['Airman 1st Class***', 70],
        ['Airman 1st Class****', 100],
        ['Airman 1st Class*****', 140],

        ['Senior Airman', 190],
        ['Senior Airman*', 270],
        ['Senior Airman**', 380],
        ['Senior Airman***', 530],
        ['Senior Airman****', 850],
        ['Senior Airman*****', 1300],

        ['Staff Sergeant', 2340],
        ['Staff Sergeant*', 3300],
        ['Staff Sergeant**', 4200],
        ['Staff Sergeant***', 5150],
        ['Staff Sergeant****', 6100],
        ['Staff Sergeant*****', 7020],

        ['Aviator', 9100],
        ['Aviator*', 12750],
        ['Aviator**', 16400],
        ['Aviator***', 20000],
        ['Aviator****', 23650],
        ['Aviator*****', 27300],

        ['Flight Lieutenant', 35500],
        ['Flight Lieutenant*', 48000],
        ['Flight Lieutenant**', 60000],
        ['Flight Lieutenant***', 72400],
        ['Flight Lieutenant****', 84500],
        ['Flight Lieutenant*****', 97000],

        ['Squadron Leader', 110000],
        ['Squadron Leader*', 140000],
        ['Squadron Leader**', 170000],
        ['Squadron Leader***', 210000],
        ['Squadron Leader****', 290000],
        ['Squadron Leader*****', 350000],

        ['Chief Master Sergeant', 429000],
        ['Chief Master Sergeant*', 601000],
        ['Chief Master Sergeant**', 772000],
        ['Chief Master Sergeant***', 944000],
        ['Chief Master Sergeant****', 1115000],
        ['Chief Master Sergeant*****', 1287000],

        ['Wing Commander', 1673000],
        ['Wing Commander*', 2238000],
        ['Wing Commander**', 2804000],
        ['Wing Commander***', 3369000],
        ['Wing Commander****', 3935000],
        ['Wing Commander*****', 4500000],

        ['Group Captain', 5020000]
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

            while ($rankLevel > 1 && $rankPoints < self::$ranks[$rankLevel][1]) {
                $rankLevel--;
            }
            $this->name = self::$ranks[$rankLevel][0];
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
     * Returns rank points
     * @return int Rank points
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Returns rank level
     * @return int Rank level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Returns rank name
     * @return string Rank name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns URL to rank image
     * @return string URL to rank image
     */
    public function getImage()
    {
        $name = $this->name;
        $n    = substr_count($name, '*');
        $name = strtr($name, [' '=>'_', '*'=>'', '.'=>'']);
        return
            'http://s1.www.erepublik.net/images/modules/ranks/'.
            strtolower($name).'_'.$n.'.png';
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

    /**
     * Converts object to array
     * @return array Array of values
     */
    public function toArray()
    {
        return [
            'name'   => $this->getName(),
            'level'  => $this->getLevel(),
            'points' => $this->getPoints(),
            'image'  => $this->getImage(),
            'toNext' => $this->getPointsToAdvance()
        ];
    }
}