<?php

namespace AppBundle\Entity;

use AppBundle\Model\MainObjectabeleInterface;
use AppBundle\Traits\MainObject;
use AppBundle\Traits\SeoFriendly;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Traits\File as FileTrade;


/**
 * Asphalting
 *
 * @ORM\Table(name="asphalting")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AsphaltingRepository")
 */
class Asphalting implements MainObjectabeleInterface
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AsphaltingTypes", inversedBy="asphalting")
     * @ORM\JoinColumn(name="asphalting_id", referencedColumnName="id")
     */
    private $type;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AsphaltingPrice", mappedBy="asphalt", cascade={"persist"})
     */
    private $price;

    /**
     * @var
     * @ORM\Column(name="state", type="smallint", nullable=true)
     */
    private $state;

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
     * @return Asphalting
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
     * @param \AppBundle\Entity\AsphaltingTypes $type
     *
     * @return Asphalting
     */
    public function setType(\AppBundle\Entity\AsphaltingTypes $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\AsphaltingTypes
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
     * @param \AppBundle\Entity\AsphaltingPrice $price
     *
     * @return Asphalting
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
