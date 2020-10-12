<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 */
class Answer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="ref_answer", type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="answers")
     * @ORM\JoinColumn(name="ref_question", nullable=false, referencedColumnName="no_question")
     */
    private Question $question;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="answers")
     * @ORM\JoinColumn(name="ref_profil", nullable=false, referencedColumnName="id_prof")
     */
    private Profil $profil;

    /**
     * @ORM\Column(name="content_answer", type="string", length=255)
     */
    private string $content;

    /**
     * @ORM\Column(name="created_at_answer", type="datetime")
     */
    private DateTimeInterface $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
