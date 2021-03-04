<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PostItRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass=PostItRepository::class)
 */
class PostIt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="boolean")
     */
    private $canAnswer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $closeAnswer;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="postIts")
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource(maxDepth=1)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Promotion::class, inversedBy="postIts")
     * @ApiSubresource(maxDepth=1)
     */
    private $promotion;

    /**
     * @ORM\ManyToOne(targetEntity=School::class, inversedBy="postIts")
     * @ApiSubresource(maxDepth=1)
     */
    private $school;

    public function __construct()
    {
        $this->canAnswer = true;
        $this->closeAnswer = false;
    }


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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchool(?School $school): self
    {
        $this->school = $school;

        return $this;
    }
}
