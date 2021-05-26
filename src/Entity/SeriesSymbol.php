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
class SeriesSymbol {

    use TRecord;
    use TNamed;

}
