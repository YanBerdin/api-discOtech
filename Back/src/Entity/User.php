<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Vich\Uploadable
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"review_read"})
     * @Groups({"album_read"})
     * @Groups({"user_detail"})
     * @Groups({"favorite_browse"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"album_read"})
     * @Groups({"review_read"})
     * @Groups({"user_detail"})
     * @Groups({"favorite_browse"})
     * @Assert\NotBlank(message= "Ce champs ne peut pas être vide")
     * @Assert\Email(message = "l'Email '{{ value }}' n'est pas valide.")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotBlank(message= "Ce champs ne peut pas être vide")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message= "Ce champs ne peut pas être vide")
     * @Assert\Regex(
     * pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",
     * match=true,
     * message= "Le mot de passe doit contenir au minimum 8 caractères, une majuscule, un chiffre et un caractère spécial"
     * )
     * 
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"album_read"})
     * @Groups({"review_read"})
     * @Groups({"user_detail"})
     * @Groups({"favorite_browse"})
     * @Assert\NotBlank(message= "Ce champs ne peut pas être vide")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"album_read"})
     * @Groups({"review_read"})
     * @Groups({"user_detail"})
     * @Groups({"favorite_browse"})
     * @Assert\NotBlank(message= "Ce champs ne peut pas être vide")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"album_read"})
     * @Groups({"support_read"})
     * @Groups({"user_detail"})
     */
    private $avatar;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="profil_images", fileNameProperty="avatar")
     * 
     * @var File|null
     */
    private $imageFile;

     /**
     * @ORM\Column(nullable="true")
     */
    private ?\DateTimeImmutable $updatedAt = null;


    /**
     * @ORM\OneToMany(targetEntity=Album::class, mappedBy="user")
     * @Groups({"user_detail"})
     * 
     */
    private $albums;

    /**
     * @ORM\OneToMany(targetEntity=Favorites::class, mappedBy="user")
     * @Groups({"user_detail"})
     * 
     */
    private $favorites;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="user")
     * @Groups({"favorite_browse"})
     */
    private $reviews;


    public function __construct()
    {
        $this->albums = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }


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
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
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
        // guarantee every user at least has ROLE_USER
        // $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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
        // $this->plainPassword = null;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserFirstnameInterface(): string
    {
        return (string) $this->firstname;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUserFirstname(): string
    {
        return (string) $this->firstname;
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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

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
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;


        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
 

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->setUser($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getUser() === $this) {
                $album->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Favorites>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorites $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
            $favorite->setUser($this);
        }

        return $this;
    }

    public function removeFavorite(Favorites $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getUser() === $this) {
                $favorite->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setUser($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUser() === $this) {
                $review->setUser(null);
            }
        }

        return $this;
    }

}
