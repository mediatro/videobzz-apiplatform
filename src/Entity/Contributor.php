<?php


namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TNamed;
use App\Entity\Traits\TRecord;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
#[ApiResource()]
class Contributor {

    use TRecord;
    use TNamed;

    /**
     * Extra-lazy non-paginated collection of all albums
     * @ORM\OneToMany(targetEntity="App\Entity\Album", mappedBy="contributor")
     */
    protected $albums;

    /**
     * Extra-lazy non-paginated collection of all series
     * @ORM\OneToMany(targetEntity="App\Entity\Series", mappedBy="contributor")
     */
    protected $series;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
        $this->series = new ArrayCollection();
    }

    /**
     * @return Collection|Album[]
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->setContributor($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getContributor() === $this) {
                $album->setContributor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Series[]
     */
    public function getSeries(): Collection
    {
        return $this->series;
    }

    public function addSeries(Series $series): self
    {
        if (!$this->series->contains($series)) {
            $this->series[] = $series;
            $series->setContributor($this);
        }

        return $this;
    }

    public function removeSeries(Series $series): self
    {
        if ($this->series->removeElement($series)) {
            // set the owning side to null (unless already changed)
            if ($series->getContributor() === $this) {
                $series->setContributor(null);
            }
        }

        return $this;
    }

}
