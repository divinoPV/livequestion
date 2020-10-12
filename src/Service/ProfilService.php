<?php

namespace App\Service;

use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;

class ProfilService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * ProjectService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @return array|null
     */
    public function getFullProfil(): ?array
    {
        return $this->em->getRepository(Profil::class)->findAll();
    }
}