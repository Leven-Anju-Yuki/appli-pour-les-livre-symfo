<?php
namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    // ID unique de chaque livre
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Titre du livre (obligatoire)
    #[ORM\Column(length: 40)]
    private ?string $titre = null;

    // Catégorie du livre (obligatoire)
    #[ORM\Column(length: 40)]
    private ?string $categorie = null;

    // Prix du livre (optionnel, peut être null)
    #[ORM\Column(type: "float", nullable: true)]
    private ?float $prix = null;
    // Tome du livre (optionnel, peut être null)
    #[ORM\Column(type: "float", nullable: true)]
    private ?float $tome = null;

    // Auteur du livre (optionnel, peut être null)
    #[ORM\Column(length: 40, nullable: true)]
    private ?string $auteur = null;

    // URL de l'image du livre (optionnel, peut être null)
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    // Relation ManyToOne, ici, la relation est définie pour une autre entité Livre
    #[ORM\ManyToOne(targetEntity: Livre::class)]
    #[ORM\JoinColumn(nullable: false)]
    
    // Méthode pour obtenir l'ID du livre
    public function getId(): ?int
    {
        return $this->id;
    }

    // Méthode pour obtenir le titre du livre
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    // Méthode pour définir le titre du livre
    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    // Méthode pour obtenir la catégorie du livre
    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    // Méthode pour définir la catégorie du livre
    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    // Méthode pour obtenir le prix du livre
    public function getTome(): ?float
    {
        return $this->prix;
    }

    // Méthode pour définir le tome du livre (optionnel)
    public function setTome(?float $tome): self
    {
        $this->tome = $tome;
        return $this;
    }
    // Méthode pour obtenir le prix du livre
    public function getPrix(): ?float
    {
        return $this->tome;
    }

    // Méthode pour définir le prix du livre (optionnel)
    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    // Méthode pour obtenir l'auteur du livre
    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    // Méthode pour définir l'auteur du livre (optionnel)
    public function setAuteur(?string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    // Méthode pour obtenir l'URL de l'image du livre
    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    // Méthode pour définir l'URL de l'image du livre (optionnel)
    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }
}
