<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Person
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
	 * @ORM\Column(name="given", type="string", length=255)
	 */
	private $given;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="surname", type="string", length=255)
	 */
	private $surname;

	/**
	 * @ORM\ManyToOne(targetEntity="Gender")
	 * @ORM\JoinColumn(name="gender_id", referencedColumnName="id")
	 **/
	private $gender;

	/**
	 * @ORM\ManyToMany(targetEntity="Country")
	 * @ORM\JoinTable(name="persons_countrys",
	 *      joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="country_id", referencedColumnName="id")}
	 *      )
	 **/
	private $countrys;

	/**
	 * @ORM\ManyToMany(targetEntity="Song", mappedBy="persons")
	 **/
	private $songs;

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
	 * Set given
	 *
	 * @param string $given
	 * @return Person
	 */
	public function setGiven($given)
	{
		$this->given = $given;

		return $this;
	}

	/**
	 * Get given
	 *
	 * @return string 
	 */
	public function getGiven()
	{
		return $this->given;
	}

	/**
	 * Set surname
	 *
	 * @param string $surname
	 * @return Person
	 */
	public function setSurname($surname)
	{
		$this->surname = $surname;

		return $this;
	}

	/**
	 * Get surname
	 *
	 * @return string 
	 */
	public function getSurname()
	{
		return $this->surname;
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
		return $this->given . ' ' . $this->surname;
	}

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->countrys = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Add countrys
	 *
	 * @param \AppBundle\Entity\Country $countrys
	 * @return Person
	 */
	public function addCountry(\AppBundle\Entity\Country $countrys)
	{
		$this->countrys[] = $countrys;

		return $this;
	}

	/**
	 * Remove countrys
	 *
	 * @param \AppBundle\Entity\Country $countrys
	 */
	public function removeCountry(\AppBundle\Entity\Country $countrys)
	{
		$this->countrys->removeElement($countrys);
	}

	/**
	 * Get countrys
	 *
	 * @return \Doctrine\Common\Collections\Collection 
	 */
	public function getCountrys()
	{
		return $this->countrys;
	}

	/**
	 * Set gender
	 *
	 * @param \AppBundle\Entity\Gender $gender
	 *
	 * @return Person
	 */
	public function setGender(\AppBundle\Entity\Gender $gender = null)
	{
		$this->gender = $gender;

		return $this;
	}

	/**
	 * Get gender
	 *
	 * @return \AppBundle\Entity\Gender
	 */
	public function getGender()
	{
		return $this->gender;
	}

	/**
	 * Add song
	 *
	 * @param \AppBundle\Entity\Song $song
	 *
	 * @return Person
	 */
	public function addSong(\AppBundle\Entity\Song $song)
	{
		$this->songs[] = $song;

		return $this;
	}

	/**
	 * Remove song
	 *
	 * @param \AppBundle\Entity\Song $song
	 */
	public function removeSong(\AppBundle\Entity\Song $song)
	{
		$this->songs->removeElement($song);
	}
}
