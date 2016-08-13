<?php
namespace Erpk\Common\Citizen;

class AirRank extends AbstractRank
{
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
     * Construct AirRank object
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
        }

        $this->name = self::$ranks[$rankLevel][0];
        $this->level = $rankLevel;
        $this->points = $rankPoints;
    }

    /**
     * Returns URL to rank image
     * @return string URL to rank image
     */
    public function getImage()
    {
        return self::encodeImageUrl($this->name, substr_count($this->name, '*'));
    }

    /**
     * Returns rank points needed to advance to next rank level
     * @return int|null Rank points needed to advance or NULL when it's not determined
     */
    public function getPointsToAdvance()
    {
        return isset(self::$ranks[$this->level + 1])
            ? self::$ranks[$this->level + 1][1] - $this->points
            : null; // We only know about first 50 ranks.
    }
}