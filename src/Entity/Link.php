<?php

namespace App\Entity;

use App\Repository\LinkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LinkRepository::class)
 */
class Link
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="links")
     * @ORM\JoinColumn(name="ref_sender", nullable=false, referencedColumnName="id_prof")
     */
    private Profil $sender;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity=Profil::class)
     * @ORM\JoinColumn(name="ref_receiver", nullable=false, referencedColumnName="id_prof")
     */
    private Profil $receiver;

    /**
     * @ORM\Column(name="is_pending_link", type="boolean")
     */
    private bool $is_pending;

    public function getSender(): ?Profil
    {
        return $this->sender;
    }

    public function setSender(Profil $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?Profil
    {
        return $this->receiver;
    }

    public function setReceiver(Profil $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getIsPending(): ?bool
    {
        return $this->is_pending;
    }

    public function setIsPending(bool $is_pending): self
    {
        $this->is_pending = $is_pending;

        return $this;
    }
}
