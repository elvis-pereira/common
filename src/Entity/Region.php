<?php
namespace Erpk\Common\Entity;

/**
 * @Entity(repositoryClass="Erpk\Common\Repository\Region")
 * @Table(name="regions")
 **/
class Region
{
    /**
     * @Id
     * @Column(type="integer")
     * @var int
     **/
    protected $id;
    
    /**
     * @Column(type="string")
     * @var string
     **/
    protected $name;
    
    /**
     * @ManyToOne(targetEntity="Country")
     * @JoinColumn(name="original_owner_country_id", referencedColumnName="id")
     * @var Country
     */
    protected $original_owner_country;
    
    /**
     * @Column(type="integer")
     * @var int
     **/
    protected $zone;
    
    /**
     * @Column(type="string")
     * @var string
     **/
    protected $permalink;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'    => $this->getId(),
            'name'  => $this->getName(),
            'original_owner_country' => $this->getOriginalOwnerCountry(),
            'zone'  => $this->getZone()
        ];
    }

    /**
     * @param int $id
     */
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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $permalink
     */
    public function setPermalink($permalink)
    {
        $this->permalink = $permalink;
    }

    /**
     * @return string
     */
    public function getPermalink()
    {
        return $this->permalink;
    }

    /**
     * @param int $zone
     */
    public function setZone($zone)
    {
        $this->zone = $zone;
    }

    /**
     * @return int
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * @param Country $country
     */
    public function setOriginalOwnerCountry(Country $country)
    {
        $this->original_owner_country = $country;
    }

    /**
     * @return Country
     */
    public function getOriginalOwnerCountry()
    {
        return $this->original_owner_country;
    }
}
