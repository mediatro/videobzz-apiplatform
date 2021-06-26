<?php


namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Entity\Traits\TApprovalStatus;
use App\Entity\Traits\TInteractionCounters;
use App\Entity\Traits\TNamed;
use App\Entity\Traits\TRecord;
use App\Entity\Traits\TSortable;
use App\Entity\Traits\TTimestampable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 */
#[ApiResource(
    itemOperations: [
        'get' => [
            'normalization_context' => ['groups' => ['albums', 'album']]
        ],
        'put', 'patch', 'delete',
    ],
    normalizationContext: ['groups' => ['albums']],
    order: ['position']
)]
#[ApiFilter(OrderFilter::class, properties: [
    'position', 'name',
    'seriesCount', 'videosCount',
    'createdAt', 'updatedAt',
    'totalInteractionsCount'
], arguments: ['orderParameterName' => 'order'])]
#[ApiFilter(SearchFilter::class, properties: [
    'contributor.id' => 'exact',

    'approvalStatus' => 'exact',
    'category.id' => 'exact',
    'subCategories.id' => 'exact',
    'contentType' => 'exact',
    'contentSubtype' => 'exact',

    'name' => 'partial',
])]
#[ApiFilter(DateFilter::class, properties: ['createdAt, updatedAt'])]
class Album {

    use TRecord;
    use TNamed;
    use TTimestampable;
    use TSortable;
    use TInteractionCounters;
    use TApprovalStatus;

    /**
     * Position at the public frontend
     * @ORM\Column(type="integer", nullable=true)
     */
    #[Groups(['albums'])]
    protected ?int $pageNumber;

    /**
     * Position at the public frontend
     * @ORM\Column(type="integer", nullable=true)
     */
    #[Groups(['albums'])]
    protected ?int $lineNumber;

    /**
     * Position at the public frontend
     * @ORM\Column(type="integer", nullable=true)
     */
    #[Groups(['albums'])]
    protected ?int $playerNumber;



    /**
     * Top level type of the content: Enum [BUSINESS, PRIVATE]
     * @ORM\Column(type="string")
     */
    #[Groups(['albums'])]
    protected $contentType = 'BUSINESS';

    /**
     * Subtype of the content: Enum [PRODUCT, SERVICE] | Enum [EVENT, GENERIC]
     * @ORM\Column(type="string")
     */
    #[Groups(['albums'])]
    protected $contentSubtype;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AlbumCategory")
     */
    #[Groups(['albums'])]
    protected $category;

    /**
     * Maximum of 4 allowed
     * @ORM\ManyToMany(targetEntity="App\Entity\AlbumSubcategory")
     * @ORM\JoinTable(name="album_to_subcategory_rels")
     */
    #[Groups(['albums'])]
    protected $subCategories;



    /**
     * Sortable group
     * @ORM\ManyToOne(targetEntity="App\Entity\Contributor", inversedBy="albums")
     * @Gedmo\SortableGroup()
     */
    #[Groups(['albums'])]
    protected $contributor;

    /**
     * At least one default series is always available, no orphan videos allowed
     * @ORM\OneToMany(targetEntity="App\Entity\Series", mappedBy="album")
     */
    #[Groups(['album'])]
    protected $series;

    /**
     * Propagated reference to the first video of the first series
     * @ORM\OneToOne(targetEntity="App\Entity\Video")
     */
    #[Groups(['albums'])]
    protected $thumbnailVideo;



    /**
     * Persistent Aggregate field
     * @ORM\Column(type="integer")
     */
    #[Groups(['albums'])]
    protected $seriesCount = 0;

    /**
     * Persistent Aggregate field
     * @ORM\Column(type="integer")
     */
    #[Groups(['albums'])]
    protected $videosCount = 0;



    public function __construct()
    {
        $this->subCategories = new ArrayCollection();
        $this->series = new ArrayCollection();
    }

    public function getPageNumber(): ?int
    {
        return $this->pageNumber;
    }

    public function setPageNumber(?int $pageNumber): self
    {
        $this->pageNumber = $pageNumber;

        return $this;
    }

    public function getLineNumber(): ?int
    {
        return $this->lineNumber;
    }

    public function setLineNumber(?int $lineNumber): self
    {
        $this->lineNumber = $lineNumber;

        return $this;
    }

    public function getPlayerNumber(): ?int
    {
        return $this->playerNumber;
    }

    public function setPlayerNumber(?int $playerNumber): self
    {
        $this->playerNumber = $playerNumber;

        return $this;
    }

    public function getContentType(): ?string
    {
        return $this->contentType;
    }

    public function setContentType(string $contentType): self
    {
        $this->contentType = $contentType;

        return $this;
    }

    public function getContentSubtype(): ?string
    {
        return $this->contentSubtype;
    }

    public function setContentSubtype(string $contentSubtype): self
    {
        $this->contentSubtype = $contentSubtype;

        return $this;
    }

    public function getSeriesCount(): ?int
    {
        return $this->seriesCount;
    }

    public function setSeriesCount(int $seriesCount): self
    {
        $this->seriesCount = $seriesCount;

        return $this;
    }

    public function getVideosCount(): ?int
    {
        return $this->videosCount;
    }

    public function setVideosCount(int $videosCount): self
    {
        $this->videosCount = $videosCount;

        return $this;
    }

    public function getCategory(): ?AlbumCategory
    {
        return $this->category;
    }

    public function setCategory(?AlbumCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|AlbumSubcategory[]
     */
    public function getSubCategories(): Collection
    {
        return $this->subCategories;
    }

    public function addSubCategory(AlbumSubcategory $subCategory): self
    {
        if (!$this->subCategories->contains($subCategory)) {
            $this->subCategories[] = $subCategory;
        }

        return $this;
    }

    public function removeSubCategory(AlbumSubcategory $subCategory): self
    {
        $this->subCategories->removeElement($subCategory);

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
            $series->setAlbum($this);
        }

        return $this;
    }

    public function removeSeries(Series $series): self
    {
        if ($this->series->removeElement($series)) {
            // set the owning side to null (unless already changed)
            if ($series->getAlbum() === $this) {
                $series->setAlbum(null);
            }
        }

        return $this;
    }

    public function getThumbnailVideo(): ?Video
    {
        if(!$this->thumbnailVideo){
            if($this->getSeries()->count() > 0){
                $firstSeries = $this->getSeries()->first();
                if($firstSeries->getVideos()->count() > 0){
                    $this->setThumbnailVideo($firstSeries->getVideos()->first());
                }
            }
        }
        return $this->thumbnailVideo;
    }

    public function setThumbnailVideo(?Video $thumbnailVideo): self
    {
        $this->thumbnailVideo = $thumbnailVideo;

        return $this;
    }



}
