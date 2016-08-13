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
     * Takes rank name and number of stars and returns full URL to image
     * @param $name
     * @param $starsCount
     * @return string
     */
    protected static function encodeImageUrl($name, $starsCount)
    {
        $name = strtr($name, [' '=>'_', '*'=>'', '.'=>'']);
        return 'http://s1.www.erepublik.net/images/modules/ranks/'.
        strtolower($name).'_'.$starsCount.'.png';
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
    public abstract function getPointsToAdvance();

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