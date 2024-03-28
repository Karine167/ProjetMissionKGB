<?php

namespace App\Entity;

class TypeMission
{
    private ?int $id = null;
    private ?string $typeMission = '';
    
    

    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of typeMission
     */
    public function getTypeMission(): ?string
    {
        return $this->typeMission;
    }

    /**
     * Set the value of typeMission
     */
    public function setTypeMission(?string $typeMission): self
    {
        $this->typeMission = $typeMission;

        return $this;
    }
}