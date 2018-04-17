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
 * EquipmentTypes
 *
 * @ORM\Table(name="equipment_types")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EquipmentTypesRepository")
 */
class EquipmentTypes implements MainObjectabeleInterface
{
    use MainObject, SeoFriendly, FileTrade;
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Equipments", mappedBy="type", cascade={"persist"})
     */
    private $equipment;

    /**
     * @var
     * @ORM\Column(type="boolean", name="is_single")
     */
    private $isSingle;


    /**
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\EquipmentsPrice", mappedBy="equipmentType", cascade={"persist"})
     */
    private $price;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->id ? $this->name : 'New Equipment Type';
        // TODO: Implement __toString() method.
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->equipment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->price = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isSingle = false;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return EquipmentTypes
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
     * Set slug
     *
     * @param string $slug
     *
     * @return EquipmentTypes
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add equipment
     *
     * @param \AppBundle\Entity\Equipments $equipment
     *
     * @return EquipmentTypes
     */
    public function addEquipment(\AppBundle\Entity\Equipments $equipment)
    {
        $this->equipment[] = $equipment;

        return $this;
    }

    /**
     * Remove equipment
     *
     * @param \AppBundle\Entity\Equipments $equipment
     */
    public function removeEquipment(\AppBundle\Entity\Equipments $equipment)
    {
        $this->equipment->removeElement($equipment);
    }

    /**
     * Get equipment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipment()
    {
        return $this->equipment;
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
     * @return mixed
     */
    public function getisSingle()
    {
        return $this->isSingle;
    }

    /**
     * @param mixed $isSingle
     */
    public function setIsSingle($isSingle)
    {
        $this->isSingle = $isSingle;
    }




    /**
     * Add price
     *
     * @param \AppBundle\Entity\EquipmentsPrice $price
     *
     * @return EquipmentTypes
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
