<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recording
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Recording
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
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;
    
    // ...
    /**
     * @ORM\ManyToMany(targetEntity="Song", mappedBy="recordings")
     **/
    private $songs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="recordingEarliest", type="date")
     */
    private $recordingEarliest;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="recordingLatest", type="date")
     */
    private $recordingLatest;
    
    /**
     * @ORM\ManyToMany(targetEntity="Person")
     * @ORM\JoinTable(name="recordings_persons",
     *      joinColumns={@ORM\JoinColumn(name="recording_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")}
     *      )
     **/
    private $persons;
    
    /**
     * @ORM\ManyToMany(targetEntity="Publication")
     * @ORM\JoinTable(name="recordings_publications",
     *      joinColumns={@ORM\JoinColumn(name="recording_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="publication_id", referencedColumnName="id")}
     *      )
     **/
    private $publications;

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
     * Set recordingEarliest
     *
     * @param \DateTime $recordingEarliest
     * @return Recording
     */
    public function setRecordingEarliest($recordingEarliest)
    {
        $this->recordingEarliest = $recordingEarliest;

        return $this;
    }

    /**
     * Get recordingEarliest
     *
     * @return \DateTime 
     */
    public function getRecordingEarliest()
    {
        return $this->recordingEarliest;
    }

    /**
     * Set recordingLatest
     *
     * @param \DateTime $recordingLatest
     * @return Recording
     */
    public function setRecordingLatest($recordingLatest)
    {
        $this->recordingLatest = $recordingLatest;

        return $this;
    }

    /**
     * Get recordingLatest
     *
     * @return \DateTime 
     */
    public function getRecordingLatest()
    {
        return $this->recordingLatest;
    }

    /**
     * Add publications
     *
     * @param \AppBundle\Entity\Publication $publications
     * @return Recording
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
     * Constructor
     */
    public function __construct()
    {
        $this->persons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->publications = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add persons
     *
     * @param \AppBundle\Entity\Person $persons
     * @return Recording
     */
    public function addPerson(\AppBundle\Entity\Person $persons)
    {
        $this->persons[] = $persons;

        return $this;
    }

    /**
     * Remove persons
     *
     * @param \AppBundle\Entity\Person $persons
     */
    public function removePerson(\AppBundle\Entity\Person $persons)
    {
        $this->persons->removeElement($persons);
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
    
    public function __toString()
	{
		if ($this->recordingEarliest) {
			return $this->title . ' (' . $this->recordingEarliest->format('Y') . ')';
		} else {
			return $this->title;
		}
	}

    /**
     * Add songs
     *
     * @param \AppBundle\Entity\Song $songs
     * @return Recording
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

    /**
     * Set title
     *
     * @param string $title
     * @return Recording
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
}
