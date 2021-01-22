<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
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
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToMany(targetEntity=QCM::class, mappedBy="questions")
     */
    private $qcms;

    /**
     * @ORM\OneToMany(targetEntity=StillQuestion::class, mappedBy="basedQuestion")
     */
    private $stillQuestions;

    public function __construct()
    {
        $this->qcms = new ArrayCollection();
        $this->stillQuestions = new ArrayCollection();
    }

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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|QCM[]
     */
    public function getQcms(): Collection
    {
        return $this->qcms;
    }

    public function addQcm(QCM $qcm): self
    {
        if (!$this->qcms->contains($qcm)) {
            $this->qcms[] = $qcm;
            $qcm->addQuestion($this);
        }

        return $this;
    }

    public function removeQcm(QCM $qcm): self
    {
        if ($this->qcms->removeElement($qcm)) {
            $qcm->removeQuestion($this);
        }

        return $this;
    }

    /**
     * @return Collection|StillQuestion[]
     */
    public function getStillQuestions(): Collection
    {
        return $this->stillQuestions;
    }

    public function addStillQuestion(StillQuestion $stillQuestion): self
    {
        if (!$this->stillQuestions->contains($stillQuestion)) {
            $this->stillQuestions[] = $stillQuestion;
            $stillQuestion->setBasedQuestion($this);
        }

        return $this;
    }

    public function removeStillQuestion(StillQuestion $stillQuestion): self
    {
        if ($this->stillQuestions->removeElement($stillQuestion)) {
            // set the owning side to null (unless already changed)
            if ($stillQuestion->getBasedQuestion() === $this) {
                $stillQuestion->setBasedQuestion(null);
            }
        }

        return $this;
    }
}
