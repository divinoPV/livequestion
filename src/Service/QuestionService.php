<?php

namespace App\Service;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\Collection;

class QuestionService
{
    private QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function getFullQuestion(): ?array
    {
        return $this->questionRepository->findAll();
    }

    public function getQuestion(string $title)
    {
        return $this->questionRepository->findTitleConcat($title);
    }
}