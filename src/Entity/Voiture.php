<?php
namespace App\Entity;

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoitureRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Voiture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque;

    /**
     * @ORM\Column(type="text")
     */
    private $introduction;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $coverImage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modèle;

    /**
     * @ORM\Column(type="integer")
     */
    private $année;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numéroSérie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $longueur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $largeur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hauteur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $poidsAVide;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $carburant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $kilomètrage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleurCarrosserie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleurIntérieur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $puissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $origine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $boiteDeVitesse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $moteurEtCylindrée;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CvFiscaux;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $conduite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nombreDePlace;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $carrosserie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $état;

    /**
     * Permet d'initialiser le slug
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initializeSlug()
    {
        if(empty($this->slug))
        {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->marque." ".$this->modèle." ".$this->type." ".$this->carburant." ".$this->année);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModèle(): ?string
    {
        return $this->modèle;
    }

    public function setModèle(string $modèle): self
    {
        $this->modèle = $modèle;

        return $this;
    }

    public function getAnnée(): ?int
    {
        return $this->année;
    }

    public function setAnnée(int $année): self
    {
        $this->année = $année;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNuméroSérie(): ?string
    {
        return $this->numéroSérie;
    }

    public function setNuméroSérie(?string $numéroSérie): self
    {
        $this->numéroSérie = $numéroSérie;

        return $this;
    }

    public function getLongueur(): ?string
    {
        return $this->longueur;
    }

    public function setLongueur(?string $longueur): self
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getLargeur(): ?string
    {
        return $this->largeur;
    }

    public function setLargeur(?string $largeur): self
    {
        $this->largeur = $largeur;

        return $this;
    }

    public function getHauteur(): ?string
    {
        return $this->hauteur;
    }

    public function setHauteur(?string $hauteur): self
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getPoidsAVide(): ?string
    {
        return $this->poidsAVide;
    }

    public function setPoidsAVide(?string $poidsAVide): self
    {
        $this->poidsAVide = $poidsAVide;

        return $this;
    }

    public function getCarburant(): ?string
    {
        return $this->carburant;
    }

    public function setCarburant(string $carburant): self
    {
        $this->carburant = $carburant;

        return $this;
    }

    public function getKilomètrage(): ?string
    {
        return $this->kilomètrage;
    }

    public function setKilomètrage(?string $kilomètrage): self
    {
        $this->kilomètrage = $kilomètrage;

        return $this;
    }

    public function getCouleurCarrosserie(): ?string
    {
        return $this->couleurCarrosserie;
    }

    public function setCouleurCarrosserie(?string $couleurCarrosserie): self
    {
        $this->couleurCarrosserie = $couleurCarrosserie;

        return $this;
    }

    public function getCouleurIntérieur(): ?string
    {
        return $this->couleurIntérieur;
    }

    public function setCouleurIntérieur(?string $couleurIntérieur): self
    {
        $this->couleurIntérieur = $couleurIntérieur;

        return $this;
    }

    public function getPuissance(): ?string
    {
        return $this->puissance;
    }

    public function setPuissance(?string $puissance): self
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getOrigine(): ?string
    {
        return $this->origine;
    }

    public function setOrigine(?string $origine): self
    {
        $this->origine = $origine;

        return $this;
    }

    public function getBoiteDeVitesse(): ?string
    {
        return $this->boiteDeVitesse;
    }

    public function setBoiteDeVitesse(?string $boiteDeVitesse): self
    {
        $this->boiteDeVitesse = $boiteDeVitesse;

        return $this;
    }

    public function getMoteurEtCylindrée(): ?string
    {
        return $this->moteurEtCylindrée;
    }

    public function setMoteurEtCylindrée(?string $moteurEtCylindrée): self
    {
        $this->moteurEtCylindrée = $moteurEtCylindrée;

        return $this;
    }

    public function getCvFiscaux(): ?string
    {
        return $this->CvFiscaux;
    }

    public function setCvFiscaux(?string $CvFiscaux): self
    {
        $this->CvFiscaux = $CvFiscaux;

        return $this;
    }

    public function getConduite(): ?string
    {
        return $this->conduite;
    }

    public function setConduite(?string $conduite): self
    {
        $this->conduite = $conduite;

        return $this;
    }

    public function getNombreDePlace(): ?string
    {
        return $this->nombreDePlace;
    }

    public function setNombreDePlace(?string $nombreDePlace): self
    {
        $this->nombreDePlace = $nombreDePlace;

        return $this;
    }

    public function getCarrosserie(): ?string
    {
        return $this->carrosserie;
    }

    public function setCarrosserie(?string $carrosserie): self
    {
        $this->carrosserie = $carrosserie;

        return $this;
    }

    public function getétat(): ?string
    {
        return $this->état;
    }

    public function setétat(?string $état): self
    {
        $this->état = $état;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(?string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(?string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
