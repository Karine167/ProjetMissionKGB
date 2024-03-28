<?php

namespace App\Entity;

class Country
{
    private ?int $id = null;
    private ?string $countryName = '';
    private ?string $nationality = '';

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
     * Get the value of countryName
     */
    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    /**
     * Set the value of countryName
     */
    public function setCountryName(?string $countryName): self
    {
        $this->countryName = $countryName;

        return $this;
    }

    /**
     * Get the value of nationality
     */
    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    /**
     * Set the value of nationality
     */
    public function setNationality(?string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }
}