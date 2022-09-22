<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
#[UniqueEntity(
    fields: ['candidate', 'jobOffer']
)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isActivated = false;

    // #[ORM\ManyToOne(targetEntity: Consultant::class, inversedBy: 'applications')]
    // private ?Consultant $Consultant = null;

    #[ORM\ManyToOne(targetEntity: JobOffer::class, inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?JobOffer $jobOffer = null;

    #[ORM\ManyToOne(targetEntity: Candidate::class, inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Candidate $Candidate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsActivated(): ?bool
    {
        return $this->isActivated;
    }

    public function setIsActivated(bool $isActivated): self
    {
        $this->isActivated = $isActivated;

        return $this;
    }

    // public function getConsultant(): ?Consultant
    // {
    //     return $this->Consultant;
    // }

    // public function setConsultant(?Consultant $Consultant): self
    // {
    //     $this->Consultant = $Consultant;

    //     return $this;
    // }

    public function getJobOffer(): ?JobOffer
    {
        return $this->jobOffer;
    }

    public function setJobOffer(?JobOffer $jobOffer): self
    {
        $this->jobOffer = $jobOffer;

        return $this;
    }

    public function getCandidate(): ?Candidate
    {
        return $this->Candidate;
    }

    public function setCandidate(?Candidate $Candidate): self
    {
        $this->Candidate = $Candidate;

        return $this;
    }
}
