<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PostItRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass=PostItRepository::class)
 */
class PostIt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"read", "write"})
     */
    private $category;

    /**
     * @ORM\Column(type="text")
     *
     * @Groups({"read", "write"})
     */
    private $message;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups({"read", "write"})
     */
    private $seen;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups({"read", "write"})
     */
    private $canAnswer;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups({"read", "write"})
     */
    private $closeAnswer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getSeen(): ?bool
    {
        return $this->seen;
    }

    public function setSeen(bool $seen): self
    {
        $this->seen = $seen;

        return $this;
    }

    public function getCanAnswer(): ?bool
    {
        return $this->canAnswer;
    }

    public function setCanAnswer(bool $canAnswer): self
    {
        $this->canAnswer = $canAnswer;

        return $this;
    }

    public function getCloseAnswer(): ?bool
    {
        return $this->closeAnswer;
    }

    public function setCloseAnswer(bool $closeAnswer): self
    {
        $this->closeAnswer = $closeAnswer;

        return $this;
    }
}
