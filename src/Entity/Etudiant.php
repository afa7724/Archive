<?php

namespace App\Entity;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\EtudiantRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Entity
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Etudiant extends User
{
    

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=1 , max=5)
     */
    private $niveau;

    /**
     * @ORM\ManyToOne(targetEntity=Filiere::class, inversedBy="etudiants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $filiere;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?Filiere $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimesStep()
    {
        $this->setUpdatedAt(new DateTimeImmutable());
        if (is_null($this->getCreatedAt())) 
            $this->setCreatedAt(new DateTimeImmutable());
        
    }

   

   

}
