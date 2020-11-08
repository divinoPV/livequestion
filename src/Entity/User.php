<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Exception;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    const ROLE_SUPER_ADMIN = "ROLE_SUPER_ADMIN";
    const ROLE_ADMIN = "ROLE_ADMIN";
    const ROLE_USER = "ROLE_USER";

    const GENDER_MAN = "MALE";
    const GENDER_WOMAN = "FEMALE";
    const GENDER_NON_BINARY = "NON_BINARY";

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string|null
     */
    private ?string $plainPassword = null;

    /**
     * @var string The hashed plainPassword
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $activation_token = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $reset_token = null;

    /**
     * @var DateTime $createdAt
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @var DateTime $updatedAt
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private DateTime $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Question::class, mappedBy="profil")
     */
    private Collection $questions;

    /**
     * @ORM\OneToMany(targetEntity=Concern::class, mappedBy="profil")
     */
    private Collection $concerns;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="profil")
     */
    private Collection $answers;

    /**
     * @ORM\OneToMany(targetEntity=Link::class, mappedBy="sender")
     */
    private Collection $linksSender;

    /**
     * @ORM\OneToMany(targetEntity=Link::class, mappedBy="sender")
     */
    private Collection $linksReceiver;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="profil")
     */
    private Collection $likes;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->concerns = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->linksSender = new ArrayCollection();
        $this->linksReceiver = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

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

    /**
     * A visual identifier that represents this user.
     * @see UserInterface
     */
    public function getUsernameEmail(): ?string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): ?array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        if ($roles === null)
        {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param string $role
     * @return $this
     * @throws Exception
     */
    public function addRole(string $role): self
    {
        if ($role !== self::ROLE_USER
            && $role !== self::ROLE_ADMIN
            && $role !== self::ROLE_SUPER_ADMIN)
        {
            throw new Exception('The code is not valid.');
        }
        $this->roles[] = $role;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @param string $gender
     * @return $this
     * @throws Exception
     */
    public function addGender(string $gender): self
    {
        if ($gender !== self::GENDER_MAN
            && $gender !== self::GENDER_WOMAN
            && $gender !== self::GENDER_NON_BINARY)
        {
            throw new Exception('The code is not valid.');
        }

        $this->gender = $gender;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return $this
     */
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt(): void
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(?string $activation_token): self
    {
        $this->activation_token = $activation_token;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    public function setResetToken(?string $reset_token): self
    {
        $this->reset_token = $reset_token;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): ?Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setUser($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getUser() === $this) {
                $question->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Concern[]
     */
    public function getConcerns(): ?Collection
    {
        return $this->concerns;
    }

    public function addConcern(Concern $concern): self
    {
        if (!$this->concerns->contains($concern)) {
            $this->concerns[] = $concern;
            $concern->setUser($this);
        }

        return $this;
    }

    public function removeConcern(Concern $concern): self
    {
        if ($this->concerns->contains($concern)) {
            $this->concerns->removeElement($concern);
            // set the owning side to null (unless already changed)
            if ($concern->getUser() === $this) {
                $concern->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): ?Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setUser($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getUser() === $this) {
                $answer->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Link[]
     */
    public function getLinksSender(): ?Collection
    {
        return $this->linksSender;
    }

    public function addLinkSender(Link $linkSender): self
    {
        if (!$this->linksSender->contains($linkSender)) {
            $this->linksSender[] = $linkSender;
            $linkSender->setSender($this);
        }

        return $this;
    }

    public function removeLinkSender(Link $linkSender): self
    {
        if ($this->linksSender->contains($linkSender)) {
            $this->linksSender->removeElement($linkSender);
            // set the owning side to null (unless already changed)
            if ($linkSender->getSender() === $this) {
                $linkSender->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Link[]
     */
    public function getLinksReceiver(): ?Collection
    {
        return $this->linksReceiver;
    }

    public function addLinkReceiver(Link $linkReceiver): self
    {
        if (!$this->linksReceiver->contains($linkReceiver)) {
            $this->linksReceiver[] = $linkReceiver;
            $linkReceiver->setSender($this);
        }

        return $this;
    }

    public function removeLinkReceiver(Link $linkReceiver): self
    {
        if ($this->linksReceiver->contains($linkReceiver)) {
            $this->linksReceiver->removeElement($linkReceiver);
            // set the owning side to null (unless already changed)
            if ($linkReceiver->getSender() === $this) {
                $linkReceiver->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Like[]
     */
    public function getLikes(): ?Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setUser($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getUser() === $this) {
                $like->setUser(null);
            }
        }

        return $this;
    }
}
