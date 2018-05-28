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
 * AsphaltingTypes
 *
 * @ORM\Table(name="asphalting_types")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AsphaltingTypesRepository")
 */
class AsphaltingTypes implements MainObjectabeleInterface
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Asphalting", mappedBy="type", cascade={"persist"}, orphanRemoval=true)
     */
    private $asphalting;


    /**
     * @var
     * @ORM\Column(type="boolean", name="is_single")
     */
    private $isSingle;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AsphaltingPrice", mappedBy="asphaltType", cascade={"persist"}, orphanRemoval=true)
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
        return $this->id ? $this->name : 'New Asphalt Type';
        // TODO: Implement __toString() method.
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->asphalting = new \Doctrine\Common\Collections\ArrayCollection();
        $this->price = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isSingle = false;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return AsphaltingTypes
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
     * @return AsphaltingTypes
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
     * Add asphalting
     *
     * @param \AppBundle\Entity\Asphalting $asphalting
     *
     * @return AsphaltingTypes
     */
    public function addAsphalting(\AppBundle\Entity\Asphalting $asphalting)
    {
        $this->asphalting[] = $asphalting;

        return $this;
    }

    /**
     * Remove asphalting
     *
     * @param \AppBundle\Entity\Asphalting $asphalting
     */
    public function removeAsphalting(\AppBundle\Entity\Asphalting $asphalting)
    {
        $this->asphalting->removeElement($asphalting);
    }

    /**
     * Get asphalting
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAsphalting()
    {
        return $this->asphalting;
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
     * Set isSingle
     *
     * @param boolean $isSingle
     *
     * @return AsphaltingTypes
     */
    public function setIsSingle($isSingle)
    {
        $this->isSingle = $isSingle;

        return $this;
    }

    /**
     * Get isSingle
     *
     * @return boolean
     */
    public function getIsSingle()
    {
        return $this->isSingle;
    }

    /**
     * Add price
     *
     * @param \AppBundle\Entity\AsphaltingPrice $price
     *
     * @return AsphaltingTypes
     */
    public function addPrice(\AppBundle\Entity\AsphaltingPrice $price)
    {
        $this->price[] = $price;

        return $this;
    }

    /**
     * Remove price
     *
     * @param \AppBundle\Entity\AsphaltingPrice $price
     */
    public function removePrice(\AppBundle\Entity\AsphaltingPrice $price)
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
