<?php

namespace App\Entity;

use App\Repository\StillQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StillQuestionRepository::class)
 */
class StillQuestion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @ORM\Column(type="array")
     */
    private $answers = [];

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="stillQuestions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $basedQuestion;

    /**
     * @ORM\ManyToOne(targetEntity=Test::class, inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $test;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getAnswers(): ?array
    {
        return $this->answers;
    }

    public function setAnswers(array $answers): self
    {
        $this->answers = $answers;

        return $this;
    }

    public function getBasedQuestion(): ?Question
    {
        return $this->basedQuestion;
    }

    public function setBasedQuestion(?Question $basedQuestion): self
    {
        $this->basedQuestion = $basedQuestion;

        return $this;
    }

    public function getTest(): ?Test
    {
        return $this->test;
    }

    public function setTest(?Test $test): self
    {
        $this->test = $test;

        return $this;
    }
}
