<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PromotionRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 */
class Promotion
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="promotion", orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=School::class, inversedBy="promotions")
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource(maxDepth=1)
     */
    private $school;

    /**
     * @ORM\OneToMany(targetEntity=PostIt::class, mappedBy="promotion")
     * @ApiSubresource(maxDepth=1)
     */
    private $postIts;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->postIts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setPromotion($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getPromotion() === $this) {
                $user->setPromotion(null);
            }
        }

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

    /**
     * @return Collection|PostIt[]
     */
    public function getPostIts(): Collection
    {
        return $this->postIts;
    }

    public function addPostIt(PostIt $postIt): self
    {
        if (!$this->postIts->contains($postIt)) {
            $this->postIts[] = $postIt;
            $postIt->setPromotion($this);
        }

        return $this;
    }

    public function removePostIt(PostIt $postIt): self
    {
        if ($this->postIts->removeElement($postIt)) {
            // set the owning side to null (unless already changed)
            if ($postIt->getPromotion() === $this) {
                $postIt->setPromotion(null);
            }
        }

        return $this;
    }
}
