<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PrePersist;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoitureRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 * fields={"marque","modele","annee","carburant","etat","prix"},
 * message="Une autre voiture possède déjà exactement les mẽmes attributs marque,modele,annee,
 * carburant,etat,prix. Vérifiez si la voiture n'est pas déjà entrée en base de donnée")
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
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $marque;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $introduction;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $coverImage;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $modele;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $annee;

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
    private $numeroSerie;

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
     * @Assert\NotBlank
     */
    private $carburant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $kilometrage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleurCarrosserie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $couleurInterieur;

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
    private $moteurEtCylindree;

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
     * @Assert\NotBlank
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="voiture", orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    private $prix;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

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
        $slugify = new Slugify();
        $this->slug = $slugify->slugify(" ".$this->id." "."le"."musée"." ".$this->marque." ".$this->modele." ".$this->carburant." "."année"." ".$this->annee." "."prix"." ".$this->prix."euros"." "."ttc");
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

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

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

    public function getNumeroSerie(): ?string
    {
        return $this->numeroSerie;
    }

    public function setNumeroSerie(?string $numeroSerie): self
    {
        $this->numeroSerie = $numeroSerie;

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

    public function getKilometrage(): ?string
    {
        return $this->kilometrage;
    }

    public function setKilometrage(?string $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

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

    public function getCouleurInterieur(): ?string
    {
        return $this->couleurInterieur;
    }

    public function setCouleurInterieur(?string $couleurInterieur): self
    {
        $this->couleurInterieur = $couleurInterieur;

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

    public function getMoteurEtCylindree(): ?string
    {
        return $this->moteurEtCylindree;
    }

    public function setMoteurEtCylindree(?string $moteurEtCylindree): self
    {
        $this->moteurEtCylindree = $moteurEtCylindree;

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

    public function getetat(): ?string
    {
        return $this->etat;
    }

    public function setetat(?string $etat): self
    {
        $this->etat = $etat;

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

    public function getCoverImage()
    {
        return $this->coverImage;
    }

    public function setCoverImage($coverImage): self
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

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImages(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setVoiture($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getVoiture() === $this) {
                $image->setVoiture(null);
            }
        }

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
