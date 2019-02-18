<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PrePersist;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticlesRepository")
 */
class Articles
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
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $introduction;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $coverImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paragraphe1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paragraphe2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image3;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paragraphe3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image4;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paragraphe4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image5;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paragraphe5;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image6;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paragraphe6;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image7;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paragraphe7;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image8;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paragraphe8;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image9;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paragraphe9;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image10;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paragraphe10;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getImage1(): ?string
    {
        return $this->image1;
    }

    public function setImage1(?string $image1): self
    {
        $this->image1 = $image1;

        return $this;
    }

    public function getParagraphe1(): ?string
    {
        return $this->paragraphe1;
    }

    public function setParagraphe1(?string $paragraphe1): self
    {
        $this->paragraphe1 = $paragraphe1;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image2;
    }

    public function setImage2(?string $image2): self
    {
        $this->image2 = $image2;

        return $this;
    }

    public function getParagraphe2(): ?string
    {
        return $this->paragraphe2;
    }

    public function setParagraphe2(?string $paragraphe2): self
    {
        $this->paragraphe2 = $paragraphe2;

        return $this;
    }

    public function getImage3(): ?string
    {
        return $this->image3;
    }

    public function setImage3(?string $image3): self
    {
        $this->image3 = $image3;

        return $this;
    }

    public function getParagraphe3(): ?string
    {
        return $this->paragraphe3;
    }

    public function setParagraphe3(?string $paragraphe3): self
    {
        $this->paragraphe3 = $paragraphe3;

        return $this;
    }

    public function getImage4(): ?string
    {
        return $this->image4;
    }

    public function setImage4(?string $image4): self
    {
        $this->image4 = $image4;

        return $this;
    }

    public function getParagraphe4(): ?string
    {
        return $this->paragraphe4;
    }

    public function setParagraphe4(?string $paragraphe4): self
    {
        $this->paragraphe4 = $paragraphe4;

        return $this;
    }

    public function getImage5(): ?string
    {
        return $this->image5;
    }

    public function setImage5(?string $image5): self
    {
        $this->image5 = $image5;

        return $this;
    }

    public function getParagraphe5(): ?string
    {
        return $this->paragraphe5;
    }

    public function setParagraphe5(?string $paragraphe5): self
    {
        $this->paragraphe5 = $paragraphe5;

        return $this;
    }

    public function getImage6(): ?string
    {
        return $this->image6;
    }

    public function setImage6(?string $image6): self
    {
        $this->image6 = $image6;

        return $this;
    }

    public function getParagraphe6(): ?string
    {
        return $this->paragraphe6;
    }

    public function setParagraphe6(?string $paragraphe6): self
    {
        $this->paragraphe6 = $paragraphe6;

        return $this;
    }

    public function getImage7(): ?string
    {
        return $this->image7;
    }

    public function setImage7(?string $image7): self
    {
        $this->image7 = $image7;

        return $this;
    }

    public function getParagraphe7(): ?string
    {
        return $this->paragraphe7;
    }

    public function setParagraphe7(?string $paragraphe7): self
    {
        $this->paragraphe7 = $paragraphe7;

        return $this;
    }

    public function getImage8(): ?string
    {
        return $this->image8;
    }

    public function setImage8(?string $image8): self
    {
        $this->image8 = $image8;

        return $this;
    }

    public function getParagraphe8(): ?string
    {
        return $this->paragraphe8;
    }

    public function setParagraphe8(?string $paragraphe8): self
    {
        $this->paragraphe8 = $paragraphe8;

        return $this;
    }

    public function getImage9(): ?string
    {
        return $this->image9;
    }

    public function setImage9(?string $image9): self
    {
        $this->image9 = $image9;

        return $this;
    }

    public function getParagraphe9(): ?string
    {
        return $this->paragraphe9;
    }

    public function setParagraphe9(?string $paragraphe9): self
    {
        $this->paragraphe9 = $paragraphe9;

        return $this;
    }

    public function getImage10(): ?string
    {
        return $this->image10;
    }

    public function setImage10(?string $image10): self
    {
        $this->image10 = $image10;

        return $this;
    }

    public function getParagraphe10(): ?string
    {
        return $this->paragraphe10;
    }

    public function setParagraphe10(?string $paragraphe10): self
    {
        $this->paragraphe10 = $paragraphe10;

        return $this;
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
        $this->slug = $slugify->slugify("id" . " ". $this->id . " " . "le" . "musée" . " " . $this->marque . " " . $this->modele . " " . $this->carburant . " " . "année" . " " . $this->annee . " " . "prix" . " " . $this->prix . "euros" . " " . "ttc");
    }
    
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
