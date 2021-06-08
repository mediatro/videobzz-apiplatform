<?php


namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

trait TSortable {

    /**
     * Position within the sortable group
     * @Gedmo\SortablePosition()
     * @ORM\Column(name="position", type="integer")
     */
    #[Groups(['albums', 'series'])]
    protected int $position;

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

}
