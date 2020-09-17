<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class City
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
	 * @ORM\Column(name="term", type="string", length=255)
	 */
	private $term;

	/**
	 * @ORM\ManyToOne(targetEntity="Country")
	 * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
	 **/
	private $country;

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
	 * Set term
	 *
	 * @param string $term
	 * @return City
	 */
	public function setTerm($term)
	{
		$this->term = $term;

		return $this;
	}

	/**
	 * Get term
	 *
	 * @return string 
	 */
	public function getTerm()
	{
		return $this->term;
	}

	/**
	 * Set country
	 *
	 * @param \AppBundle\Entity\Country $country
	 * @return City
	 */
	public function setCountry(\AppBundle\Entity\Country $country = null)
	{
		$this->country = $country;

		return $this;
	}

	/**
	 * Get country
	 *
	 * @return \AppBundle\Entity\Country 
	 */
	public function getCountry()
	{
		return $this->country;
	}

	public function __toString()
	{
		if ($this->term) {
			return $this->term;
		}
		return "not set";
	}
}
