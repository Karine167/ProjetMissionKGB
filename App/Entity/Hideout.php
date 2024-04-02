<?php

namespace App\Entity;

class Hideout
{
    private ?int $id = null;
    private ?string $codeHide = '';
    private ?string $city = '';
    private ?string $zipcode = '';
    private ?string $address = '';
    private ?int $idCountry = 1;
    private ?int $idTypeHide = 1;
    private ?int $idMission = null;

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
     * Get the value of codeHide
     */
    public function getCodeHide(): ?string
    {
        return $this->codeHide;
    }

    /**
     * Set the value of codeHide
     */
    public function setCodeHide(?string $codeHide): self
    {
        $this->codeHide = $codeHide;

        return $this;
    }

    /**
     * Get the value of city
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Set the value of city
     */
    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get the value of zipcode
     */
    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    /**
     * Set the value of zipcode
     */
    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get the value of address
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Set the value of address
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of idCountry
     */
    public function getIdCountry(): ?int
    {
        return $this->idCountry;
    }

    /**
     * Set the value of idCountry
     */
    public function setIdCountry(?int $idCountry): self
    {
        $this->idCountry = $idCountry;

        return $this;
    }

    /**
     * Get the value of idTypeHide
     */
    public function getIdTypeHide(): ?int
    {
        return $this->idTypeHide;
    }

    /**
     * Set the value of idTypeHide
     */
    public function setIdTypeHide(?int $idTypeHide): self
    {
        $this->idTypeHide = $idTypeHide;

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