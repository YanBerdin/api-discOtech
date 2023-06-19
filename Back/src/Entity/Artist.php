<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArtistRepository::class)
 */
class Artist
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"artist_browse"})
     * @Groups({"album_browse"})
     * @Groups({"album_read"})
     * @Groups({"user_detail"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"album_browse"})
     * @Groups({"favorite_browse"})
     * @Groups({"artist_browse"})
     * @Groups({"support_read"})
     * @Groups({"user_detail"})
     * @Assert\NotBlank(message= "Ce champs ne peut pas être vide")
     */
    private $fullname;

    /**
     * @ORM\OneToMany(targetEntity=Album::class, mappedBy="artist")
     * @Groups({"artist_browse"})
     */
    private $albums;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * A visual identifier that represents this artist.
     *
     * @see ArtistInterface
     */
    public function getArtistFullnameInterface(): string
    {
        return (string) $this->fullname;
    }

    /**
     * @deprecated since Symfony 5.3, use getArtistIdentifier instead
     */
    public function getArtistFullname(): string
    {
        return (string) $this->fullname;
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
            $album->setArtist($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getArtist() === $this) {
                $album->setArtist(null);
            }
        }

        return $this;
    }
}
