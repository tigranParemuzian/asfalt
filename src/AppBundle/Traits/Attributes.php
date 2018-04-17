<?php

namespace AppBundle\Traits;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * This traits is used for include file
 *
 * Class File
 * @package AppBundle\Traits
 */
trait Attributes
{

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, options={"default":"image"})
     */
    private $title;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var int
     *
     * @ORM\Column(name="sort_ordering", type="integer")
     * @Assert\NotBlank(message="Sort Ordering can`t be null")
     */
    private $sortOrdering;

    /**
     * @var
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var
     * @ORM\Column(name="form_type", type="string", length=50, nullable=true)
     */
    private $formType;

    /**
     * This function is used to get object class name
     *
     * @return string
     */
    public function getClassName(){
        return get_class($this);
    }

    public function __toString()
    {
        return $this->id ? $this->title : 'new Attribute';
        // TODO: Implement __toString() method.
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return $this
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return int
     */
    public function getSortOrdering()
    {
        return $this->sortOrdering;
    }

    /**
     * @param int $sortOrdering
     */
    public function setSortOrdering($sortOrdering)
    {
        $this->sortOrdering = $sortOrdering;
    }

    /**
     * @return mixed
     */
    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * @param mixed $formType
     */
    public function setFormType($formType)
    {
        $this->formType = $formType;
    }
}