<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PrePersist;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticlesRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 * fields={"titre","introduction"},
 * message="Un article possède déjà le même titre et le même contenu, vérifiez qu'il n'existe pas déjà dans votre base de données !")
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

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaires", mappedBy="article", orphanRemoval=true)
     */
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
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
        $this->slug = $slugify->slugify($this->id." ".$this->titre);
    }

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

    public function getCoverImage()
    {
        return $this->coverImage;
    }

    public function setCoverImage($coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getImage1()
    {
        return $this->image1;
    }

    public function setImage1($image1): self
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

    public function getImage2()
    {
        return $this->image2;
    }

    public function setImage2($image2): self
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

    public function getImage3()
    {
        return $this->image3;
    }

    public function setImage3($image3): self
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

    public function getImage4()
    {
        return $this->image4;
    }

    public function setImage4($image4): self
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

    public function getImage5()
    {
        return $this->image5;
    }

    public function setImage5($image5): self
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

    public function getImage6()
    {
        return $this->image6;
    }

    public function setImage6($image6): self
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

    public function getImage7()
    {
        return $this->image7;
    }

    public function setImage7($image7): self
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

    public function getImage8()
    {
        return $this->image8;
    }

    public function setImage8($image8): self
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

    public function getImage9()
    {
        return $this->image9;
    }

    public function setImage9($image9): self
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

    public function getImage10()
    {
        return $this->image10;
    }

    public function setImage10($image10): self
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
    
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Commentaires[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setArticle($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getArticle() === $this) {
                $commentaire->setArticle(null);
            }
        }

        return $this;
    }
}
