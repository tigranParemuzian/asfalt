<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Settings
 *
 * @ORM\Table(name="settings")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SettingsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Settings
{
    const IS_DOCUMENT = 0;
    const IS_DOCUMENTS_LIST = 1;
    const IS_TEXT = 2;
    const IS_BOOLEAN = 3;
    const IS_DATE = 4;
    const IS_IMAGE = 5;
    const IS_VIDEO = 6;
    const IS_FILE = 7;
    const IS_TEXT_AREA = 8;
    const IS_GALLERY = 9;
    const IS_URL = 10;

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
     * @Assert\NotNull(message="settings name can`t be null")
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @var bool
     *
     * @ORM\Column(name="in_enabled", type="boolean")
     */
    private $inEnabled;

    /**
     * @var int
     *
     * @ORM\Column(name="from_id", type="integer")
     */
    private $fromId;

    /**
     * @var int
     *
     * @ORM\Column(name="to_id", type="integer")
     */
    private $toId;

    /**
     * @var string
     *
     * @ORM\Column(name="from_class_name", type="string", length=255)
     */
    private $fromClassName;

    /**
     * @var string
     *
     * @ORM\Column(name="to_class_name", type="string", length=255)
     */
    private $toClassName;

    /**
     * @var int
     *
     * @ORM\Column(name="to_class_type", type="smallint")
     */
    private $toClassType;

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

    private $values;

    public function __clone()
    {
        $this->id = null;
        // TODO: Implement __clone() method.
    }

    public function __construct()
    {
        $this->toClassType = self::IS_DOCUMENT;
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
     * @return Settings
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
     * @return Settings
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
     * Set position
     *
     * @param integer $position
     *
     * @return Settings
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set inEnabled
     *
     * @param boolean $inEnabled
     *
     * @return Settings
     */
    public function setInEnabled($inEnabled)
    {
        $this->inEnabled = $inEnabled;

        return $this;
    }

    /**
     * Get inEnabled
     *
     * @return bool
     */
    public function getInEnabled()
    {
        return $this->inEnabled;
    }

    /**
     * Set fromId
     *
     * @param integer $fromId
     *
     * @return Settings
     */
    public function setFromId($fromId)
    {
        $this->fromId = $fromId;

        return $this;
    }

    /**
     * Get fromId
     *
     * @return int
     */
    public function getFromId()
    {
        return $this->fromId;
    }

    /**
     * Set toId
     *
     * @param integer $toId
     *
     * @return Settings
     */
    public function setToId($toId)
    {
        $this->toId = $toId;

        return $this;
    }

    /**
     * Get toId
     *
     * @return int
     */
    public function getToId()
    {
        return $this->toId;
    }

    /**
     * Set fromClassName
     *
     * @param string $fromClassName
     *
     * @return Settings
     */
    public function setFromClassName($fromClassName)
    {
        $this->fromClassName = $fromClassName;

        return $this;
    }

    /**
     * Get fromClassName
     *
     * @return string
     */
    public function getFromClassName()
    {
        return $this->fromClassName;
    }

    /**
     * Set toClassName
     *
     * @param string $toClassName
     *
     * @return Settings
     */
    public function setToClassName($toClassName)
    {
        $this->toClassName = $toClassName;

        return $this;
    }

    /**
     * Get toClassName
     *
     * @return string
     */
    public function getToClassName()
    {
        return $this->toClassName;
    }

    /**
     * Set toClassType
     *
     * @param integer $toClassType
     *
     * @return Settings
     */
    public function setToClassType($toClassType)
    {
        $this->toClassType = $toClassType;

        return $this;
    }

    /**
     * Get toClassType
     *
     * @return int
     */
    public function getToClassType()
    {
        return $this->toClassType;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Settings
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
     * @return Settings
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

    public function setValues(array $value){
        $this->values[] = $value;
    }

    public function getValues(){
        return $this->values;
    }
}
