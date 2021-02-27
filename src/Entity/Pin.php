<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\PinRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PinRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Pin
{
    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\CustomIdGenerator(class=UuidV4Generator::class)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     */
    private ?string $id;

    /**
     * @ORM\Column(type="text")
     */
    #[Assert\NotBlank(message: 'The description is required.', groups: ['pin_creation_update'])]
    #[Assert\Length(
        min: 10,
        minMessage: 'Your description must be at least {{ limit }} characters long.',
        groups: ['pin_creation_update']
    )]
    private ?string $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Assert\NotBlank(message: 'The title is required.', groups: ['pin_creation_update'])]
    #[Assert\Length(
        min: 3,
        minMessage: 'Your title must be at least {{ limit }} characters long.',
        groups: ['pin_creation_update']
    )]
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $imageName;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pins")
     * @ORM\JoinColumn(nullable=false)
     */
    private UserInterface $author;

    public function __toString(): string
    {
        return $this->title;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getAuthor(): ?UserInterface
    {
        return $this->author;
    }

    public function setAuthor(UserInterface $author): self
    {
        $this->author = $author;

        return $this;
    }
}
