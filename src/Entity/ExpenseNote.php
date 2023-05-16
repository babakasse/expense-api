<?php

namespace App\Entity;

use App\Repository\ExpenseNoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

#[ORM\Entity(repositoryClass: ExpenseNoteRepository::class)]
class ExpenseNote
{
    const TYPE_FUEL = 'fuel';
    const TYPE_TOLL = 'toll';
    const TYPE_MEAL = 'meal';
    const TYPE_CONFERENCE = 'conference';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $noteDate = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column(length: 255)]
    private ?string $noteType = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $registrationDate = null;

    #[ORM\ManyToOne(inversedBy: 'expenseNotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'expenseNotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $commercial = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoteDate(): ?\DateTimeInterface
    {
        return $this->noteDate;
    }

    public function setNoteDate(\DateTimeInterface $noteDate): self
    {
        $this->noteDate = $noteDate;

        return $this;
    }

    public function setNoteType(string $noteType): self
    {
        if (!in_array($noteType, [self::TYPE_FUEL, self::TYPE_TOLL, self::TYPE_MEAL, self::TYPE_CONFERENCE])) {
            throw new InvalidArgumentException("Invalid type");
        }

        $this->noteType = $noteType;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getCommercial(): ?User
    {
        return $this->commercial;
    }

    public function setCommercial(?User $commercial): self
    {
        $this->commercial = $commercial;

        return $this;
    }
}
