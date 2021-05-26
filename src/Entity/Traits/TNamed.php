<?php


namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait TNamed {

    /**
     * Entity display name
     * @ORM\Column(type="string")
     */
    protected string $name;

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

}
