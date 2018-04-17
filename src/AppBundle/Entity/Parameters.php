<?php

namespace AppBundle\Entity;

use AppBundle\Model\MainObjectabeleInterface;
use AppBundle\Traits\MainObject;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Traits\File as FileTrade;

/**
 * Parameters
 *
 * @ORM\Table(name="parameters")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParametersRepository")
 */
class Parameters
{
    use FileTrade;

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
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @var int
     * @Gedmo\SortablePosition()
     * @ORM\Column(name="position", type="integer", options={"default":1})
     */
    private $position;

//    /**
//     * @var
//     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Products", inversedBy="parameters")
//     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
//     */
//    private $product;

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
     * @return Parameters
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
     * Set value
     *
     * @param string $value
     *
     * @return Parameters
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
     * Set position
     *
     * @param integer $position
     *
     * @return Parameters
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

//    /**
//     * Set product
//     *
//     * @param \AppBundle\Entity\Products $product
//     *
//     * @return Parameters
//     */
//    public function setProduct(\AppBundle\Entity\Products $product = null)
//    {
//        $this->product = $product;
//
//        return $this;
//    }
//
//    /**
//     * Get product
//     *
//     * @return \AppBundle\Entity\Products
//     */
//    public function getProduct()
//    {
//        return $this->product;
//    }
}
