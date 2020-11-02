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
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="answers")
     * @ORM\JoinColumn(name="ref_question", nullable=false, referencedColumnName="id")
     */
    private Question $question;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="answers")
     * @ORM\JoinColumn(name="ref_user", nullable=false, referencedColumnName="id")
     */
    private User $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $content;

    /**
     * @ORM\Column(type="datetime")
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

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
