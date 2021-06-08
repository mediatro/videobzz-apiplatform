<?php


namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait TInteractionCounters {

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['albums', 'series'])]
    protected int $shareCount = 0;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['albums', 'series'])]
    protected int $downloadCount = 0;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['albums', 'series'])]
    protected int $linkCount = 0;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['albums', 'series'])]
    protected int $playCount = 0;

    /**
     * Persistent Aggregate column
     * @ORM\Column(type="integer")
     */
    #[Groups(['albums', 'series'])]
    protected int $totalInteractionsCount = 0;

    public function getShareCount(): ?int
    {
        return $this->shareCount;
    }

    public function setShareCount(int $shareCount): self
    {
        $this->shareCount = $shareCount;

        return $this;
    }

    public function getDownloadCount(): ?int
    {
        return $this->downloadCount;
    }

    public function setDownloadCount(int $downloadCount): self
    {
        $this->downloadCount = $downloadCount;

        return $this;
    }

    public function getLinkCount(): ?int
    {
        return $this->linkCount;
    }

    public function setLinkCount(int $linkCount): self
    {
        $this->linkCount = $linkCount;

        return $this;
    }

    public function getPlayCount(): ?int
    {
        return $this->playCount;
    }

    public function setPlayCount(int $playCount): self
    {
        $this->playCount = $playCount;

        return $this;
    }

    public function getTotalInteractionsCount(): ?int
    {
        return $this->totalInteractionsCount;
    }

    public function setTotalInteractionsCount(int $totalInteractionsCount): self
    {
        $this->totalInteractionsCount = $totalInteractionsCount;

        return $this;
    }

}
