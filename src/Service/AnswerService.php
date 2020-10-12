<?php

namespace App\Service;

use App\Entity\Answer;
use Doctrine\ORM\EntityManagerInterface;

class AnswerService
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
    public function getFullAnswer(): ?array
    {
        return $this->em->getRepository(Answer::class)->findAll();
    }
}