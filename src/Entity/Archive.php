<?php

namespace App\Entity;

use DateTimeImmutable;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArchiveRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ArchiveRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Archive
{
    const TYPE = ['Mini Projet' => 'Mini Projet', 'Memoire' => 'Memoire', 'Rapport de stage' => 'Rapport de stage', 'Projet Tutoriel' => 'Projet Tutoriel'];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="archive_file", fileNameProperty="rapportfilename")
     * 
     * @var File|null
     */
    private $imageFile;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="archive_file_codesource", fileNameProperty="codesource")
     * 
     * @var File|null
     */

    private $filecodesources;


    /**
     * @Assert\Length(min=2,
     * minMessage=" Saisir au moins 2 caracteres")
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Assert\Length(min=10,
     * minMessage=" Saisir au moins 10 caracteres")
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * 
     * @ORM\Column(type="date")
     */
    private $datepromotionOn;

    /**
     *@Assert\Choice(choices=Archive::TYPE, message="Choisir un type valable.")
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Filiere::class, inversedBy="archives")
     * @ORM\JoinColumn(nullable=false)
     */
    private $filiere;

    /**
     * @Assert\Length(min=2,
     * minMessage=" Saisir au moins 2 caracteres")
     * @ORM\Column(type="string", length=255)
     */
    private $Encadreur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rapportfilename;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="archives")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codesource;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDatepromotionOn(): ?\DateTimeInterface
    {
        return $this->datepromotionOn;
    }

    public function setDatepromotionOn(?\DateTimeInterface $datepromotionOn): self
    {
        $this->datepromotionOn = $datepromotionOn;


        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getSlug(): string
    {
        return ((new Slugify())->slugify($this->title));
    }

    public function getEncadreur(): ?string
    {
        return $this->Encadreur;
    }

    public function setEncadreur(string $Encadreur): self
    {
        $this->Encadreur = $Encadreur;

        return $this;
    }





    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): Archive
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setFilecodesources(?File $Filecodesources = null): Archive
    {
        $this->filecodesources = $Filecodesources;

        if (null !== $Filecodesources) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    public function getFilecodesources(): ?File
    {
        return $this->filecodesources;
    }
    public function getRapportfilename(): ?string
    {
        return $this->rapportfilename;
    }

    public function setRapportfilename(?string $rapportfilename): self
    {
        $this->rapportfilename = $rapportfilename;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getCodesource(): ?string
    {
        return $this->codesource;
    }

    public function setCodesource(?string $codesource): self
    {
        $this->codesource = $codesource;

        return $this;
    }
}
