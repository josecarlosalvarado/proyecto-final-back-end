<?php

namespace App\Entity;

use App\Repository\VegetableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VegetableRepository::class)
 */
class Vegetable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=125)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=125)
     */
    private $scientificName;

    /**
     * @ORM\Column(type="string", length=125)
     */
    private $family;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     */
    private $sowingTemperateClimates;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     */
    private $sowOtherClimates;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     */
    private $plantation;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     */
    private $harvest;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     */
    private $flowerpot;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     */
    private $substrateFertilizer;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     */
    private $irrigation;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     */
    private $light;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     */
    private $weather;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     */
    private $difficulty;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $properties;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $associations;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $pests;

    /**
     * @ORM\Column(type="string", length=125, nullable=true)
     */
    private $filterMonth;

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

    public function getScientificName(): ?string
    {
        return $this->scientificName;
    }

    public function setScientificName(string $scientificName): self
    {
        $this->scientificName = $scientificName;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(string $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getSowingTemperateClimates(): ?string
    {
        return $this->sowingTemperateClimates;
    }

    public function setSowingTemperateClimates(?string $sowingTemperateClimates): self
    {
        $this->sowingTemperateClimates = $sowingTemperateClimates;

        return $this;
    }

    public function getSowOtherClimates(): ?string
    {
        return $this->sowOtherClimates;
    }

    public function setSowOtherClimates(?string $sowOtherClimates): self
    {
        $this->sowOtherClimates = $sowOtherClimates;

        return $this;
    }

    public function getPlantation(): ?string
    {
        return $this->plantation;
    }

    public function setPlantation(?string $plantation): self
    {
        $this->plantation = $plantation;

        return $this;
    }

    public function getHarvest(): ?string
    {
        return $this->harvest;
    }

    public function setHarvest(?string $harvest): self
    {
        $this->harvest = $harvest;

        return $this;
    }

    public function getFlowerpot(): ?string
    {
        return $this->flowerpot;
    }

    public function setFlowerpot(?string $flowerpot): self
    {
        $this->flowerpot = $flowerpot;

        return $this;
    }

    public function getSubstrateFertilizer(): ?string
    {
        return $this->substrateFertilizer;
    }

    public function setSubstrateFertilizer(?string $substrateFertilizer): self
    {
        $this->substrateFertilizer = $substrateFertilizer;

        return $this;
    }

    public function getIrrigation(): ?string
    {
        return $this->irrigation;
    }

    public function setIrrigation(?string $irrigation): self
    {
        $this->irrigation = $irrigation;

        return $this;
    }

    public function getLight(): ?string
    {
        return $this->light;
    }

    public function setLight(?string $light): self
    {
        $this->light = $light;

        return $this;
    }

    public function getWeather(): ?string
    {
        return $this->weather;
    }

    public function setWeather(?string $weather): self
    {
        $this->weather = $weather;

        return $this;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(?string $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getProperties(): ?string
    {
        return $this->properties;
    }

    public function setProperties(?string $properties): self
    {
        $this->properties = $properties;

        return $this;
    }

    public function getAssociations(): ?string
    {
        return $this->associations;
    }

    public function setAssociations(?string $associations): self
    {
        $this->associations = $associations;

        return $this;
    }

    public function getPests(): ?string
    {
        return $this->pests;
    }

    public function setPests(?string $pests): self
    {
        $this->pests = $pests;

        return $this;
    }

    public function getFilterMonth(): ?string
    {
        return $this->filterMonth;
    }

    public function setFilterMonth(?string $filterMonth): self
    {
        $this->filterMonth = $filterMonth;

        return $this;
    }
}
