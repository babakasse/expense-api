<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\OneToMany(mappedBy: 'commercial', targetEntity: ExpenseNote::class)]
    private Collection $expenseNotes;

    public function __construct()
    {
        $this->expenseNotes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * @return Collection<int, ExpenseNote>
     */
    public function getExpenseNotes(): Collection
    {
        return $this->expenseNotes;
    }

    public function addExpenseNote(ExpenseNote $expenseNote): self
    {
        if (!$this->expenseNotes->contains($expenseNote)) {
            $this->expenseNotes->add($expenseNote);
            $expenseNote->setCommercial($this);
        }

        return $this;
    }

    public function removeExpenseNote(ExpenseNote $expenseNote): self
    {
        if ($this->expenseNotes->removeElement($expenseNote)) {
            // set the owning side to null (unless already changed)
            if ($expenseNote->getCommercial() === $this) {
                $expenseNote->setCommercial(null);
            }
        }

        return $this;
    }
}
