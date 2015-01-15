<?php
namespace Erpk\Common\Entity;

/**
 * @Entity(repositoryClass="Erpk\Common\Repository\Campaign")
 * @Table(name="battles")
 **/
class Campaign
{
    /**
     * @Id @Column(type="integer")
     * @var int
     **/
    protected $id;
    
    /**
     * @ManyToOne(targetEntity="Country")
     * @var Country
     **/
    protected $attacker;
    
    /**
     * @ManyToOne(targetEntity="Country")
     * @var Country
     **/
    protected $defender;
    
    /**
     * @ManyToOne(targetEntity="Region")
     * @var Region
     **/
    protected $region;
    
    /**
     * @Column(type="boolean")
     * @var bool
     **/
    protected $is_resistance;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'             => $this->getId(),
            'url'            => 'http://www.erepublik.com/en/military/battlefield-new/'.$this->getId(),
            'region'         => $this->getRegion(),
            'is_resistance'  => $this->isResistance(),
            'attacker'       => $this->getAttacker(),
            'defender'       => $this->getDefender()
        ];
    }
    
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Country $country
     */
    public function setAttacker(Country $country)
    {
        $this->attacker = $country;
    }

    /**
     * @return Country
     */
    public function getAttacker()
    {
        return $this->attacker;
    }

    /**
     * @param Country $country
     */
    public function setDefender(Country $country)
    {
        $this->defender = $country;
    }

    /**
     * @return Country
     */
    public function getDefender()
    {
        return $this->defender;
    }

    /**
     * @param Region $region
     */
    public function setRegion(Region $region)
    {
        $this->region = $region;
    }

    /**
     * @return Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param bool $res
     */
    public function setResistance($res)
    {
        $this->is_resistance = (bool)$res;
    }

    /**
     * @return bool
     */
    public function isResistance()
    {
        return $this->is_resistance;
    }
}
