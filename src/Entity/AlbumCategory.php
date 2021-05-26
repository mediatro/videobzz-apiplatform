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
#[ApiResource]
class AlbumCategory {

    use TRecord;
    use TNamed;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AlbumSubcategory", mappedBy="category")
     */
    protected $subCategories;

    /**
     * Top level type of the content: Enum [BUSINESS, PRIVATE]
     * @ORM\Column(type="string")
     */
    protected $contentType = 'BUSINESS';

    public function __construct()
    {
        $this->subCategories = new ArrayCollection();
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
            $subCategory->setCategory($this);
        }

        return $this;
    }

    public function removeSubCategory(AlbumSubcategory $subCategory): self
    {
        if ($this->subCategories->removeElement($subCategory)) {
            // set the owning side to null (unless already changed)
            if ($subCategory->getCategory() === $this) {
                $subCategory->setCategory(null);
            }
        }

        return $this;
    }

}
