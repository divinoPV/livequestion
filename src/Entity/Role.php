<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 */
class Role
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_role", type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(name="code_role", type="string", length=255)
     */
    private string $code = self::ROLE_USER;

    /**
     * @ORM\Column(name="wording_role", type="string", length=255)
     */
    private string $wording = "USER";

    /**
     * @ORM\OneToMany(targetEntity=Profil::class, mappedBy="profil")
     */
    private Collection $profil;

    public function __construct()
    {
        $this->profil = new ArrayCollection();
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
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return $this
     * @throws Exception
     */
    public function setCode(string $code): self
    {
        if ($code !== self::ROLE_USER && $code !== self::ROLE_ADMIN) {
            throw new Exception('The code is not valid.');
        }

        $this->code = $code;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWording(): ?string
    {
        return $this->wording;
    }

    /**
     * @param string $wording
     * @return $this
     */
    public function setWording(string $wording): self
    {
        $this->wording = $wording;

        return $this;
    }

    /**
     * @return Collection|Profil[]
     */
    public function getProfil(): ?Collection
    {
        return $this->profil;
    }

    public function addProfil(Profil $profil): self
    {
        if (!$this->$profil->contains($profil)) {
            $this->profil[] = $profil;
            $profil->setRole($this);
        }

        return $this;
    }

    public function removeProfil(Profil $profil): self
    {
        if ($this->profil->contains($profil)) {
            $this->profil->removeElement($profil);
            // set the owning side to null (unless already changed)
            if ($profil->getRole() === $this) {
                $profil->setRole(null);
            }
        }

        return $this;
    }
}
