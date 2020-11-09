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
    public function getAll(): ?array
    {
        return $this->em
            ->getRepository(Link::class)
            ->findAll();
    }

    /**
     * @param int $receiver
     * @param int $sender
     * @param bool $isPending
     * @return array|null
     */
    public function getLink(int $receiver, int $sender, bool $isPending): ?array
    {
        return $this->em
            ->getRepository(Link::class)
            ->findBy([],
                ["ref_receiver" => $receiver],
                ["ref_sender" => $sender],
                ["is_pending" => $isPending]);
    }
}