<?php

/*
 * This file is part of the AdminLTE-Bundle demo.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Application main User entity.
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(
 *      name="users",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(columns={"username"}),
 *          @ORM\UniqueConstraint(columns={"email"})
 *      }
 * )
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User extends BaseUser implements UserInterface, EquatableInterface
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_TEAMLEAD = 'ROLE_TEAMLEAD';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    public const DEFAULT_ROLE = 'ROLE_USE';
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageFilename;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Customer", mappedBy="compte", cascade={"persist", "remove"})
     */
    private $customer;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Employee", mappedBy="compte", cascade={"persist", "remove"})
     */
    private $employee;
    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CustomerUser", mappedBy="compte", cascade={"persist", "remove"})
     */
    private $customerUser;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Checks if the user has to be logged out of the session,
     * due to changed fields / security related settings (like roles and teams).
     *
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof self) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(?string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        // set (or unset) the owning side of the relation if necessary
        $newCompte = null === $customer ? null : $this;
        if ($customer->getCompte() !== $newCompte) {
            $customer->setCompte($newCompte);
        }

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        // set (or unset) the owning side of the relation if necessary
        $newCompte = null === $employee ? null : $this;
        if ($employee->getCompte() !== $newCompte) {
            $employee->setCompte($newCompte);
        }

        return $this;
    }

    public function getCustomerUser(): ?CustomerUser
    {
        return $this->customerUser;
    }

    /**
     * @param mixed $customerUser
     */
    public function setCustomerUser($customerUser): self
    {
        $this->customerUser = $customerUser;
        // set (or unset) the owning side of the relation if necessary
        $newCompte = null === $customerUser ? null : $this;
        if ($customerUser->getCompte() !== $newCompte) {
            $customerUser->setCompte($newCompte);
        }

        return $this;
    }
}
