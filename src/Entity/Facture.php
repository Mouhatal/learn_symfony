<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $montant;

    /**
     * @ORM\Column(type="string")
     */
    private $client;

    /**
     * @ORM\Column(type="string")
     */
    private $numClient;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateFacture;

    // /**
    //  * @ORM\ManyToMany(targetEntity=Produit::class, inversedBy="factures")
    //  * @ORM\JoinTable(name="detail_ventes")
    //  */
    // protected $produits;

    public function __construct()
    {
        // $this->produits = new ArrayCollection();
        // $this->participations = new ArrayCollection();
        $this->detailVente = new ArrayCollection();
    }

    /**
     * @ORM\OneToMany(targetEntity=DetailVente::class, mappedBy="facture")
     */
    protected $detailVente;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PriseService", inversedBy="factures")
     */
    private $priseService;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateFacture(): ?\DateTimeInterface
    {
        return $this->dateFacture;
    }

    public function setDateFacture(\DateTimeInterface $dateFacture): self
    {
        $this->dateFacture = $dateFacture;

        return $this;
    }


    /**
     * @return Collection|DetailVente[]
     */
    public function getDetailVente(): Collection
    {
        return $this->detailVente;
    }

    public function addDetailVente(DetailVente $detailVente): self
    {
        if (!$this->detailVente->contains($detailVente)) {
            $this->detailVente[] = $detailVente;
            $detailVente->setFacture($this);
        }

        return $this;
    }

    public function removeDetailVente(DetailVente $detailVente): self
    {
        if ($this->detailVente->removeElement($detailVente)) {
            // set the owning side to null (unless already changed)
            if ($detailVente->getFacture() === $this) {
                $detailVente->setFacture(null);
            }
        }

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getNumClient(): ?string
    {
        return $this->numClient;
    }

    public function setNumClient(string $numClient): self
    {
        $this->numClient = $numClient;

        return $this;
    }

    public function getPriseService(): ?PriseService
    {
        return $this->priseService;
    }

    public function setPriseService(?PriseService $priseService): self
    {
        $this->priseService = $priseService;

        return $this;
    }
}
