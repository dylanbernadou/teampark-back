<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="This email has already taken !")
 */
class User implements UserInterface
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @SerializedName("password")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = ["STUDENT"];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $interests = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mbti;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $personality = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slugger;

    /**
     * @var MediaObject|null
     *
     * @ORM\OneToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     * @ApiSubresource(maxDepth=1)
     * @ApiProperty(iri="http://schema.org/avatar")
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="user", orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     */
    private $messages;

    /**
     * @ORM\ManyToOne(targetEntity=School::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource(maxDepth=1)
     */
    private $school;

    /**
     * @ORM\ManyToOne(targetEntity=Promotion::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @ApiSubresource(maxDepth=1)
     */
    private $promotion;

    /**
     * @ORM\OneToMany(targetEntity=PostIt::class, mappedBy="user", orphanRemoval=true)
     * @ApiSubresource(maxDepth=1)
     */
    private $postIts;

    /**
     * @ORM\ManyToMany(targetEntity=Channel::class, mappedBy="users")
     * @ApiSubresource(maxDepth=1)
     */
    private $channels;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->postIts = new ArrayCollection();
        $this->channels = new ArrayCollection();
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function hasRoles(string $roles): bool
    {
        return in_array($roles, $this->roles);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getInterests(): ?array
    {
        return $this->interests;
    }

    public function setInterests(?array $interests): self
    {
        $this->interests = $interests;

        return $this;
    }

    public function getMbti(): ?string
    {
        return $this->mbti;
    }

    public function setMbti(?string $mbti): self
    {
        $this->mbti = $mbti;

        return $this;
    }

    public function getPersonality(): ?array
    {
        return $this->personality;
    }

    public function setPersonality(?array $personality): self
    {
        $this->personality = $personality;

        return $this;
    }

    public function getSlugger(): ?string
    {
        return $this->slugger;
    }

    public function setSlugger(string $slugger): self
    {
        $this->slugger = $slugger;

        return $this;
    }

    public function getAvatar(): ?MediaObject
    {
        return $this->avatar;
    }

    public function setAvatar(?MediaObject $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setUser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUser() === $this) {
                $message->setUser(null);
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

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(?Promotion $promotion): self
    {
        $this->promotion = $promotion;

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
            $postIt->setUser($this);
        }

        return $this;
    }

    public function removePostIt(PostIt $postIt): self
    {
        if ($this->postIts->removeElement($postIt)) {
            // set the owning side to null (unless already changed)
            if ($postIt->getUser() === $this) {
                $postIt->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Channel[]
     */
    public function getChannels(): Collection
    {
        return $this->channels;
    }

    public function addChannel(Channel $channel): self
    {
        if (!$this->channels->contains($channel)) {
            $this->channels[] = $channel;
            $channel->addUser($this);
        }

        return $this;
    }

    public function removeChannel(Channel $channel): self
    {
        if ($this->channels->removeElement($channel)) {
            $channel->removeUser($this);
        }

        return $this;
    }
}
