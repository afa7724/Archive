<?php

namespace App\Entity;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\ProfesseurRepository;

/**
 * @Entity
 * @ORM\Entity(repositoryClass=ProfesseurRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Professeur extends User
{
   

    /**
     * @ORM\ManyToMany(targetEntity=Filiere::class, inversedBy="professeurs")
     */
    private $filieres;

    public function __construct()
    {
        parent::__construct();
        $this->filieres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[]= 'ROLE_PROFESSAIRE';
        return array_unique($roles);
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

    /**
     * @return Collection|Filiere[]
     */
    public function getFilieres(): Collection
    {
        return $this->filieres;
    }

    public function addFiliere(Filiere $filiere): self
    {
        if (!$this->filieres->contains($filiere)) {
            $this->filieres[] = $filiere;
        }

        return $this;
    }

    public function removeFiliere(Filiere $filiere): self
    {
        $this->filieres->removeElement($filiere);

        return $this;
    }

   
}
