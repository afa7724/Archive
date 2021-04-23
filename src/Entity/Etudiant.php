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
     * @Assert\NotBlank(message="Entrez votre niveau s'il vous plait")
     * @Assert\NotBlank
     */
    private $niveau;

  

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
