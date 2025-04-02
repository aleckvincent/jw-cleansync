<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VolunteerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: VolunteerRepository::class)]
#[ApiResource(
  normalizationContext: ['groups' => ['volunteer:read']],
  denormalizationContext: ['groups' => ['volunteer:write']]
)]
class Volunteer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['volunteer:read', 'volunteer:write', 'assignment:write', 'team:red'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['volunteer:read', 'volunteer:write', 'assignment:write'])]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['volunteer:read', 'volunteer:write', 'assignment:write'])]
    private ?string $congregation = "Toulouse Compans";

    /**
     * @var Collection<int, Assignment>
     */
    #[ORM\OneToMany(targetEntity: Assignment::class, mappedBy: 'volunteer', orphanRemoval: true)]
    private Collection $assignments;

    public function __construct()
    {
        $this->assignments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCongregation(): ?string
    {
        return $this->congregation;
    }

    public function setCongregation(?string $congregation): static
    {
        $this->congregation = $congregation;

        return $this;
    }

    /**
     * @return Collection<int, Assignment>
     */
    public function getAssignments(): Collection
    {
        return $this->assignments;
    }

    public function addAssignment(Assignment $assignment): static
    {
        if (!$this->assignments->contains($assignment)) {
            $this->assignments->add($assignment);
            $assignment->setVolunteer($this);
        }

        return $this;
    }

    public function removeAssignment(Assignment $assignment): static
    {
        if ($this->assignments->removeElement($assignment)) {
            // set the owning side to null (unless already changed)
            if ($assignment->getVolunteer() === $this) {
                $assignment->setVolunteer(null);
            }
        }

        return $this;
    }
}
