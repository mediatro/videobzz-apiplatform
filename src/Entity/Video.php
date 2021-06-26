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
#[ApiResource(order: ['position'])]
#[ApiFilter(OrderFilter::class, properties: [
    'position', 'duration', 'symbolValue',
    'createdAt', 'updatedAt',
    'totalInteractionsCount'
])]
#[ApiFilter(SearchFilter::class, properties: [
    'series.id' => 'exact',

    'approvalStatus' => 'exact',
    'languageText.id' => 'exact',
    'languageSubtitles.id' => 'exact',
    'languageVoiceover.id' => 'exact',

    'aspectRatio' => 'exact',
    'soundtrack' => 'partial',
])]
#[ApiFilter(DateFilter::class, properties: ['createdAt, updatedAt'])]
class Video {

    use TRecord;
    use TTimestampable;
    use TSortable;
    use TInteractionCounters;
    use TApprovalStatus;

    /**
     * Duration in seconds
     * @ORM\Column(type="integer")
     */
    protected int $duration;

    /**
     * Thumbnail image absolute url
     * @ORM\Column(type="string")
     */
    #[Groups(['albums', 'series'])]
    protected string $thumbnailImageUrl;



    /**
     * Aspect Ration Enum [VERTICAL, HORIZONTAL]
     * @ORM\Column(type="string", nullable=true)
     */
    protected string $aspectRatio = 'HORIZONTAL';

    /**
     * Value for currency or % symbol accent
     * @ORM\Column(type="float", nullable=true)
     */
    protected ?float $symbolValue;

    /**
     * Soundtrack codename
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $soundtrack;

    /**
     * Soundtrack licence full text
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $soundtrackLicense;

    /**
     * @ORM\ManyToOne(targetEntity="VideoLanguage")
     */
    protected $languageText;

    /**
     * @ORM\ManyToOne(targetEntity="VideoLanguage")
     */
    protected $languageSubtitles;

    /**
     * @ORM\ManyToOne(targetEntity="VideoLanguage")
     */
    protected $languageVoiceover;



    /**
     * Sortable group
     * @ORM\ManyToOne(targetEntity="App\Entity\Series", inversedBy="videos")
     * @Gedmo\SortableGroup()
     */
    protected $series;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VideoVariant", mappedBy="video")
     */
    protected $variants;

    public function __construct()
    {
        $this->variants = new ArrayCollection();
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

    public function getThumbnailImageUrl(): ?string
    {
        return $this->thumbnailImageUrl;
    }

    public function setThumbnailImageUrl(string $thumbnailImageUrl): self
    {
        $this->thumbnailImageUrl = $thumbnailImageUrl;

        return $this;
    }

    public function getAspectRatio(): ?string
    {
        return $this->aspectRatio;
    }

    public function setAspectRatio(?string $aspectRatio): self
    {
        $this->aspectRatio = $aspectRatio;

        return $this;
    }

    public function getSymbolValue(): ?float
    {
        return $this->symbolValue;
    }

    public function setSymbolValue(?float $symbolValue): self
    {
        $this->symbolValue = $symbolValue;

        return $this;
    }

    public function getSoundtrack(): ?string
    {
        return $this->soundtrack;
    }

    public function setSoundtrack(?string $soundtrack): self
    {
        $this->soundtrack = $soundtrack;

        return $this;
    }

    public function getSoundtrackLicense(): ?string
    {
        return $this->soundtrackLicense;
    }

    public function setSoundtrackLicense(?string $soundtrackLicense): self
    {
        $this->soundtrackLicense = $soundtrackLicense;

        return $this;
    }

    public function getLanguageText(): ?VideoLanguage
    {
        return $this->languageText;
    }

    public function setLanguageText(?VideoLanguage $languageText): self
    {
        $this->languageText = $languageText;

        return $this;
    }

    public function getLanguageSubtitles(): ?VideoLanguage
    {
        return $this->languageSubtitles;
    }

    public function setLanguageSubtitles(?VideoLanguage $languageSubtitles): self
    {
        $this->languageSubtitles = $languageSubtitles;

        return $this;
    }

    public function getLanguageVoiceover(): ?VideoLanguage
    {
        return $this->languageVoiceover;
    }

    public function setLanguageVoiceover(?VideoLanguage $languageVoiceover): self
    {
        $this->languageVoiceover = $languageVoiceover;

        return $this;
    }

    public function getSeries(): ?Series
    {
        return $this->series;
    }

    public function setSeries(?Series $series): self
    {
        $this->series = $series;

        return $this;
    }

    /**
     * @return Collection|VideoVariant[]
     */
    public function getVariants(): Collection
    {
        return $this->variants;
    }

    public function addVariant(VideoVariant $variant): self
    {
        if (!$this->variants->contains($variant)) {
            $this->variants[] = $variant;
            $variant->setVideo($this);
        }

        return $this;
    }

    public function removeVariant(VideoVariant $variant): self
    {
        if ($this->variants->removeElement($variant)) {
            // set the owning side to null (unless already changed)
            if ($variant->getVideo() === $this) {
                $variant->setVideo(null);
            }
        }

        return $this;
    }


}
