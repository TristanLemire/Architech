<?php

namespace App\Entity;

use App\Repository\ClassroomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClassroomRepository::class)
 */
class Classroom
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $floor;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $zone;

    /**
     * @ORM\ManyToOne(targetEntity=building::class, inversedBy="classrooms")
     */
    private $building;

    /**
     * @ORM\OneToMany(targetEntity=Sensor::class, mappedBy="classroom")
     */
    private $sensors;

    /**
     * @ORM\OneToMany(targetEntity=Incident::class, mappedBy="classroom")
     */
    private $incidents;

    public function __construct()
    {
        $this->sensors = new ArrayCollection();
        $this->incidents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getZone(): ?string
    {
        return $this->zone;
    }

    public function setZone(string $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getBuilding(): ?building
    {
        return $this->building;
    }

    public function setBuilding(?building $building): self
    {
        $this->building = $building;

        return $this;
    }

    /**
     * @return Collection|Sensor[]
     */
    public function getSensors(): Collection
    {
        return $this->sensors;
    }

    public function addSensor(Sensor $sensor): self
    {
        if (!$this->sensors->contains($sensor)) {
            $this->sensors[] = $sensor;
            $sensor->setClassroom($this);
        }

        return $this;
    }

    public function removeSensor(Sensor $sensor): self
    {
        if ($this->sensors->removeElement($sensor)) {
            // set the owning side to null (unless already changed)
            if ($sensor->getClassroom() === $this) {
                $sensor->setClassroom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Incident[]
     */
    public function getIncidents(): Collection
    {
        return $this->incidents;
    }

    public function addIncident(Incident $incident): self
    {
        if (!$this->incidents->contains($incident)) {
            $this->incidents[] = $incident;
            $incident->setClassroom($this);
        }

        return $this;
    }

    public function removeIncident(Incident $incident): self
    {
        if ($this->incidents->removeElement($incident)) {
            // set the owning side to null (unless already changed)
            if ($incident->getClassroom() === $this) {
                $incident->setClassroom(null);
            }
        }

        return $this;
    }
}
