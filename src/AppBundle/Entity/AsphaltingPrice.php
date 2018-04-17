<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AsphaltingPrice
 *
 * @ORM\Table(name="asphalting_price")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AsphaltingPriceRepository")
 */
class AsphaltingPrice
{
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
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=255, nullable=true)
     */
    private $unit;

    /**
     * @var string
     *
     * @ORM\Column(name="layer", type="string", length=255, nullable=true)
     */
    private $layer;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Asphalting", inversedBy="price")
     * @ORM\JoinColumn(name="asphalt_id", referencedColumnName="id")
     */
    private $asphalt;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AsphaltingTypes", inversedBy="price")
     * @ORM\JoinColumn(name="asphalt_type_id", referencedColumnName="id")
     */
    private $asphaltType;


    public function __toString()
    {
        return $this->id ? $this->value  . ' / ' . $this->unit: 'New Price';
    }

    public function __construct()
    {
//        $this->unit = 'm2';
//        $this->layer = '5 см';
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
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value)
    {
        $this->value = $value;
    }

    /**
     * Set unit
     *
     * @param string $unit
     *
     * @return AsphaltingPrice
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set layer
     *
     * @param string $layer
     *
     * @return AsphaltingPrice
     */
    public function setLayer($layer)
    {
        $this->layer = $layer;

        return $this;
    }

    /**
     * Get layer
     *
     * @return string
     */
    public function getLayer()
    {
        return $this->layer;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return AsphaltingPrice
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
     * Set asphalt
     *
     * @param \AppBundle\Entity\Asphalting $asphalt
     *
     * @return AsphaltingPrice
     */
    public function setAsphalt(\AppBundle\Entity\Asphalting $asphalt = null)
    {
        $this->asphalt = $asphalt;

        return $this;
    }

    /**
     * Get asphalt
     *
     * @return \AppBundle\Entity\Asphalting
     */
    public function getAsphalt()
    {
        return $this->asphalt;
    }

    /**
     * Set asphaltType
     *
     * @param \AppBundle\Entity\AsphaltingTypes $asphaltType
     *
     * @return AsphaltingPrice
     */
    public function setAsphaltType(\AppBundle\Entity\AsphaltingTypes $asphaltType = null)
    {
        $this->asphaltType = $asphaltType;

        return $this;
    }

    /**
     * Get asphaltType
     *
     * @return \AppBundle\Entity\AsphaltingTypes
     */
    public function getAsphaltType()
    {
        return $this->asphaltType;
    }
}
