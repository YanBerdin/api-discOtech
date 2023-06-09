<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 */
class Review
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"album_read"})
     * @Groups({"review_read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reviews")
     * @Groups({"album_read"})
     * @Groups({"review_read"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Album::class, inversedBy="reviews")
     * @Groups({"review_read"})
     */
    private $album;

    /**
     * @ORM\Column(type="text")
     * @Groups({"album_read"})
     * @Groups({"review_read"})
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"album_read"})
     * @Groups({"review_read"})
     */
    private $createdAt;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
}
