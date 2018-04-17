<?php

namespace AppBundle\Entity;

use AppBundle\Model\AttributeInterface;
use AppBundle\Traits\Attributes;
use AppBundle\Traits\Configurator;
use AppBundle\Traits\File as FileTrade;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Image
 *
 * @ORM\Table(name="file")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FileRepository")
 */
class File implements AttributeInterface
{
    use FileTrade, Attributes;

    const IS_FILE = 0;
    const IS_IMAGE = 1;
    const IS_VIDEO = 2;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="boolean")
     */
    private $state;

    public function __construct()
    {
        $this->state=self::IS_FILE;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return File
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }
}
