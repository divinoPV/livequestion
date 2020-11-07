<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Link;

class LinkService
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
    public function getFull(): ?array
    {
        return $this->em
            ->getRepository(Link::class)
            ->findAll();
    }

    /**
     * @param int $receiver
     * @param int $sender
     * @return array|null
     */
    public function getApprovedFriend(int $receiver, int $sender): ?array
    {
        return $this->em
            ->getRepository(Link::class)
            ->findBy([],
                ["ref_sender" => $sender],
                ["ref_receiver" => $receiver]);
    }
}