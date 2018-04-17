<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 *
 * @ORM\Table(name="user")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"booking_history", "user-info"})
     *
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(name="first_name", type="string", nullable=true)
     * @Groups({"user-info", "booking_list"})
     */
    private $firstName;

    /**
     * @var
     * @ORM\Column(name="last_name", type="string", nullable=true)
     * @Groups({"user-info", "booking_list"})
     */
    private $lastName;

    public function __toString()
    {
        return $this->id ? $this->username : '';
//        return parent::__toString(); //
    }

    public function __construct()
    {
        parent::__construct();

    }

    /**
     * @VirtualProperty()
     *
     * @Groups({"user-info", "booking_list"})
     */
    public function getClientFullName() {

        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
}
