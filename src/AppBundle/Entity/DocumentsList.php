<?php

namespace AppBundle\Entity;

use AppBundle\Model\AttributeInterface;
use AppBundle\Model\MainObjectabeleInterface;
use AppBundle\Traits\Attributes;
use AppBundle\Traits\MainObject;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * DocumentsList
 *
 * @ORM\Table(name="documents_list")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentsListRepository")
 */
class DocumentsList implements AttributeInterface, MainObjectabeleInterface
{
    use  Attributes, MainObject;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
