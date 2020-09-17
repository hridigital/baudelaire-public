<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Poem
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Poem
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="english", type="string", length=255)
     */
    private $english;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="compositionEarliest", type="date")
     */
    private $compositionEarliest;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="compositionLatest", type="date")
     */
    private $compositionLatest;
    
    /**
     * @ORM\ManyToMany(targetEntity="Publication")
     * @ORM\JoinTable(name="poems_publications",
     *      joinColumns={@ORM\JoinColumn(name="poem_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="publication_id", referencedColumnName="id")}
     *      )
     **/
    private $publications;

    /**
     * @ORM\ManyToMany(targetEntity="Metre")
     * @ORM\JoinTable(name="poems_metres",
     *      joinColumns={@ORM\JoinColumn(name="poem_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="metre_id", referencedColumnName="id")}
     *      )
     **/
    private $metres;
    
    /**
     * @ORM\ManyToOne(targetEntity="Form")
     * @ORM\JoinColumn(name="form_id", referencedColumnName="id")
     **/
    private $form;
    
    /**
     * @ORM\ManyToOne(targetEntity="Rhyme")
     * @ORM\JoinColumn(name="rhyme_id", referencedColumnName="id")
     **/
    private $rhyme;
    
    /**
     * @ORM\ManyToMany(targetEntity="Theme")
     * @ORM\JoinTable(name="poems_themes",
     *      joinColumns={@ORM\JoinColumn(name="poem_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="theme_id", referencedColumnName="id")}
     *      )
     **/
    private $themes;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

	/**
     * @ORM\ManyToMany(targetEntity="Song", inversedBy="poems")
     * @ORM\JoinTable(name="poems_songs")
     **/
    private $songs;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Poem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set compositionEarliest
     *
     * @param \DateTime $compositionEarliest
     * @return Poem
     */
    public function setCompositionEarliest($compositionEarliest)
    {
        $this->compositionEarliest = $compositionEarliest;

        return $this;
    }

    /**
     * Get compositionEarliest
     *
     * @return \DateTime 
     */
    public function getCompositionEarliest()
    {
        return $this->compositionEarliest;
    }

    /**
     * Set compositionLatest
     *
     * @param \DateTime $compositionLatest
     * @return Poem
     */
    public function setCompositionLatest($compositionLatest)
    {
        $this->compositionLatest = $compositionLatest;

        return $this;
    }

    /**
     * Get compositionLatest
     *
     * @return \DateTime 
     */
    public function getCompositionLatest()
    {
        return $this->compositionLatest;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Poem
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }


    /**
     * Set form
     *
     * @param \AppBundle\Entity\Form $form
     * @return Poem
     */
    public function setForm(\AppBundle\Entity\Form $form = null)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form
     *
     * @return \AppBundle\Entity\Form 
     */
    public function getForm()
    {
        return $this->form;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->themes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add themes
     *
     * @param \AppBundle\Entity\Theme $themes
     * @return Poem
     */
    public function addTheme(\AppBundle\Entity\Theme $themes)
    {
        $this->themes[] = $themes;

        return $this;
    }

    /**
     * Remove themes
     *
     * @param \AppBundle\Entity\Theme $themes
     */
    public function removeTheme(\AppBundle\Entity\Theme $themes)
    {
        $this->themes->removeElement($themes);
    }

    /**
     * Get themes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * Add publications
     *
     * @param \AppBundle\Entity\Publication $publications
     * @return Poem
     */
    public function addPublication(\AppBundle\Entity\Publication $publications)
    {
        $this->publications[] = $publications;

        return $this;
    }

    /**
     * Remove publications
     *
     * @param \AppBundle\Entity\Publication $publications
     */
    public function removePublication(\AppBundle\Entity\Publication $publications)
    {
        $this->publications->removeElement($publications);
    }

    /**
     * Get publications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPublications()
    {
        return $this->publications;
    }

    /**
     * Set rhyme
     *
     * @param \AppBundle\Entity\Rhyme $rhyme
     * @return Poem
     */
    public function setRhyme(\AppBundle\Entity\Rhyme $rhyme = null)
    {
        $this->rhyme = $rhyme;

        return $this;
    }

    /**
     * Get rhyme
     *
     * @return \AppBundle\Entity\Rhyme 
     */
    public function getRhyme()
    {
        return $this->rhyme;
    }

    /**
     * Add songs
     *
     * @param \AppBundle\Entity\Song $songs
     * @return Poem
     */
    public function addSong(\AppBundle\Entity\Song $songs)
    {
        $this->songs[] = $songs;

        return $this;
    }

    /**
     * Remove songs
     *
     * @param \AppBundle\Entity\Song $songs
     */
    public function removeSong(\AppBundle\Entity\Song $songs)
    {
        $this->songs->removeElement($songs);
    }

    /**
     * Get songs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSongs()
    {
        return $this->songs;
    }
    
    public function __toString()
	{
		return (string) $this->title;
	}

    /**
     * Add metres
     *
     * @param \AppBundle\Entity\Metre $metres
     * @return Poem
     */
    public function addMetre(\AppBundle\Entity\Metre $metres)
    {
        $this->metres[] = $metres;

        return $this;
    }

    /**
     * Remove metres
     *
     * @param \AppBundle\Entity\Metre $metres
     */
    public function removeMetre(\AppBundle\Entity\Metre $metres)
    {
        $this->metres->removeElement($metres);
    }

    /**
     * Get metres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMetres()
    {
        return $this->metres;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Poem
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set english
     *
     * @param string $english
     * @return Poem
     */
    public function setEnglish($english)
    {
        $this->english = $english;

        return $this;
    }

    /**
     * Get english
     *
     * @return string 
     */
    public function getEnglish()
    {
        return $this->english;
    }
}
