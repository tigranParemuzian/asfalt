<?php

namespace AppBundle\Entity;

use AppBundle\Model\MainObjectabeleInterface;
use AppBundle\Traits\MainObject;
use AppBundle\Traits\SeoFriendly;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Traits\File as FileTrade;


/**
 * Equipments
 *
 * @ORM\Table(name="equipments")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EquipmentsRepository")
 */
class Equipments implements MainObjectabeleInterface
{
    use MainObject, SeoFriendly, FileTrade;

    const IS_TOP = 1, IS_NEW = 0, IS_DISABLED = 2;

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"}, updatable=false)
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EquipmentTypes", inversedBy="equipment")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @var
     * @ORM\Column(name="state", type="smallint", nullable=true)
     */
    private $state;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\EquipmentsPrice", mappedBy="equipment", cascade={"persist"})
     */
    private $price;


    public function __toString()
    {
        return $this->id ? $this->name : 'New project';
        // TODO: Implement __toString() method.
    }

    public function __construct()
    {
        $this->state = self::IS_NEW;
        $this->price = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Projects
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getClassName()
    {
        return get_class($this);
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\EquipmentTypes $type
     *
     * @return Equipments
     */
    public function setType(\AppBundle\Entity\EquipmentTypes $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\EquipmentTypes
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Add price
     *
     * @param \AppBundle\Entity\EquipmentsPrice $price
     *
     * @return Equipments
     */
    public function addPrice(\AppBundle\Entity\EquipmentsPrice $price)
    {
        $this->price[] = $price;

        return $this;
    }

    /**
     * Remove price
     *
     * @param \AppBundle\Entity\EquipmentsPrice $price
     */
    public function removePrice(\AppBundle\Entity\EquipmentsPrice $price)
    {
        $this->price->removeElement($price);
    }

    /**
     * Get price
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrice()
    {
        return $this->price;
    }
}
