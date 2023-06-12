<?php

namespace App\Entity;

use App\Repository\SongRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SongRepository::class)
 */
class Song
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"song_browse"})
     * @Groups({"album_browse"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"song_browse"})
     * @Groups({"album_browse"})
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"song_browse"})
     * @Groups({"album_browse"})
     * @Groups({"song_read"})
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"song_browse"})
     * @Groups({"song_read"})
     */
    private $preview;

    /**
     * @ORM\ManyToOne(targetEntity=Album::class, inversedBy="songs")
     * @Groups({"song_browse"})
     * @Groups({"song_read"})
     */
    private $album;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"song_browse"})
     * @Groups({"song_read"})
     */
    private $trackNb;

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

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPreview(): ?string
    {
        return $this->preview;
    }

    public function setPreview(?string $preview): self
    {
        $this->preview = $preview;

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

    public function getTrackNb(): ?int
    {
        return $this->trackNb;
    }

    public function setTrackNb(int $trackNb): self
    {
        $this->trackNb = $trackNb;

        return $this;
    }
}
