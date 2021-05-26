<?php


namespace App\Entity\Traits;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;

trait TRecord {

    /**
     * Unique auto incremented primary key
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    #[ApiFilter(SearchFilter::class, strategy: 'exact')]
    protected int $id;

    public function getId(): int {
        return $this->id;
    }

}
