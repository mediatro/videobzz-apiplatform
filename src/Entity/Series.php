<?php


namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Entity\Traits\TApprovalStatus;
use App\Entity\Traits\TInteractionCounters;
use App\Entity\Traits\TNamed;
use App\Entity\Traits\TRecord;
use App\Entity\Traits\TSortable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 */
#[ApiResource(
    normalizationContext: ['groups' => ['series', 'album']],
    order: ['position']
)]
#[ApiFilter(OrderFilter::class, properties: [
    'position', 'name',
    'totalInteractionsCount'
])]
#[ApiFilter(SearchFilter::class, properties: [
    'contributor.id' => 'exact',
    'album.id' => 'exact',

    'approvalStatus' => 'exact',
    'symbol.id' => 'exact',
    'creativeMethod.id' => 'exact',
    'environment.id' => 'exact',

    'name' => 'partial',
    'keywords' => 'partial',
    'description' => 'partial',
])]
class Series {

    use TRecord;
    use TNamed;
    use TSortable;
    use TInteractionCounters;
    use TApprovalStatus;


    /**
     * Keywords as simple string array (no comma allowed!)
     * @ORM\Column(type="simple_array", nullable=true)
     */
    protected array $keywords = [];

    /**
     * Description in html
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $description;



    /**
     * Symbol with variable numeric values for each video
     * @ORM\ManyToOne(targetEntity="SeriesSymbol")
     */
    protected $symbol;

    /**
     * @ORM\ManyToOne(targetEntity="SeriesCreativeMethod")
     */
    protected $creativeMethod;

    /**
     * @ORM\ManyToOne(targetEntity="SeriesEnvironment")
     */
    protected $environment;



    /**
     * Sortable group
     * @ORM\ManyToOne(targetEntity="App\Entity\Album", inversedBy="series")
     * @Gedmo\SortableGroup()
     */
    protected $album;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="series")
     */
    #[Groups(['series', 'album'])]
    protected $videos;

    /**
     * Back reference for extra-lazy collection
     * @ORM\ManyToOne(targetEntity="App\Entity\Contributor", inversedBy="series")
     */
    protected $contributor;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
    }

    public function getKeywords(): ?array
    {
        return $this->keywords;
    }

    public function setKeywords(?array $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getDescription(): ?array
    {
        return $this->description;
    }

    public function setDescription(?array $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSymbol(): ?SeriesSymbol
    {
        return $this->symbol;
    }

    public function setSymbol(?SeriesSymbol $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getCreativeMethod(): ?SeriesCreativeMethod
    {
        return $this->creativeMethod;
    }

    public function setCreativeMethod(?SeriesCreativeMethod $creativeMethod): self
    {
        $this->creativeMethod = $creativeMethod;

        return $this;
    }

    public function getEnvironment(): ?SeriesEnvironment
    {
        return $this->environment;
    }

    public function setEnvironment(?SeriesEnvironment $environment): self
    {
        $this->environment = $environment;

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

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setSeries($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getSeries() === $this) {
                $video->setSeries(null);
            }
        }

        return $this;
    }

    public function getContributor(): ?Contributor
    {
        return $this->contributor;
    }

    public function setContributor(?Contributor $contributor): self
    {
        $this->contributor = $contributor;

        return $this;
    }


}
