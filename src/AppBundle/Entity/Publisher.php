<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publisher
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Publisher
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
	 * @ORM\ManyToOne(targetEntity="City")
	 * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
	 **/
	private $city;

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
	 * @return Publisher
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
	 * Set city
	 *
	 * @param \AppBundle\Entity\City $city
	 * @return Publisher
	 */
	public function setCity(\AppBundle\Entity\City $city = null)
	{
		$this->city = $city;

		return $this;
	}

	/**
	 * Get city
	 *
	 * @return \AppBundle\Entity\City 
	 */
	public function getCity()
	{
		return $this->city;
	}

	public function __toString()
	{
		if ($this->term) {
			return $this->term;
		}
		return "not set";
	}
}
