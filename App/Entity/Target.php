<?php

namespace App\Entity;

class Target extends Person
{
    private string $idTarget;
    private ?string $codeName = '';
    private ?int $idMission = null;

    /**
     * Get the value of idTarget
     */
    public function getIdTarget(): string
    {
        return $this->idTarget;
    }

    /**
     * Set the value of idTarget
     */
    public function setIdTarget(string $idTarget): self
    {
        $this->idTarget = $idTarget;

        return $this;
    }

    /**
     * Get the value of codeName
     */
    public function getCodeName(): ?string
    {
        return $this->codeName;
    }

    /**
     * Set the value of codeName
     */
    public function setCodeName(?string $codeName): self
    {
        $this->codeName = $codeName;

        return $this;
    }

    /**
     * Get the value of idMission
     */
    public function getIdMission(): ?int
    {
        return $this->idMission;
    }

    /**
     * Set the value of idMission
     */
    public function setIdMission(?int $idMission): self
    {
        $this->idMission = $idMission;

        return $this;
    }
}