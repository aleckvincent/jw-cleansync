<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AssignmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AssignmentRepository::class)]
#[ApiResource(
  normalizationContext: ['groups' => ['assignment:read']],
  denormalizationContext: ['groups' => ['assignment:write']]
)]
class Assignment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'assignments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['assignment:write', 'assignment:read', 'team:red'])]
    private ?Volunteer $volunteer = null;

    #[ORM\Column]
    #[Groups(['assignment:write', 'assignment:read', 'team:red'])]
    private ?bool $confirmed = false;

    #[ORM\Column(length: 3, nullable: true)]
    #[Groups(['assignment:write', 'assignment:read', 'team:red'])]
    private ?string $day = null;

    #[ORM\Column(length: 64, nullable: true)]
    #[Groups(['assignment:write', 'assignment:read', 'team:red'])]
    private ?string $activity = null;

    #[ORM\ManyToOne(inversedBy: 'assignments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['assignment:write', 'assignment:read'])]
    private ?Team $team = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVolunteer(): ?Volunteer
    {
        return $this->volunteer;
    }

    public function setVolunteer(?Volunteer $volunteer): static
    {
        $this->volunteer = $volunteer;

        return $this;
    }

    public function isConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): static
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(?string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getActivity(): ?string
    {
        return $this->activity;
    }

    public function setActivity(?string $activity): static
    {
        $this->activity = $activity;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

        return $this;
    }
}
