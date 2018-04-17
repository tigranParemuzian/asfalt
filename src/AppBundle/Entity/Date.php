<?php

namespace AppBundle\Entity;

use AppBundle\Model\AttributeInterface;
use AppBundle\Traits\Attributes;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * TextValues
 *
 * @ORM\Table(name="date")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DateRepository")
 */
class Date implements AttributeInterface
{
    use Attributes;

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
     * @ORM\Column(name="value", type="datetime", nullable=true)
     */
    private $value;

    public function __clone()
    {
        $this->id = null;
        // TODO: Implement __clone() method.
    }

    public function __construct()
    {
        $this->value = new \DateTime('now');
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
     * @return Text
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
}
