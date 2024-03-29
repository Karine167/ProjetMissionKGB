<?php

namespace App\Entity;

class TypeHideout 
{
    private ?int $id = null;
    private ?string $typeHide = '';

    

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
     * Get the value of typeHide
     */
    public function getTypeHide(): ?string
    {
        return $this->typeHide;
    }

    /**
     * Set the value of typeHide
     */
    public function setTypeHide(?string $typeHide): self
    {
        $this->typeHide = $typeHide;

        return $this;
    }
}