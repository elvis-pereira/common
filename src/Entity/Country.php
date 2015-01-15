<?php
namespace Erpk\Common\Entity;

/**
 * @Entity(repositoryClass="Erpk\Common\Repository\Country")
 * @Table(name="countries")
 **/
class Country
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
     * @Column(type="string")
     * @var string
     **/
    protected $code;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id'    => $this->getId(),
            'name'  => $this->getName(),
            'code'  => $this->getCode()
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
     * @return string
     */
    public function getEncodedName()
    {
        return strtr($this->name, [' and '=>'-','('=>'',')'=>'',' '=>'-']);
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}
