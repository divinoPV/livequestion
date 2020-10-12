<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 */
class Profil
{
    const GENDER_MAN = 'man';
    const GENDER_WOMAN = 'woman';
    const GENDER_NON_BINARY = 'non_binary';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_prof", type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(name="username_prof", type="string", length=255)
     */
    private string $username;

    /**
     * @ORM\Column(name="password_prof", type="string", length=255)
     */
    private string $password;

    /**
     * @var string
     * Do not put in base (clear password)
     */
    private string $plain_password;

    /**
     * @ORM\Column(name="email_prof", type="string", length=255)
     */
    private string $email;

    /**
     * @ORM\Column(name="gender_prof", type="string", length=255)
     */
    private string $gender;

    /**
     * @ORM\Column(name="image_prof", type="string", length=255)
     */
    private string $image;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="profil")
     * @ORM\JoinColumn(name="ref_role", nullable=false, referencedColumnName="id_role")
     */
    private Role $role;

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

    /**
     * @return int|null
     */
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

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plain_password;
    }

    /**
     * @param string $plain_password
     * @return $this
     */
    public function setPlainPassword(string $plain_password): self
    {
        $this->plain_password = $plain_password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return $this
     * @throws Exception
     */
    public function setGender(string $gender): self
    {
        if ($gender !== self::GENDER_MAN && $gender !== self::GENDER_WOMAN && $gender !== self::GENDER_NON_BINARY) {
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
     * @return Role|null
     */
    public function getRole(): ?Role
    {
        return $this->role;
    }

    /**
     * @param Role $role
     * @return $this
     */
    public function setRole(Role $role): self
    {
        $this->role = $role;

        return $this;
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
            $question->setProfil($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getProfil() === $this) {
                $question->setProfil(null);
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
            $concern->setProfil($this);
        }

        return $this;
    }

    public function removeConcern(Concern $concern): self
    {
        if ($this->concerns->contains($concern)) {
            $this->concerns->removeElement($concern);
            // set the owning side to null (unless already changed)
            if ($concern->getProfil() === $this) {
                $concern->setProfil(null);
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
            $answer->setProfil($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getProfil() === $this) {
                $answer->setProfil(null);
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
            $like->setProfil($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getProfil() === $this) {
                $like->setProfil(null);
            }
        }

        return $this;
    }
}
