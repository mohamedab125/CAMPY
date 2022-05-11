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


}
