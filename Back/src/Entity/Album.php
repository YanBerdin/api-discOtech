<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AlbumRepository::class)
 */
class Album
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"album_browse"})
     * @Groups({"favorite_browse"})
     * @Groups({"album_read"})
     * @Groups({"song_browse"})
     * @Groups({"style_read"})
     * @Groups({"support_read"})
     * @Groups({"review_read"})
     * @Groups({"artist_browse"})
     * @Groups({"user_detail"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"song_browse"})
     * @Groups({"album_browse"})
     * @Groups({"favorite_browse"})
     * @Groups({"artist_browse"})
     * @Groups({"style_read"})
     * @Groups({"review_read"})
     * @Groups({"support_read"})
     * @Groups({"user_detail"})
     * @Assert\NotBlank (message = "Ce champs ne peut pas être vide")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"album_browse"})
     * @Groups({"style_read"})
     * @Groups({"support_read"})
     * @Groups({"artist_browse"})
     * @Groups({"user_detail"})
     * @Groups({"favorite_browse"})
     * @Assert\NotBlank(message= "Ce champs ne peut pas être vide")
     */
    private $edition;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"album_browse"})
     * @Groups({"style_read"})
     * @Groups({"favorites_browse"})
     * @Groups({"support_read"})
     * @Assert\NotBlank(message= "Ce champs ne peut pas être vide")
     */
    private $releaseDate;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"album_browse"})
     * @Groups({"style_read"})
     * @Groups({"user_detail"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"album_browse"})
     * @Groups({"user_detail"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=Style::class, inversedBy="albums")
     * @Groups({"album_browse"})
     * @Groups({"favorite_browse"})
     * @Groups({"artist_browse"})
     * @Groups({"user_detail"})
     * @Assert\NotBlank(message= "Ces champs ne peuvent pas être vide")
     */
    private $style;

    /**
     * @ORM\ManyToMany(targetEntity=Support::class, inversedBy="albums")
     * @Groups({"album_browse"})
     * @Groups({"favorite_browse"})
     * @Groups({"user_detail"})
     * @Assert\NotBlank(message= "Ce champs ne peuvent pas être vide")
     */
    private $support;

    /**
     * @ORM\OneToMany(targetEntity=Song::class, mappedBy="album",orphanRemoval=true)
     * @Groups({"album_browse"})
     */
    private $songs;

    /**
     * @ORM\ManyToOne(targetEntity=Artist::class, inversedBy="albums")
     * @Groups({"album_browse"})
     * @Groups({"favorite_browse"})
     * @Groups({"support_read"})
     * @Groups({"user_detail"})
     * @Groups({"style_read"})
     * @Assert\NotBlank(message= "Ce champs ne peut pas être vide")
     */
    private $artist;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="albums")
     * @Groups({"album_read"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Favorites::class, mappedBy="album")
     * @Groups({"album_read"})
     */
    private $favorites;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="album")
     * @Groups({"album_read"})
     */
    private $reviews;

    /**
     * @ORM\Column(type="string", length=255,)
     * @Groups({"album_browse"})
     * @Groups({"song_browse"})
     * @Groups({"support_read"})
     * @Groups({"favorite_browse"})
     * @Groups({"style_read"})
     * @Groups({"artist_browse"})
     * @Assert\NotBlank(message= "Ce champs ne peut pas être vide")
     */
    private $image;

    public function __construct()
    {
        $this->createdAt =new \DateTime();
        $this->style = new ArrayCollection();
        $this->support = new ArrayCollection();
        $this->songs = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->reviews = new ArrayCollection();
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

    public function getEdition(): ?string
    {
        return $this->edition;
    }

    public function setEdition(?string $edition): self
    {
        $this->edition = $edition;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate = null): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        $this->createdAt;
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = new \DateTime("now");
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Style>
     */
    public function getStyle(): Collection
    {
        return $this->style;
    }

    public function addStyle(Style $style): self
    {
        if (!$this->style->contains($style)) {
            $this->style[] = $style;
        }

        return $this;
    }

    public function removeStyle(Style $style): self
    {
        $this->style->removeElement($style);

        return $this;
    }

    

    /**
     * @return Collection<int, Support>
     */
    public function getSupport(): Collection
    {
        return $this->support;
    }

    public function addSupport(Support $support): self
    {
        if (!$this->support->contains($support)) {
            $this->support[] = $support;
        }

        return $this;
    }

    public function removeSupport(Support $support): self
    {
        $this->support->removeElement($support);

        return $this;
    }

    /**
     * @return Collection<int, Song>
     */
    public function getSongs(): Collection
    {
        return $this->songs;
    }

    public function addSong(Song $song): self
    {
        if (!$this->songs->contains($song)) {
            $this->songs[] = $song;
            $song->setAlbum($this);
        }

        return $this;
    }

    public function removeSong(Song $song): self
    {
        if ($this->songs->removeElement($song)) {
            // set the owning side to null (unless already changed)
            if ($song->getAlbum() === $this) {
                $song->setAlbum(null);
            }
        }

        return $this;
    }

    public function getArtist(): ?Artist
    {
        return $this->artist;
    }

    public function setArtist(?Artist $artist): self
    {
        $this->artist = $artist;

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
            $favorite->setAlbum($this);
        }

        return $this;
    }

    public function removeFavorite(Favorites $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getAlbum() === $this) {
                $favorite->setAlbum(null);
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
            $review->setAlbum($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getAlbum() === $this) {
                $review->setAlbum(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    
}
