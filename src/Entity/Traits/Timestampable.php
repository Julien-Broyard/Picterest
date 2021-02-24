<?php


namespace App\Entity\Traits;


use Doctrine\ORM\Mapping as ORM;

trait Timestampable
{
    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTime $updatedAt;

    /** @ORM\PrePersist() */
    public function prePersist(): void
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /** @ORM\PreUpdate() */
    public function preUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
}