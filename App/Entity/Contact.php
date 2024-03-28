<?php

namespace App\Entity;

class Contact extends Person
{
    private string $idContact;
    private ?string $codeName = '';
    private ?int $idMission = null;

    

    /**
     * Get the value of idContact
     */
    public function getIdContact(): string
    {
        return $this->idContact;
    }

    /**
     * Set the value of idContact
     */
    public function setIdContact(string $idContact): self
    {
        $this->idContact = $idContact;

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