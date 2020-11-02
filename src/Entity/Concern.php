<?php

namespace App\Entity;

use App\Repository\ConcernRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConcernRepository::class)
 */
class Concern
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="concerns")
     * @ORM\JoinColumn(name="ref_user", nullable=false, referencedColumnName="id")
     */
    private User $user;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="concerns")
     * @ORM\JoinColumn(name="ref_question", nullable=false, referencedColumnName="id")
     */
    private Question $question;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
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
}
