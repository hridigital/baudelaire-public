<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Song
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Song
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
     * @ORM\JoinTable(name="songs_publications",
     *      joinColumns={@ORM\JoinColumn(name="song_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="publication_id", referencedColumnName="id")}
     *      )
     **/
    private $publications;
    
    /**
     * @ORM\ManyToMany(targetEntity="Recording", inversedBy="songs")
     * @ORM\JoinTable(name="songs_recordings")
     **/
    private $recordings;
    
     /**
     * @ORM\ManyToMany(targetEntity="Person")
     * @ORM\JoinTable(name="songs_people",
     *      joinColumns={@ORM\JoinColumn(name="song_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")}
     *      )
     **/
    private $persons;
    
   /**
     * @ORM\ManyToOne(targetEntity="Tonality")
     * @ORM\JoinColumn(name="tonality_id", referencedColumnName="id")
     **/
    private $tonality;
    
    /**
     * @ORM\ManyToMany(targetEntity="Scoring")
     * @ORM\JoinTable(name="songs_scorings",
     *      joinColumns={@ORM\JoinColumn(name="song_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="scoring_id", referencedColumnName="id")}
     *      )
     **/
    private $scorings;
    
    /**
     * @ORM\ManyToOne(targetEntity="Tessitura")
     * @ORM\JoinColumn(name="tessitura_id", referencedColumnName="id")
     **/
    private $tessitura;
    
     /**
     * @ORM\ManyToMany(targetEntity="Lang")
     * @ORM\JoinTable(name="songs_langs",
     *      joinColumns={@ORM\JoinColumn(name="song_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="lang_id", referencedColumnName="id")}
     *      )
     **/
    private $langs;
    
    /**
     * @ORM\ManyToMany(targetEntity="Repository")
     * @ORM\JoinTable(name="songs_repositorys",
     *      joinColumns={@ORM\JoinColumn(name="song_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="repository_id", referencedColumnName="id")}
     *      )
     **/
    private $repositorys;
    
    // ...
    /**
     * @ORM\ManyToMany(targetEntity="Poem", mappedBy="songs")
     **/
    private $poems;
    
    /**
     * @var string
     *
     * @ORM\Column(name="premiere", type="text", nullable=true)
     */
    private $premiere;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->publications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recordings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->persons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->scorings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->langs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->repositorys = new \Doctrine\Common\Collections\ArrayCollection();
        $this->poems = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     *
     * @return Song
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
     *
     * @return Song
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
     *
     * @return Song
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
     * Set premiere
     *
     * @param string $premiere
     *
     * @return Song
     */
    public function setPremiere($premiere)
    {
        $this->premiere = $premiere;

        return $this;
    }

    /**
     * Get premiere
     *
     * @return string
     */
    public function getPremiere()
    {
        return $this->premiere;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Song
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
     * Add publication
     *
     * @param \AppBundle\Entity\Publication $publication
     *
     * @return Song
     */
    public function addPublication(\AppBundle\Entity\Publication $publication)
    {
        $this->publications[] = $publication;

        return $this;
    }

    /**
     * Remove publication
     *
     * @param \AppBundle\Entity\Publication $publication
     */
    public function removePublication(\AppBundle\Entity\Publication $publication)
    {
        $this->publications->removeElement($publication);
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
     * Add recording
     *
     * @param \AppBundle\Entity\Recording $recording
     *
     * @return Song
     */
    public function addRecording(\AppBundle\Entity\Recording $recording)
    {
        $this->recordings[] = $recording;

        return $this;
    }

    /**
     * Remove recording
     *
     * @param \AppBundle\Entity\Recording $recording
     */
    public function removeRecording(\AppBundle\Entity\Recording $recording)
    {
        $this->recordings->removeElement($recording);
    }

    /**
     * Get recordings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecordings()
    {
        return $this->recordings;
    }

    /**
     * Add person
     *
     * @param \AppBundle\Entity\Person $person
     *
     * @return Song
     */
    public function addPerson(\AppBundle\Entity\Person $person)
    {
        $this->persons[] = $person;

        return $this;
    }

    /**
     * Remove person
     *
     * @param \AppBundle\Entity\Person $person
     */
    public function removePerson(\AppBundle\Entity\Person $person)
    {
        $this->persons->removeElement($person);
    }

    /**
     * Get persons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersons()
    {
        return $this->persons;
    }

    /**
     * Set tonality
     *
     * @param \AppBundle\Entity\Tonality $tonality
     *
     * @return Song
     */
    public function setTonality(\AppBundle\Entity\Tonality $tonality = null)
    {
        $this->tonality = $tonality;

        return $this;
    }

    /**
     * Get tonality
     *
     * @return \AppBundle\Entity\Tonality
     */
    public function getTonality()
    {
        return $this->tonality;
    }

    /**
     * Add scoring
     *
     * @param \AppBundle\Entity\Scoring $scoring
     *
     * @return Song
     */
    public function addScoring(\AppBundle\Entity\Scoring $scoring)
    {
        $this->scorings[] = $scoring;

        return $this;
    }

    /**
     * Remove scoring
     *
     * @param \AppBundle\Entity\Scoring $scoring
     */
    public function removeScoring(\AppBundle\Entity\Scoring $scoring)
    {
        $this->scorings->removeElement($scoring);
    }

    /**
     * Get scorings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getScorings()
    {
        return $this->scorings;
    }

    /**
     * Set tessitura
     *
     * @param \AppBundle\Entity\Tessitura $tessitura
     *
     * @return Song
     */
    public function setTessitura(\AppBundle\Entity\Tessitura $tessitura = null)
    {
        $this->tessitura = $tessitura;

        return $this;
    }

    /**
     * Get tessitura
     *
     * @return \AppBundle\Entity\Tessitura
     */
    public function getTessitura()
    {
        return $this->tessitura;
    }

    /**
     * Add lang
     *
     * @param \AppBundle\Entity\Lang $lang
     *
     * @return Song
     */
    public function addLang(\AppBundle\Entity\Lang $lang)
    {
        $this->langs[] = $lang;

        return $this;
    }

    /**
     * Remove lang
     *
     * @param \AppBundle\Entity\Lang $lang
     */
    public function removeLang(\AppBundle\Entity\Lang $lang)
    {
        $this->langs->removeElement($lang);
    }

    /**
     * Get langs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLangs()
    {
        return $this->langs;
    }

    /**
     * Add repository
     *
     * @param \AppBundle\Entity\Repository $repository
     *
     * @return Song
     */
    public function addRepository(\AppBundle\Entity\Repository $repository)
    {
        $this->repositorys[] = $repository;

        return $this;
    }

    /**
     * Remove repository
     *
     * @param \AppBundle\Entity\Repository $repository
     */
    public function removeRepository(\AppBundle\Entity\Repository $repository)
    {
        $this->repositorys->removeElement($repository);
    }

    /**
     * Get repositorys
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRepositorys()
    {
        return $this->repositorys;
    }

    /**
     * Add poem
     *
     * @param \AppBundle\Entity\Poem $poem
     *
     * @return Song
     */
    public function addPoem(\AppBundle\Entity\Poem $poem)
    {
        $this->poems[] = $poem;
	$poem->addSong($this);
        return $this;
    }

    /**
     * Remove poem
     *
     * @param \AppBundle\Entity\Poem $poem
     */
    public function removePoem(\AppBundle\Entity\Poem $poem)
    {
        $this->poems->removeElement($poem);
    }

    /**
     * Get poems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPoems()
    {
        return $this->poems;
    }
}
