<?php

namespace App\Entity;

use DateTime;

class Mission
{
    protected ?int $id = null;
    protected ?string $title = '';
    protected ?string $description = '';
    protected ?string $codeName = '';
    protected ?DateTime $beginDate = null;
    protected ?DateTime $endDate = null;
    protected ?int $idCountry = null;
    protected ?int $idStatus = null;
    protected ?int $idTypeMission = null;
    protected ?int $idSpeciality = null;

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
     * Get the value of title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
     * Get the value of beginDate
     */
    public function getBeginDate(): DateTime | null
    {
        return $this->beginDate;
    }

    /**
     * Set the value of beginDate
     */
    public function setBeginDate(?DateTime $beginDate = null ): self
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    /**
     * Get the value of endDate
     */
    public function getEndDate(): DateTime | null
    {
        return $this->endDate;
    }

    /**
     * Set the value of endDate
     */
    public function setEndDate(?DateTime $endDate = null): self
    {
        $this->endDate = $endDate;

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
     * Get the value of idStatus
     */
    public function getIdStatus(): ?int
    {
        return $this->idStatus;
    }

    /**
     * Set the value of idStatus
     */
    public function setIdStatus(?int $idStatus): self
    {
        $this->idStatus = $idStatus;

        return $this;
    }

    /**
     * Get the value of idTypeMission
     */
    public function getIdTypeMission(): ?int
    {
        return $this->idTypeMission;
    }

    /**
     * Set the value of idTypeMission
     */
    public function setIdTypeMission(?int $idTypeMission): self
    {
        $this->idTypeMission = $idTypeMission;

        return $this;
    }

    /**
     * Get the value of idSpeciality
     */
    public function getIdSpeciality(): ?int
    {
        return $this->idSpeciality;
    }

    /**
     * Set the value of idSpeciality
     */
    public function setIdSpeciality(?int $idSpeciality): self
    {
        $this->idSpeciality = $idSpeciality;

        return $this;
    }
}