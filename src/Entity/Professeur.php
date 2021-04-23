<?php

namespace App\Entity;
use DateTimeImmutable;
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
}
