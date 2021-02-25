<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     */
    private ?string $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Assert\NotBlank(groups: ['user_create'])]
    #[Assert\Length(min: 3, groups: ['user_create'])]
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Assert\NotBlank(groups: ['user_create'])]
    #[Assert\Length(min: 3, groups: ['user_create'])]
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    #[Assert\NotBlank(groups: ['user_create'])]
    #[Assert\Email(groups: ['user_create'])]
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $password;

    /**
     * @ORM\OneToMany(targetEntity=Pin::class, mappedBy="author", orphanRemoval=true)
     * @var Pin[] $pins
     */
    private $pins;

    public function __construct()
    {
        $this->pins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): string
    {
        return sprintf("%s %s", $this->firstName, $this->lastName);
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return Collection|Pin[]
     */
    public function getPins(): Collection
    {
        return $this->pins;
    }

    public function addPin(Pin $pin): self
    {
        if (!$this->pins->contains($pin)) {
            $this->pins[] = $pin;
            $pin->setAuthor($this);
        }

        return $this;
    }

    public function removePin(Pin $pin): self
    {
        if ($this->pins->removeElement($pin)) {
            if ($pin->getAuthor() === $this) {
                $pin->setAuthor(null);
            }
        }

        return $this;
    }
}
