<?php


namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait TApprovalStatus {

    /**
     * Admin approval status Enum [PENDING, ACTIVE, REJECTED]
     * @ORM\Column(type="string")
     */
    #[Groups(['albums', 'series'])]
    protected string $approvalStatus = 'PENDING';

    /**
     * Admin approval rejection reasons Array<Enum [OFFENSIVE, COPYRIGHT_SOUNDTRACK, COPYRIGHT_CONTENT, LENGTH, QUALITY, OTHER]>
     * @ORM\Column(type="simple_array")
     */
    #[Groups(['albums', 'series'])]
    protected array $rejectionReasons = [];

    /**
     * Other admin approval rejection reason details in free text
     * @ORM\Column(type="string", nullable=true)
     */
    #[Groups(['albums', 'series'])]
    protected ?string $rejectionReasonOther;

    public function getApprovalStatus(): ?string
    {
        return $this->approvalStatus;
    }

    public function setApprovalStatus(string $approvalStatus): self
    {
        $this->approvalStatus = $approvalStatus;

        return $this;
    }

    public function getRejectionReasons(): ?array
    {
        return $this->rejectionReasons;
    }

    public function setRejectionReasons(array $rejectionReasons): self
    {
        $this->rejectionReasons = $rejectionReasons;

        return $this;
    }

    public function getRejectionReasonOther(): ?string
    {
        return $this->rejectionReasonOther;
    }

    public function setRejectionReasonOther(?string $rejectionReasonOther): self
    {
        $this->rejectionReasonOther = $rejectionReasonOther;

        return $this;
    }

}
