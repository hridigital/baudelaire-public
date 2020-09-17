<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
	 * @var \DateTime
	 *
	 * @ORM\Column(name="releaseDate", type="date", nullable=true)
	 */
	private $releaseDate;

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
	 * @ORM\ManyToMany(targetEntity="Person", inversedBy="songs")
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
	 * @ORM\ManyToMany(targetEntity="Genre")
	 * @ORM\JoinTable(name="songs_genres",
	 *      joinColumns={@ORM\JoinColumn(name="song_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id")}
	 *      )
	 **/
	private $genres;

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

	/**
	 * @var string
	 *
	 * @ORM\Column(name="catalogue_link", type="string", length=255, nullable=true)
	 */
	private $catalogueLink;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="spotify_link", type="string", length=255, nullable=true)
	 */
	private $spotifyLink;

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
		$this->genres = new \Doctrine\Common\Collections\ArrayCollection();
		$this->langs = new \Doctrine\Common\Collections\ArrayCollection();
		$this->repositorys = new \Doctrine\Common\Collections\ArrayCollection();
		$this->poems = new \Doctrine\Common\Collections\ArrayCollection();
	}

	public function getDatingString() {

		$ret = "";

		if ($this->compositionEarliest && $this->compositionLatest) {

			$earliestYear = $this->compositionEarliest->format("Y");
			$latestYear = $this->compositionLatest->format("Y");
			/*$releaseYear = $this->releaseDate->format("Y");*/

			if ($earliestYear > 1821) {

				if ($earliestYear == $latestYear) {

					$ret = $ret."Composed in ".$earliestYear.". ";

				} else {

					$ret = $ret."Composed between ".$earliestYear." and ".$latestYear.". ";

				}

			}

			/*
			if ($releaseYear > 1821) {

				$ret = $ret."Released in ".$earliestYear.". ";

			}
			 */

		}

		return $ret;

	}

	public function __toString()
	{
		$ret = $this->title.". ";
		$persons = $this->getPersons();

		foreach ($persons as $person) {
			$ret = $ret.$person.", ";
		}

		$ret = $ret.$this->getDatingString();

		return (string) $ret;
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
	 * Set releaseDate
	 *
	 * @param \DateTime $releaseDate
	 *
	 * @return Song
	 */
	public function setReleaseDate($releaseDate)
	{
		$this->releaseDate = $releaseDate;

		return $this;
	}

	/**
	 * Get releaseDate
	 *
	 * @return \DateTime
	 */
	public function getReleaseDate()
	{
		return $this->releaseDate;
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

	public function getPersonsKeyword()
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
	 * Add genre
	 *
	 * @param \AppBundle\Entity\Genre $genre
	 *
	 * @return Genre
	 */
	public function addGenre(\AppBundle\Entity\Genre $genre)
	{
		$this->genres[] = $genre;

		return $this;
	}

	/**
	 * Remove genre
	 *
	 * @param \AppBundle\Entity\Genre $genre
	 */
	public function removeGenre(\AppBundle\Entity\Genre $genre)
	{
		$this->genres->removeElement($genre);
	}

	/**
	 * Get genres
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getGenres()
	{
		return $this->genres;
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
		$poem->removeSong($this);
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

	public function getPoemsTitlesEnglish()
	{
		$englishTitles = "";
		if (isset($this->poems)) {
			foreach ($this->poems as $poem) {
				$englishTitles = $englishTitles . $poem->getEnglish() . " ";
			}
		}
		return $englishTitles;
	}

	public function getPoemsTitles()
	{
		$titles = "";
		if (isset($this->poems)) {
			foreach ($this->poems as $poem) {
				$titles = $titles . $poem->getTitle() . " ";
			}
		}
		return $titles;
	}

	public function getYear($dt) {
		if($dt instanceof \DateTime){
			return (int)$dt->format('Y');
		}
	}

	public function getYears()
	{
		$years = [];

		$compositionEarliest = $this->getYear($this->getCompositionEarliest());
		if ($compositionEarliest > 1821) { $years[]=$compositionEarliest; }

		$compositionLatest = $this->getYear($this->getCompositionLatest());
		if ($compositionLatest > 1821) { $years[]=$compositionLatest; }

		/*
		$releaseDate = $this->getYear($this->getReleaseDate());
		if ($releaseDate > 1821) { $years[]=$releaseDate; }
		 */

		$publications = $this->getPublications();

		foreach ($publications as $publication) {

			$years[]=$publication->getPublicationEarliest()->format("Y");
			$years[]=$publication->getPublicationLatest()->format("Y");

		}

		$years = array_unique($years);

		if (($key = array_search(-1, $years)) !== false) {
			unset($years[$key]);
		}

		$years = array_values($years);

		return $years;
	}

	/**
	 * Get earliest year
	 *
	 * @return integer
	 */
	public function getEarliestYear()
	{
		$years = $this->getYears();
		if (count($years) > 0) {
			return min($years);
		}
		return null;
	}

	/**
	 * Get latest year
	 *
	 * @return integer
	 */
	public function getLatestYear()
	{
		$years = $this->getYears();
		if (count($years) > 0) {
			return max($years);
		}
		return null;
	}

	public function getDecades()
	{

		$decades = [];

		$ey = $this->getEarliestYear();
		$ly = $this->getLatestYear();

		if ($ey > 0 && $ly > 0) {

			$ed = (int)floor($ey / 10);
			$ld = (int)floor($ly / 10);

			for ($i = $ed; $i <= $ld; $i++) {

				$decades[]=$i.'0s';

			}

		}

		return $decades;
	}

	public function getThemes()
	{
		$ret = [];

		if (isset($this->poems)) {

			$poems = $this->getPoems();

			foreach ($poems as $poem) {

				$themes = $poem->getThemes();

				foreach ($themes as $theme) {

					$ret[]=$theme->getTerm();

				}
			}
		}

		return $ret;

	}

	public function hasViewData() {
		if ($this->id == '43' || $this->id == '44' || $this->id == '71' || $this->id == '830') {
			return true;
		}
		return false;
	}


	/**
	 * Set catalogueLink
	 *
	 * @param string $catalogueLink
	 *
	 * @return Song
	 */
	public function setCatalogueLink($catalogueLink)
	{
		$this->catalogueLink = $catalogueLink;

		return $this;
	}

	/**
	 * Get catalogueLink
	 *
	 * @return string
	 */
	public function getCatalogueLink()
	{
		return $this->catalogueLink;
	}

	/**
	 * Set spotifyLink
	 *
	 * @param string $spotifyLink
	 *
	 * @return Song
	 */
	public function setSpotifyLink($spotifyLink)
	{
		$this->spotifyLink = $spotifyLink;

		return $this;
	}

	/**
	 * Get spotifyLink
	 *
	 * @return string
	 */
	public function getSpotifyLink()
	{
		return $this->spotifyLink;
	}

	/**
	 * Get gender
	 *
	 * @return Gender
	 */
	public function getGender()
	{

		$persons = $this->getPersons();

		if (count($persons) > 0) {
			return $this->persons[0]->getGender();
		}

		return null;
	}

}
