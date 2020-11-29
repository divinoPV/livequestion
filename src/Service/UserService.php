<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
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
        return $this->em->getRepository(User::class)->findAll();
    }

    public function checkUser(string $email, string $name): bool
    {
        $res = $this->em->getRepository(User::class)
            ->findBy([
                'email' => $email,
                'username' => $name
            ]);

        return empty($res) ? false : true;
    }
}