<?php


namespace App\Service;

use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;

class RoleService
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
    public function getFullRole(): ?array
    {
        return $this->em->getRepository(Role::class)->findAll();
    }
}