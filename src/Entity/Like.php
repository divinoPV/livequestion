<?php

namespace App\Entity;

use App\Repository\LikeRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LikeRepository::class)
 * @ORM\Table(name="`like`")
 */
class Like
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="likes")
     * @ORM\JoinColumn(name="ref_profil", nullable=false, referencedColumnName="id_prof")
     */
    private Profil $profil;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="likes")
     * @ORM\JoinColumn(name="ref_question", nullable=false, referencedColumnName="no_question")
     */
    private Question $question;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $createdAt;

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(Profil $profil): self
    {
        $this->profil = $profil;

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
