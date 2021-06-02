<?php

namespace App\Entity;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FiliereRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=FiliereRepository::class)
 * @UniqueEntity(fields={"name"}, message="La filiere existe déjà ")
 */
class Filiere
{



    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    /**
     * @ORM\OneToMany(targetEntity=Archive::class, mappedBy="filiere",cascade={"persist", "remove"})
     */
    private $archives;

    /**
     * @ORM\ManyToMany(targetEntity=Professeur::class, mappedBy="filieres",cascade={"persist", "remove"})
     */
    private $professeurs;

    /**
     * @ORM\OneToMany(targetEntity=Etudiant::class, mappedBy="filiere",cascade={"persist", "remove"})
     */
    private $etudiants;



    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updateAt = new DateTimeImmutable();
        $this->users = new ArrayCollection();
        $this->professeurs = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
    }





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * @return Collection|Archive[]
     */
    public function getArchives(): Collection
    {
        return $this->archives;
    }

    public function addArchive(Archive $archive): self
    {
        if (!$this->archives->contains($archive)) {
            $this->archives[] = $archive;
            $archive->setFiliere($this);
        }

        return $this;
    }

    public function removeArchive(Archive $archive): self
    {
        if ($this->archives->removeElement($archive)) {
            // set the owning side to null (unless already changed)
            if ($archive->getFiliere() === $this) {
                $archive->setFiliere(null);
            }
        }

        return $this;
    }



    /**
     * ?ettre a jour les heures
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimesStep()
    {
        $this->setUpdateAt(new DateTimeImmutable());
        if (is_null($this->getCreatedAt()))
            $this->setCreatedAt(new DateTimeImmutable());
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return Collection|Professeur[]
     */
    public function getProfesseurs(): Collection
    {
        return $this->professeurs;
    }

    public function addProfesseur(Professeur $professeur): self
    {
        if (!$this->professeurs->contains($professeur)) {
            $this->professeurs[] = $professeur;
            $professeur->addFiliere($this);
        }

        return $this;
    }

    public function removeProfesseur(Professeur $professeur): self
    {
        if ($this->professeurs->removeElement($professeur)) {
            $professeur->removeFiliere($this);
        }

        return $this;
    }

    /**
     * @return Collection|Etudiant[]
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setFiliere($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getFiliere() === $this) {
                $etudiant->setFiliere(null);
            }
        }

        return $this;
    }
}
