<?php

namespace App\Service;

use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;

class QuestionService
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
    public function getFullQuestion(): ?array
    {
        return $this->em->getRepository(Question::class)->findAll();
    }
}