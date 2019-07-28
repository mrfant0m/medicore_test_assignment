<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transport
 *
 * @ORM\Table(name="transport")
 * @ORM\Entity
 */
class Transport
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=25, nullable=false, options={"comment"="Transport"})
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="compensation", type="float", precision=2, scale=2, nullable=false, options={"comment"="Compensation per km"})
     */
    private $compensation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCompensation(): ?float
    {
        return $this->compensation;
    }

    public function setCompensation(float $compensation): self
    {
        $this->compensation = $compensation;

        return $this;
    }

    public function __toString() {
        return $this->name;
    }

}
