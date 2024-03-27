<?php

namespace App\Entity;

use DateTime;

class Person 
{
    private string $id;
    private ?string $firstName = '';
    private ?string $lastName = '';
    private DateTime $birthdate;

    public function __toString()
    {
        return $this->getFirstName() . " " . $this->getLastName();
    }

    /**
     * Get the value of id
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of firstName
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     */
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of birthdate
     */
    public function getBirthdate(): DateTime
    {
        return $this->birthdate;
    }

    /**
     * Set the value of birthdate
     */
    public function setBirthdate(DateTime $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }
}