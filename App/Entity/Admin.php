<?php

namespace App\Entity;

use DateTime;

class Admin
{
    private string $idAdmin;
    private ?string $email = '';
    private ?string $password = '';
    private DateTime $createdAt;


    /**
     * Get the value of idAdmin
     */
    public function getIdAdmin(): string
    {
        return $this->idAdmin;
    }

    /**
     * Set the value of idAdmin
     */
    public function setIdAdmin(string $idAdmin): self
    {
        $this->idAdmin = $idAdmin;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of createdAt
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}