<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gender
 *
 * @ORM\Table(name="gender")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GenderRepository")
 */
class Gender
{
	/**
	 * @var int
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
	 * Get id
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set term
	 *
	 * @param string $term
	 *
	 * @return Gender
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

	public function __toString()
	{
		if ($this->term) {
			return $this->term;
		}
		return "not set";
	}
}
