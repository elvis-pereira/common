<?php
namespace Erpk\Common\Citizen;

abstract class AbstractRank
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
    public abstract function getImage();

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