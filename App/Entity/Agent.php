<?php

namespace App\Entity;

class Agent extends Person
{
    private string $idAgent;
    private ?string $identifyCode = '';
    private ?int $idMission = null;

    

    /**
     * Get the value of idAgentt
     */
    public function getIdAgent(): string
    {
        return $this->idAgent;
    }

    /**
     * Set the value of idAgentt
     */
    public function setIdAgent(string $idAgent): self
    {
        $this->idAgent = $idAgent;

        return $this;
    }

    /**
     * Get the value of identifyCode
     */
    public function getIdentifyCode(): ?string
    {
        return $this->identifyCode;
    }

    /**
     * Set the value of identifyCode
     */
    public function setIdentifyCode(?string $identifyCode): self
    {
        $this->identifyCode = $identifyCode;

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