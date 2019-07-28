<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employees
 *
 * @ORM\Table(name="employees", indexes={@ORM\Index(name="transport_id", columns={"transport_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\EmployeesRepository")
 *
 */
class Employees
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="employee", type="string", length=50, nullable=false, options={"comment"="Employee"})
     */
    private $employee;

    /**
     * @var int|null
     *
     * @ORM\Column(name="distance", type="integer", nullable=false, options={"unsigned"=true,"comment"="Distance (km/one way)"})
     */
    private $distance;

    /**
     * @var float|null
     *
     * @ORM\Column(name="workdays", type="float", precision=11, scale=2, nullable=false, options={"comment"="Workdays per week"})
     */
    private $workdays;

    /**
     * @var \Transport
     *
     * @ORM\ManyToOne(targetEntity="Transport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transport_id", referencedColumnName="id")
     * })
     */
    private $transport;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployee(): ?string
    {
        return $this->employee;
    }

    public function setEmployee(?string $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(?int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getWorkdays(): ?float
    {
        return $this->workdays;
    }

    public function setWorkdays(?float $workdays): self
    {
        $this->workdays = $workdays;

        return $this;
    }

    public function getTransport(): ?Transport
    {
        return $this->transport;
    }

    public function setTransport(?Transport $transport): self
    {
        $this->transport = $transport;

        return $this;
    }


}
