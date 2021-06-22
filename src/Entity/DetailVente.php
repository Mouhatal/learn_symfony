<?php

namespace App\Entity;

use App\Repository\DetailVenteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetailVenteRepository::class)
 * @ORM\Table(name="detail_ventes")
 */
class DetailVente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="float")
     */
    private $pu;

    /**
     * @ORM\ManyToOne(targetEntity=Facture::class, inversedBy="detail_ventes")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $facture;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class)
     */
    protected $produit;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getPu(): ?float
    {
        return $this->pu;
    }

    public function setPu(float $pu): self
    {
        $this->pu = $pu;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}
