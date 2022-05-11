<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier")
 * @ORM\Entity
 */
class Panier
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_Panier", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPanier;

    /**
     * @var int
     *
     * @ORM\Column(name="ID_Materiel", type="integer", nullable=false)
     */
    private $idMateriel;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixTotale", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixtotale;

    public function getIdPanier(): ?int
    {
        return $this->idPanier;
    }

    public function getIdMateriel(): ?int
    {
        return $this->idMateriel;
    }

    public function setIdMateriel(int $idMateriel): self
    {
        $this->idMateriel = $idMateriel;

        return $this;
    }

    public function getPrixtotale(): ?float
    {
        return $this->prixtotale;
    }

    public function setPrixtotale(float $prixtotale): self
    {
        $this->prixtotale = $prixtotale;

        return $this;
    }


}
