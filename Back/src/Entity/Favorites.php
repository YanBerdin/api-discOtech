<?php

namespace App\Entity;

use App\Repository\FavoritesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FavoritesRepository::class)
 */
class Favorites
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({"album_read"})
     * @Groups({"favorite_browse"})
     * @Groups({"user_detail"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="favorites")
     * 
     * @Groups({"album_read"})
     * @Groups({"favorite_browse"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Album::class, inversedBy="favorites")
     * @Groups({"favorite_browse"})
     * @Groups({"user_detail"})
     */
    private $album;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"album_read"})
     * @Groups({"favorite_browse"})
     * @Groups({"user_detail"})
     */
    private $createdAt;

    public function __construct()
    {
    $this->createdAt =new \DateTime();
    }
    

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAlbum(): ?Album
    {
        return $this->album;
    }

    public function setAlbum(?Album $album): self
    {
        $this->album = $album;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        $this->createdAt = new \DateTime("now");
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = new \DateTime("now");
        $this->createdAt = $createdAt;

        return $this;
    }
}
