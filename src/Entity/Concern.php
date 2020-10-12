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
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="concerns")
     * @ORM\JoinColumn(name="ref_profil", nullable=false, referencedColumnName="id_prof")
     */
    private Profil $profil;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="concerns")
     * @ORM\JoinColumn(name="ref_question", nullable=false, referencedColumnName="no_question")
     */
    private Question $question;

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
}
