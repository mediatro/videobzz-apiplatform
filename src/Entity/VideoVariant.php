<?php


namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TRecord;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity()
 */
#[ApiResource]
class VideoVariant {

    use TRecord;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Video", inversedBy="variants")
     */
    protected $video;

    /**
     * Height in pixels
     * @ORM\Column(type="integer")
     */
    protected int $height;

    /**
     * Width in pixels
     * @ORM\Column(type="integer")
     */
    protected int $width;

    /**
     * File size in bytes
     * @ORM\Column(type="integer")
     */
    protected int $fileSize;

    /**
     * Direct file absolute url
     * @ORM\Column(type="string")
     */
    protected string $fileUrl;

    /**
     * Embed code full html iframe
     * @ORM\Column(type="string")
     */
    protected string $embedCode;

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    public function setFileSize(int $fileSize): self
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    public function getFileUrl(): ?string
    {
        return $this->fileUrl;
    }

    public function setFileUrl(string $fileUrl): self
    {
        $this->fileUrl = $fileUrl;

        return $this;
    }

    public function getEmbedCode(): ?string
    {
        return $this->embedCode;
    }

    public function setEmbedCode(string $embedCode): self
    {
        $this->embedCode = $embedCode;

        return $this;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(?Video $video): self
    {
        $this->video = $video;

        return $this;
    }


}
