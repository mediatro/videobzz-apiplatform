<?php


namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TNamed;
use App\Entity\Traits\TRecord;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
#[ApiResource]
class AlbumSubcategory {

    use TRecord;
    use TNamed;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AlbumCategory", inversedBy="subCategories")
     */
    protected $category;

    public function getCategory(): ?AlbumCategory
    {
        return $this->category;
    }

    public function setCategory(?AlbumCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

}
