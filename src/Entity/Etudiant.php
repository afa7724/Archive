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
     * 
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
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
       $roles[]= 'ROLE_ETUDIANT';
        return array_unique($roles);
    }


}
