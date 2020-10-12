<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    const VISIBILITY_PUBLIC = 'public';
    const VISIBILITY_PRIVATE = 'private';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="no_question", type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(name="title_question", type="string", length=255)
     */
    private string $title;

    /**
     * @ORM\Column(name="created_at_question", type="datetime")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(name="visibility_question", type="string", length=255)
     */
    private string $visibility = self::VISIBILITY_PUBLIC;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="questions")
     * @ORM\JoinColumn(name="categ_question", nullable=false, referencedColumnName="no_categ")
     */
    private Category $category;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="questions")
     * @ORM\JoinColumn(name="profil_question", nullable=false, referencedColumnName="id_prof")
     */
    private Profil $profil;

    /**
     * @ORM\OneToMany(targetEntity=Concern::class, mappedBy="question")
     */
    private Collection $concerns;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="question")
     */
    private Collection $answers;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="question")
     */
    private Collection $likes;

    public function __construct()
    {
        $this->concerns = new ArrayCollection();
        $this->answers = new ArrayCollection();
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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVisibility(): ?string
    {
        return $this->visibility;
    }

    /**
     * @param string $visibility
     * @return $this
     */
    public function setVisibility(string $visibility): self
    {
        $this->visibility = $visibility;

        return $this;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Profil|null
     */
    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    /**
     * @param Profil $profil
     * @return $this
     */
    public function setProfil(Profil $profil): self
    {
        $this->profil = $profil;

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
            $concern->setQuestion($this);
        }

        return $this;
    }

    public function removeConcern(Concern $concern): self
    {
        if ($this->concerns->contains($concern)) {
            $this->concerns->removeElement($concern);
            // set the owning side to null (unless already changed)
            if ($concern->getQuestion() === $this) {
                $concern->setQuestion(null);
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
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
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
            $like->setQuestion($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getQuestion() === $this) {
                $like->setQuestion(null);
            }
        }

        return $this;
    }
}
