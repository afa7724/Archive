<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @Entity
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"etudiant" = "Etudiant", "user" = "User", "professeur" = "Professeur"})
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="Il existe déjà un compte avec cet e-mail")
 */
class User implements UserInterface
{
    public function __construct()
    {
        $this->isVerified = false;
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="Entrez votre adresse email s'il vous plait")
     * @Assert\Email(message="S'il vous plaît, mettez une adresse email valide") 
     */
    protected $email;

    /**
     * @ORM\Column(type="json")
     */
    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Regex(
     * pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$/",
     * htmlPattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$",
     * match=true,
     * message="Respectez le message d'aide ci-dessous"
     * )
     * @Assert\Length(max=4096)
     * @Assert\NotBlank(message="Entrez votre mot de passe  s'il vous plait")
     */
    protected $password;

    /**
     *@Assert\EqualTo(propertyPath="password",message="Mot de passe Different")
     *@Assert\NotBlank(message="retapez votre mot de passe s'il vous plait")
     */
    protected $confirmepassword;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Entrez votre prénom s'il vous plait")
     * @Assert\Regex(
     * pattern="/\d/",
     * match=false,
     * message="Votre nom ne peut pas contenir un nombre"
     * )
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Entrez votre nom s'il vous plait")
     * @Assert\Regex(
     * pattern="/\d/",
     * match=false,
     * message="Votre nom ne peut pas contenir un nombre")
     */
    protected $lastname;



    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;



    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\ManyToOne(targetEntity=Filiere::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $filiere;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
       $roles[] = '';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getConfirmepassword(): string
    {
        return (string) $this->confirmepassword;
    }

    /**
     *
     * @return self
     */
    public function setConfirmepassword(string $confirmepassword)
    {
        $this->confirmepassword = $confirmepassword;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        //$this->password = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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




    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getFullName(): string
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

    public function getGravatarUrl(?int $size = 100)
    {
        return sprintf('https://www.gravatar.com/avatar/%s?s=%d', md5(strtolower(trim($this->getEmail()))), $size);
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
     * ?ettre a jour les heures
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
