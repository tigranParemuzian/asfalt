<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EquipmentsPrice
 *
 * @ORM\Table(name="equipments_price")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EquipmentsPriceRepository")
 */
class EquipmentsPrice
{
    const IS_H = 0, IS_4H = 1, IS_D = 2, IS_W = 3;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="smallint")
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipments", inversedBy="price")
     * @ORM\JoinColumn(name="equipment_id", referencedColumnName="id")
     */
    private $equipment;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EquipmentTypes", inversedBy="price")
     * @ORM\JoinColumn(name="equipment_type_id", referencedColumnName="id")
     */
    private $equipmentType;

    public function __toString()
    {
        return $this->id ? $this->state . ' ' . $this->value : 'New Price';
        // TODO: Implement __toString() method.
    }

    public function __construct()
    {
        $this->state = self::IS_H;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return EquipmentsPrice
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return EquipmentsPrice
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return EquipmentsPrice
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set equipment
     *
     * @param \AppBundle\Entity\Equipments $equipment
     *
     * @return EquipmentsPrice
     */
    public function setEquipment(\AppBundle\Entity\Equipments $equipment = null)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return \AppBundle\Entity\Equipments
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Set equipmentType
     *
     * @param \AppBundle\Entity\EquipmentTypes $equipmentType
     *
     * @return EquipmentsPrice
     */
    public function setEquipmentType(\AppBundle\Entity\EquipmentTypes $equipmentType = null)
    {
        $this->equipmentType = $equipmentType;

        return $this;
    }

    /**
     * Get equipmentType
     *
     * @return \AppBundle\Entity\EquipmentTypes
     */
    public function getEquipmentType()
    {
        return $this->equipmentType;
    }
}
